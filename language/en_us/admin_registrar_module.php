<?php
// Controller get functions

$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_checkAvailability'] = 'Checks if a domain name is available or not, returns boolean.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_checkTransferAvailability'] = 'Checks if a domain name can be transferred, returns boolean.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_getDomainInfo'] = 'Fetches the information of a given domain name.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_getExpirationDate'] = 'Returns the expiration date of a given domain name.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_getTldPricing'] = 'Returns an array containing the cost price of all available TLDs';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_registerDomain'] = 'Performs any action required to register a new domain name. Sets Input errors on failure, preventing the domain name registration.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_renewDomain'] = 'Performs any action required to renew an existing domain name. Sets Input errors on failure, preventing the renewal of the domain name.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_transferDomain'] = 'Performs any action required to transfer a domain name. Sets Input errors on failure, preventing the domain name from being transferred.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_getDomainContacts'] = 'Returns an array containing all the contacts associated to the domain name.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_getDomainIsLocked'] = 'Returns whether or not the domain is locked, returns boolean.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_getDomainNameServers'] = 'Returns the name servers of the domain.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_lockDomain'] = 'Performs any action required to lock the domain. Sets Input errors on failure, preventing the domain from being locked.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_unlockDomain'] = 'Performs any action required to unlock the domain. Sets Input errors on failure, preventing the domain from being unlocked.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_updateEppCode'] = 'Performs any action required to update the EPP or Authorization code of the domain. Sets Input errors on failure, preventing the code from being updated.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_restoreDomain'] = 'Performs any action required to restore a domain. Sets Input errors on failure, preventing the domain from being restored.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_setNameserverIps'] = 'Sets the name servers for a given domain name.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_sendEppEmail'] = 'Performs any action required to send an email containing the EPP code.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_cancelService'] = 'Called to perform module actions on service cancellation.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_suspendService'] = 'Called to perform module actions on service suspension.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_unsuspendService'] = 'Called to perform module actions on service unsuspension.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_renewService'] = 'Called to perform module actions when a service is renewed.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_addPackage'] = 'Performs any action required to add the package on the remote server. Sets Input errors on failure, preventing the package from being added.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_editPackage'] = 'Performs any action required to edit the package on the remote server. Sets Input errors on failure, preventing the package from being edited.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_deletePackage'] = 'Deletes the package on the remote server. Sets Input errors on failure, preventing the package from being deleted.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_deleteModuleRow'] = 'Deletes the module row on the remote server. Sets Input errors on failure, preventing the row from being deleted.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_manageAddRow'] = 'Returns the rendered view of the add module row page';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_manageEditRow'] = 'Returns the rendered view of the edit module row page';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_upgrade'] = 'Performs migration of data from $current_version (the current installed version) to the given file set version. Sets Input errors on failure, preventing the module from being upgraded.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_getGroupOrderOptions'] = 'Returns an array of available service delegation order methods. The module will determine how each method is defined. For example, the method "first" may be implemented such that it returns the module row with the least number of services assigned to it.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_selectModuleRow'] = 'Determines which module row should be attempted when a service is provisioned for the given group based upon the order method set for that group.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_getAdminServiceInfo'] = 'Fetches the HTML content to display when viewing the service info in the admin interface.';
$lang['AdminRegistrarModule.getoptionalfunctions.tooltip_getClientServiceInfo'] = 'Fetches the HTML content to display when viewing the service info in the client interface.';

// Page title
$lang['AdminRegistrarModule.index.page_title'] = 'Extension Generator - %1$s'; // %1$s is the module name

$lang['AdminRegistrarModule.index.boxtitle_extension_generator'] = 'Extension Generator - Module';


// Basic info page
$lang['AdminRegistrarModule.basic.heading_basic'] = 'Basic Information';
$lang['AdminRegistrarModule.basic.heading_authors'] = 'Authors';
$lang['AdminRegistrarModule.basic.heading_tlds'] = 'Supported TLDs';

