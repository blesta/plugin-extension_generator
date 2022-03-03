<?php
/**
 * Extension Generator admin registrar module controller
 *
 * @package blesta
 * @subpackage blesta.plugins.extension_generator
 * @copyright Copyright (c) 2022, Phillips Data, Inc.
 * @license http://www.blesta.com/license/ The Blesta License Agreement
 * @link http://www.blesta.com/ Blesta
 */
class AdminRegistrarModule extends ExtensionGeneratorController
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
        $this->structure->set('page_title', Language::_('AdminRegistrarModule.index.page_title', true, $extension->name));
    }

    /**
     * Returns the view to be rendered when configuring the basic settings for a module
     */
    public function basic()
    {
        // Attempt to upload logo if submitted
        $errors = $this->uploadLogo();

        // Process step
        if (!$errors) {
            // Perform edit and redirect or set errors and repopulate vars
            $vars = $this->processStep('registrar_module/basic', $this->extension);
        } else {
            $vars = $this->post;

            $this->setMessage('error', $errors, false, null, false);
        }

        // Set the view to render for all actions under this controller
        $this->set('form_type', $this->extension->form_type);
        $this->set('vars', $vars);

        // Set the node progress bar
        $nodes = $this->getNodes($this->extension);
        $page_step = array_search('registrar_module/basic', array_keys($nodes));
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
        $vars = $this->processStep('registrar_module/fields', $this->extension);

        // Set required fields
        $vars['package_fields'] = [
            'name' => [0 => 'epp_code'],
            'label' => [0 => Language::_('AdminRegistrarModule.fields.package_fields_epp_code_label', true)],
            'type' => [0 => 'checkbox'],
            'tooltip' => [0 => Language::_('AdminRegistrarModule.fields.package_fields_epp_code_tooltip', true)]
        ];
        $vars['service_fields'] = [
            'name' => [0 => 'domain'],
            'label' => [0 => Language::_('AdminRegistrarModule.fields.service_fields_domain_label', true)],
            'type' => [0 => 'text']
        ];

        // Set the view to render for all actions under this controller
        $this->set('field_types', $this->getFieldTypes());
        $this->set('vars', $vars);

        // Set the node progress bar
        $nodes = $this->getNodes($this->extension);
        $page_step = array_search('registrar_module/fields', array_keys($nodes));
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
        $vars = $this->processStep('registrar_module/features', $this->extension);

        // Set the view to render for all actions under this controller
        $this->set('tab_levels', $this->getTabLevels());
        $this->set('task_types', $this->getTaskTypes());
        $this->set('optional_functions', $this->getOptionalFunctions());
        $this->set('vars', $vars);

        // Set the node progress bar
        $nodes = $this->getNodes($this->extension);
        $page_step = array_search('registrar_module/features', array_keys($nodes));
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
    protected function getOptionalFunctions()
    {
        $functions = [
            'checkAvailability' => ['enabled' => 'true'],
            'checkTransferAvailability' => ['enabled' => 'true'],
            'getDomainInfo' => ['enabled' => 'true'],
            'getExpirationDate' => ['enabled' => 'true'],
            'getServiceDomain' => ['enabled' => 'true'],
            'getTldPricing' => ['enabled' => 'true'],
            'registerDomain' => ['enabled' => 'true'],
            'renewDomain' => ['enabled' => 'true'],
            'transferDomain' => ['enabled' => 'true'],
            'upgrade' => ['enabled' => 'true'],
            'cancelService' => ['enabled' => 'true'],
            'suspendService' => ['enabled' => 'true'],
            'unsuspendService' => ['enabled' => 'true'],
            'renewService' => ['enabled' => 'true'],
            'addPackage' => ['enabled' => 'true'],
            'editPackage' => ['enabled' => 'true'],
            'deletePackage' => ['enabled' => 'true'],
            'getDomainContacts' => ['enabled' => 'false'],
            'getDomainIsLocked' => ['enabled' => 'false'],
            'getDomainNameServers' => ['enabled' => 'false'],
            'lockDomain' => ['enabled' => 'false'],
            'resendTransferEmail' => ['enabled' => 'false'],
            'restoreDomain' => ['enabled' => 'false'],
            'sendEppEmail' => ['enabled' => 'false'],
            'setDomainContacts' => ['enabled' => 'false'],
            'setDomainNameservers' => ['enabled' => 'false'],
            'setNameserverIps' => ['enabled' => 'false'],
            'unlockDomain' => ['enabled' => 'false'],
            'updateEppCode' => ['enabled' => 'false'],
            'deleteModuleRow' => ['enabled' => 'false'],
            'getGroupOrderOptions' => ['enabled' => 'false'],
            'selectModuleRow' => ['enabled' => 'false'],
            'getAdminServiceInfo' => ['enabled' => 'false'],
            'getClientServiceInfo' => ['enabled' => 'false']
        ];

        foreach ($functions as $function => &$settings) {
            $settings['tooltip'] = Language::_(
                'AdminRegistrarModule.getoptionalfunctions.tooltip_' . $function,
                true
            );
        }

        return $functions;
    }
}
