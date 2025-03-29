<?php

namespace App\Controllers;

use Core\Controller;
use Core\Model;

class SubscriptionController extends Controller
{
    public function index()
    {
        check_auth(6);
        $model = new Model();
        $subscriptions = $model->rawQuery('
            SELECT subscription_plan.name, customer.full_name, subscription.* 
            FROM subscription
            JOIN subscription_plan ON subscription.plan = subscription_plan.id
            JOIN customer ON subscription.customer_id = customer.id
            ORDER BY subscription.created_at DESC
        ');
        $subscription_plan = $model->rawQuery('SELECT * FROM subscription_plan');
        $this->view('subscription/index', ['subscriptions' => $subscriptions,'plans'=>$subscription_plan]);
    }
}