$lang['AdminRegistrarModule.basic.description'] = 'Description';
$lang['AdminRegistrarModule.basic.logo'] = 'Logo';
$lang['AdminRegistrarModule.basic.module_row'] = 'Module Row Name';
$lang['AdminRegistrarModule.basic.module_row_plural'] = 'Module Row Name (Plural)';
$lang['AdminRegistrarModule.basic.module_group'] = 'Module Group Label';
$lang['AdminRegistrarModule.basic.author_name'] = 'Author Name';
$lang['AdminRegistrarModule.basic.author_url'] = 'Author URL';
$lang['AdminRegistrarModule.basic.text_options'] = 'Options';
$lang['AdminRegistrarModule.basic.author_row_add'] = 'Add Author';
$lang['AdminRegistrarModule.basic.text_remove'] = 'Remove';
$lang['AdminRegistrarModule.basic.static_tlds'] = 'Statically Define TLDs';
$lang['AdminRegistrarModule.basic.tlds'] = 'TLDs';

$lang['AdminRegistrarModule.basic.tooltip_description'] = 'The description shown in the module listing';
$lang['AdminRegistrarModule.basic.tooltip_logo'] = 'The logo displayed in the module listing';
$lang['AdminRegistrarModule.basic.tooltip_module_row'] = 'The term by which to refer to a single module row for this module';
$lang['AdminRegistrarModule.basic.tooltip_module_row_plural'] = 'The term by which to refer to multiple module rows for this module';
$lang['AdminRegistrarModule.basic.tooltip_module_group'] = 'The term by which to refer to module row groups for this module';
$lang['AdminRegistrarModule.basic.tooltip_static_tlds'] = 'Define the TLDs supported by this module as a comma separated list (e.g. .com,.net,.org)';

$lang['AdminRegistrarModule.basic.placeholder_module_row'] = 'e.g. Server';
$lang['AdminRegistrarModule.basic.placeholder_module_row_plural'] = 'e.g. Servers';
$lang['AdminRegistrarModule.basic.placeholder_module_group'] = 'e.g. Server Group';
$lang['AdminRegistrarModule.basic.placeholder_author_name'] = 'e.g. Blesta';
$lang['AdminRegistrarModule.basic.placeholder_author_url'] = 'e.g. https://blesta.com/';
$lang['AdminRegistrarModule.basic.placeholder_tlds'] = '.com,.net,.org';

$lang['AdminRegistrarModule.basic.fields'] = 'Next - Module Fields';
$lang['AdminRegistrarModule.basic.confirm'] = 'Next - Confirmation';


// Fields page
$lang['AdminRegistrarModule.fields.heading_module_row_fields'] = 'Module Row Fields';
$lang['AdminRegistrarModule.fields.heading_package_fields'] = 'Package Fields';
$lang['AdminRegistrarModule.fields.heading_service_fields'] = 'Service Fields';

$lang['AdminRegistrarModule.fields.name'] = 'Name';
$lang['AdminRegistrarModule.fields.label'] = 'Label';
$lang['AdminRegistrarModule.fields.type'] = 'Type';
$lang['AdminRegistrarModule.fields.tooltip'] = 'Tooltip Text';
$lang['AdminRegistrarModule.fields.name_key'] = 'Name Key';

$lang['AdminRegistrarModule.fields.tooltip_name'] = 'The name of the field in the code base';
$lang['AdminRegistrarModule.fields.tooltip_label'] = 'The display name of the field';
$lang['AdminRegistrarModule.fields.tooltip_type'] = 'The type of field to create (checkbox, text, etc.)';
$lang['AdminRegistrarModule.fields.tooltip_tooltip'] = 'The text of the tooltip to display along side the field (leave empty to have no tooltip)';
$lang['AdminRegistrarModule.fields.tooltip_name_key'] = 'The field by which Blesta determines the name of a package/service/module row';

