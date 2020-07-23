<?php
////use Blesta\Core\Util\Validate\Server;
/**
 * {{name}} Module
 *
{{array:authors}}
 * @link {{authors.url}} {{authors.name}}{{array:authors}}
 */
class {{class_name}} extends Module
{

    /**
     * Initializes the module
     */
    public function __construct()
    {
        // Load the language required by this module
        Language::loadLang('{{snake_case_name}}', null, dirname(__FILE__) . DS . 'language' . DS);

        // Load components required by this module
        Loader::loadComponents($this, ['Input']);

        // Load module config
        $this->loadConfig(dirname(__FILE__) . DS . 'config.json');
    }

    /**
     * Performs any necessary bootstraping actions
     */
    public function install()
    {{{function:addCronTasks}}{{function:getCronTasks}}
        // Add cron tasks for this module
        $this->addCronTasks($this->getCronTasks());{{function:getCronTasks}}{{function:addCronTasks}}
    }{{function:upgrade}}

    /**
     * Performs migration of data from $current_version (the current installed version)
     * to the given file set version. Sets Input errors on failure, preventing
     * the module from being upgraded.
     *
     * @param string $current_version The current installed version of this module
     */
    public function upgrade($current_version)
    {
////        if (version_compare($current_version, '1.1.0', '<')) {
////            // Preform actions here such as re-adding cron tasks, setting new meta fields, and more
////        }
    }{{function:upgrade}}

    /**
     * Performs any necessary cleanup actions. Sets Input errors on failure
     * after the module has been uninstalled.
     *
     * @param int $module_id The ID of the module being uninstalled
     * @param bool $last_instance True if $module_id is the last instance
     *  across all companies for this module, false otherwise
     */
    public function uninstall($module_id, $last_instance)
    {{{function:addCronTasks}}{{function:getCronTasks}}
        if (!isset($this->Record)) {
            Loader::loadComponents($this, ['Record']);
        }
        Loader::loadModels($this, ['CronTasks']);

        $cron_tasks = $this->getCronTasks();

        if ($last_instance) {
            // Remove the cron tasks
            foreach ($cron_tasks as $task) {
                $cron_task = $this->CronTasks->getByKey($task['key'], $task['dir'], $task['task_type']);
                if ($cron_task) {
                    $this->CronTasks->deleteTask($cron_task->id, $task['task_type'], $task['dir']);
                }
            }
        }

        // Remove individual cron task runs
        foreach ($cron_tasks as $task) {
            $cron_task_run = $this->CronTasks
                ->getTaskRunByKey($task['key'], $task['dir'], false, $task['task_type']);
            if ($cron_task_run) {
                $this->CronTasks->deleteTaskRun($cron_task_run->task_run_id);
            }
        }{{function:getCronTasks}}{{function:addCronTasks}}
    }

    /**
     * Returns the rendered view of the manage module page.
     *
     * @param mixed $module A stdClass object representing the module and its rows
     * @param array $vars An array of post data submitted to or on the manager module
     *  page (used to repopulate fields after an error)
     * @return string HTML content containing information to display when viewing the manager module page
     */
    public function manageModule($module, array &$vars)
    {
        // Load the view into this object, so helpers can be automatically added to the view
        $this->view = new View('manage', 'default');
        $this->view->base_uri = $this->base_uri;
        $this->view->setDefaultView('components' . DS . 'modules' . DS . '{{snake_case_name}}' . DS);

        // Load the helpers required for this view
        Loader::loadHelpers($this, ['Form', 'Html', 'Widget']);

        $this->view->set('module', $module);

        return $this->view->fetch();
    }{{function:addModuleRow}}

    /**
     * Returns the rendered view of the add module row page.
     *
     * @param array $vars An array of post data submitted to or on the add module
     *  row page (used to repopulate fields after an error)
     * @return string HTML content containing information to display when viewing the add module row page
     */
    public function manageAddRow(array &$vars)
    {
        // Load the view into this object, so helpers can be automatically added to the view
        $this->view = new View('add_row', 'default');
        $this->view->base_uri = $this->base_uri;
        $this->view->setDefaultView('components' . DS . 'modules' . DS . '{{snake_case_name}}' . DS);

        // Load the helpers required for this view
        Loader::loadHelpers($this, ['Form', 'Html', 'Widget']);

        if (!empty($vars)) {
            // Set unset checkboxes
            $checkbox_fields = [{{array:module_rows}}{{if:module_rows.type:Checkbox}}'{{module_rows.name}}',{{else}}{{if:module_rows.type}}{{array:module_rows}}];

            foreach ($checkbox_fields as $checkbox_field) {
                if (!isset($vars[$checkbox_field])) {
                    $vars[$checkbox_field] = 'false';
                }
            }
        }

        $this->view->set('vars', (object) $vars);

        return $this->view->fetch();
    }{{function:addModuleRow}}{{function:editModuleRow}}

    /**
     * Returns the rendered view of the edit module row page.
     *
     * @param stdClass $module_row The stdClass representation of the existing module row
     * @param array $vars An array of post data submitted to or on the edit
     *  module row page (used to repopulate fields after an error)
     * @return string HTML content containing information to display when viewing the edit module row page
     */
    public function manageEditRow($module_row, array &$vars)
    {
        // Load the view into this object, so helpers can be automatically added to the view
        $this->view = new View('edit_row', 'default');
        $this->view->base_uri = $this->base_uri;
        $this->view->setDefaultView('components' . DS . 'modules' . DS . '{{snake_case_name}}' . DS);

        // Load the helpers required for this view
        Loader::loadHelpers($this, ['Form', 'Html', 'Widget']);

        if (empty($vars)) {
            $vars = $module_row->meta;
        } else {
            // Set unset checkboxes
            $checkbox_fields = [{{array:module_rows}}{{if:module_rows.type:Checkbox}}'{{module_rows.name}}',{{else}}{{if:module_rows.type}}{{array:module_rows}}];

            foreach ($checkbox_fields as $checkbox_field) {
                if (!isset($vars[$checkbox_field])) {
                    $vars[$checkbox_field] = 'false';
                }
            }
        }

        $this->view->set('vars', (object) $vars);

        return $this->view->fetch();
    }{{function:editModuleRow}}{{function:addModuleRow}}

