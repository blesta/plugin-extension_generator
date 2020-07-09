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
     *  - comment_code True to include commented out code examples
     *  - language_code The language code for which to create a language file
     *  - replacements A list of tag names and their replacements
     *  - optional_functions A list method names to include
     */
    private $options;

    /**
     * @var string $output_dir The directory under which to generate files
     */
    private $output_dir;

    /**
     * @param string $extension_type The type of extension for which to generate files
     * @param array $options A list of options for generating files including:
     *
     *  - name The name of the extension to generate
     *  - comment_code True to include commented out code examples
     *  - language_code The language code for which to create a language file
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
     * Sets the options for parsing and generate files
     *
     * @param array $options A list of options for generating files including:
     *
     *  - name The name of the extension to generate
     *  - code_examples True to include commented out code examples
     *  - language_code The language code for which to create a language file
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
     * Parse and generate new files
     */
    public function parseAndOutput()
    {
        $file_paths = $this->getFileList();
        $template_directory = $this->getTemplateDirectory();

        // Set extension name variables
        $data['name'] = $this->options['name'];
        $data['snake_case_name'] = str_replace(' ', '_', strtolower($data['name']));
        $data['class_name'] = str_replace('', '_', ucwords(str_replace('_', ' ', $data['name'])));
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
            $file_path = $file_settings['path'];
            if (isset($file_settings['dependancies'])
                && empty(
                    array_intersect($file_settings['dependancies'], array_flip($this->data['optional_functions']))
                )
            ) {
                continue;
            }

            // Create any necessary directories before creating this file
            $file_path_parts = explode(DS, $file_path);
            $temp_path = '';
            for ($i = 0; $i < count($file_path_parts) - 1; $i++) {
                $temp_path .= $file_path_parts[$i];
                if (!is_dir($temp_path)) {
                    mkdir($extension_directory . DS . $file_path);
                }
            }

            // Get the template file contents
            $contents = file_get_contents($template_directory . $file_path);

            if (!$this->options['code_examples']) {
                // Parse and replace the template file contents
                preg_replace('//.*(\n|\r\n)', '', $contents);
            }
            if (!$this->options['code_examples']) {
                // Parse and replace the template file contents
                preg_replace('//.*(\n|\r\n)', '', $contents);
            }

            // Output the parsed contents
            file_put_contents($extension_directory . DS . $file_path, $contents);
        }

        // Rename generically named files to be specific to this extension
        self::renameFiles($extension_directory, $this->extension_type . '.php', $data['snake_case_name'] . '.php');
    }

    private function getFileList()
    {
        $file_path_list = [
            'module' => [['path' => 'module.php', 'dependencies' => ['cancelService']]],
            'plugin' => [],
            'gateway' => [],
        ];
        return $file_path_list[$this->extension_type];
    }

    private function getTemplateDirectory()
    {
        $directories = [
            'module' => PLUGINDIR . 'extension_generator' . DS . 'lib' . DS . 'templates' . DS . 'module' . DS,
            'plugin' => PLUGINDIR . 'extension_generator' . DS . 'lib' . DS . 'templates' . DS . 'plugin' . DS,
            'gateway' => PLUGINDIR . 'extension_generator' . DS . 'lib' . DS . 'templates' . DS . 'gateway' . DS,
        ];

        return $directories[$this->extension_type];
    }

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

    public static function renameFiles($directory, $old_name, $new_name) {
        $directory = rtrim($directory, DS) . DS;

        $files = glob($directory . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::renameFiles($file);
            }
        }

        if (is_file($directory . $old_name) && !is_dir($directory . $old_name)) {
            rename($directory . $old_name, $directory . $new_name);
        }
    }
}
