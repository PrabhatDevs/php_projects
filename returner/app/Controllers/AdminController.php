<?php

namespace App\Controllers;

use App\Models\Admin;
use App\Models\Module;
use App\Models\User;
use Core\Controller;
use Core\Model;
use Exception;

class AdminController extends Controller
{
    
    public function index()
    {
        check_auth(2);
        $admin = new Admin();
        $admins = $admin->orderBy('created_at', 'desc');
        foreach ($admins as &$admin) {
            unset($admin['password']);
            $module_ids = explode(',', $admin['module_ids']);
            $modules = [];
            foreach ($module_ids as $module_id) {
                $module = new Module();
                $module = $module->find($module_id);
                if ($module) {
                    $modules[] = $module['module_name'];
                }
            }
            $admin['accessible_modules'] = implode(', ', $modules);
        }
        $this->view('admin/index', ['admins' => $admins]);
    }
    public function create()
    {
        $model = new Model();
        check_auth(2);
        $permissions = $model->rawQuery('SELECT * FROM module_details');
        $this->view('admin/create', ['permissions' => $permissions]);
    }
    public function store()
    {
        check_auth(2);
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? '';
        $accessible_modules = $_POST['accessible_modules'] ?? [];
        $profile_picture = $_FILES['profile_pic'] ?? '';

        $model = new Model();

        if ($role == 'super_admin') {
            $accessible_modules = [];
            $modules = $model->rawQuery('SELECT id AS count from module_details');
            foreach ($modules as $module) {
                array_push($accessible_modules, $module['count']);
            }
        }

        if ($name == '' || $email == '' || $password == '' || $role == '' || $accessible_modules == []) {
            $_SESSION['message'] = 'All fields are required';
            $_SESSION['status'] = 'error';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'role' => $role,
            'module_ids' => implode(',', (array) $accessible_modules),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if ($profile_picture['error'] == UPLOAD_ERR_OK) {
            $upload_dir = base_path('app/Views/admin/uploads/profile_pictures/');
            $file_name = uniqid() . '_' . basename($profile_picture['name']);
            $target_file = $upload_dir . $file_name;

            if (move_uploaded_file($profile_picture['tmp_name'], $target_file)) {
                $data['profile_pic'] = $file_name;
            }
        }

        // Save the data to the database
        $admin = new Admin();
        $check_admin = $admin->firstWhere('email', '=', $email);
        if (empty($check_admin)) {
            $admin->insert($data);
            $_SESSION['message'] = 'Admin created successfully';
            $_SESSION['status'] = 'success';
            header('Location: ' . base_url('admins'));
            exit;
        } else {
            $_SESSION['message'] = 'Email Already exists';
            $_SESSION['status'] = 'error';
            header('Location: ' . base_url('admins'));
            exit;

        }
    }
    public function edit()
    {

      
        $id = $_GET['id'];
        $admin = new Admin();
        $admin = $admin->find($id);

        if (!$admin) {
            $_SESSION['message'] = 'Admin not found';
            $_SESSION['status'] = 'error';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        unset($admin['password']);

        $model = new Model();
       
        $permissions = $model->rawQuery('SELECT * FROM module_details');
        $this->view('admin/edit', ['admin' => $admin, 'permissions' => $permissions]);
    }
    public function update()
    {
        
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $status = $_POST['status'] ?? '';
        $role = $_POST['role'] ?? '';
        $accessible_modules = $_POST['accessible_modules'] ?? '';
        $profile_picture = $_FILES['profile_pic'] ?? '';

        if ($name == '' || $email == '' || $role == '' || $accessible_modules == '' || $status == '') {
            $_SESSION['message'] = 'All fields are required';
            $_SESSION['status'] = 'error';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        $model = new Model();
        if ($role == 'super_admin') {
            $accessible_modules = [];
            $modules = $model->rawQuery('SELECT id AS count from module_details');
            foreach ($modules as $module) {
                array_push($accessible_modules, $module['count']);
            }
        }
        $data = [
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'status' => $status,
            'module_ids' => implode(',', (array) $accessible_modules)
        ];

        if ($profile_picture['error'] == UPLOAD_ERR_OK) {
            $upload_dir = base_path('app/Views/admin/uploads/profile_pictures/');
            $file_name = uniqid() . '_' . basename($profile_picture['name']);
            $target_file = $upload_dir . $file_name;

            // Delete the previous profile picture if it exists
            $admin = new Admin();
            $existing_admin = $admin->find($_POST['admin_id']);
            if ($existing_admin && !empty($existing_admin['profile_pic'])) {
                $old_file = $upload_dir . $existing_admin['profile_pic'];
                if (file_exists($old_file)) {
                    unlink($old_file);
                }
            }

            if (move_uploaded_file($profile_picture['tmp_name'], $target_file)) {
                $data['profile_pic'] = $file_name;
            }
        }

        // Save the data to the database
        $admin = new Admin();

        $admin->update($_POST['admin_id'], $data);
        $_SESSION['message'] = 'Admin updated successfully';
        $_SESSION['status'] = 'success';
        header('Location: ' . base_url('admins'));
    }
    public function delete()
    {
        check_auth(2);
        $id = $_POST['admin_id'];
        $admin = new Admin();
        $admin_image = $admin->find($id);
        if ($admin_image && !empty($admin_image['profile_pic'])) {
            $upload_dir = base_path('app/Views/admin/uploads/profile_pictures/');
            $file = $upload_dir . $admin_image['profile_pic'];
            if (file_exists($file)) {
                unlink($file);
            }
        }
        $admin->delete($id);
        $_SESSION['message'] = 'Admin deleted successfully';
        $_SESSION['status'] = 'success';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    public function changeStatus()
    {
        check_auth(2);
        $id = $_POST['admin_id'] ?? '';
        if ($id == '') {
            $_SESSION['message'] = 'Admin not found';
            $_SESSION['status'] = 'error';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        $status = $_POST['status'];
        $admin = new Admin();
        $admin->update($id, ['status' => $status]);
        $_SESSION['message'] = 'Status changed successfully';
        $_SESSION['status'] = 'success';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    public function fetch_data()
    {
        try {
            $limit = isset($_POST['length']) ? (int) $_POST['length'] : 10;
            $start = isset($_POST['start']) ? (int) $_POST['start'] : 0;
            $draw = isset($_POST['draw']) ? (int) $_POST['draw'] : 1;

            $roleFilter = $_POST['role'] ?? '';
            $emailFilter = $_POST['email'] ?? '';
            $statusFilter = $_POST['status'] ?? '';

            if ($statusFilter == 'inactive') {
                $statusFilter = '0';
            }

            $whereClauses = [];
            $params = [];

            if (!empty($roleFilter)) {
                $whereClauses[] = "role = :role";
                $params[':role'] = $roleFilter;
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
            $totalQuery = "SELECT COUNT(*) as total FROM admins";
            $totalRecords = $model->rawQuery($totalQuery)[0]['total'] ?? 0;

            // Get filtered records count
            $filteredQuery = "SELECT COUNT(*) as total FROM admins $whereSql ORDER BY created_at DESC";
            $filteredRecords = $model->rawQuery($filteredQuery, $params)[0]['total'] ?? 0;

            // ✅ FIX: Directly append integers for `LIMIT` (No named placeholders)
            $query = "SELECT * FROM admins $whereSql LIMIT $start, $limit";

            // error_log("Executing Query: " . $query);
            // error_log("Parameters: " . json_encode($params));

            $admins = $model->rawQuery($query, $params) ?? [];

            if ($admins === false) {
                echo json_encode(['error' => 'Database query failed']);
                exit;
            }

            foreach ($admins as &$admin) {
                unset($admin['password']);
                $module_name = [];

                if (!empty($admin['module_ids'])) {
                    foreach (explode(',', $admin['module_ids']) as $id) {
                        $modules = $model->rawQuery('SELECT module_name FROM module_details WHERE id=:id', [':id' => $id]);
                        if (!empty($modules)) {
                            $module_name[] = $modules[0]['module_name'];
                        }
                    }
                }
                $admin['module_names'] = implode(', ', $module_name);
            }

            echo json_encode([
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $admins
            ]);
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    }





}