    /**
     * Adds the module row on the remote server. Sets Input errors on failure,
     * preventing the row from being added. Returns a set of data, which may be
     * a subset of $vars, that is stored for this module row.
     *
     * @param array $vars An array of module info to add
     * @return array A numerically indexed array of meta fields for the module row containing:
     *  - key The key for this meta field
     *  - value The value for this key
     *  - encrypted Whether or not this field should be encrypted (default 0, not encrypted)
     */
    public function addModuleRow(array &$vars)
    {
        $meta_fields = [{{array:module_rows}}'{{module_rows.name}}',{{array:module_rows}}];
        $encrypted_fields = [];

        // Set unset checkboxes
        $checkbox_fields = [{{array:module_rows}}{{if:module_rows.type:Checkbox}}'{{module_rows.name}}',{{else}}{{if:module_rows.type}}{{array:module_rows}}];

        foreach ($checkbox_fields as $checkbox_field) {
            if (!isset($vars[$checkbox_field])) {
                $vars[$checkbox_field] = 'false';
            }
        }

        $this->Input->setRules($this->getRowRules($vars));

        // Validate module row
        if ($this->Input->validates($vars)) {
            // Build the meta data for this row
            $meta = [];
            foreach ($vars as $key => $value) {
                if (in_array($key, $meta_fields)) {
                    $meta[] = [
                        'key' => $key,
                        'value' => $value,
                        'encrypted' => in_array($key, $encrypted_fields) ? 1 : 0
                    ];
                }
            }

            return $meta;
        }
    }{{function:addModuleRow}}{{function:editModuleRow}}

    /**
     * Edits the module row on the remote server. Sets Input errors on failure,
     * preventing the row from being updated. Returns a set of data, which may be
     * a subset of $vars, that is stored for this module row.
     *
     * @param stdClass $module_row The stdClass representation of the existing module row
     * @param array $vars An array of module info to update
     * @return array A numerically indexed array of meta fields for the module row containing:
     *  - key The key for this meta field
     *  - value The value for this key
     *  - encrypted Whether or not this field should be encrypted (default 0, not encrypted)
     */
    public function editModuleRow($module_row, array &$vars)
    {
        $meta_fields = [{{array:module_rows}}'{{module_rows.name}}',{{array:module_rows}}];
        $encrypted_fields = [];

        // Set unset checkboxes
        $checkbox_fields = [{{array:module_rows}}{{if:module_rows.type:Checkbox}}'{{module_rows.name}}',{{else}}{{if:module_rows.type}}{{array:module_rows}}];

        foreach ($checkbox_fields as $checkbox_field) {
            if (!isset($vars[$checkbox_field])) {
                $vars[$checkbox_field] = 'false';
            }
        }

        $this->Input->setRules($this->getRowRules($vars));

        // Validate module row
        if ($this->Input->validates($vars)) {
            // Build the meta data for this row
            $meta = [];
            foreach ($vars as $key => $value) {
                if (in_array($key, $meta_fields)) {
                    $meta[] = [
                        'key' => $key,
                        'value' => $value,
                        'encrypted' => in_array($key, $encrypted_fields) ? 1 : 0
                    ];
                }
            }

            return $meta;
        }
    }{{function:editModuleRow}}{{function:deleteModuleRow}}

    /**
     * Deletes the module row on the remote server. Sets Input errors on failure,
     * preventing the row from being deleted.
     *
     * @param stdClass $module_row The stdClass representation of the existing module row
     */
    public function deleteModuleRow($module_row)
    {
    }{{function:deleteModuleRow}}{{function:addModuleRow}}

    /**
     * Builds and returns the rules required to add/edit a module row (e.g. server).
     *
     * @param array $vars An array of key/value data pairs
     * @return array An array of Input rules suitable for Input::setRules()
     */
    private function getRowRules(&$vars)
    {
////// Defined below are a few common and useful validation functions.  To use them you can change the 'rule' line to
////// something along the lines of:
//////                    'rule' => [[$this, 'validateHostName']],
////// For more information on writing validation rules, see the
////// docs at https://docs.blesta.com/display/dev/Error+Checking
////
        $rules = [{{array:module_rows}}
            '{{module_rows.name}}' => [
                'valid' => [
                    'rule' => true,
                    'message' => Language::_('{{class_name}}.!error.{{module_rows.name}}.valid', true)
                ]
            ],{{array:module_rows}}
        ];

        return $rules;
    }
////
////    /**
////     * Validates that the given hostname is valid.
////     *
////     * @param string $host_name The host name to validate
////     * @return bool True if the hostname is valid, false otherwise
////     */
////    public function validateHostName($host_name)
////    {
////// Be sure to uncomment the Server use statement at the top of this file if you are going to uncomment this method
////        $validator = new Server();
////        return $validator->isDomain($host_name) || $validator->isIp($host_name);
////    }
////
////    /**
////     * Validates that at least 2 name servers are set in the given array of name servers.
////     *
////     * @param array $name_servers An array of name servers
////     * @return bool True if the array count is >= 2, false otherwise
////     */
////    public function validateNameServerCount($name_servers)
////    {
////        if (is_array($name_servers) && count($name_servers) >= 2) {
////            return true;
////        }
////
////        return false;
////    }
////
////    /**
////     * Validates that the nameservers given are formatted correctly.
////     *
////     * @param array $name_servers An array of name servers
////     * @return bool True if every name server is formatted correctly, false otherwise
////     */
////    public function validateNameServers($name_servers)
////    {
////// Be sure that you have also uncommented validateHostName() before you uncomment this method
////        if (is_array($name_servers)) {
////            foreach ($name_servers as $name_server) {
////                if (!$this->validateHostName($name_server)) {
////                    return false;
////                }
////            }
////        }
////
////        return true;
////    }
////
////
////    /**
////     * Validates whether or not the connection details are valid by attempting to fetch
////     * the number of accounts that currently reside on the server.
////     *
////     * @param string $password The ISPmanager server password
////     * @param string $hostname The ISPmanager server hostname
////     * @param string $user_name The ISPmanager server user name
////     * @param mixed $use_ssl Whether or not to use SSL
////     * @param int $account_count The number of existing accounts on the server
////     * @return bool True if the connection is valid, false otherwise
////     */
////    public function validateConnection($password, $hostname, $user_name, $use_ssl, &$account_count)
////    {
////        try {
////// Be sure that you've uncommented the getApi() method if you're uncommenting this code
//////            $api = $this->getApi($hostname, $user_name, $password, $use_ssl);
////
////            $params = compact('hostname', 'user_name', 'password', 'use_ssl');
////            $masked_params = $params;
////            $masked_params['user_name'] = '***';
////            $masked_params['password'] = '***';
////
////            $this->log($hostname . '|user', serialize($masked_params), 'input', true);
////
////            $response = $api->getAccounts();
////
////            $success = false;
////            if (!isset($response->error)) {
////                $account_count = isset($response->response) ? count($response->response) : 0;
////                $success = true;
////            }
////
////            $this->log($hostname . '|user', serialize($response), 'output', $success);
////
////            if ($success) {
////                return true;
////            }
////        } catch (Exception $e) {
////            // Trap any errors encountered, could not validate connection
////        }
////
////        return false;
////    }
{{function:addModuleRow}}{{function:getGroupOrderOptions}}

