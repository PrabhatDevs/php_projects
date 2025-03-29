<?php

namespace App\Middleware;

class AuthMiddleware
{
    public function handle()
    {
        // Example: Check if user is authenticated
        $permissions = explode(',', $_SESSION['user_details']['module_ids']);
        if (!isset($_SESSION['is_login'])) {

            header('Location:'.base_url('login'));
            exit;
        }
    }
}
