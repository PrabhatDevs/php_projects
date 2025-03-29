<?php

namespace Core;

class Controller
{
    public function view($view, $data = [])
    {
        extract($data); // Extract data to be used in the view
        $viewPath = base_path("app/Views/{$view}.view.php");

        // Check if the view file exists
        if (file_exists($viewPath)) {
            require_once $viewPath; // Dynamically load the view
        } else {
            require_once base_path("app/Views/404.view.php"); // Load the 404 view
        }
    }


    public function model($model)
    {
        require_once "../app/Models/{$model}.php";
        return new $model;
    }
}