    /**
     * Returns an array of available service deligation order methods. The module
     * will determine how each method is defined. For example, the method "first"
     * may be implemented such that it returns the module row with the least number
     * of services assigned to it.
     *
     * @return array An array of order methods in key/value paris where the key is the
     *  type to be stored for the group and value is the name for that option
     * @see Module::selectModuleRow()
     */
    public function getGroupOrderOptions()
    {
        return [
            'roundrobin' => Language::_('{{class_name}}.order_options.roundrobin', true),
            'first' => Language::_('{{class_name}}.order_options.first', true)
        ];
    }{{function:getGroupOrderOptions}}{{function:selectModuleRow}}

    /**
     * Determines which module row should be attempted when a service is provisioned
     * for the given group based upon the order method set for that group.
     *
     * @return int The module row ID to attempt to add the service with
     * @see Module::getGroupOrderOptions()
     */
    public function selectModuleRow($module_group_id)
    {
        if (!isset($this->ModuleManager)) {
            Loader::loadModels($this, ['ModuleManager']);
        }

        $group = $this->ModuleManager->getGroup($module_group_id);

        if ($group) {
            switch ($group->add_order) {
                default:
                case 'first':
////
////                    foreach ($group->rows as $row) {
////                        return $row->id;
////                    }
////
                    break;
                case 'roundrobin':
                    break;
            }
        }
        return 0;
    }{{function:selectModuleRow}}{{function:addPackage}}

    /**
     * Validates input data when attempting to add a package, returns the meta
     * data to save when adding a package. Performs any action required to add
     * the package on the remote server. Sets Input errors on failure,
     * preventing the package from being added.
     *
     * @param array An array of key/value pairs used to add the package
     * @return array A numerically indexed array of meta fields to be stored for this package containing:
     *
     *  - key The key for this meta field
     *  - value The value for this key
     *  - encrypted Whether or not this field should be encrypted (default 0, not encrypted)
     * @see Module::getModule()
     * @see Module::getModuleRow()
     */
    public function addPackage(array $vars = null)
    {
        // Set rules to validate input data
        $this->Input->setRules($this->getPackageRules($vars));

        // Build meta data to return
        $meta = [];
        if ($this->Input->validates($vars)) {
            if (!isset($vars['meta'] )) {
                return [];
            }

            // Return all package meta fields
            foreach ($vars['meta'] as $key => $value) {
                $meta[] = [
                    'key' => $key,
                    'value' => $value,
                    'encrypted' => 0
                ];
            }
        }

        return $meta;
    }{{function:addPackage}}{{function:editPackage}}

    /**
     * Validates input data when attempting to edit a package, returns the meta
     * data to save when editing a package. Performs any action required to edit
     * the package on the remote server. Sets Input errors on failure,
     * preventing the package from being edited.
     *
     * @param stdClass $package A stdClass object representing the selected package
     * @param array An array of key/value pairs used to edit the package
     * @return array A numerically indexed array of meta fields to be stored for this package containing:
     *
     *  - key The key for this meta field
     *  - value The value for this key
     *  - encrypted Whether or not this field should be encrypted (default 0, not encrypted)
     * @see Module::getModule()
     * @see Module::getModuleRow()
     */
    public function editPackage($package, array $vars = null)
    {
        // Set rules to validate input data
        $this->Input->setRules($this->getPackageRules($vars));

        // Build meta data to return
        $meta = [];
        if ($this->Input->validates($vars)) {
            if (!isset($vars['meta'] )) {
                return [];
            }

            // Return all package meta fields
            foreach ($vars['meta'] as $key => $value) {
                $meta[] = [
                    'key' => $key,
                    'value' => $value,
                    'encrypted' => 0
                ];
            }
        }

        return $meta;
    }{{function:editPackage}}{{function:deletePackage}}

    /**
     * Deletes the package on the remote server. Sets Input errors on failure,
     * preventing the package from being deleted.
     *
     * @param stdClass $package A stdClass object representing the selected package
     * @see Module::getModule()
     * @see Module::getModuleRow()
     */
    public function deletePackage($package)
    {
    }{{function:deletePackage}}{{function:addPackage}}

    /**
     * Builds and returns rules required to be validated when adding/editing a package.
     *
     * @param array $vars An array of key/value data pairs
     * @return array An array of Input rules suitable for Input::setRules()
     */
    private function getPackageRules(array $vars)
    {
////// For info on writing validation rules, see the
////// docs at https://docs.blesta.com/display/dev/Error+Checking
////
        // Validate the package fields
        $rules = [{{array:package_fields}}
            '{{package_fields.name}}' => [
                'valid' => [
                    'rule' => true,
                    'message' => Language::_('{{class_name}}.!error.{{package_fields.name}}.valid', true)
                ]
            ],{{array:package_fields}}
        ];

        return $rules;
    }{{function:addPackage}}

