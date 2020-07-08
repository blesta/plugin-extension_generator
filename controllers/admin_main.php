<?php
/**
 * Extension Generator admin main controller
 *
 * @package blesta
 * @subpackage blesta.plugins.extension_generator
 * @copyright Copyright (c) 2020, Phillips Data, Inc.
 * @license http://www.blesta.com/license/ The Blesta License Agreement
 * @link http://www.blesta.com/ Blesta
 */
class AdminMain extends ExtensionGeneratorController
{
    /**
     * @var string The string with which to start every variable name stored by this plugin
     */
    private $session_prefix = 'extensiongenerator_';

    /**
     * Returns the view for a list of extensions
     */
    public function index()
    {
        // Set current page of results
        $page = (isset($this->get[1]) ? (int) $this->get[1] : 1);
        $sort = (isset($this->get['sort']) ? $this->get['sort'] : 'date_updated');
        $order = (isset($this->get['order']) ? $this->get['order'] : 'desc');

        $extensions = $this->ExtensionGeneratorExtensions->getList(
            Configure::get('Blesta.company_id'),
            $page, [$sort => $order]
        );
        $total_results = $this->ExtensionGeneratorExtensions->getListCount(Configure::get('Blesta.company_id'));

        $this->set('extensions', $extensions);
        $this->set('sort', $sort);
        $this->set('order', $order);
        $this->set('negate_order', ($order == 'asc' ? 'desc' : 'asc'));

        // Overwrite default pagination settings
        $settings = array_merge(
            Configure::get('Blesta.pagination'),
            [
                'total_results' => $total_results,
                'uri' => $this->base_uri . 'plugin/extension_generator/admin_main/index/[p]/',
                'params' => ['sort' => $sort, 'order' => $order],
            ]
        );
        $this->setPagination($this->get, $settings);
    }

    /**
     * Returns the view to be rendered when creating an extension
     */
    public function create()
    {
        $this->components(['Session']);

        $step = isset($this->get['step']) ? $this->get['step'] : '';

        // Get the form by action
        if (!empty($this->post))
        {
            $type = isset($this->post['extension_type']) ? $this->post['extension_type'] : 'general';
            $action = isset($this->post['action']) ? $this->post['action'] : 'general';

            $this->Session->write(
                $this->session_prefix . ($action == 'general' ? 'generalgeneral' : $type . $action),
                $this->post
            );

            $step = $this->getNextStep($type . $action);
        }


        $this->view->setView(null, 'ExtensionGenerator.default');
        $form = $this->getForm($step);

        // Set the view to render for all actions under this controller
        $this->set('form', $form);
        $this->set(
            'progress_bar',
            $this->partial(
                'partial_progress_bar',
                [
                    'nodes' => $this->getNodes($step),
                    'page_step' => $this->page_step
                ]
            )
        );
    }

    /**
     * Returns the next step in the chain of extension forms
     *
     * @param string $current_step The current step being displayed
     * @return string The next step to be displayed
     */
    private function getNextStep($current_step)
    {
        $step_mapping = [
            'modulegeneral' => 'modulebasic',
            'modulebasic' => 'modulefields',
            'modulefields' => 'modulefeatures',
            'modulefeatures' => 'complete',
        ];

        // Use a simplified set of steps if set to use the basic extension form
        $general_vars = $this->Session->read($this->session_prefix . 'generalgeneral');
        if (is_array($general_vars) && isset($general_vars['form_type']) && $general_vars['form_type'] == 'basic') {
            $step_mapping = [
                'modulegeneral' => 'modulebasic',
                'modulebasic' => 'complete'
            ];
        }

        return isset($step_mapping[$current_step]) ? $step_mapping[$current_step] : 'generalgeneral';
    }

    /**
     * Get a form partial view based on the given step
     *
     * @param string $step The step for which to render a form
     * @return string The rendered view
     */
    private function getForm($step)
    {
        $vars = $this->Session->read($this->session_prefix . $step);
        $general_vars = $this->Session->read($this->session_prefix . 'generalgeneral');

        $form = null;
        switch ($step) {
            case 'modulebasic':
                $this->page_step = 1;
                $form = $this->partial(
                        'partial_module_basic',
                        [
                            'vars' => $vars,
                            'general_vars' => $general_vars
                        ]
                    );
                break;
            case 'modulefields':
                $this->page_step = 2;
                $form = $this->partial(
                        'partial_module_fields',
                        [
                            'field_types' => $this->getFieldTypes(),
                            'vars' => $vars
                        ]
                    );
                break;
            case 'modulefeatures':
                $this->page_step = 3;
                $form = $this->partial(
                        'partial_module_features',
                        [
                            'tab_levels' => $this->getTabLevels(),
                            'task_types' => $this->getTaskTypes(),
                            'optional_functions' => $this->getOptionalFunctions(),
                            'vars' => $vars
                        ]
                    );
                break;
            case 'complete':
                $extension_type = isset($general_vars['extension_type']) ? $general_vars['extension_type'] : 'module';
                $this->setMessage(
                    'success',
                    Language::_(
                        'AdminMain.!success.' . $extension_type . '_created',
                        true,
                        COMPONENTDIR . 'modules' . DS // . $extension_name
                    ),
                    false,
                    null,
                    false
                );
                $this->clearSession();
            default:
                $form = $this->partial(
                        'partial_general',
                        [
                            'extension_types' => $this->ExtensionGeneratorExtensions->getTypes(),
                            'form_types' => $this->ExtensionGeneratorExtensions->getFormTypes(),
                            'vars' => $vars
                        ]
                    );
                $this->page_step = 0;
                break;
        }

        return $form;
    }

