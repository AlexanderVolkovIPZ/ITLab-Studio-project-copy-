<?php

namespace App\Models;

use App\Core\Database\ActiveRecord;

/**
 * @property string $id id of news
 * @property string $title title of news
 * @property string $text text of news
 * @property string $date date of news
 */
class News extends ActiveRecord
{
    public function __construct()
    {
        $this->table = "news";
        parent::__construct();

    }
}