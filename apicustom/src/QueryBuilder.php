<?php

class QueryBuilder
{

    protected $fields;
    protected $table;
    protected $type;
    protected $params;
    protected $where;

    public function __construct()
    {
        $this->params = [];
    }

    public function select($fields = "*")
    {
        $this->type = "select";
        $fields_string = $fields;
        if (is_array($fields)) {
            $fields_string = implode(", ", $fields);
        }
        $this->fields = $fields_string;
        return $this;
    }

    public function from($table)
    {
        $this->table = $table;
        return $this;
    }

    public function getSql()
    {
        switch ($this->type) {
            case 'select':
                $sql = "SELECT {$this->fields} FROM {$this->table}";
                if (!empty($this->where)) {
                    $sql .= " WHERE {$this->where}";
                }
                return $sql;
            case 'insert':
                $sql = "INSERT INTO  {$this->table} ({$this->fields['keys']}) VALUES {$this->fields['keys_prepared_query']}";
                return $sql;
        }
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

    public function getParams()
    {
        return $this->params;
    }


    public function into($table)
    {
        $this->table = $table;
        return $this;
    }


    public function insert($fields)
    {
        $this->type = "insert";
        $counter = 0;
        $insert_keys = [];
        $keys_prepared_query = [];

        function is_two_dimensional_array($array) {
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
                    if ($sub_key == array_keys($value)[0]) {
                        $keys_prepared_query[] .= "( :{$sub_key}" . $counter;
                    } elseif ($sub_key == array_keys($value)[count($value)-1]) {
                        $keys_prepared_query[] .= ":{$sub_key}" . $counter . " )";
                    } else {
                        $keys_prepared_query[] .= ":{$sub_key}" . $counter;
                    }
                    $this->params[$sub_key.$counter] = $sub_value;
                }
                $counter++;
            }
        } else {
            foreach ($fields as $key => $value) {
                $insert_keys[] = $key;

                if ($key == array_keys($fields)[0]) {
                    $keys_prepared_query[] .= "( :{$key}";
                } elseif ($key == array_keys($fields)[count($fields)-1]) {
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


}