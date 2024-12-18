<?php
////// Plugins may define email templates here.  Define both a text version and html
////// version for each language you wish to include.  For information on writing
////// email templates see the docs at https://docs.blesta.com/display/user/Customizing+Emails
////
////// Email templates
/////Configure::set('{{class_name}}.install.emails', [
/////    [
/////        'action' => '{{class_name}}.example_action',
/////        'type' => 'client',
/////        'plugin_dir' => '{{snake_case_name}}',
/////        'tags' => '{example}',
/////        'from' => 'support@mydomain.com',
/////        'from_name' => 'Example',
/////        'subject' => 'Example email',
/////        'text' => 'The text email content
/////
/////You can use tags and mulitple lines
/////
/////You can customize emails, see https://docs.blesta.com/display/user/Customizing+Emails',
/////    'html' => '<p>The text email content</p>
/////<p>You can use tags and mulitple lines</p>
/////<p>You can customize emails, see https://docs.blesta.com/display/user/Customizing+Emails</p>'
/////    ],
/////]);
////