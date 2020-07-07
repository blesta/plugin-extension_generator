<?php
/**
 * Extension Generator plugin handler
 *
 * @package blesta
 * @subpackage blesta.plugins.extension_generator
 * @copyright Copyright (c) 2020, Phillips Data, Inc.
 * @license http://www.blesta.com/license/ The Blesta License Agreement
 * @link http://www.blesta.com/ Blesta
 */
class ExtensionGeneratorPlugin extends Plugin
{
    public function __construct()
    {
        // Load components required by this plugin
        Loader::loadComponents($this, ['Input']);

        Language::loadLang('extension_generator_plugin', null, dirname(__FILE__) . DS . 'language' . DS);
        $this->loadConfig(dirname(__FILE__) . DS . 'config.json');
    }

    /**
     * Returns all actions to be configured for this widget (invoked after install()
     * or upgrade(), overwrites all existing actions)
     *
     * @return array A numerically indexed array containing:
     *  - action The action to register for
     *  - uri The URI to be invoked for the given action
     *  - name The name to represent the action
     *  - options An array of options (optional)
     */
    public function getActions()
    {
        return [
            [
                'action' => 'nav_secondary_staff',
                'uri' => 'plugin/extension_generator/admin_main/',
                'name' => 'ExtensionGeneratorPlugin.nav_secondary_staff.admin_main',
                'options' => ['parent' => 'tools/']
            ]
        ];
    }
}