    /**
     * Returns all fields used when adding/editing a package, including any
     * javascript to execute when the page is rendered with these fields.
     *
     * @param $vars stdClass A stdClass object representing a set of post fields
     * @return ModuleFields A ModuleFields object, containg the fields to
     *  render as well as any additional HTML markup to include
     */
    public function getPackageFields($vars = null)
    {
        Loader::loadHelpers($this, ['Html']);

        $fields = new ModuleFields();{{array:package_fields}}

        // Set the {{package_fields.label}} field
        ${{package_fields.name}} = $fields->label(Language::_('{{class_name}}.package_fields.{{package_fields.name}}', true), '{{snake_case_name}}_{{package_fields.name}}');
        ${{package_fields.name}}->attach(
            $fields->field{{package_fields.type}}(
                '{{package_fields.name}}',{{if:package_fields.type:Checkbox}}
                'true',{{else}}{{if:package_fields.type}}
                $this->Html->ifSet($vars->{{package_fields.name}}){{if:package_fields.type:Checkbox}} == 'true'{{else}}{{if:package_fields.type}},
                ['id' => '{{snake_case_name}}_{{package_fields.name}}']
            )
        );{{if:package_fields.tooltip:}}{{else}}
        // Add tooltip
        $tooltip = $fields->tooltip(Language::_('{{class_name}}.package_field.tooltip.{{package_fields.name}}', true));
        ${{package_fields.name}}->attach($tooltip);{{if:package_fields.tooltip}}
        $fields->setField(${{package_fields.name}});{{array:package_fields}}

        return $fields;
    }{{function:addService}}

    /**
     * Adds the service to the remote server. Sets Input errors on failure,
     * preventing the service from being added.
     *
     * @param stdClass $package A stdClass object representing the selected package
     * @param array $vars An array of user supplied info to satisfy the request
     * @param stdClass $parent_package A stdClass object representing the parent
     *  service's selected package (if the current service is an addon service)
     * @param stdClass $parent_service A stdClass object representing the parent
     *  service of the service being added (if the current service is an addon service
     *  service and parent service has already been provisioned)
     * @param string $status The status of the service being added. These include:
     *  - active
     *  - canceled
     *  - pending
     *  - suspended
     * @return array A numerically indexed array of meta fields to be stored for this service containing:
     *  - key The key for this meta field
     *  - value The value for this key
     *  - encrypted Whether or not this field should be encrypted (default 0, not encrypted)
     * @see Module::getModule()
     * @see Module::getModuleRow()
     */
    public function addService(
        $package,
        array $vars = null,
        $parent_package = null,
        $parent_service = null,
        $status = 'pending'
    ) {
////// Modules often load an API object to perform necessary actions on the remote server.  Below is some code
////// to ensure that we have a module row to connect to the server and to load the API object.  You will want
////// to replace the parameters being submitted to the method with those relevant for your module.  Uncomment
////// the getApi() method below and modify the parameters and doc comments
////        $row = $this->getModuleRow();
////
////        if (!$row) {
////            $this->Input->setErrors(
////                ['module_row' => ['missing' => Language::_('{{class_name}}.!error.module_row.missing', true)]]
////            );
////
////            return;
////        }
////
////        $api = $this->getApi($row->meta->host_name, $row->meta->user_name, $row->meta->password, $row->meta->use_ssl);
////
////// Modules often find it useful to do some processing and formatting before submitting data to the API.  Uncomment
////// the getFieldsFromInput() method below and update it to suite your needs.
////        $params = $this->getFieldsFromInput((array) $vars, $package);

        // Set unset checkboxes
        $checkbox_fields = [{{array:service_fields}}{{if:service_fields.type:Checkbox}}'{{service_fields.name}}',{{else}}{{if:service_fields.type}}{{array:service_fields}}];

        foreach ($checkbox_fields as $checkbox_field) {
            if (!isset($vars[$checkbox_field])) {
                $vars[$checkbox_field] = 'false';
            }
        }


        $this->validateService($package, $vars);

        if ($this->Input->errors()) {
            return;
        }

        // Only provision the service if 'use_module' is true
        if ($vars['use_module'] == 'true') {
        }

        // Return service fields
        return [{{array:service_fields}}
            [
                'key' => '{{service_fields.name}}',
                'value' => $vars['{{service_fields.name}}'],
                'encrypted' => 0
            ],{{array:service_fields}}
        ];
    }{{function:addService}}{{function:editService}}

    /**
     * Edits the service on the remote server. Sets Input errors on failure,
     * preventing the service from being edited.
     *
     * @param stdClass $package A stdClass object representing the current package
     * @param stdClass $service A stdClass object representing the current service
     * @param array $vars An array of user supplied info to satisfy the request
     * @param stdClass $parent_package A stdClass object representing the parent
     *  service's selected package (if the current service is an addon service)
     * @param stdClass $parent_service A stdClass object representing the parent
     *  service of the service being edited (if the current service is an addon service)
     * @return array A numerically indexed array of meta fields to be stored for this service containing:
     *  - key The key for this meta field
     *  - value The value for this key
     *  - encrypted Whether or not this field should be encrypted (default 0, not encrypted)
     * @see Module::getModule()
     * @see Module::getModuleRow()
     */
    public function editService($package, $service, array $vars = null, $parent_package = null, $parent_service = null)
    {
////// Modules often load an API object to perform necessary actions on the remote server.  Below is some code
////// to ensure that we have a module row to connect to the server and to load the API object.  You will want
////// to replace the parameters being submitted to the method with those relevant for your module.  Uncomment
////// the getApi() method below and modify the parameters and doc comments
////        $row = $this->getModuleRow();
////
////        if (!$row) {
////            $this->Input->setErrors(
////                ['module_row' => ['missing' => Language::_('{{class_name}}.!error.module_row.missing', true)]]
////            );
////
////            return;
////        }
////
////        $api = $this->getApi($row->meta->host_name, $row->meta->user_name, $row->meta->password, $row->meta->use_ssl);
////
////// Modules often find it useful to do some processing and formatting before submitting data to the API.  Uncomment
////// the getFieldsFromInput() method below and update it to suite your needs.
////        $params = $this->getFieldsFromInput((array) $vars, $package);

        // Set unset checkboxes
        $checkbox_fields = [{{array:service_fields}}{{if:service_fields.type:Checkbox}}'{{service_fields.name}}',{{else}}{{if:service_fields.type}}{{array:service_fields}}];

        foreach ($checkbox_fields as $checkbox_field) {
            if (!isset($vars[$checkbox_field])) {
                $vars[$checkbox_field] = 'false';
            }
        }

        $service_fields = $this->serviceFieldsToObject($service->fields);

        $this->validateService($package, $vars, true);

        if ($this->Input->errors()) {
            return;
        }

        // Only update the service if 'use_module' is true
        if ($vars['use_module'] == 'true') {
        }

        // Return all the service fields
        $fields = [];
        $encrypted_fields = [];
        foreach ($service_fields as $key => $value) {
            $fields[] = [
                'key' => $key,
                'value' => isset($vars[$key]) ? $vars[$key] : $value,
                'encrypted' => (in_array($key, $encrypted_fields) ? 1 : 0)
            ];
        }

        return $fields;
    }{{function:editService}}{{function:suspendService}}

