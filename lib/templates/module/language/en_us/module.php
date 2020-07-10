<?php
/**
 * en_us language for the {{name}} module.
 */
// Basics
$lang['{{class_name}}.name'] = '{{name}}';
$lang['{{class_name}}.description'] = '{{description}}';
$lang['{{class_name}}.module_row'] = '{{module_row}}';
$lang['{{class_name}}.module_row_plural'] = '{{module_row_plural}}';


// Module management
$lang['{{class_name}}.add_module_row'] = 'Add {{module_row}}';
$lang['{{class_name}}.manage.module_rows_title'] = '{{name}} - {{module_row_plural}}';
{{array:module_rows}}
$lang['{{class_name}}.manage.module_rows_heading.{{module_rows.name}}'] = '{{module_rows.label}}';{{array:module_rows}}
$lang['{{class_name}}.manage.module_rows_heading.options'] = 'Options';
$lang['{{class_name}}.manage.module_rows.edit'] = 'Edit';
$lang['{{class_name}}.manage.module_rows.delete'] = 'Delete';
$lang['{{class_name}}.manage.module_rows.confirm_delete'] = 'Are you sure you want to delete this {{module_row}}';

$lang['{{class_name}}.manage.module_rows_no_results'] = 'There are no {{module_row_plural}}.';


// Add row
$lang['{{class_name}}.add_row.box_title'] = '{{name}} - Add {{module_row}}';
$lang['{{class_name}}.add_row.add_btn'] = 'Add {{module_row}}';


// Edit row
$lang['{{class_name}}.edit_row.box_title'] = '{{name}} - Edit {{module_row}}';
$lang['{{class_name}}.edit_row.edit_btn'] = 'Update {{module_row}}';


// Row meta{{array:module_rows}}
$lang['{{class_name}}.row_meta.{{module_rows.name}}'] = '{{module_rows.label}}';{{array:module_rows}}


// Errors{{array:module_rows}}
$lang['{{class_name}}.!error.{{module_rows.name}}.valid'] = 'Invalid {{module_rows.label}}';{{array:module_rows}}
$lang['{{class_name}}.!error.module_row.missing'] = 'An internal error occurred. The module row is unavailable.';
{{array:service_tabs}}

// {{service_tabs.label}}
$lang['{{class_name}}.{{service_tabs.method_name}}'] = '{{service_tabs.label}}';
$lang['{{class_name}}.{{service_tabs.method_name}}.header'] = '{{service_tabs.label}}';
$lang['{{class_name}}.{{service_tabs.method_name}}.submit'] = 'Submit';{{array:service_tabs}}
