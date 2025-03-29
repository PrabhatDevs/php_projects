<?php

namespace App\Models;

use Core\Model;

class Admin extends Model
{
    protected $table = 'admins'; // Make it protected

    public function __construct()
    {
        parent::__construct();
        $this->setTable($this->table);
    }
}