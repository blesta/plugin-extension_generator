<?php
/**
 * Extension Generator Extension Management
 *
 * @package blesta
 * @subpackage blesta.plugins.extension.models
 * @copyright Copyright (c) 2020, Phillips Data, Inc.
 * @license http://www.blesta.com/license/ The Blesta License Agreement
 * @link http://www.blesta.com/ Blesta
 */
class ExtensionGeneratorExtensions extends ExtensionGeneratorModel
{
    /**
     * Returns a list of extensions for the given company
     *
     * @param int $company_id The ID of the company to fetch extensions from
     * @param int $page The page number of results to fetch
     * @param array $order A key/value pair array of fields to extension the results by
     * @return array An array of stdClass objects, each representing an extension
     */
    public function getList($company_id, $page = 1, array $order = ['id' => 'desc'])
    {
        $this->Record = $this->getExtension(['company_id' => $company_id]);
        return $this->Record
            ->order($order)
            ->limit($this->getPerPage(), (max(1, $page) - 1) * $this->getPerPage())
            ->fetchAll();
    }

    /**
     * Returns the total number of extension for the given company
     *
     * @param int $company_id The ID of the company to fetch extension count from
     * @return int The total number of extensions for the given company
     */
    public function getListCount($company_id)
    {
        $this->Record = $this->getExtension(['company_id' => $company_id]);
        return $this->Record->numResults();
    }

    /**
     * Returns all extensions in the system for the given company
     *
     * @param int $company_id The ID of the company to fetch extensions for
     * @param array $order A key/value pair array of fields to extension the results by
     * @return array An array of stdClass objects, each representing an extension
     */
    public function getAll($company_id, array $order = ['id' => 'desc'])
    {
        $this->Record = $this->getExtension(['company_id' => $company_id]);
        return $this->Record->order($order)->fetchAll();
    }

    /**
     * Fetches the extension with the given ID
     *
     * @param int $extension_id The ID of the extension to fetch
     * @return mixed A stdClass object representing the extension, false if no such extension exists
     */
    public function get($extension_id)
    {
        $this->Record = $this->getExtension();
        return $this->Record->where('extension_generator_extensions.id', '=', $extension_id)->fetch();
    }

    /**
     * Add an extension
     *
     * @param array $vars An array of input data including:
     *
     *  - company_id The ID of the company with which to associate the extension
     * @return int The ID of the extension that was created, void on error
     */
    public function add(array $vars)
    {
        $this->Input->setRules($this->getRules($vars));

        if ($this->Input->validates($vars)) {
            $fields = [];
            $this->Record->insert('extension_generator_extensions', $vars, $fields);

            return $this->Record->lastInsertId();
        }
    }

    /**
     * Edit an extension
     *
     * @param int $extension_id The ID of the extension to edit
     * @param array $vars An array of input data including:
     *
     *  - company_id The ID of the company with which to associate the extension
     * @return int The ID of the extension that was updated, void on error
     */
    public function edit($extension_id, array $vars)
    {
        $this->Input->setRules($this->getRules($vars, true));

        if ($this->Input->validates($vars)) {
            $fields = [];
            $this->Record->where('id', '=', $extension_id)->update('extension_generator_extensions', $vars, $fields);

            return $extension_id;
        }
    }

    /**
     * Permanently deletes the given extension
     *
     * @param int $extension_id The ID of the extension to delete
     */
    public function delete($extension_id)
    {
        // Delete an extension and their associated records
        $this->Record->from('extension_generator_extensions')
            ->where('extension_generator_extensions.id', '=', $extension_id)
            ->delete();
    }

    /**
     * Returns all supported extension statuses in key/value pairs
     *
     * @return array A list of extension statuses
     */
    public function getStatuses()
    {
    }


    /**
     * Returns a partial extension query
     *
     * @param array $filters A list of filters for the query
     *
     *  - company_id The ID of the company to which the extensions must be assigned
     * @return Record A partially built extension query
     */
    private function getExtension(array $filters = [])
    {
        $select = [
            'extension_generator_extensions.*',
        ];

        $this->Record->select($select)
            ->from('extension_generator_extensions')
            ->group('extension_generator_extensions.id');

        if (isset($filters['company_id'])) {
            $this->Record->where('extension_generator_extensions.company_id', '=', $filters['company_id']);
        }

        return $this->Record;
    }

    /**
     * Returns all validation rules for adding/editing extensions
     *
     * @param array $vars An array of input key/value pairs
     * @param bool $edit True if this if an edit, false otherwise
     * @return array An array of validation rules
     */
    private function getRules($vars, $edit = false)
    {
        $rules = [
        ];

        if ($edit) {
        }

        return $rules;
    }
}
