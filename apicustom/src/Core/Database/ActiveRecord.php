<?php

namespace App\Core\Database;

use App\Core\Core;
use App\Core\StaticCore;

class ActiveRecord
{
    protected $fields = [];
    protected string $table;

    public function __construct()
    {

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
                if (!empty($arguments[0])) {
                    $this->table = $arguments[0];
                }

                if (!empty($this->table)) {
                    $builder->insert($this->fields)->into($this->table);
                    Core::getInstance()->GetDatabase()->execute($builder);
//                    StaticCore::GetDatabase()->execute($builder);
                }else{
                    //Error
                }
                break;


            }
        }
    }
}