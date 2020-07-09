<?php

/**
 * {name} Module
 *
 * @link {authors[0].url} {authors[0].name}
 */
class {class_name} extends Module
{

    /**
     * Initializes the module
     */
    public function __construct()
    {
        // Load the language required by this module
        Language::loadLang('{snake_case_name}', null, dirname(__FILE__) . DS . 'language' . DS);

        // Load module config
        $this->loadConfig(dirname(__FILE__) . DS . 'config.json');
    }
}
