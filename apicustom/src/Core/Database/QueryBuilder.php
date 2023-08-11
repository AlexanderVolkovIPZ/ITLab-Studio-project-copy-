<?php

namespace App\Core\Database;

class QueryBuilder
{

    protected $fields;
    protected $table;
    protected $type;
    protected $params;
    protected $where;
    protected $set;
    protected $left_join;
    protected $right_join;
    protected $full_join;
    protected $inner_join;

    public function __construct()
    {
        $this->params = [];
    }

    public function getSql()
    {
        switch ($this->type) {
            case 'select':
                $sql = "SELECT {$this->fields} FROM {$this->table}";
                if (!empty($this->left_join)) {
                    $sql .= " LEFT JOIN {$this->left_join['table']} ON {$this->table}.{$this->left_join['field1']} = {$this->left_join['table']}.{$this->left_join['field2']} ";
                }
                if (!empty($this->right_join)) {
                    $sql .= " RIGHT JOIN {$this->right_join['table']} ON {$this->table}.{$this->right_join['field1']} = {$this->right_join['table']}.{$this->right_join['field2']} ";
                }
                if (!empty($this->full_join)) {
                    $sql .= " FULL JOIN {$this->full_join['table']} ON {$this->table}.{$this->full_join['field1']} = {$this->full_join['table']}.{$this->full_join['field2']} ";
                }
                if (!empty($this->inner_join)) {
                    $sql .= " INNER JOIN {$this->inner_join['table']} ON {$this->table}.{$this->inner_join['field1']} = {$this->inner_join['table']}.{$this->inner_join['field2']} ";
                }

                if (!empty($this->where)) {
                    $sql .= " WHERE {$this->where}";
                }
                return $sql;
            case 'insert':
                $sql = "INSERT INTO  {$this->table} ({$this->fields['keys']}) VALUES {$this->fields['keys_prepared_query']}";
                return $sql;
            case 'update':
                $sql = "UPDATE {$this->table} SET {$this->set}";
                if (!empty($this->where)) {
                    $sql .= " WHERE {$this->where}";
                }
                return $sql;
            case 'delete':
                $sql = "DELETE FROM {$this->table} ";
                if (!empty($this->where)) {
                    $sql .= " WHERE {$this->where}";
                }
                return $sql;
        }
    }


    public function getParams()
    {
        return $this->params;
    }

    public function select($fields = "*"):self
    {
        $this->type = "select";
        $fields_string = $fields;
        if (is_array($fields)) {
            $fields_string = implode(", ", $fields);
        }
        $this->fields = $fields_string;
        return $this;
    }

    public function insert($fields):self
    {
        $this->type = "insert";
        $counter = 0;
        $insert_keys = [];
        $keys_prepared_query = [];
        function is_two_dimensional_array($array)
        {
            foreach ($array as $element) {
                if (is_array($element)) {
                    return true;
                }
            }
            return false;
        }

        if (is_two_dimensional_array($fields)) {
            foreach ($fields as $key => $value) {
                foreach ($value as $sub_key => $sub_value) {
                    if (!in_array($sub_key, $insert_keys)) {
                        $insert_keys[] = $sub_key;
                    }
                    if ($sub_key == array_key_first($value)) {
                        $keys_prepared_query[] .= "( :{$sub_key}" . $counter;
                    } elseif ($sub_key == array_key_last($value)) {
                        $keys_prepared_query[] .= ":{$sub_key}" . $counter . " )";
                    } else {
                        $keys_prepared_query[] .= ":{$sub_key}" . $counter;
                    }
                    $this->params[$sub_key . $counter] = $sub_value;
                }
                $counter++;
            }
        } else {
            foreach ($fields as $key => $value) {
                $insert_keys[] = $key;

                if ($key == array_key_first($fields)) {
                    $keys_prepared_query[] .= "( :{$key}";
                } elseif ($key == array_key_last($fields)) {
                    $keys_prepared_query[] .= ":{$key} )";
                } else {
                    $keys_prepared_query[] .= ":{$key}";
                }
                $this->params[$key] = $value;
            }
        }

        $this->fields['keys'] = implode(", ", $insert_keys);
        $this->fields['keys_prepared_query'] = implode(", ", $keys_prepared_query);
        return $this;
    }

    public function update($table):self
    {
        $this->type = "update";
        $this->table = $table;
        return $this;
    }

    public function delete($table):self
    {
        $this->type = "delete";
        $this->table = $table;
        return $this;
    }

    public function from($table)
    {
        $this->table = $table;
        return $this;
    }

    public function into($table)
    {
        $this->table = $table;
        return $this;
    }

    public function where($where)
    {
        $where_parts = [];
        foreach ($where as $key => $value) {
            $where_parts[] = "{$key} = :{$key}";
            $this->params[$key] = $value;
        }
        $this->where = implode(" AND ", $where_parts);
        return $this;
    }

    public function set($set)
    {
        $set_parts = [];
        foreach ($set as $key => $value) {
            $set_parts[] = "{$key} = :{$key}";
            $this->params[$key] = $value;
        }
        $this->set = implode(" , ", $set_parts);
        return $this;
    }

    public function left_join($table, $field_tb1, $field_tb2)
    {
        $this->left_join['table'] = $table;
        $this->left_join['field1'] = $field_tb1;
        $this->left_join['field2'] = $field_tb2;
        return $this;
    }

    public function right_join($table, $field_tb1, $field_tb2)
    {
        $this->right_join['table'] = $table;
        $this->right_join['field1'] = $field_tb1;
        $this->right_join['field2'] = $field_tb2;
        return $this;
    }

    public function full_join($table, $field_tb1, $field_tb2)
    {
        $this->full_join['table'] = $table;
        $this->full_join['field1'] = $field_tb1;
        $this->full_join['field2'] = $field_tb2;
        return $this;
    }

    public function inner_join($table, $field_tb1, $field_tb2)
    {
        $this->inner_join['table'] = $table;
        $this->inner_join['field1'] = $field_tb1;
        $this->inner_join['field2'] = $field_tb2;
        return $this;
    }

}