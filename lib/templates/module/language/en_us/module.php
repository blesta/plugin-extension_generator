<?php
/**
 * en_us language for the {{name}} module.
 */
// Basics
$lang['{{class_name}}.name'] = '{{name}}';
$lang['{{class_name}}.description'] = '{{description}}';
$lang['{{class_name}}.module_row'] = '{{module_row}}';
$lang['{{class_name}}.module_row_plural'] = '{{module_row_plural}}';
$lang['{{class_name}}.module_group'] = '{{module_group}}';


// Module management
$lang['{{class_name}}.add_module_row'] = 'Add {{module_row}}';
$lang['{{class_name}}.add_module_group'] = 'Add {{module_group}}';
$lang['{{class_name}}.manage.module_rows_title'] = '{{module_row_plural}}';
{{array:module_rows}}
$lang['{{class_name}}.manage.module_rows_heading.{{module_rows.name}}'] = '{{module_rows.label}}';{{array:module_rows}}
$lang['{{class_name}}.manage.module_rows_heading.options'] = 'Options';
$lang['{{class_name}}.manage.module_rows.edit'] = 'Edit';
$lang['{{class_name}}.manage.module_rows.delete'] = 'Delete';
$lang['{{class_name}}.manage.module_rows.confirm_delete'] = 'Are you sure you want to delete this {{module_row}}';

$lang['{{class_name}}.manage.module_rows_no_results'] = 'There are no {{module_row_plural}}.';

$lang['{{class_name}}.manage.module_groups_title'] = 'Groups';
$lang['{{class_name}}.manage.module_groups_heading.name'] = 'Name';
$lang['{{class_name}}.manage.module_groups_heading.module_rows'] = '{{module_row_plural}}';
$lang['{{class_name}}.manage.module_groups_heading.options'] = 'Options';

$lang['{{class_name}}.manage.module_groups.edit'] = 'Edit';
$lang['{{class_name}}.manage.module_groups.delete'] = 'Delete';
$lang['{{class_name}}.manage.module_groups.confirm_delete'] = 'Are you sure you want to delete this {{module_row}}';

$lang['{{class_name}}.manage.module_groups.no_results'] = 'There is no {{module_group}}';

{{function:getGroupOrderOptions}}
$lang['{{class_name}}.order_options.roundrobin'] = 'Evenly Distribute Among Servers';
$lang['{{class_name}}.order_options.first'] = 'First Non-full Server';
{{function:getGroupOrderOptions}}

// Add row
$lang['{{class_name}}.add_row.box_title'] = '{{name}} - Add {{module_row}}';
$lang['{{class_name}}.add_row.add_btn'] = 'Add {{module_row}}';


// Edit row
$lang['{{class_name}}.edit_row.box_title'] = '{{name}} - Edit {{module_row}}';
$lang['{{class_name}}.edit_row.edit_btn'] = 'Update {{module_row}}';


// Row meta{{array:module_rows}}
$lang['{{class_name}}.row_meta.{{module_rows.name}}'] = '{{module_rows.label}}';{{array:module_rows}}

{{array:module_rows}}{{if:module_rows.tooltip:}}{{else}}
$lang['{{class_name}}.row_meta.tooltip.{{module_rows.name}}'] = '{{module_rows.tooltip}}';{{if:module_rows.tooltip}}{{array:module_rows}}


// Errors{{array:module_rows}}
$lang['{{class_name}}.!error.{{module_rows.name}}.valid'] = 'Invalid {{module_rows.label}}';{{array:module_rows}}
$lang['{{class_name}}.!error.module_row.missing'] = 'An internal error occurred. The module row is unavailable.';
{{array:service_tabs}}


// {{service_tabs.label}}
$lang['{{class_name}}.{{service_tabs.method_name}}'] = '{{service_tabs.label}}';
$lang['{{class_name}}.{{service_tabs.method_name}}.header'] = '{{service_tabs.label}}';
$lang['{{class_name}}.{{service_tabs.method_name}}.submit'] = 'Submit';{{array:service_tabs}}

// Service info{{array:service_fields}}
$lang['{{class_name}}.service_info.{{service_fields.name}}'] = '{{service_fields.label}}';{{array:service_fields}}


// Service Fields{{array:service_fields}}
$lang['{{class_name}}.service_fields.{{service_fields.name}}'] = '{{service_fields.label}}';{{array:service_fields}}

{{array:service_fields}}{{if:service_fields.tooltip:}}{{else}}
$lang['{{class_name}}.service_field.tooltip.{{service_fields.name}}'] = '{{service_fields.tooltip}}';{{if:service_fields.tooltip}}{{array:service_fields}}


// Package Fields{{array:package_fields}}
$lang['{{class_name}}.package_fields.{{package_fields.name}}'] = '{{package_fields.label}}';{{array:package_fields}}

{{array:package_fields}}{{if:package_fields.tooltip:}}{{else}}
$lang['{{class_name}}.package_field.tooltip.{{package_fields.name}}'] = '{{package_fields.tooltip}}';{{if:package_fields.tooltip}}{{array:package_fields}}