    /**
     * Gets a list of field types and their languages
     *
     * @return A list of field types and their languages
     */
    private function getFieldTypes()
    {
        return [
            'text' => Language::_('AdminMain.getfieldtypes.text', true),
            'textarea' => Language::_('AdminMain.getfieldtypes.textarea', true),
            'checkbox' => Language::_('AdminMain.getfieldtypes.checkbox', true)
        ];
    }

    /**
     * Gets a list of cron task types and their languages
     *
     * @return A list of cron task types and their languages
     */
    private function getTaskTypes()
    {
        return [
            'time' => Language::_('AdminMain.gettasktypes.time', true),
            'interval' => Language::_('AdminMain.gettasktypes.interval', true)
        ];
    }

    /**
     * Gets a list of tab levels and their languages
     *
     * @return A list of tab levels and their languages
     */
    private function getTabLevels()
    {
        return [
            'staff' => Language::_('AdminMain.gettablevels.staff', true),
            'client' => Language::_('AdminMain.gettablevels.client', true)
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
            'cancelService' => ['enabled' => 'true'],
            'suspendService' => ['enabled' => 'true'],
            'unsuspendService' => ['enabled' => 'true'],
            'renewService' => ['enabled' => 'true'],
            'addPackage' => ['enabled' => 'true'],
            'editPackage' => ['enabled' => 'true'],
            'deletePackage' => ['enabled' => 'true'],
            'addModuleRow' => ['enabled' => 'true'],
            'editModuleRow' => ['enabled' => 'true'],
            'manageAddRow' => ['enabled' => 'true'],
            'manageEditRow' => ['enabled' => 'true'],
            'getGroupOrderOptions' => ['enabled' => 'false'],
            'selectModuleRow' => ['enabled' => 'false'],
            'getAdminServiceInfo' => ['enabled' => 'false'],
            'getClientServiceInfo' => ['enabled' => 'false']
        ];

        foreach ($functions as $function => &$settings) {
            $settings['tooltip'] = Language::_(
                'AdminMain.getoptionalfunctions.tooltip_' . $function,
                true
            );
        }

        return $functions;
    }

    /**
     * Gets a list of progress nodes for the given form step
     *
     * @param string $step The form step for which to get nodes
     * @return array A list of progress nodes, keyed by the step to which they should link
     */
    private function getNodes($step)
    {
        // Use a simplified set of steps if set to use the basic extension form
        $general_vars = $this->Session->read($this->session_prefix . 'generalgeneral');
        $node_sets = [];
        if (is_array($general_vars) && isset($general_vars['form_type']) && $general_vars['form_type'] == 'basic') {
            $node_sets = [
                'module' => [
                    'modulebasic' => Language::_('AdminMain.getnodes.basic_info', true),
                ],
                'plugin' => [],
                'merchant' => [],
                'nonmerchant' => [],
            ];
        } else {
            $node_sets = [
                'module' => [
                    'modulebasic' => Language::_('AdminMain.getnodes.basic_info', true),
                    'modulefields' => Language::_('AdminMain.getnodes.module_fields', true),
                    'modulefeatures' => Language::_('AdminMain.getnodes.additional_features', true),
                ],
                'plugin' => [],
                'merchant' => [],
                'nonmerchant' => [],
            ];
        }

        $nodes = ['generalgeneral' => Language::_('AdminMain.getnodes.general_settings', true)];
        foreach ($node_sets as $type => $node_set) {
            if (strpos($step, $type) === 0) {
                $nodes += $node_set;
                break;
            }
        }

        if (count($nodes) == 1) {
            $nodes[] = Language::_('AdminMain.getnodes.basic_info', true);
        }

        $nodes[] = Language::_('AdminMain.getnodes.complete', true);

        return $nodes;
    }

    /**
     * Clears the session variables set by this plugin
     */
    private function clearSession()
    {
        // Define a complete list of session variable used by the plugin
        $session_variables = ['generalgeneral', 'modulebasic', 'modulefields', 'modulefeatures'];

        // Define the session variables that should be excluded from the commit
        $excluded_variables = ['generalgeneral'];

        // Clear each session variable
        foreach ($session_variables as $session_variable) {
            if (!in_array($session_variable, $excluded_variables)) {
                $this->Session->clear($this->session_prefix . $session_variable);
            }
        }
    }
}
