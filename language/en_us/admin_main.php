<?php

// Error messages
$lang['AdminMain.!error.generation_failed'] = 'Unable to generate your extension.  Exception generated: %1$s'; // Where %1$s is the exeption message
$lang['AdminMain.!error.logo_upload_failed'] = 'Unable to generate your extension.  Exception generated: %1$s'; // Where %1$s is the exeption message


// Success messages
$lang['AdminMain.!success.package_deleted'] = 'The extension has been successfully deleted';
$lang['AdminMain.!success.module_created'] = 'The new module has been successfully generated and can be found at %1$s'; // Where %1$s is the path to the created module's directory
$lang['AdminMain.!success.plugin_created'] = 'The new plugin has been successfully generated and can be found at %1$s'; // Where %1$s is the path to the created plugin's directory
$lang['AdminMain.!success.gateway_created'] = 'The new gateway has been successfully generated and can be found at %1$s'; // Where %1$s is the path to the created gateway's directory


// Controller get functions

$lang['AdminMain.getfieldtypes.text'] = 'Text';
$lang['AdminMain.getfieldtypes.textarea'] = 'Textarea';
$lang['AdminMain.getfieldtypes.checkbox'] = 'Checkbox';

$lang['AdminMain.getfieldtypes.text'] = 'Text';
$lang['AdminMain.getfieldtypes.textarea'] = 'Textarea';
$lang['AdminMain.getfieldtypes.checkbox'] = 'Checkbox';

$lang['AdminMain.gettablevels.staff'] = 'Staff';
$lang['AdminMain.gettablevels.client'] = 'Client';

$lang['AdminMain.gettasktypes.time'] = 'Time';
$lang['AdminMain.gettasktypes.interval'] = 'Interval';

$lang['AdminMain.getfilelocations.module'] = 'Blesta Modules Directory';
$lang['AdminMain.getfilelocations.plugin'] = 'Blesta Plugins Directory';
$lang['AdminMain.getfilelocations.gateway'] = 'Blesta Gateways Directory';
$lang['AdminMain.getfilelocations.upload'] = 'Blesta Uploads Directory';
$lang['AdminMain.getfilelocations.custom'] = 'Custom';

$lang['AdminMain.getnodes.general_settings'] = 'General Settings';
$lang['AdminMain.getnodes.basic_info'] = 'Basic Info';
$lang['AdminMain.getnodes.module_fields'] = 'Module Fields';
$lang['AdminMain.getnodes.additional_features'] = 'Additional Features';
$lang['AdminMain.getnodes.confirm'] = 'Confirmation';

$lang['AdminMain.getoptionalfunctions.tooltip_cancelService'] = 'Called to perform module actions on service cancellation.';
$lang['AdminMain.getoptionalfunctions.tooltip_suspendService'] = 'Called to perform module actions on service suspension.';
$lang['AdminMain.getoptionalfunctions.tooltip_unsuspendService'] = 'Called to perform module actions on service unsuspension.';
$lang['AdminMain.getoptionalfunctions.tooltip_renewService'] = 'Called to perform module actions when a service is renewed.';
$lang['AdminMain.getoptionalfunctions.tooltip_addPackage'] = 'Performs any action required to add the package on the remote server. Sets Input errors on failure, preventing the package from being added.';
$lang['AdminMain.getoptionalfunctions.tooltip_editPackage'] = 'Performs any action required to edit the package on the remote server. Sets Input errors on failure, preventing the package from being edited.';
$lang['AdminMain.getoptionalfunctions.tooltip_deletePackage'] = 'Deletes the package on the remote server. Sets Input errors on failure, preventing the package from being deleted.';
$lang['AdminMain.getoptionalfunctions.tooltip_addModuleRow'] = 'Adds the module row on the remote server. Sets Input errors on failure, preventing the row from being added.';
$lang['AdminMain.getoptionalfunctions.tooltip_editModuleRow'] = 'Edits the module row on the remote server. Sets Input errors on failure, preventing the row from being updated.';
$lang['AdminMain.getoptionalfunctions.tooltip_deleteModuleRow'] = 'Deletes the module row on the remote server. Sets Input errors on failure, preventing the row from being deleted.';
$lang['AdminMain.getoptionalfunctions.tooltip_manageAddRow'] = 'Returns the rendered view of the add module row page';
$lang['AdminMain.getoptionalfunctions.tooltip_manageEditRow'] = 'Returns the rendered view of the edit module row page';
$lang['AdminMain.getoptionalfunctions.tooltip_upgrade'] = 'Performs migration of data from $current_version (the current installed version) to the given file set version. Sets Input errors on failure, preventing the module from being upgraded.';
$lang['AdminMain.getoptionalfunctions.tooltip_getGroupOrderOptions'] = 'Returns an array of available service delegation order methods. The module will determine how each method is defined. For example, the method "first" may be implemented such that it returns the module row with the least number of services assigned to it.';
$lang['AdminMain.getoptionalfunctions.tooltip_selectModuleRow'] = 'Determines which module row should be attempted when a service is provisioned for the given group based upon the order method set for that group.';
$lang['AdminMain.getoptionalfunctions.tooltip_getAdminServiceInfo'] = 'Fetches the HTML content to display when viewing the service info in the admin interface.';
$lang['AdminMain.getoptionalfunctions.tooltip_getClientServiceInfo'] = 'Fetches the HTML content to display when viewing the service info in the client interface.';


