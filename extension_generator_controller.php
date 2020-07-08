<?php
/**
 * Extension Generator parent controller
 *
 * @package blesta
 * @subpackage blesta.plugins.extension_generator
 * @copyright Copyright (c) 2020, Phillips Data, Inc.
 * @license http://www.blesta.com/license/ The Blesta License Agreement
 * @link http://www.blesta.com/ Blesta
 */
class ExtensionGeneratorController extends AppController
{
    /**
     * Require admin to be login and setup the view
     */
    public function preAction()
    {
        Loader::loadModels($this, ['ExtensionGenerator.ExtensionGeneratorExtensions']);

        $this->structure->setDefaultView(APPDIR);

        parent::preAction();

        $this->requireLogin();

        // Auto load language for the controller
        Language::loadLang(
            [Loader::fromCamelCase(get_class($this))],
            null,
            dirname(__FILE__) . DS . 'language' . DS
        );
        Language::loadLang(
            'extension_generator_controller',
            null,
            dirname(__FILE__) . DS . 'language' . DS
        );

        // Override default view directory
        $this->view->view = "default";
        $this->orig_structure_view = $this->structure->view;
        $this->structure->view = "default";

        // Restore structure view location of the admin portal
        $this->structure->setDefaultView(APPDIR);
        $this->structure->setView(null, $this->orig_structure_view);
        $this->view->setView(null, 'ExtensionGenerator.default');
    }
}
