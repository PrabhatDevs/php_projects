<?php

namespace App\Models;

use Core\Model;


class User extends Model
{
    protected $table = 'users'; // Keep it protected

    public function __construct()
    {
        parent::__construct();
        $this->setTable($this->table);
    }
}

