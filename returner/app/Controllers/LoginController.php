<?php

namespace App\Controllers;

use App\Models\Admin;
use App\Models\User;
use Core\Controller;
use Core\Model;
use Exception;
class LoginController extends Controller
{

    public function index()
    {
        $this->view('auth/login');
    }
    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        if ($email == '' || $password == '') {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'All the fields are required';
            header('Location:' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Invalid email format';
            header('Location:' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        // Clear previous session data
        session_unset();
        session_destroy();
        session_start();

        $admin = new Admin();
        $find_admin = $admin->firstWhere('email', '=', $email);
        if ($find_admin) {
            if ($find_admin['status']) {
                if (password_verify($password, $find_admin['password'])) {
                    unset($find_admin['password']);
                    // Set new session data except password
                    $_SESSION['user_id'] = $find_admin['user_id'];
                    $_SESSION['is_login'] = true;
                    $_SESSION['user_details'] = $find_admin;
                    $_SESSION['status'] = 'success';
                    $_SESSION['message'] = 'Login successful';
                    header('Location:' . base_url('dashboard'));
                    exit;
                } else {
                    $_SESSION['status'] = 'error';
                    $_SESSION['message'] = 'Invalid password';
                    header('Location:' . $_SERVER['HTTP_REFERER']);
                    exit;
                }
            } else {
                $_SESSION['status'] = 'error';
                $_SESSION['message'] = 'Admin is Inactive! Cannot Login';
                header('Location:' . $_SERVER['HTTP_REFERER']);
                exit;
            }
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'User not found';
            header('Location:' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
    public function logout()
    {
        // Clear all session data
        session_unset();
        session_destroy();

        // Redirect to login page
        header('Location: ' . base_url('login'));
        exit;
    }
    public function reset_password()
    {
        $this->view('auth/reset_password');
    }
    public function reset()
    {
        $old_pass = $_POST['currentPassword'] ?? '';
        $new_pass = $_POST['newPassword'] ?? '';
        $email = $_SESSION['user_details']['email'] ?? '';

        if (empty($old_pass) || empty($new_pass) || empty($email)) {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'All fields are required!';
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? base_url('dashboard')));
            exit;
        }
        $admin = new Admin();
        $admin_details = $admin->firstWhere('email', '=', $email);
        if ($admin_details && password_verify($old_pass, $admin_details['password'])) {
            try {
                $admin->rawQuery('UPDATE admins SET password=:pass where email=:email', ['pass' => password_hash($new_pass, PASSWORD_BCRYPT), 'email' => $email]);
                $_SESSION['status'] = 'success';
                $_SESSION['message'] = 'Password reset successfully!';
                header('Location:' . base_url('dashboard'));
                exit;
            } catch (Exception $e) {
                $_SESSION['status'] = 'error';
                $_SESSION['message'] = 'Failed to reset password!';
                header('Location:' . base_url('dashboard'));
                exit;
            }
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Old password is incorrect!';
            header('Location:' . base_url('dashboard'));
            exit;
        }

    }
    public function not_found(){
        $this->view('404');
    }

}
