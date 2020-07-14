<?php
/**
 * Extension File Generator
 *
 * @package blesta
 * @subpackage blesta.plugins.extension_generator.lib
 * @copyright Copyright (c) 2020, Phillips Data, Inc.
 * @license http://www.blesta.com/license/ The Blesta License Agreement
 * @link http://www.blesta.com/ Blesta
 */
class ExtensionFileGenerator
{
    /**
     * @var string The type of extension for which to parse files
     */
    private $extension_type;

    /**
     * @var array $options A list of options for generating files including:
     *
     *  - name The name of the extension to generate
     *  - comment_code True to include commented out code examples
     *  - language_code The language code for which to create language files
     *  - replacements A list of tag names and their replacements
     *  - optional_functions A list method names to include
     */
    private $options;

    /**
     * @var string $output_dir The directory under which to generate files
     */
    private $output_dir;

    private $code_comment_marker = '\/\/\/\/';
    private $tag_start = '{{';
    private $tag_end = '}}';

    /**
     * @param string $extension_type The type of extension for which to generate files
     * @param array $options A list of options for generating files including:
     *
     *  - name The name of the extension to generate
     *  - comment_code True to include commented out code examples
     *  - language_code The language code for which to create language files
     *  - replacements A list of tag names and their replacements
     *  - optional_functions A list method names to include
     */
    public function __construct($extension_type, array $options)
    {
        $this->setExtensionType($extension_type);
        $this->setOptions($options);
    }

    /**
     * Sets the extension type for which to parse and generate files
     *
     * @param string $extension_type The type of extension for which to generate files
     */
    public function setExtensionType($extension_type)
    {
        $this->extension_type = $extension_type;
    }

    /**
     * Sets the options for parsing and generating files
     *
     * @param array $options A list of options for generating files including:
     *
     *  - name The name of the extension to generate
     *  - code_examples True to include commented out code examples
     *  - language_code The language code for which to create language files
     *  - data A list of tag names and their replacements
     *  - optional_functions A list method names to include
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * Sets the directory under which to generate files
     *
     * @param string $output_dir The directory under which to generate files
     */
    public function setOutputDir($output_dir)
    {
        $this->output_dir = $output_dir;
    }

