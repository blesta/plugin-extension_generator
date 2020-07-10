<?php

/**
 * {{name}} Module
 *
{{array:authors}}
 * @link {{authors.url}} {{authors.name}}{{array:authors}}
 */
class {{class_name}} extends Module
{

    /**
     * Initializes the module
     */
    public function __construct()
    {
        // Load the language required by this module
        Language::loadLang('{{snake_case_name}}', null, dirname(__FILE__) . DS . 'language' . DS);

        // Load module config
        $this->loadConfig(dirname(__FILE__) . DS . 'config.json');
    }

    /**
     * Performs any necessary bootstraping actions
     */
    public function install()
    {
        {{function:addCronTasks}}{{function:getCronTasks}}
        // Add cron tasks for this module
        $this->addCronTasks($this->getCronTasks());{{function:getCronTasks}}{{function:addCronTasks}}
    }{{function:cancelService}}

    public function cancelService() {


    }{{function:cancelService}}{{function:unsuspendService}}

    public function unsuspendService() {


    }{{function:unsupendService}}{{function:addCronTasks}}

    /**
     * Attempts to add new cron tasks for this module
     *
     * @param array $tasks A list of cron tasks to add
     */
    private function addCronTasks(array $tasks)
    {
        Loader::loadModels($this, ['CronTasks']);
        foreach ($tasks as $task) {
            $task_id = $this->CronTasks->add($task);

            if (!$task_id) {
                $cron_task = $this->CronTasks->getByKey($task['key'], $task['dir'], $task['task_type']);
                if ($cron_task) {
                    $task_id = $cron_task->id;
                }
            }

            if ($task_id) {
                $task_vars = ['enabled' => $task['enabled']];
                if ($task['type'] === 'time') {
                    $task_vars['time'] = $task['type_value'];
                } else {
                    $task_vars['interval'] = $task['type_value'];
                }

                $this->CronTasks->addTaskRun($task_id, $task_vars);
            }
        }
    }{{function:addCronTasks}}{{function:getCronTasks}}

    /**
     * Retrieves cron tasks available to this module along with their default values
     *
     * @return array A list of cron tasks
     */
    private function getCronTasks()
    {
        return [{{array:cron_tasks}}
            [
                'key' => '{{cron_tasks.name}}',
                'task_type' => 'module',
                'dir' => '{{snake_case_name}}',
                'name' => Language::_('{{class_name}}.getCronTasks.{{cron_tasks.name}}', true),
                'description' => Language::_('{{class_name}}.getCronTasks.{{cron_tasks.name}}_description', true),
                'type' => '{{cron_tasks.type}}',
                'type_value' => '{{cron_tasks.time}}',
                'enabled' => 1
            ],{{array:cron_tasks}}
        ];
    }
    {{function:getCronTasks}}
}
