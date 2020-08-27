
	<ul>{{array:fields}}
        <li>
            <?php
            $this->Form->label($this->_('{{class_name}}.meta.{{fields.name}}', true), '{{fields.name}}'{{if:fields.tooltip:}});{{else:fields.tooltip}}, ['class' => 'inline']);
            ?>
            <span class="tooltip inline-block"><?php $this->_("AppController.tooltip.text");?><div><?php $this->_("{{class_name}}.meta.tooltip_{{fields.name}}");?></div></span>
            <?php{{if:fields.tooltip}}{{if:fields.type:Checkbox}}
            $this->Form->field{{fields.type}}('{{fields.name}}', 'true', $this->Html->ifSet($meta['{{fields.name}}']) == 'true', ['id' => '{{fields.name}}']);{{else:fields.type}}
            $this->Form->field{{fields.type}}('{{fields.name}}', $this->Html->ifSet($meta['{{fields.name}}']), ['id' => '{{fields.name}}', 'class' => 'block']);{{if:fields.type}}
            ?>
        </li>{{array:fields}}
	</ul>
