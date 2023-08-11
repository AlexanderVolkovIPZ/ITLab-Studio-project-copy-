<?php

namespace App\Core\Database;

class ActiveRecord
{
    protected $fields = [];
    protected Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    function __set(string $name, $value): void
    {
        $this->fields[$name] = $value;
    }

    function __get(string $name)
    {
        return $this->fields[$name];
    }

    public function __call(string $name, array $arguments)
    {
        switch ($name) {
            case 'save':
            {
                $builder = new QueryBuilder();
                $builder->insert($this->fields)->into($arguments[0]);
                $this->database->execute($builder);
                break;
            }
        }
    }
}