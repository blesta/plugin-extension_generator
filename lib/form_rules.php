<?php
class FormRules {
    public function __construct()
    {
       Loader::loadComponents($this, ['Input']);
        Language::loadLang(
            'form_rules',
            null,
            dirname(__FILE__) . DS . '..' . DS . 'language' . DS
        );
    }

    /**
     * Validates the submitted vars for the given action
     *
     * @param string $action The action for which to validate vars
     * @param array $vars The submitted input vars to validate
     * @return bool True if the input vars were successfully validated, false otherwise
     */
    public function validate($action, array $vars)
    {
        $this->Input->setRules($this->{$action}());
        return $this->Input->validates($vars);
    }

    /**
     * Return all validation errors encountered
     *
     * @return mixed Boolean false if no errors encountered, an array of errors otherwise
     */
    public function errors()
    {
        if (is_object($this->Input) && $this->Input instanceof Input) {
            return $this->Input->errors();
        }
    }

    /**
     * Gets a list of input validation rules for the modulebasic action
     *
     * @return array A list of input validation rules
     */
    private function modulebasic()
    {
        $rules = [
            'module_row' => [
                'empty' => [
                    'rule' => 'isEmpty',
                    'negate' => true,
                    'message' => Language::_('FormRules.modulebasic.module_row.empty', true)
                ]
            ],
            'module_row_plural' => [
                'empty' => [
                    'rule' => 'isEmpty',
                    'negate' => true,
                    'message' => Language::_('FormRules.modulebasic.module_row_plural.empty', true)
                ]
            ],
            'module_group' => [
                'empty' => [
                    'rule' => 'isEmpty',
                    'negate' => true,
                    'message' => Language::_('FormRules.modulebasic.module_group.empty', true)
                ]
            ],
            'authors[][name]' => [
                'empty' => [
                    'rule' => 'isEmpty',
                    'negate' => true,
                    'message' => Language::_('FormRules.modulebasic.authors[][name].empty', true)
                ]
            ],
        ];

        return $rules;
    }

    /**
     * Gets a list of input validation rules for the modulefields action
     *
     * @return array A list of input validation rules
     */
    private function modulefields()
    {
        $rules = [];
        $array_fields = ['module_rows', 'service_fields', 'package_fields'];
        foreach ($array_fields as $array_field) {
            $rules += [
                $array_field . '[][name]' => [
                    'format' => [
                        'rule' => ['matches', '/([a-z0-9]+_?)+$/'],
                        'message' => Language::_('FormRules.modulefields.' .  $array_field . '[][name].format', true)
                    ]
                ],
                $array_field . '[][label]' => [
                    'empty' => [
                        'rule' => 'isEmpty',
                        'negate' => true,
                        'message' => Language::_('FormRules.modulefields.' .  $array_field . '[][label].empty', true)
                    ]
                ],
                $array_field . '[][type]' => [
                    'valid' => [
                        'rule' => ['in_array', $this->getFieldTypes()],
                        'message' => Language::_('FormRules.modulefields.' .  $array_field . '[][type].valid', true)
                    ]
                ],
                $array_field . '[][name_key]' => [
                    'valid' => [
                        'rule' => ['in_array', ['true', 'false']],
                        'message' => Language::_('FormRules.modulefields.' .  $array_field . '[][name_key].valid', true)
                    ]
                ],
            ];
        }

        return $rules;
    }

    /**
     * Gets a list of input validation rules for the modulefeatures action
     *
     * @return array A list of input validation rules
     */
    private function modulefeatures()
    {
        $rules = [
            'service_tabs[][method_name]' => [
                'format' => [
                    'rule' => ['matches', '/([a-z0-9]+_?)+$/'],
                    'message' => Language::_('FormRules.modulefeatures.service_tabs[][method_name].format', true)
                ]
            ],
            'service_tabs[][label]' => [
                'empty' => [
                    'rule' => 'isEmpty',
                    'negate' => true,
                    'message' => Language::_('FormRules.modulefeatures.service_tabs[][label].empty', true)
                ]
            ],
            'service_tabs[][level]' => [
                'valid' => [
                    'rule' => ['in_array', ['staff', 'client']],
                    'message' => Language::_('FormRules.modulefeatures.service_tabs[][level].valid', true)
                ]
            ],
            'cron_tasks[][name]' => [
                'format' => [
                    'rule' => ['matches', '/([a-z])+$/'],
                    'message' => Language::_('FormRules.modulefeatures.cron_tasks[][name].format', true)
                ]
            ],
            'cron_tasks[][label]' => [
                'empty' => [
                    'rule' => 'isEmpty',
                    'negate' => true,
                    'message' => Language::_('FormRules.modulefeatures.cron_tasks[][label].empty', true)
                ]
            ],
            'cron_tasks[][type]' => [
                'valid' => [
                    'rule' => ['in_array', ['time', 'interval']],
                    'message' => Language::_('FormRules.modulefeatures.cron_tasks[][type].valid', true)
                ]
            ],
            'cron_tasks[][time]' => [
                'format' => [
                    'rule' => [
                        function ($time, $type) {
                            if ($type == 'time') {
                                return preg_match('/[0-9]{1,2}:[0-9]{1,2}(:[0-9]{1,2})?$/', $time);
                            } else {
                                return is_numeric($time);
                            }
                        },
                        ['_linked' => 'cron_tasks[][type]'],
                    ],
                    'message' => Language::_('FormRules.modulefeatures.cron_tasks[][time].format', true)
                ]
            ],
        ];

        return $rules;
    }

    /**
     * Gets a list of input validation rules for the pluginbasic action
     *
     * @return array A list of input validation rules
     */
    private function pluginbasic()
    {
        $rules = [
            'authors[][name]' => [
                'empty' => [
                    'rule' => 'isEmpty',
                    'negate' => true,
                    'message' => Language::_('FormRules.pluginbasic.authors[][name].empty', true)
                ]
            ],
        ];

        return $rules;
    }

    /**
     * Gets a list of input validation rules for the plugindatabase action
     *
     * @return array A list of input validation rules
     */
    private function plugindatabase()
    {
        $rules = [];

        return $rules;
    }

    /**
     * Gets a list of input validation rules for the pluginintegrations action
     *
     * @return array A list of input validation rules
     */
    private function pluginintegrations()
    {
        $rules = [];

        return $rules;
    }

    /**
     * Gets a list of input validation rules for the pluginfeatures action
     *
     * @return array A list of input validation rules
     */
    private function pluginfeatures()
    {
        $rules = [];

        return $rules;
    }

    /**
     * Gets a list of field types and their language
     *
     * @return A list of field types and their language
     */
    protected function getFieldTypes()
    {
        return [
            'Text',
            'Textarea',
            'Checkbox'
        ];
    }
}