// Boxtitle
$lang['AdminMain.index.boxtitle_extension_generator'] = 'Extension Generator';

$lang['AdminMain.index.boxtitle_extensions'] = 'Extension Generator - Extensions';

$lang['AdminMain.index.extension_add'] = 'Add Extension';
$lang['AdminMain.index.heading_id'] = 'ID';
$lang['AdminMain.index.heading_name'] = 'Name';
$lang['AdminMain.index.heading_type'] = 'Type';
$lang['AdminMain.index.heading_form_type'] = 'Form Type';
$lang['AdminMain.index.heading_code_examples'] = 'Code Examples';
$lang['AdminMain.index.heading_date_updated'] = 'Date Updated';
$lang['AdminMain.index.heading_options'] = 'Options';

$lang['AdminMain.index.option_edit'] = 'Edit';
$lang['AdminMain.index.option_delete'] = 'Delete';
$lang['AdminMain.index.text_confirm_delete'] = 'Are you sure you want to delete this extension?';
$lang['AdminMain.index.extensions_no_results'] = 'There are no extensions at this time.';


// General settings page
$lang['AdminMain.general.heading_general_settings'] = 'General Settings';

$lang['AdminMain.general.name'] = 'Name';
$lang['AdminMain.general.type'] = 'Extension Type';
$lang['AdminMain.general.form_type'] = 'Form Type';
$lang['AdminMain.general.code_examples'] = 'Include Example Code';
$lang['AdminMain.general.basic_info'] = 'Next - Basic Info';

$lang['AdminMain.general.tooltip_name'] = 'The display name of the extension';
$lang['AdminMain.general.tooltip_form_type'] = 'Basic to use a highly truncated version of the extension form, including only the minimum necessary to generate the extension.';
$lang['AdminMain.general.tooltip_code_examples'] = 'Check to include commented out lines of sample code for features such as Cron Tasks, Event lists and tie-ins, etc.';

$lang['AdminMain.general.placeholder_name'] = 'Extension Name';


// Basic info page
$lang['AdminMain.modulebasic.heading_module_basic'] = 'Basic Information';
$lang['AdminMain.modulebasic.heading_module_authors'] = 'Authors';

$lang['AdminMain.modulebasic.description'] = 'Description';
$lang['AdminMain.modulebasic.logo'] = 'Logo';
$lang['AdminMain.modulebasic.module_row'] = 'Module Row Name';
$lang['AdminMain.modulebasic.module_row_plural'] = 'Module Row Name (Plural)';
$lang['AdminMain.modulebasic.module_group'] = 'Module Group Label';
$lang['AdminMain.modulebasic.author_name'] = 'Author Name';
$lang['AdminMain.modulebasic.author_url'] = 'Author URL';
$lang['AdminMain.modulebasic.text_options'] = 'Options';
$lang['AdminMain.modulebasic.author_row_add'] = 'Add Author';
$lang['AdminMain.modulebasic.text_remove'] = 'Remove';

