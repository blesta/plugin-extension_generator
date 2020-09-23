        <?php
        $link_buttons = [
            ['name' => $this->_('{{class_name}}.add_module_row', true), 'attributes' => ['href' => $this->base_uri . 'settings/company/modules/addrow/' . $module->id]],
            ['name' => $this->_('{{class_name}}.add_module_group', true), 'attributes' => ['href' => $this->base_uri . 'settings/company/modules/addgroup/' . $module->id]]
        ];

        $this->Widget->clear();
        $this->Widget->setLinkButtons($link_buttons);

        $this->Widget->create($this->_('AdminCompanyModules.manage.boxtitle_manage', true, $this->Html->_($module->name, true)), ['id' => 'manage_{{snake_case_name}}']);
        ?>

        <div class="title_row first">
            <h3><?php $this->_('{{class_name}}.manage.module_rows_title'); ?></h3>
        </div>
        <?php
        $num_rows = count($this->Html->ifSet($module->rows, []));
        if ($num_rows > 0) {
            ?>
        <table class="table">
            <tr class="heading_row">{{array:module_rows}}
                <td><span><?php $this->_('{{class_name}}.manage.module_rows_heading.{{module_rows.name}}'); ?></span></td>{{array:module_rows}}
                <td class="last"><span><?php $this->_('{{class_name}}.manage.module_rows_heading.options'); ?></span></td>
            </tr>
            <?php
            for ($i = 0; $i < $num_rows; $i++) {
                ?>
            <tr<?php echo ($i % 2 == 1) ? ' class="odd_row"' : ''; ?>>{{array:module_rows}}{{if:module_rows.type:Checkbox}}
                <td><?php echo $this->Html->ifSet($module->rows[$i]->meta->{{module_rows.name}}) == 'true' ? '<i class="fas fa-check"></i>' : '<i class="fas fa-times"></i>'; ?></td>{{else:module_rows.type}}
                <td><?php $this->Html->_($module->rows[$i]->meta->{{module_rows.name}}); ?></td>{{if:module_rows.type}}{{array:module_rows}}
                <td class="last">
                    <a href="<?php echo $this->Html->safe($this->base_uri . 'settings/company/modules/editrow/' . $this->Html->ifSet($module->id) . '/' . $this->Html->ifSet($module->rows[$i]->id) . '/'); ?>"><?php $this->_('{{class_name}}.manage.module_rows.edit'); ?></a>
                    <?php
                    $this->Form->create($this->base_uri . 'settings/company/modules/deleterow/');
                    $this->Form->fieldHidden('id', $this->Html->ifSet($module->id));
                    $this->Form->fieldHidden('row_id', $this->Html->ifSet($module->rows[$i]->id)); ?>
                    <a href="<?php echo $this->Html->safe($this->base_uri . 'settings/company/modules/deleterow/' . $this->Html->ifSet($module->id) . '/' . $this->Html->ifSet($module->rows[$i]->id) . '/'); ?>" class="manage" rel="<?php echo $this->Html->safe($this->_('{{class_name}}.manage.module_rows.confirm_delete', true)); ?>"><?php $this->_('{{class_name}}.manage.module_rows.delete'); ?></a>
                    <?php
                    $this->Form->end(); ?>
                </td>
            </tr>
            <?php
            } ?>
        </table>
        <?php
        } else {
            ?>
        <div class="empty_section">
            <div class="empty_box">
                <?php $this->_('{{class_name}}.manage.module_rows_no_results'); ?>
            </div>
        </div>
        <?php
        }
        ?>

        <div class="title_row">
            <h3><?php $this->_('{{class_name}}.manage.module_groups_title');?></h3>
        </div>
        <?php
        $num_rows = count($this->Html->ifSet($module->groups, []));
        if ($num_rows > 0) {
        ?>
        <table class="table">
            <tr class="heading_row">
                <td><span><?php $this->_('{{class_name}}.manage.module_groups_heading.name');?></span></td>
                <td><span><?php $this->_('{{class_name}}.manage.module_groups_heading.module_rows');?></span></td>
                <td class="last"><span><?php $this->_('{{class_name}}.manage.module_groups_heading.options');?></span></td>
            </tr>
            <?php
            for ($i=0; $i<$num_rows; $i++) {
            ?>
            <tr<?php echo ($i%2 == 1) ? ' class="odd_row"' : '';?>>
                <td><?php $this->Html->_($module->groups[$i]->name);?></td>
                <td><?php echo count($this->Html->ifSet($module->groups[$i]->rows, []));?></td>
                <td>
                    <a href="<?php echo $this->Html->safe($this->base_uri . 'settings/company/modules/editgroup/' . $this->Html->ifSet($module->id) . '/' . $this->Html->ifSet($module->groups[$i]->id) . '/');?>"><?php $this->_('{{class_name}}.manage.module_groups.edit');?></a>
                    <?php
                    $this->Form->create($this->base_uri . 'settings/company/modules/deletegroup/');
                    $this->Form->fieldHidden('id', $this->Html->ifSet($module->id));
                    $this->Form->fieldHidden('group_id', $this->Html->ifSet($module->groups[$i]->id));
                    ?>
                    <a href="<?php echo $this->Html->safe($this->base_uri . 'settings/company/modules/deletegroup/' . $this->Html->ifSet($module->id) . '/' . $this->Html->ifSet($module->groups[$i]->id) . '/');?>" class="manage" rel="<?php echo $this->Html->safe($this->_('{{class_name}}.manage.module_groups.confirm_delete', true));?>"><?php $this->_('{{class_name}}.manage.module_groups.delete');?></a>
                    <?php
                    $this->Form->end();
                    ?>
                </td>
            </tr>
            <?php
            }
            ?>
        </table>
        <?php
        } else {
        ?>
        <div class="empty_section">
            <div class="empty_box">
                <?php $this->_('{{class_name}}.manage.module_groups.no_results');?>
            </div>
        </div>
        <?php
        }

        $this->Widget->end();
        ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#manage_{{snake_case_name}} a.manage[rel]').blestaModalConfirm({base_url: '<?php echo $this->base_uri; ?>', close: '<?php $this->_('AppController.modal.text_close'); ?>', submit: true});
    });
</script>