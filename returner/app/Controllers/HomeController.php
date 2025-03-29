<?php

namespace App\Controllers;

use Core\Controller;
use Core\Model;

class HomeController extends Controller
{
    public function index()
    {
        $model = new Model();
        $customer_count = $model->rawQuery('SELECT COUNT(*) as count from customer')[0]['count'] ?? 0;
        $driver_count = $model->rawQuery('SELECT COUNT(*) as count FROM driver')[0]['count'] ?? 0;
        $success_delivery_count = $model->rawQuery("SELECT COUNT(*) as count FROM package WHERE status = 'delivered'")[0]['count'] ?? 0;
        $platform_count = $model->rawQuery('SELECT COUNT(*) as count FROM platform')[0]['count'] ?? 0;
        $pending_package_count = $model->rawQuery("SELECT COUNT(*) as count FROM package where status != 'delivered'")[0]['count'] ?? 0;
        $revenue = $model->rawQuery('SELECT SUM(subscription_plan.price) as total FROM subscription JOIN subscription_plan ON subscription.plan = subscription_plan.id')[0]['total'] ?? 0;

        $paid_subs = $model->rawQuery('SELECT COUNT(*) AS count from subscription')[0]['count'] ?? 0;
        $users = $model->rawQuery('SELECT full_name, email, phone_number, created_at, id from customer ORDER BY created_at DESC LIMIT 10');
        $this->view('home',['paid_count'=>$paid_subs,'users'=>$users,'customer_count'=>$customer_count,'driver_count'=>$driver_count,'delivery_count'=>$success_delivery_count,'platform_count'=>$platform_count,'pending_package'=>$pending_package_count,'revenue'=>$revenue]);
    }

}