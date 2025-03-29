<?php
namespace App\Controllers;

use Core\Controller;
use Core\Model;
use Exception;
class CustomerController extends Controller
{
    public function index()
    {
        check_auth(1);
        $this->view('user/customer');
    }
    public function fetch_customer_list()
    {
        check_auth(1);
        try {
            $limit = isset($_POST['length']) ? (int) $_POST['length'] : 10;
            $start = isset($_POST['start']) ? (int) $_POST['start'] : 0;
            $draw = isset($_POST['draw']) ? (int) $_POST['draw'] : 1;

            $nameFilter = $_POST['name'] ?? '';
            $emailFilter = $_POST['email'] ?? '';
            $dateFilter = $_POST['date'] ?? '';

            $whereClauses = [];
            $params = [];

            if (!empty($nameFilter)) {
                $whereClauses[] = "full_name LIKE :name";
                $params[':name'] = "%$nameFilter%";
            }
            if (!empty($emailFilter)) {
                $whereClauses[] = "email LIKE :email";
                $params[':email'] = "%$emailFilter%";
            }
            if ($dateFilter !== '') {
                $whereClauses[] = "created_at LIKE :date";
                $params[':date'] = "%$dateFilter%";
            }

            $whereSql = !empty($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "";

            $model = new Model();

            // Get total records count
            $totalQuery = "SELECT COUNT(*) as total FROM customer";
            $totalRecords = $model->rawQuery($totalQuery)[0]['total'] ?? 0;

            // Get filtered records count
            $filteredQuery = "SELECT COUNT(*) as total FROM customer $whereSql ORDER BY created_at DESC";
            $filteredRecords = $model->rawQuery($filteredQuery, $params)[0]['total'] ?? 0;

            // ✅ FIX: Directly append integers for `LIMIT` (No named placeholders)
            $query = "SELECT * FROM customer $whereSql LIMIT $start, $limit";

            // error_log("Executing Query: " . $query);
            // error_log("Parameters: " . json_encode($params));

            $customer = $model->rawQuery($query, $params) ?? [];

            if ($customer === false) {
                echo json_encode(['error' => 'Database query failed']);
                exit;
            }

            foreach ($customer as &$cust)
                unset($cust['password']);

            echo json_encode([
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $customer
            ]);
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    }

    function show()
    {
        check_auth(1);
        $model = new Model();
        $driver_id = $_GET['driver_id'] ?? '';
        if (isset($driver_id) && $driver_id != '') {
            $packages = $model->rawQuery('SELECT customer.full_name AS customer_name, driver.full_name AS driver_name, platform.name AS platform_name, package.* 
              FROM package 
              LEFT JOIN customer ON package.customer_id = customer.id 
              LEFT JOIN driver ON package.driver_id = driver.id 
              JOIN platform ON package.platform_id = platform.id 
              WHERE package.driver_id = :driver_id 
              ORDER BY package.created_at DESC', ['driver_id' => $driver_id]);

            $driver = $model->rawQuery('SELECT * FROM driver WHERE id=:id', ['id' => $driver_id])[0] ?? [];
            unset($driver['password']);
            $this->view('user/show_driver', ['packages' => $packages, 'driver' => $driver]);
        }
        $customer_id = $_GET['customer_id'] ?? '';
        if (isset($customer_id) && $customer_id != '') {
            $packages = $model->rawQuery('SELECT driver.full_name AS driver_name, platform.name AS platform_name, package.* 
              FROM package 
              LEFT JOIN driver ON package.driver_id = driver.id 
              JOIN platform ON package.platform_id = platform.id 
              WHERE package.customer_id = :customer_id 
              ORDER BY package.created_at DESC', ['customer_id' => $customer_id]);

            $subscriptions = $model->rawQuery('SELECT subscription.*, subscription_plan.name as plan_name, subscription_plan.price FROM subscription JOIN subscription_plan ON subscription.plan=subscription_plan.id WHERE customer_id = :customer_id', ['customer_id' => $customer_id]);
            $customer = $model->rawQuery('SELECT * FROM customer WHERE id=:id', ['id' => $customer_id])[0] ?? [];
            unset($customer['password']);

            $this->view('user/show', ['packages' => $packages, 'subscriptions' => $subscriptions, 'customer' => $customer]);
        }
        if ($customer_id == '' && $driver_id == '') {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'User Not Found';
            header('Location:' . $_SERVER['HTTP_REFERER']);
            exit;
        }



    }


    function change_customer_status()
    {
        check_auth(1);
        $model = new Model();
        $customer_id = $_POST['customer_id'] ?? '';
        $status = $_POST['status'] ?? '';
        $customer_count = $model->rawQuery('SELECT COUNT(*) AS count from customer where id=:id', ['id' => $customer_id])[0]['count'];
        if ($customer_id == '' || $customer_count == 0 || $status == '') {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'customer Not Found';
            header('Location:' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        try {
            $model->rawQuery('UPDATE customer SET status=:status WHERE id=:id', ['status' => $status, 'id' => $customer_id]);
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'Status Updated Successfully';
            header('Location:' . base_url('customers'));
            exit;
        } catch (Exception $e) {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Error: ' . $e->getMessage();
            header('Location:' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }

    // ******************************driver section ***********************


    public function drivers()
    {
        check_auth(1);
        $this->view('user/drivers');
    }
    public function fetch_driver_list()
    {
        check_auth(1);
        try {
            $limit = isset($_POST['length']) ? (int) $_POST['length'] : 10;
            $start = isset($_POST['start']) ? (int) $_POST['start'] : 0;
            $draw = isset($_POST['draw']) ? (int) $_POST['draw'] : 1;

            $nameFilter = $_POST['name'] ?? '';
            $emailFilter = $_POST['email'] ?? '';
            $statusFilter = $_POST['status'] ?? '';

            $whereClauses = [];
            $params = [];

            if (!empty($nameFilter)) {
                $whereClauses[] = "full_name LIKE :name";
                $params[':name'] = "%$nameFilter%";
            }
            if (!empty($emailFilter)) {
                $whereClauses[] = "email LIKE :email";
                $params[':email'] = "%$emailFilter%";
            }
            if ($statusFilter !== '') {
                $whereClauses[] = "status = :status";
                $params[':status'] = $statusFilter;
            }

            $whereSql = !empty($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "";

            $model = new Model();

            // Get total records count
            $totalQuery = "SELECT COUNT(*) as total FROM driver";
            $totalRecords = $model->rawQuery($totalQuery)[0]['total'] ?? 0;

            // Get filtered records count
            $filteredQuery = "SELECT COUNT(*) as total FROM driver $whereSql ORDER BY created_at DESC";
            $filteredRecords = $model->rawQuery($filteredQuery, $params)[0]['total'] ?? 0;

            // ✅ FIX: Directly append integers for `LIMIT` (No named placeholders)
            $query = "SELECT * FROM driver $whereSql LIMIT $start, $limit";

            // error_log("Executing Query: " . $query);
            // error_log("Parameters: " . json_encode($params));

            $driver = $model->rawQuery($query, $params) ?? [];

            if ($driver === false) {
                echo json_encode(['error' => 'Database query failed']);
                exit;
            }

            foreach ($driver as &$cust)
                unset($cust['password']);

            echo json_encode([
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $driver
            ]);
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    }
    function change_driver_status()
    {
        check_auth(1);
        $model = new Model();
        $driver_id = $_POST['driver_id'] ?? '';
        $status = $_POST['status'] ?? '';
        $driver_count = $model->rawQuery('SELECT COUNT(*) AS count from driver where id=:id', ['id' => $driver_id])[0]['count'];
        if ($driver_id == '' || $driver_count == 0 || $status == '') {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Driver Not Found';
            header('Location:' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        try {
            $model->rawQuery('UPDATE driver SET status=:status WHERE id=:id', ['status' => $status, 'id' => $driver_id]);
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'Status Updated Successfully';
            header('Location:' . base_url('drivers'));
            exit;
        } catch (Exception $e) {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Error: ' . $e->getMessage();
            header('Location:' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }

}