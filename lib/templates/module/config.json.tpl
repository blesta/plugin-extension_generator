{
    "version": "1.0.0",
    "name": "{{class_name}}.name",
    "description": "{{class_name}}.description",
    "authors": [{{array:authors}}
        {
            "name": "{{authors.name}}",
            "url": "{{authors.url}}"
        },{{array:authors}}
    ],
    "module": {
        "row": "{{class_name}}.module_row",
        "rows": "{{class_name}}.module_row_plural",
        "group": "{{class_name}}.module_group"{{array:module_rows}}{{if:module_rows.name_key:true}},
        "row_key": "{{module_rows.name}}"{{else:module_rows.name_key}}{{if:module_rows.name_key}}{{array:module_rows}}
    },
    "package": {{{array:package_fields}}{{if:package_fields.name_key:true}}
        "name_key": "{{package_fields.name}}"{{else:package_fields.name_key}}{{if:package_fields.name_key}}{{array:package_fields}}
    },
    "service": {{{array:service_fields}}{{if:service_fields.name_key:true}}
        "name_key": "{{service_fields.name}}"{{else:service_fields.name_key}}{{if:service_fields.name_key}}{{array:service_fields}}
    },
    "email_tags": {
        "module": [{{array:module_rows}}"{{module_rows.name}}",{{array:module_rows}}],
        "package": [{{array:package_fields}}"{{package_fields.name}}",{{array:package_fields}}],
        "service": [{{array:service_fields}}"{{service_fields.name}}",{{array:service_fields}}]
    }
}