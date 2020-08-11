<?php
/**
 * en_us language for the {{name}} plugin.
 */
// Basics
$lang['{{class_name}}Plugin.name'] = '{{name}}';
$lang['{{class_name}}Plugin.description'] = '{{description}}';{{function:getCronTasks}}
{{array:service_tabs}}

// {{service_tabs.label}}
$lang['{{class_name}}.{{service_tabs.method_name}}'] = '{{service_tabs.label}}';
$lang['{{class_name}}.{{service_tabs.method_name}}.header'] = '{{service_tabs.label}}';
$lang['{{class_name}}.{{service_tabs.method_name}}.submit'] = 'Submit';{{array:service_tabs}}

// Cron Tasks{{array:cron_tasks}}
$lang['{{class_name}}Plugin.getCronTasks.{{cron_tasks.name}}'] = '{{cron_tasks.label}}';
$lang['{{class_name}}Plugin.getCronTasks.{{cron_tasks.name}}_description'] = '{{cron_tasks.description}}';{{array:cron_tasks}}{{function:getActions}}{{function:getActions}}

// Plugin Actions{{array:actions}}
$lang['{{class_name}}Plugin.{{actions.location}}.main'] = '{{actions.name}}';{{array:actions}}{{function:getActions}}{{function:getCards}}

// Plugin Cards{{array:cards}}
$lang['{{class_name}}Plugin.card_{{cards.level}}.{{cards.callback}}'] = '{{cards.label}}';{{array:cards}}{{function:getCards}}