$lang['AdminRegistrarModule.fields.placeholder_module_name'] = 'e.g. module_field';
$lang['AdminRegistrarModule.fields.placeholder_module_label'] = 'e.g. Module Field';
$lang['AdminRegistrarModule.fields.placeholder_package_name'] = 'e.g. package_field';
$lang['AdminRegistrarModule.fields.placeholder_package_label'] = 'e.g. Package Field';
$lang['AdminRegistrarModule.fields.placeholder_service_name'] = 'e.g. service_field';
$lang['AdminRegistrarModule.fields.placeholder_service_label'] = 'e.g. Service Field';

$lang['AdminRegistrarModule.fields.module_row_add'] = 'Add Module Row Field';
$lang['AdminRegistrarModule.fields.package_row_add'] = 'Add Package Field';
$lang['AdminRegistrarModule.fields.service_row_add'] = 'Add Service Field';

$lang['AdminRegistrarModule.fields.text_options'] = 'Options';
$lang['AdminRegistrarModule.fields.text_remove'] = 'Remove';

$lang['AdminRegistrarModule.fields.features'] = 'Next - Additional Features';

$lang['AdminRegistrarModule.fields.package_fields_epp_code_label'] = 'EPP Code';
$lang['AdminRegistrarModule.fields.package_fields_epp_code_tooltip'] = 'Whether to allow users to request an EPP Code through the Blesta service interface.';
$lang['AdminRegistrarModule.fields.service_fields_domain_label'] = 'Domain';

// Additional features page
$lang['AdminRegistrarModule.features.heading_features'] = 'Additional Features';
$lang['AdminRegistrarModule.features.heading_service_tabs'] = 'Service Management Tabs';
$lang['AdminRegistrarModule.features.heading_cron_tasks'] = 'Cron Tasks';
$lang['AdminRegistrarModule.features.heading_optional_functions'] = 'Optional Functions';

$lang['AdminRegistrarModule.features.method_name'] = 'Method Name';
$lang['AdminRegistrarModule.features.label'] = 'Label';
$lang['AdminRegistrarModule.features.level'] = 'Level';
$lang['AdminRegistrarModule.features.name'] = 'Name';
$lang['AdminRegistrarModule.features.description'] = 'Description';
$lang['AdminRegistrarModule.features.type'] = 'Type';
$lang['AdminRegistrarModule.features.time'] = 'Start Time/Interval';

$lang['AdminRegistrarModule.features.tooltip_method_name'] = 'The name of the method to be generated for this tab in the code base (in the form camelCaseMethodName)';
$lang['AdminRegistrarModule.features.tooltip_tab_label'] = 'The display name of the service tab';
$lang['AdminRegistrarModule.features.tooltip_level'] = 'The level of interface on which to display the tab (staff or client)';
$lang['AdminRegistrarModule.features.tooltip_name'] = 'The name of the cron task in the code base';
$lang['AdminRegistrarModule.features.tooltip_cron_label'] = 'The display name of the cron task';
$lang['AdminRegistrarModule.features.tooltip_description'] = 'The description shown on the cron task list page';
$lang['AdminRegistrarModule.features.tooltip_type'] = 'The type of timing to use for the cron task (time or interval)';
$lang['AdminRegistrarModule.features.tooltip_time'] = 'The daily 24-hour time that this task should run (e.g. "14:25") OR The interval, in minutes, that this cron task should run';

$lang['AdminRegistrarModule.features.placeholder_method_name'] = 'e.g. tabChangePassword';
$lang['AdminRegistrarModule.features.placeholder_tab_label'] = 'e.g. Change Password';
$lang['AdminRegistrarModule.features.placeholder_name'] = 'e.g. my_cron_task';
$lang['AdminRegistrarModule.features.placeholder_cron_label'] = 'e.g. My Cron Task';
$lang['AdminRegistrarModule.features.placeholder_time'] = 'e.g. 14:25 or 60';

$lang['AdminRegistrarModule.features.service_tab_row_add'] = 'Add Service Management Tab';
$lang['AdminRegistrarModule.features.cron_task_row_add'] = 'Add Cron Task';

$lang['AdminRegistrarModule.features.text_options'] = 'Options';
$lang['AdminRegistrarModule.features.text_remove'] = 'Remove';

$lang['AdminRegistrarModule.features.confirm'] = 'Next - Confirmation';
