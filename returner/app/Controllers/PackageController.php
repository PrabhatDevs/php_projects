<?php

namespace App\Controllers;

use Core\Controller;
use Core\Model;

class PackageController extends Controller
{
    public function index()
    {
        check_auth(5);
        $model = new Model();
        $packages = $model->rawQuery('SELECT customer.full_name AS customer_name, driver.full_name AS driver_name, platform.name AS platform_name, package.* 
                          FROM package 
                          LEFT JOIN customer ON package.customer_id = customer.id 
                          LEFT JOIN driver ON package.driver_id = driver.id 
                          JOIN platform ON package.platform_id = platform.id 
                          ORDER BY package.created_at DESC');
        $this->view('package/index', ['packages' => $packages]);
    }
    public function show(){
        check_auth(5);
        $package_id = $_GET['package_id'] ?? '';
        if ($package_id == '') {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Invalid package id';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
        $model = new Model();
        $package = $model->rawQuery('SELECT customer.full_name AS customer_name, driver.full_name AS driver_name, platform.name AS platform_name, package.* 
              FROM package 
              LEFT JOIN customer ON package.customer_id = customer.id 
              LEFT JOIN driver ON package.driver_id = driver.id 
              JOIN platform ON package.platform_id = platform.id 
              WHERE package.id = :id 
              ORDER BY package.created_at DESC', ['id'=>$package_id])[0] ?? [];

        $images = $model->rawQuery('SELECT * FROM package_images WHERE package_id = :id', ['id' => $package_id]);

        $package['images'] = $images;
        if (empty($package)) {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Package not found';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
        $this->view('package/show', ['package' => $package]);
     
    }

}