    /**
     * Parse and generate the extension files. This is where the science happens.
     */
    public function parseAndOutput()
    {
        // Get the directory in which to search for template files
        $template_directory = $this->getTemplateDirectory();
        // Get a list of template files to parse and output
        $file_paths = $this->getFileList();

        $data = $this->options['data'];

        // Set extension name variables
        $data['name'] = $this->options['name'];
        $data['snake_case_name'] = str_replace(' ', '_', strtolower($data['name']));
        $data['class_name'] = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['name'])));
        if ($this->extension_type == 'plugin') {
            $data['snake_case_name'] .= '_plugin';
            $data['class_name'] .= 'Plugin';
        }

        // Clear and remake the directory for this extension
        $extension_directory = $this->output_dir . $data['snake_case_name'];
        self::deleteDir($extension_directory . DS);
        mkdir($extension_directory);

        // Parse and output template files
        foreach ($file_paths as $file_settings) {
            // If the given file is required by optional functions and none are being used, skip the file
            if (isset($file_settings['required_by'])
                && isset($data['optional_functions'])
                && ($required_by =
                    array_intersect_key($data['optional_functions'], array_flip($file_settings['required_by']))
                )
                && array_search('true', $required_by) === false
            ) {
                continue;
            }

            // Create any necessary directories before creating this file
            $file_path = $file_settings['path'];
            $file_path_parts = explode(DS, $file_path);
            $temp_path = '';
            for ($i = 0; $i < count($file_path_parts) - 1; $i++) {
                $temp_path .= DS . $file_path_parts[$i];
                if (!is_dir($extension_directory . DS . $temp_path)) {
                    mkdir($extension_directory . DS . $temp_path);
                }
            }

            // Get the template file contents
            $content = file_get_contents($template_directory . $file_path);

            // Parse and replace the template file contents

            // Remove code examples if set to do so
            if (!$this->options['code_examples']) {
                $content = preg_replace('/' . $this->code_comment_marker . '.*[\r\n|\n]/', '', $content);
            }

            // Replace content tags
            $content = $this->replaceTags($content, $data);

            // Remove any remaining array tags
            $content = preg_replace(
                '/' . $this->tag_start . 'array\:.*?' . $this->tag_end
                    . '[\d\D]*?'
                    . $this->tag_start . 'array\:.*?' . $this->tag_end . '/',
                '',
                $content
            );

            // Remove any remaining conditional tags
            $content = preg_replace(
                '/' . $this->tag_start . 'if\:.*?' . $this->tag_end
                    . '[\d\D]*?'
                    . $this->tag_start . 'if\:.*?' . $this->tag_end . '/',
                '',
                $content
            );

            // Filter optional functions
            if (!isset($data['optional_functions'])) {
                $data['optional_functions'] = [];
            }

            // Set new optional function values based on the given data
            $data['optional_functions'] = array_merge(
                $data['optional_functions'],
                $this->getOptionalFunctionValues($data)
            );

            ##
            # TODO add support for code that is conditional on tag values
            ##

            // Replace content tags
            $content = $this->filterOptionalFunctions($content, $data['optional_functions']);

            // Remove any remaining tags
            $content = preg_replace('/' . $this->tag_start . '\S*' . $this->tag_end . '/', '', $content);

            // Output the parsed contents
            file_put_contents($extension_directory . DS . $file_path, $content);
        }

        // Rename generically named files to be specific to this extension
        self::renameFiles($extension_directory, $this->extension_type . '.php', $data['snake_case_name'] . '.php');
    }

    /**
     * Replaces tags in the given content
     *
     * @param string $content The content in which to replace tags
     * @param array $replacement_tags A list of tags and values to search for and replace
     * @param string $parent_tag The parent tag with which to prefix replacement tags (optional)
     * @return string The content with tags replaced
     */
    private function replaceTags($content, array $replacement_tags, $parent_tag = '')
    {
        // Get a list of array tags and remove them from the primary list
        // Wrap keys in the set  tag delimiters
        $array_tags = [];
        $tag_start = $this->tag_start;
        $tag_end = $this->tag_end;
        foreach ($replacement_tags as $replacement_tag => $replacement_value) {
            if (is_array($replacement_value)) {
                $array_tags[$replacement_tag] = $replacement_value;
            } else {
                $replacement_tags[$tag_start . $parent_tag . $replacement_tag . $tag_end] = $replacement_value;
            }

            unset($replacement_tags[$replacement_tag]);
        }

        // Parse content condtitionally based on the value of tags
        $content = $this->replaceConditionalTags($content, $replacement_tags);

        // Replace all tags for scalar values
        $content = str_replace(
            array_keys($replacement_tags),
            array_values($replacement_tags),
            $content
        );

        foreach ($array_tags as $array_tag => $array_values) {
            $matches = [];
            $wrapped_array_tag = $tag_start . 'array:' . $array_tag . $tag_end;
            $pattern = '/' . $wrapped_array_tag . '([\d\D]*?)' . $wrapped_array_tag . '/';

            // Find all instances of the array tag
            preg_match_all($pattern, $content, $matches);

            // No matches for this tag, move on
            if (!isset($matches[1])) {
                continue;
            }

            // Process each match
            foreach ($matches[0] as $match) {
                $matched_content = '';

                // For each item in the array, copy the text within the array tag and perform tag replacement on it
                foreach ($array_values as $key => $value) {
                    if (is_array($value)) {
                        // Examine the mnatched content for each subtag and perform the tag replacement
                        $matched_content .= $this->replaceTags($match, $value, $parent_tag . $array_tag . '.');
                    } else {
                        // Perform single tag replacement on the content of the array tag
                        $matched_content .= str_replace(
                            $tag_start . $array_tag . '.' . $key . $tag_end,
                            $value,
                            $match
                        );
                    }
                }

                // Remove the array tag from around the content
                $matched_content = rtrim(str_replace($wrapped_array_tag, '', $matched_content), ',');

                // Replace the matched content with the new, tag replaced content
                $content = str_replace($match, $matched_content, $content);
            }
        }

        return $content;
    }

    /**
     * Replaces conditional tags in the given content
     *
     * @param string $content The content in which to replace tags
     * @param array $replacement_tags A list of tags and values to search for and replace
     * @return string The content with tags replaced
     */
    private function replaceConditionalTags($content, array $replacement_tags)
    {
        // Created a list of strings that match the conditional pattern, and the value to replace them with
        $match_replacements = [];
        foreach ($replacement_tags as $replacement_tag => $replacement_value) {
            // Remove any tag delimiters
            $trimmed_tag = rtrim(ltrim($replacement_tag, $this->tag_start), $this->tag_end);

            // {{if:tag:value}}true_text{{else}}false_text{{if:tag}}
            $pattern = '/' . $this->tag_start . 'if:' . $trimmed_tag . ':(.*?)' . $this->tag_end
                . '([\d\D]*?)' . $this->tag_start . 'else' . $this->tag_end
                . '([\d\D]*?)' . $this->tag_start . 'if:' . $trimmed_tag . $this->tag_end . '/';

            if (preg_match_all($pattern, $content, $matches) && count($matches) !== 0) {
                foreach ($matches[0] as $index => $match) {
                    // Set variables to make the role of each match more clear
                    $comparaison_value = $matches[1][$index];
                    $true_text = $matches[2][$index];
                    $false_text = $matches[3][$index];

                    // If the tag value equals the parsed comparison value, use the parse text for the true case,
                    // else use the parsed text for the false calse
                    $match_replacements[$match] = $replacement_value == $comparaison_value
                        ? $replacement_tags[$trimmed_tag] = $true_text
                        : $replacement_tags[$trimmed_tag] = $false_text;
                }
            }

            unset($replacement_tags[$replacement_tag]);
        }

        return str_replace(array_keys($match_replacements), array_values($match_replacements), $content);
    }

    /**
     * Remove optional functions that are set to false
     *
     * @param string $content The content from which to remove/keep optional functions
     * @param array $optional_functions A list of optional functions and their status, false to remove, true to keep
     * @return string The content with optional functions removed
     */
    private function filterOptionalFunctions($content, array $optional_functions)
    {
        // Filter optional functions from the content
        foreach ($optional_functions as $optional_function => $include)
        {
            if ($include == 'false') {
                // Remove the optional function
                $content = preg_replace(
                    '/' . $this->tag_start . 'function:' . $optional_function . $this->tag_end
                        . '[\d\D]*?'
                        . $this->tag_start . 'function:' . $optional_function . $this->tag_end . '/',
                    '',
                    $content
                );
            } else {
                // Keep the optional function but remove the surrounding tags
                $content = str_replace(
                    $this->tag_start . 'function:' . $optional_function . $this->tag_end,
                    '',
                    $content
                );
            }
        }

        return $content;
    }

    /**
     * Gets a list of files to parse and generate based on the set extension type
     *
     * @return array A list of arrays for files to parse and generate, each containing:
     *
     *  - path The path to the template file to parse, relative to the template directory
     *  - required_by A list of optional functions that require the given file
     */
    private function getFileList()
    {
        $file_path_list = [
            'module' => [
                ['path' => 'language' . DS . 'en_us' . DS . 'module.php'],
                ['path' => 'README.md'],
                ['path' => 'config.json'],
                ['path' => 'composer.json'],
                ['path' => 'module.php'],
                ['path' => 'views' . DS . 'default' . DS . 'images' . DS . 'logo.png'],
                ['path' => 'views' . DS . 'default' . DS . 'manage.pdt'],
                [
                    'path' => 'views' . DS . 'default' . DS . 'client_service_info.pdt',
                    'required_by' => ['getClientServiceInfo']
                ],
                [
                    'path' => 'views' . DS . 'default' . DS . 'admin_service_info.pdt',
                    'required_by' => ['getAdminServiceInfo']
                ],
                ['path' => 'views' . DS . 'default' . DS . 'edit_row.pdt', 'required_by' => ['module_rows']],
                ['path' => 'views' . DS . 'default' . DS . 'add_row.pdt', 'required_by' => ['module_rows']],
                ['path' => 'views' . DS . 'default' . DS . 'edit_row.pdt', 'required_by' => ['module_rows']],
                ['path' => 'views' . DS . 'default' . DS . 'tab.pdt', 'required_by' => ['service_tabs']],
            ],
            'plugin' => [],
            'gateway' => [],
        ];

        return $file_path_list[$this->extension_type];
    }

    /**
     * Gets the template directory containing the files to parse based on the set extension type
     *
     * @return string The directory containing template files
     */
    private function getTemplateDirectory()
    {
        $directories = [
            'module' => PLUGINDIR . 'extension_generator' . DS . 'lib' . DS . 'templates' . DS . 'module' . DS,
            'plugin' => PLUGINDIR . 'extension_generator' . DS . 'lib' . DS . 'templates' . DS . 'plugin' . DS,
            'gateway' => PLUGINDIR . 'extension_generator' . DS . 'lib' . DS . 'templates' . DS . 'gateway' . DS,
        ];

        return $directories[$this->extension_type];
    }

    private function getOptionalFunctionValues($data)
    {
        $function_dependencies = [
            'module' => [
                'addCronTasks' => 'cron_tasks',
                'getCronTasks' => 'cron_tasks',
                'getPackageFields' => 'package_fields',
                'getAdminAddFields' => 'service_fields',
                'getAdminEditFields' => 'service_fields',
                'getClientAddFields' => 'service_fields',
                'getAdminTabs' => 'service_tabs',
                'getClientTabs' => 'service_tabs',
            ],
            'plugin' => [],
            'gateway' => [],
        ];

        $optional_functions = [];
        foreach ($function_dependencies[$this->extension_type] as $function => $dependency) {
            $optional_functions[$function] = empty($data[$dependency]) ? 'false' : 'true';
        }

        return $optional_functions;
    }

    /**
     * Recursively delete the directory and it's contents
     *
     * @param string $directory The directory to clear and delete
     */
    public static function deleteDir($directory) {
        $directory = rtrim($directory, DS) . DS;
        if (!is_dir($directory)) {
            return;
        }

        $files = glob($directory . '*', GLOB_MARK);
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($directory);
    }

    /**
     * Recursively search the given directory for files with the given old name and rename them
     *
     * @param string $directory The directory to search
     * @param string $old_name The name of the files for which to search
     * @param string $new_name The new name to give the files
     */
    public static function renameFiles($directory, $old_name, $new_name) {
        $directory = rtrim($directory, DS) . DS;

        $files = glob($directory . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::renameFiles($file, $old_name, $new_name);
            }
        }

        if (is_file($directory . $old_name) && !is_dir($directory . $old_name)) {
            rename($directory . $old_name, $directory . $new_name);
        }
    }
}
