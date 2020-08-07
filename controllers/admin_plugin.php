<?php
/**
 * Extension Generator admin plugin controller
 *
 * @package blesta
 * @subpackage blesta.plugins.extension_generator
 * @copyright Copyright (c) 2020, Phillips Data, Inc.
 * @license http://www.blesta.com/license/ The Blesta License Agreement
 * @link http://www.blesta.com/ Blesta
 */
class AdminPlugin extends ExtensionGeneratorController
{
    /**
     * Setup
     */
    public function preAction()
    {
        parent::preAction();

        // Ensure extension exists
        if (!isset($this->get[0])
            || !($extension = $this->ExtensionGeneratorExtensions->get($this->get[0]))
            || $extension->company_id != $this->company_id
        ) {
            $this->redirect($this->base_uri . 'plugin/extension_generator/admin_main/');
        }

        $this->extension = $extension;
        $this->structure->set('page_title', Language::_('AdminPlugin.index.page_title', true, $extension->name));
    }

    /**
     * Returns the view to be rendered when configuring the basic settings for a plugin
     */
    public function basic()
    {
        if (!isset($this->SettingsCollection)) {
            Loader::loadComponents($this, ['SettingsCollection', 'Upload']);
        }
        if (!isset($this->Upload)) {
            Loader::loadComponents($this, ['Upload']);
        }

        // Attempt to upload logo if submitted
        $errors = $this->uploadLogo();

        if (!$errors) {
            // Perform edit and redirect or set errors and repopulate vars
            $vars = $this->processStep('plugin/basic', $this->extension);
        } else {
            $vars = $this->post;

            $this->setMessage('error', $errors, false, null, false);
        }

        // Set the view to render for all actions under this controller
        $this->set('form_type', $this->extension->form_type);
        $this->set('vars', $vars);

        // Set the node progress bar
        $nodes = $this->getNodes($this->extension);
        $page_step = array_search('plugin/basic', array_keys($nodes));
        $this->set(
            'progress_bar',
            $this->partial(
                'partial_progress_bar',
                ['nodes' => $nodes, 'page_step' => $page_step, 'extension' => $this->extension]
            )
        );
    }

    /**
     * Returns the view to be rendered when configuring the additional features for a plugin
     */
    public function features()
    {
        // Perform edit and redirect or set errors and repopulate vars
        $vars = $this->processStep('plugin/features', $this->extension);

        // Set the view to render for all actions under this controller
        $this->set('optional_functions', $this->getOptionalFunctions());
        $this->set('vars', $vars);

        // Set the node progress bar
        $nodes = $this->getNodes($this->extension);
        $page_step = array_search('plugin/features', array_keys($nodes));
        $this->set(
            'progress_bar',
            $this->partial(
                'partial_progress_bar',
                ['nodes' => $nodes, 'page_step' => $page_step, 'extension' => $this->extension]
            )
        );
    }

    /**
     * Gets a list of optional functions and their settings
     *
     * @return A list of optional functions and their settings
     */
    private function getOptionalFunctions()
    {
        $functions = [
        ];

        foreach ($functions as $function => &$settings) {
            $settings['tooltip'] = Language::_(
                'AdminPlugin.getoptionalfunctions.tooltip_' . $function,
                true
            );
        }

        return $functions;
    }
}
