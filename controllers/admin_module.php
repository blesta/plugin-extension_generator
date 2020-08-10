<?php
/**
 * Extension Generator admin module controller
 *
 * @package blesta
 * @subpackage blesta.plugins.extension_generator
 * @copyright Copyright (c) 2020, Phillips Data, Inc.
 * @license http://www.blesta.com/license/ The Blesta License Agreement
 * @link http://www.blesta.com/ Blesta
 */
class AdminModule extends ExtensionGeneratorController
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
        $this->structure->set('page_title', Language::_('AdminModule.index.page_title', true, $extension->name));
    }

    /**
     * Returns the view to be rendered when configuring the basic settings for a module
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
            $vars = $this->processStep('module/basic', $this->extension);
        } else {
            $vars = $this->post;

            $this->setMessage('error', $errors, false, null, false);
        }

        // Set the view to render for all actions under this controller
        $this->set('form_type', $this->extension->form_type);
        $this->set('vars', $vars);

        // Set the node progress bar
        $nodes = $this->getNodes($this->extension);
        $page_step = array_search('module/basic', array_keys($nodes));
        $this->set(
            'progress_bar',
            $this->partial(
                'partial_progress_bar',
                ['nodes' => $nodes, 'page_step' => $page_step, 'extension' => $this->extension]
            )
        );
    }

    /**
     * Returns the view to be rendered when configuring the module fields for a module
     */
    public function fields()
    {
        // Set empty array inputs
        if (!empty($this->post)) {
            $array_fields = ['module_rows', 'package_fields', 'service_fields'];
            foreach ($array_fields as $array_field) {
                if (!isset($this->post[$array_field])) {
                    // Set empty array inputs
                    $this->post[$array_field] = [];
                }
            }
        }

        // Perform edit and redirect or set errors and repopulate vars
        $vars = $this->processStep('module/fields', $this->extension);

        // Set the view to render for all actions under this controller
        $this->set('field_types', $this->getFieldTypes());
        $this->set('vars', $vars);

        // Set the node progress bar
        $nodes = $this->getNodes($this->extension);
        $page_step = array_search('module/fields', array_keys($nodes));
        $this->set(
            'progress_bar',
            $this->partial(
                'partial_progress_bar',
                ['nodes' => $nodes, 'page_step' => $page_step, 'extension' => $this->extension]
            )
        );
    }

    /**
     * Returns the view to be rendered when configuring the additional features for a module
     */
    public function features()
    {
        // Set empty array inputs
        if (!empty($this->post)) {
            if (!isset($this->post['service_tabs'])) {
                $this->post['service_tabs'] = [];
            }

            if (!isset($this->post['cron_tasks'])) {
                $this->post['cron_tasks'] = [];
            }
        }

        // Perform edit and redirect or set errors and repopulate vars
        $vars = $this->processStep('module/features', $this->extension);

        // Set the view to render for all actions under this controller
        $this->set('tab_levels', $this->getTabLevels());
        $this->set('task_types', $this->getTaskTypes());
        $this->set('optional_functions', $this->getOptionalFunctions());
        $this->set('vars', $vars);

        // Set the node progress bar
        $nodes = $this->getNodes($this->extension);
        $page_step = array_search('module/features', array_keys($nodes));
        $this->set(
            'progress_bar',
            $this->partial(
                'partial_progress_bar',
                ['nodes' => $nodes, 'page_step' => $page_step, 'extension' => $this->extension]
            )
        );
    }

    /**
     * Gets a list of cron task types and their language
     *
     * @return A list of cron task types and their language
     */
    private function getTaskTypes()
    {
        return [
            'time' => Language::_('AdminModule.gettasktypes.time', true),
            'interval' => Language::_('AdminModule.gettasktypes.interval', true)
        ];
    }

    /**
     * Gets a list of tab levels and their language
     *
     * @return A list of tab levels and their language
     */
    private function getTabLevels()
    {
        return [
            'staff' => Language::_('AdminModule.gettablevels.staff', true),
            'client' => Language::_('AdminModule.gettablevels.client', true)
        ];
    }

    /**
     * Gets a list of optional functions and their settings
     *
     * @return A list of optional functions and their settings
     */
    private function getOptionalFunctions()
    {
        $functions = [
            'upgrade' => ['enabled' => 'true'],
            'cancelService' => ['enabled' => 'true'],
            'suspendService' => ['enabled' => 'true'],
            'unsuspendService' => ['enabled' => 'true'],
            'renewService' => ['enabled' => 'true'],
            'addPackage' => ['enabled' => 'true'],
            'editPackage' => ['enabled' => 'true'],
            'deletePackage' => ['enabled' => 'true'],
            'deleteModuleRow' => ['enabled' => 'false'],
            'getGroupOrderOptions' => ['enabled' => 'false'],
            'selectModuleRow' => ['enabled' => 'false'],
            'getAdminServiceInfo' => ['enabled' => 'false'],
            'getClientServiceInfo' => ['enabled' => 'false']
        ];

        foreach ($functions as $function => &$settings) {
            $settings['tooltip'] = Language::_(
                'AdminModule.getoptionalfunctions.tooltip_' . $function,
                true
            );
        }

        return $functions;
    }
}
