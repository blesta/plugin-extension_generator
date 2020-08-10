<?php

// Page title
$lang['AdminPlugin.index.page_title'] = 'Extension Generator - %1$s'; // %1$s is the plugin name

$lang['AdminPlugin.index.boxtitle_extension_generator'] = 'Extension Generator - Plugin';


// Basic info page
$lang['AdminPlugin.basic.heading_basic'] = 'Basic Information';
$lang['AdminPlugin.basic.heading_authors'] = 'Authors';

$lang['AdminPlugin.basic.description'] = 'Description';
$lang['AdminPlugin.basic.logo'] = 'Logo';
$lang['AdminPlugin.basic.author_name'] = 'Author Name';
$lang['AdminPlugin.basic.author_url'] = 'Author URL';
$lang['AdminPlugin.basic.text_options'] = 'Options';
$lang['AdminPlugin.basic.author_row_add'] = 'Add Author';
$lang['AdminPlugin.basic.text_remove'] = 'Remove';

$lang['AdminPlugin.basic.tooltip_description'] = 'The description shown in the plugin listing';
$lang['AdminPlugin.basic.tooltip_logo'] = 'The logo displayed in the plugin listing';

$lang['AdminPlugin.basic.placeholder_author_name'] = 'e.g. Blesta';
$lang['AdminPlugin.basic.placeholder_author_url'] = 'e.g. https://blesta.com/';

$lang['AdminPlugin.basic.database'] = 'Next - Database Info';
$lang['AdminPlugin.basic.confirm'] = 'Next - Confirmation';


// Database info page
$lang['AdminPlugin.database.heading_database'] = 'Database Table Info';

$lang['AdminPlugin.database.table_row_add'] = 'Add Database Table';
$lang['AdminPlugin.database.column_row_add'] = 'Add Column';

$lang['AdminPlugin.database.table_name'] = 'Table Name';
$lang['AdminPlugin.database.tooltip_table_name'] = 'The name of the table in the database (e.g. extention_table_name)';
$lang['AdminPlugin.database.placeholder_table_name'] = 'e.g. extention_table_name';

$lang['AdminPlugin.database.column_name'] = 'Column Name';
$lang['AdminPlugin.database.type'] = 'Type';
$lang['AdminPlugin.database.length'] = 'Length/Values';
$lang['AdminPlugin.database.default'] = 'Default';
$lang['AdminPlugin.database.nullable'] = 'Nullable';

$lang['AdminPlugin.database.tooltip_column_name'] = 'The name of the column in the database (e.g. column_name)';
$lang['AdminPlugin.database.tooltip_type'] = 'The type of the column in the database';
$lang['AdminPlugin.database.tooltip_length'] = 'Sets the max number of characters in a field. If column type is "enum", please enter the values using this format: \'a\',\'b\',\'c\'...';
$lang['AdminPlugin.database.tooltip_default'] = 'The default value to insert for this column';
$lang['AdminPlugin.database.tooltip_nullable'] = 'Whether or not to allow a null value for this column';
$lang['AdminPlugin.database.placeholder_column_name'] = 'e.g. column_name';

$lang['AdminPlugin.database.text_options'] = 'Options';
$lang['AdminPlugin.database.text_remove'] = 'Remove';

$lang['AdminPlugin.database.confirm'] = 'Next - Core Integrations';


// Core integration page
$lang['AdminPlugin.integrations.heading_actions'] = 'Actions';
$lang['AdminPlugin.integrations.heading_events'] = 'Event Handlers';
$lang['AdminPlugin.integrations.heading_cards'] = 'Client Cards';


$lang['AdminPlugin.integrations.tooltip_event'] = 'The event for which to add a handler (e.g. Clients.add). For a list of core events registered by blesta see https://docs.blesta.com/display/dev/Event+Handlers';


// Additional features page
$lang['AdminPlugin.features.heading_optional_functions'] = 'Optional Functions';
$lang['AdminPlugin.features.confirm'] = 'Next - Confirmation';