    /**
     * Suspends the service on the remote server. Sets Input errors on failure,
     * preventing the service from being suspended.
     *
     * @param stdClass $package A stdClass object representing the current package
     * @param stdClass $service A stdClass object representing the current service
     * @param stdClass $parent_package A stdClass object representing the parent
     *  service's selected package (if the current service is an addon service)
     * @param stdClass $parent_service A stdClass object representing the parent
     *  service of the service being suspended (if the current service is an addon service)
     * @return mixed null to maintain the existing meta fields or a numerically
     *  indexed array of meta fields to be stored for this service containing:
     *  - key The key for this meta field
     *  - value The value for this key
     *  - encrypted Whether or not this field should be encrypted (default 0, not encrypted)
     * @see Module::getModule()
     * @see Module::getModuleRow()
     */
    public function suspendService($package, $service, $parent_package = null, $parent_service = null)
    {
        if (($row = $this->getModuleRow())) {
////            $api = $this->getApi(
////                $row->meta->host_name,
////                $row->meta->user_name,
////                $row->meta->password,
////                $row->meta->use_ssl
////            );
////
////            $service_fields = $this->serviceFieldsToObject($service->fields);
        }

        return null;
    }{{function:suspendService}}{{function:unsuspendService}}

    /**
     * Unsuspends the service on the remote server. Sets Input errors on failure,
     * preventing the service from being unsuspended.
     *
     * @param stdClass $package A stdClass object representing the current package
     * @param stdClass $service A stdClass object representing the current service
     * @param stdClass $parent_package A stdClass object representing the parent
     *  service's selected package (if the current service is an addon service)
     * @param stdClass $parent_service A stdClass object representing the parent
     *  service of the service being unsuspended (if the current service is an addon service)
     * @return mixed null to maintain the existing meta fields or a numerically
     *  indexed array of meta fields to be stored for this service containing:
     *  - key The key for this meta field
     *  - value The value for this key
     *  - encrypted Whether or not this field should be encrypted (default 0, not encrypted)
     * @see Module::getModule()
     * @see Module::getModuleRow()
     */
    public function unsuspendService($package, $service, $parent_package = null, $parent_service = null)
    {
        if (($row = $this->getModuleRow())) {
////            $api = $this->getApi(
////                $row->meta->host_name,
////                $row->meta->user_name,
////                $row->meta->password,
////                $row->meta->use_ssl
////            );
////
////            $service_fields = $this->serviceFieldsToObject($service->fields);
        }

        return null;
    }{{function:unsuspendService}}{{function:cancelService}}

    /**
     * Cancels the service on the remote server. Sets Input errors on failure,
     * preventing the service from being canceled.
     *
     * @param stdClass $package A stdClass object representing the current package
     * @param stdClass $service A stdClass object representing the current service
     * @param stdClass $parent_package A stdClass object representing the parent
     *  service's selected package (if the current service is an addon service)
     * @param stdClass $parent_service A stdClass object representing the parent
     *  service of the service being canceled (if the current service is an addon service)
     * @return mixed null to maintain the existing meta fields or a numerically
     *  indexed array of meta fields to be stored for this service containing:
     *  - key The key for this meta field
     *  - value The value for this key
     *  - encrypted Whether or not this field should be encrypted (default 0, not encrypted)
     * @see Module::getModule()
     * @see Module::getModuleRow()
     */
    public function cancelService($package, $service, $parent_package = null, $parent_service = null)
    {
////        if (($row = $this->getModuleRow())) {
////            $api = $this->getApi(
////                $row->meta->host_name,
////                $row->meta->user_name,
////                $row->meta->password,
////                $row->meta->use_ssl
////            );
////
////            $service_fields = $this->serviceFieldsToObject($service->fields);
////        }
////
        return null;
    }{{function:cancelService}}{{function:renewService}}

    /**
     * Allows the module to perform an action when the service is ready to renew.
     * Sets Input errors on failure, preventing the service from renewing.
     *
     * @param stdClass $package A stdClass object representing the current package
     * @param stdClass $service A stdClass object representing the current service
     * @param stdClass $parent_package A stdClass object representing the parent
     *  service's selected package (if the current service is an addon service)
     * @param stdClass $parent_service A stdClass object representing the parent
     *  service of the service being renewed (if the current service is an addon service)
     * @return mixed null to maintain the existing meta fields or a numerically
     *  indexed array of meta fields to be stored for this service containing:
     *  - key The key for this meta field
     *  - value The value for this key
     *  - encrypted Whether or not this field should be encrypted (default 0, not encrypted)
     * @see Module::getModule()
     * @see Module::getModuleRow()
     */
    public function renewService($package, $service, $parent_package = null, $parent_service = null)
    {
////        if (($row = $this->getModuleRow())) {
////            $api = $this->getApi(
////                $row->meta->host_name,
////                $row->meta->user_name,
////                $row->meta->password,
////                $row->meta->use_ssl
////            );
////
////            $service_fields = $this->serviceFieldsToObject($service->fields);
////        }
////
        return null;
    }{{function:renewService}}{{function:addService}}

    /**
     * Attempts to validate service info. This is the top-level error checking method. Sets Input errors on failure.
     *
     * @param stdClass $package A stdClass object representing the selected package
     * @param array $vars An array of user supplied info to satisfy the request
     * @return bool True if the service validates, false otherwise. Sets Input errors when false.
     */
    public function validateService($package, array $vars = null)
    {
        $this->Input->setRules($this->getServiceRules($vars));
        return $this->Input->validates($vars);
    }{{function:addService}}{{function:editService}}

    /**
     * Attempts to validate an existing service against a set of service info updates. Sets Input errors on failure.
     *
     * @param stdClass $service A stdClass object representing the service to validate for editing
     * @param array $vars An array of user-supplied info to satisfy the request
     * @return bool True if the service update validates or false otherwise. Sets Input errors when false.
     */
    public function validateServiceEdit($service, array $vars = null)
    {
        $this->Input->setRules($this->getServiceRules($vars, true));
        return $this->Input->validates($vars);
    }{{function:editService}}{{function:addService}}

