    <div class="table-responsive">
        <table class="table table-curved table-striped">
            <thead>
                <tr>
                    <th><i class="fas fa-share fa-flip-vertical"></i></th>{{array:service_fields}}
                    <th><?php $this->_('{{class_name}}.service_info.{{service_fields.name}}'); ?></th>{{array:service_fields}}
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>{{array:service_fields}}
                    <td><?php $this->Html->_($service_fields->{{service_fields.name}}); ?></td>{{array:service_fields}}
                </tr>
            </tbody>
        </table>
    </div>{{if:code_examples:1}}<?php{{else:code_examples}}{{if:code_examples}}
////
////// Modules will often use this location to show a login link (either a link to the login page or one that automatically logs the user in)
////// To do so add the following td to the end of the "heading_row" tr
////?><!--
////                    <th><?php $this->_('{{class_name}}.service_info.options'); ?></th>
//// --><?php
////
////// And add this row to the end of the other tr
////?><!--
////                    <td>
////                        <?php
////                        if ($this->Html->ifSet($login_url)) {
////                        ?>
////                        <a href="<?php $this->Html->_($login_url);?>" target="_blank"><?php $this->_('{{class_name}}.service_info.option_login');?></a>
////                        <?php
////                        }
////                        ?>
////                    </td>
////--><?php
////
////// Be sure to visit the {{snake_case_name}}.php language file to uncomment the language definitions for these rows
