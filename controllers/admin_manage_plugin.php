<?php
/**
 * Extension Generator manage plugin controller
 *
 * @package blesta
 * @subpackage blesta.plugins.extension_generator
 * @copyright Copyright (c) 2020, Phillips Data, Inc.
 * @license http://www.blesta.com/license/ The Blesta License Agreement
 * @link http://www.blesta.com/ Blesta
 */
class AdminManagePlugin extends AppController
{
    /**
     * Performs necessary initialization
     */
    private function init()
    {
        // Require login
        $this->parent->requireLogin();

        Language::loadLang(
            'extension_generator_plugin',
            null,
            PLUGINDIR . 'extension_generator' . DS . 'language' . DS
        );

        $this->plugin_id = isset($this->get[0]) ? $this->get[0] : null;

        // Set the page title
        $this->parent->structure->set(
            'page_title',
            Language::_(
                'ExtensionGeneratorPlugin.'
                . Loader::fromCamelCase($this->action ? $this->action : 'index') . '.page_title',
                true
            )
        );
    }

    /**
     * Returns the view to be rendered when managing this plugin
     */
    public function index()
    {
        $this->init();

        // Set the view to render for all actions under this controller
        $this->view->setView(null, 'ExtensionGenerator.default');
        $vars = [
            'plugin_id' => $this->plugin_id,
            'extension_types' => $this->getExtensionTypes(),
            'form_types' => $this->getFormTypes(),
            'progress_bar' => $this->partial(
                'admin_manage_progress_bar',
                [
                    'nodes' => $this->getNodes('general'),
                    'page_step' => 0
                ]
            ),
        ];

        return $this->partial('admin_manage_plugin', $vars);
    }

    /**
     * Gets a list of extension types and their languages
     *
     * @return A list of extension types and their languages
     */
    private function getExtensionTypes()
    {
        return [
            'module' => Language::_('ExtensionGeneratorPlugin.getextensiontypes.module', true),
            'plugin' => Language::_('ExtensionGeneratorPlugin.getextensiontypes.plugin', true),
            'gateway' => Language::_('ExtensionGeneratorPlugin.getextensiontypes.gateway', true)
        ];
    }

    /**
     * Gets a list of form types and their languages
     *
     * @return A list of form types and their languages
     */
    private function getFormTypes()
    {
        return [
            'basic' => Language::_('ExtensionGeneratorPlugin.getformtypes.basic', true),
            'advanced' => Language::_('ExtensionGeneratorPlugin.getformtypes.advanced', true)
        ];
    }

    private function getNodes($type)
    {
        $nodes = [
            Language::_('ExtensionGeneratorPlugin.getnodes.general_settings', true),
            Language::_('ExtensionGeneratorPlugin.getnodes.basic_info', true)
        ];

        switch ($type) {
            case 'module':
                break;
            case 'plugin':
                break;
            case 'merchant':
                break;
            case 'nonmerchant':
                break;
        }

        $nodes[] = Language::_('ExtensionGeneratorPlugin.getnodes.complete', true);

        return $nodes;
    }
}