    /**
     * Returns the rule set for adding/editing a service
     *
     * @param array $vars A list of input vars
     * @param bool $edit True to get the edit rules, false for the add rules
     * @return array Service rules
     */
    private function getServiceRules(array $vars = null, $edit = false)
    {
////// For info on writing validation rules, see the
////// docs at https://docs.blesta.com/display/dev/Error+Checking
////
        // Validate the service fields
        $rules = [{{array:service_fields}}
            '{{service_fields.name}}' => [
                'valid' => [
                    'if_set' => $edit,
                    'rule' => true,
                    'message' => Language::_('{{class_name}}.!error.{{service_fields.name}}.valid', true)
                ]
            ],{{array:service_fields}}
        ];

        // Unset irrelevant rules when editing a service
        if ($edit) {
            $edit_fields = [];

            foreach ($rules as $field => $rule) {
                if (!in_array($field, $edit_fields)) {
                    unset($rules[$field]);
                }
            }
        }

        return $rules;
    }{{function:addService}}{{function:changeServicePackage}}

    /**
     * Updates the package for the service on the remote server. Sets Input
     * errors on failure, preventing the service's package from being changed.
     *
     * @param stdClass $package_from A stdClass object representing the current package
     * @param stdClass $package_to A stdClass object representing the new package
     * @param stdClass $service A stdClass object representing the current service
     * @param stdClass $parent_package A stdClass object representing the parent
     *  service's selected package (if the current service is an addon service)
     * @param stdClass $parent_service A stdClass object representing the parent
     *  service of the service being changed (if the current service is an addon service)
     * @return mixed null to maintain the existing meta fields or a numerically
     *  indexed array of meta fields to be stored for this service containing:
     *  - key The key for this meta field
     *  - value The value for this key
     *  - encrypted Whether or not this field should be encrypted (default 0, not encrypted)
     * @see Module::getModule()
     * @see Module::getModuleRow()
     */
    public function changeServicePackage(
        $package_from,
        $package_to,
        $service,
        $parent_package = null,
        $parent_service = null
    ) {
        if (($row = $this->getModuleRow())) {
////            $api = $this->getApi(
////                $row->meta->host_name,
////                $row->meta->user_name,
////                $row->meta->password,
////                ($row->meta->use_ssl == 'true')
////            );
////
        }

        return null;
    }{{function:changeServicePackage}}{{function:addService}}
////
////    /**
////     * Initializes the {{class_name}}Api and returns an instance of that object.
////     *
////     * @param string $hostname The {{name}} server hostname
////     * @param string $user_name The {{name}} server user name
////     * @param string $password The {{name}} server password
////     * @param mixed $use_ssl Whether or not to use SSL
////     * @return {{class_name}}Api The {{class_name}}Api instance
////     */
////    private function getApi($hostname, $user_name, $password, $use_ssl = 'true')
////    {
////        Loader::load(dirname(__FILE__) . DS . 'apis' . DS . '{{snake_case_name}}_api.php');
////
////        $api = new {{class_name}}Api($hostname, $user_name, $password, $use_ssl === 'true');
////
////        return $api;
////    }
////
////    /**
////     * Returns an array of service field to set for the service using the given input
////     *
////     * @param array $vars An array of key/value input pairs
////     * @param stdClass $package A stdClass object representing the package for the service
////     * @return array An array of key/value pairs representing service fields
////     */
////    private function getFieldsFromInput(array $vars, $package)
////    {
////        $domain = isset($vars['domain']) ? strtolower($vars['domain']) : null;
////        $username = !empty($vars['username'])
////            ? $vars['username']
////            : $this->generateUsername($domain);
////        $password = !empty($vars['password']) ? $vars['password'] : $this->generatePassword();
////        $fields = [
////            'domain' => $domain,
////            'username' => $username,
////            'password' => $password,
////            'confirm_password' => $password,
////        ];
////
////        return $fields;
////    }
////
////    /**
////     * Generates a username from the given host name.
////     *
////     * @param string $host_name The host name to use to generate the username
////     * @return string The username generated from the given hostname
////     */
////    private function generateUsername($host_name)
////    {
////        // Remove everything except letters and numbers from the domain
////        // ensure no number appears in the beginning
////        $username = ltrim(preg_replace('/[^a-z0-9]/i', '', $host_name), '0123456789');
////
////        $length = strlen($username);
////        $pool = 'abcdefghijklmnopqrstuvwxyz0123456789';
////        $pool_size = strlen($pool);
////
////        if ($length < 5) {
////            for ($i = $length; $i < 8; $i++) {
////                $username .= substr($pool, mt_rand(0, $pool_size - 1), 1);
////            }
////            $length = strlen($username);
////        }
////
////        $username = substr($username, 0, min($length, 8));
////
////        // Check for an existing user account
////        $row = $this->getModuleRow();
////
////        if ($row) {
////            $api = $this->getApi($row->meta->host_name, $row->meta->user_name, $row->meta->password, $row->meta->use_ssl);
////
////            // Username exists, create another instead
////            if ($api->accountExists($username)) {
////                for ($i = 0; strlen((string)$i) < 8; $i++) {
////                    $new_username = substr($username, 0, -strlen((string)$i)) . $i;
////                    if (!$api->accountExists($new_username)) {
////                        $username = $new_username;
////                        break;
////                    }
////                }
////            }
////        }
////
////        return $username;
////    }
////
////    /**
////     * Generates a password.
////     *
////     * @param int $min_length The minimum character length for the password (5 or larger)
////     * @param int $max_length The maximum character length for the password (14 or fewer)
////     * @return string The generated password
////     */
////    private function generatePassword($min_length = 10, $max_length = 14)
////    {
////        $pool = 'abcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()';
////        $pool_size = strlen($pool);
////        $length = mt_rand(max($min_length, 5), min($max_length, 14));
////        $password = '';
////
////        for ($i = 0; $i < $length; $i++) {
////            $password .= substr($pool, mt_rand(0, $pool_size - 1), 1);
////        }
////
////        return $password;
////    }
{{function:addService}}{{function:getAdminServiceInfo}}