$lang['AdminMain.modulebasic.tooltip_module_description'] = 'The description shown in the module listing';
$lang['AdminMain.modulebasic.tooltip_module_logo'] = 'The logo displayed in the module listing';
$lang['AdminMain.modulebasic.tooltip_module_row'] = 'The term by which to refer to a single module row for this module';
$lang['AdminMain.modulebasic.tooltip_module_row_plural'] = 'The term by which to refer to multiple module rows for this module';
$lang['AdminMain.modulebasic.tooltip_module_group'] = 'The term by which to refer to module row groups for this module';

$lang['AdminMain.modulebasic.placeholder_module_row'] = 'e.g. Server';
$lang['AdminMain.modulebasic.placeholder_module_row_plural'] = 'e.g. Servers';
$lang['AdminMain.modulebasic.placeholder_module_group'] = 'e.g. Server Group';
$lang['AdminMain.modulebasic.placeholder_author_name'] = 'e.g. Blesta';
$lang['AdminMain.modulebasic.placeholder_author_url'] = 'e.g. https://blesta.com/';

$lang['AdminMain.modulebasic.module_fields'] = 'Next - Module Fields';
$lang['AdminMain.modulebasic.module_confirm'] = 'Next - Confirmation';


// Fields page
$lang['AdminMain.modulefields.heading_module_row_fields'] = 'Module Row Fields';
$lang['AdminMain.modulefields.heading_package_fields'] = 'Package Fields';
$lang['AdminMain.modulefields.heading_service_fields'] = 'Service Fields';

$lang['AdminMain.modulefields.name'] = 'Name';
$lang['AdminMain.modulefields.label'] = 'Label';
$lang['AdminMain.modulefields.type'] = 'Type';
$lang['AdminMain.modulefields.tooltip'] = 'Tooltip Text';
$lang['AdminMain.modulefields.name_key'] = 'Name Key';

$lang['AdminMain.modulefields.module_row_add'] = 'Add Module Row Field';
$lang['AdminMain.modulefields.package_row_add'] = 'Add Package Field';
$lang['AdminMain.modulefields.service_row_add'] = 'Add Service Field';

$lang['AdminMain.modulefields.text_options'] = 'Options';
$lang['AdminMain.modulefields.text_remove'] = 'Remove';

$lang['AdminMain.modulefields.module_features'] = 'Next - Additional Features';


// Additional features page
$lang['AdminMain.modulefeatures.heading_module_features'] = 'Additional Features';
$lang['AdminMain.modulefeatures.heading_service_tabs'] = 'Service Management Tabs';
$lang['AdminMain.modulefeatures.heading_cron_tasks'] = 'Cron Tasks';
$lang['AdminMain.modulefeatures.heading_optional_functions'] = 'Optional Functions';

$lang['AdminMain.modulefeatures.name'] = 'Name';
$lang['AdminMain.modulefeatures.label'] = 'Label';
$lang['AdminMain.modulefeatures.description'] = 'Description';
$lang['AdminMain.modulefeatures.type'] = 'Type';
$lang['AdminMain.modulefeatures.method_name'] = 'Method Name';
$lang['AdminMain.modulefeatures.level'] = 'Level';
$lang['AdminMain.modulefeatures.time'] = 'Start Time/Interval';

$lang['AdminMain.modulefeatures.service_tab_row_add'] = 'Add Service Management Tab';
$lang['AdminMain.modulefeatures.cron_task_row_add'] = 'Add Cron Task';

$lang['AdminMain.modulefeatures.text_options'] = 'Options';
$lang['AdminMain.modulefeatures.text_remove'] = 'Remove';

$lang['AdminMain.modulefeatures.module_confirm'] = 'Next - Confirmation';


// Confirmation page
$lang['AdminMain.confirm.heading_confirm'] = 'Confirmation';
$lang['AdminMain.confirm.text_generation'] = 'Extension settings are complete.  You may review any section by clicking on the nodes in the progress bar.  Click "Generate Extension" to finish and automatically generate the files for your extension.';

$lang['AdminMain.confirm.location'] = 'Extension Location';
$lang['AdminMain.confirm.tooltip_location'] = 'The directory in which to upload generated extension files.';
$lang['AdminMain.confirm.custom_path'] = 'Custom Path';

$lang['AdminMain.confirm.generate'] = 'Generate Extension';
