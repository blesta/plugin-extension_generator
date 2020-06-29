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

        Language::loadLang('extension_generator', null, dirname(__FILE__) . DS . 'language' . DS);
        $this->loadConfig(dirname(__FILE__) . DS . 'config.json');
    }
}