    /**
     * Fetches the HTML content to display when viewing the service info in the
     * admin interface.
     *
     * @param stdClass $service A stdClass object representing the service
     * @param stdClass $package A stdClass object representing the service's package
     * @return string HTML content containing information to display when viewing the service info
     */
    public function getAdminServiceInfo($service, $package)
    {
        $row = $this->getModuleRow();

        // Load the view into this object, so helpers can be automatically added to the view
        $this->view = new View('admin_service_info', 'default');
        $this->view->base_uri = $this->base_uri;
        $this->view->setDefaultView('components' . DS . 'modules' . DS . '{{snake_case_name}}' . DS);

        // Load the helpers required for this view
        Loader::loadHelpers($this, ['Form', 'Html']);

        $this->view->set('module_row', $row);
        $this->view->set('package', $package);
        $this->view->set('service', $service);
        $this->view->set('service_fields', $this->serviceFieldsToObject($service->fields));

        return $this->view->fetch();
    }{{function:getAdminServiceInfo}}{{function:getClientServiceInfo}}

    /**
     * Fetches the HTML content to display when viewing the service info in the
     * client interface.
     *
     * @param stdClass $service A stdClass object representing the service
     * @param stdClass $package A stdClass object representing the service's package
     * @return string HTML content containing information to display when viewing the service info
     */
    public function getClientServiceInfo($service, $package)
    {
        $row = $this->getModuleRow();

        // Load the view into this object, so helpers can be automatically added to the view
        $this->view = new View('client_service_info', 'default');
        $this->view->base_uri = $this->base_uri;
        $this->view->setDefaultView('components' . DS . 'modules' . DS . '{{snake_case_name}}' . DS);

        // Load the helpers required for this view
        Loader::loadHelpers($this, ['Form', 'Html']);

        $this->view->set('module_row', $row);
        $this->view->set('package', $package);
        $this->view->set('service', $service);
        $this->view->set('service_fields', $this->serviceFieldsToObject($service->fields));

        return $this->view->fetch();
    }{{function:getClientServiceInfo}}{{function:getClientTabs}}

    /**
     * Returns all tabs to display to a client when managing a service whose
     * package uses this module
     *
     * @param stdClass $package A stdClass object representing the selected package
     * @return array An array of tabs in the format of method => title.
     *  Example: array('methodName' => "Title", 'methodName2' => "Title2")
     */
    public function getClientTabs($package)
    {
        return [{{array:service_tabs}}
            '{{service_tabs.method_name}}' => Language::_('{{class_name}}.{{service_tabs.method_name}}', true),{{array:service_tabs}}
        ];
    }{{function:getClientTabs}}{{function:getAdminTabs}}

    /**
     * Returns all tabs to display to an admin when managing a service whose
     * package uses this module
     *
     * @param stdClass $package A stdClass object representing the selected package
     * @return array An array of tabs in the format of method => title.
     *  Example: array('methodName' => "Title", 'methodName2' => "Title2")
     */
    public function getAdminTabs($package)
    {
        return [{{array:service_tabs}}
            '{{service_tabs.method_name}}' => Language::_('{{class_name}}.{{service_tabs.method_name}}', true),{{array:service_tabs}}
        ];
    }{{function:getAdminTabs}}{{array:service_tabs}}

    /**
     * {{service_tabs.method_name}}
     *
     * @param stdClass $package A stdClass object representing the current package
     * @param stdClass $service A stdClass object representing the current service
     * @param array $get Any GET parameters
     * @param array $post Any POST parameters
     * @param array $files Any FILES parameters
     * @return string The string representing the contents of this tab
     */
    public function {{service_tabs.method_name}}(
        $package,
        $service,
        array $get = null,
        array $post = null,
        array $files = null
    ) {
        $this->view = new View('tab', 'default');
        $this->view->base_uri = $this->base_uri;
        // Load the helpers required for this view
        Loader::loadHelpers($this, ['Form', 'Html']);

        $service_fields = $this->serviceFieldsToObject($service->fields);

        if (!empty($post)) {

            // Perform any post actions

            if ($this->Services->errors()) {
                $this->Input->setErrors($this->Services->errors());
            }

            $vars = (object)$post;
        }

        $this->view->set('tab', '{{service_tabs.method_name}}');
        $this->view->set('service_fields', $service_fields);
        $this->view->set('service_id', $service->id);
        $this->view->set('client_id', $service->client_id);
        $this->view->set('vars', (isset($vars) ? $vars : new stdClass()));

        $this->view->setDefaultView('components' . DS . 'modules' . DS . '{{snake_case_name}}' . DS);
        return $this->view->fetch();
    }{{array:service_tabs}}

    /**
     * Returns all fields to display to an admin attempting to add a service with the module
     *
     * @param stdClass $package A stdClass object representing the selected package
     * @param $vars stdClass A stdClass object representing a set of post fields
     * @return ModuleFields A ModuleFields object, containg the fields to render
     *  as well as any additional HTML markup to include
     */
    public function getAdminAddFields($package, $vars = null)
    {
        Loader::loadHelpers($this, ['Html']);

        $fields = new ModuleFields();{{array:service_fields}}

        // Set the {{service_fields.label}} field
        ${{service_fields.name}} = $fields->label(Language::_('{{class_name}}.service_fields.{{service_fields.name}}', true), '{{snake_case_name}}_{{service_fields.name}}');
        ${{service_fields.name}}->attach(
            $fields->field{{service_fields.type}}(
                '{{service_fields.name}}',{{if:service_fields.type:Checkbox}}
                'true',{{else}}{{if:service_fields.type}}
                $this->Html->ifSet($vars->{{service_fields.name}}){{if:service_fields.type:Checkbox}} == 'true'{{else}}{{if:service_fields.type}},
                ['id' => '{{snake_case_name}}_{{service_fields.name}}']
            )
        );{{if:service_fields.tooltip:}}{{else}}
        // Add tooltip
        $tooltip = $fields->tooltip(Language::_('{{class_name}}.package_field.tooltip.{{service_fields.name}}', true));
        ${{service_fields.name}}->attach($tooltip);{{if:service_fields.tooltip}}
        $fields->setField(${{service_fields.name}});{{array:service_fields}}

        return $fields;
    }

