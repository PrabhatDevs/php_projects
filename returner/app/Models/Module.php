<?php

namespace App\Models;

use Core\Model;


class Module extends Model
{
    protected $table = 'module_details'; // Keep it protected

    public function __construct()
    {
        parent::__construct();
        $this->setTable($this->table);
    }
}