    /**
     * Returns all fields to display to an admin attempting to edit a service with the module
     *
     * @param stdClass $package A stdClass object representing the selected package
     * @param $vars stdClass A stdClass object representing a set of post fields
     * @return ModuleFields A ModuleFields object, containg the fields to render
     *  as well as any additional HTML markup to include
     */
    public function getAdminEditFields($package, $vars = null)
    {
        Loader::loadHelpers($this, ['Html']);

        $fields = new ModuleFields();{{array:service_fields}}

        // Set the {{service_fields.label}} field
        ${{service_fields.name}} = $fields->label(Language::_('{{class_name}}.service_fields.{{service_fields.name}}', true), '{{snake_case_name}}_{{service_fields.name}}');
        ${{service_fields.name}}->attach(
            $fields->field{{service_fields.type}}(
                '{{service_fields.name}}',{{if:service_fields.type:Checkbox}}
                'true',{{else}}{{if:service_fields.type}}
                $this->Html->ifSet($vars->{{service_fields.name}}){{if:service_fields.type:Checkbox}} == 'true'{{else}}{{if:service_fields.type}},
                ['id' => '{{snake_case_name}}_{{service_fields.name}}']
            )
        );{{if:service_fields.tooltip:}}{{else}}
        // Add tooltip
        $tooltip = $fields->tooltip(Language::_('{{class_name}}.package_field.tooltip.{{service_fields.name}}', true));
        ${{service_fields.name}}->attach($tooltip);{{if:service_fields.tooltip}}
        $fields->setField(${{service_fields.name}});{{array:service_fields}}

        return $fields;
    }

    /**
     * Returns all fields to display to a client attempting to add a service with the module
     *
     * @param stdClass $package A stdClass object representing the selected package
     * @param $vars stdClass A stdClass object representing a set of post fields
     * @return ModuleFields A ModuleFields object, containg the fields to render
     *  as well as any additional HTML markup to include
     */
    public function getClientAddFields($package, $vars = null)
    {
        Loader::loadHelpers($this, ['Html']);

        $fields = new ModuleFields();{{array:service_fields}}

        // Set the {{service_fields.label}} field
        ${{service_fields.name}} = $fields->label(Language::_('{{class_name}}.service_fields.{{service_fields.name}}', true), '{{snake_case_name}}_{{service_fields.name}}');
        ${{service_fields.name}}->attach(
            $fields->field{{service_fields.type}}(
                '{{service_fields.name}}',{{if:service_fields.type:Checkbox}}
                'true',{{else}}{{if:service_fields.type}}
                $this->Html->ifSet($vars->{{service_fields.name}}){{if:service_fields.type:Checkbox}} == 'true'{{else}}{{if:service_fields.type}},
                ['id' => '{{snake_case_name}}_{{service_fields.name}}']
            )
        );{{if:service_fields.tooltip:}}{{else}}
        // Add tooltip
        $tooltip = $fields->tooltip(Language::_('{{class_name}}.package_field.tooltip.{{service_fields.name}}', true));
        ${{service_fields.name}}->attach($tooltip);{{if:service_fields.tooltip}}
        $fields->setField(${{service_fields.name}});{{array:service_fields}}

        return $fields;
    }

    /**
     * Returns all fields to display to a client attempting to edit a service with the module
     *
     * @param stdClass $package A stdClass object representing the selected package
     * @param $vars stdClass A stdClass object representing a set of post fields
     * @return ModuleFields A ModuleFields object, containg the fields to render
     *  as well as any additional HTML markup to include
     */
    public function getClientEditFields($package, $vars = null)
    {
        Loader::loadHelpers($this, ['Html']);

        $fields = new ModuleFields();{{array:service_fields}}

        // Set the {{service_fields.label}} field
        ${{service_fields.name}} = $fields->label(Language::_('{{class_name}}.service_fields.{{service_fields.name}}', true), '{{snake_case_name}}_{{service_fields.name}}');
        ${{service_fields.name}}->attach(
            $fields->field{{service_fields.type}}(
                '{{service_fields.name}}',{{if:service_fields.type:Checkbox}}
                'true',{{else}}{{if:service_fields.type}}
                $this->Html->ifSet($vars->{{service_fields.name}}){{if:service_fields.type:Checkbox}} == 'true'{{else}}{{if:service_fields.type}},
                ['id' => '{{snake_case_name}}_{{service_fields.name}}']
            )
        );{{if:service_fields.tooltip:}}{{else}}
        // Add tooltip
        $tooltip = $fields->tooltip(Language::_('{{class_name}}.package_field.tooltip.{{service_fields.name}}', true));
        ${{service_fields.name}}->attach($tooltip);{{if:service_fields.tooltip}}
        $fields->setField(${{service_fields.name}});{{array:service_fields}}

        return $fields;
    }{{function:addCronTasks}}

    /**
     * Attempts to add new cron tasks for this module
     *
     * @param array $tasks A list of cron tasks to add
     */
    private function addCronTasks(array $tasks)
    {
        Loader::loadModels($this, ['CronTasks']);
        foreach ($tasks as $task) {
            $task_id = $this->CronTasks->add($task);

            if (!$task_id) {
                $cron_task = $this->CronTasks->getByKey($task['key'], $task['dir'], $task['task_type']);
                if ($cron_task) {
                    $task_id = $cron_task->id;
                }
            }

            if ($task_id) {
                $task_vars = ['enabled' => $task['enabled']];
                if ($task['type'] === 'time') {
                    $task_vars['time'] = $task['type_value'];
                } else {
                    $task_vars['interval'] = $task['type_value'];
                }

                $this->CronTasks->addTaskRun($task_id, $task_vars);
            }
        }
    }{{function:addCronTasks}}{{function:getCronTasks}}

    /**
     * Retrieves cron tasks available to this module along with their default values
     *
     * @return array A list of cron tasks
     */
    private function getCronTasks()
    {
        return [{{array:cron_tasks}}
            [
                'key' => '{{cron_tasks.name}}',
                'task_type' => 'module',
                'dir' => '{{snake_case_name}}',
                'name' => Language::_('{{class_name}}.getCronTasks.{{cron_tasks.name}}', true),
                'description' => Language::_('{{class_name}}.getCronTasks.{{cron_tasks.name}}_description', true),
                'type' => '{{cron_tasks.type}}',
                'type_value' => '{{cron_tasks.time}}',
                'enabled' => 1
            ],{{array:cron_tasks}}
        ];
    }

    /**
     * Runs the cron task identified by the key used to create the cron task
     *
     * @param string $key The key used to create the cron task
     * @see CronTasks::add()
     */
    public function cron($key)
    {
        switch ($key) {{{array:cron_tasks}}
            case '{{cron_tasks.name}}':
                // Perform necessary actions
                break;{{array:cron_tasks}}
        }
    }
    {{function:getCronTasks}}
}
