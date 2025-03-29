<?php

// Base path function to access the application's file system
function base_path($path = '')
{
    // Get the absolute path of the root directory (three levels up)
    $root_path = realpath(__DIR__ . '/..'); // Fix the relative path
    return $root_path . '/' . $path;
}
// Base URL function to generate the full URL
function base_url($path = '')
{
    // Check if the request is using HTTPS
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

    // Dynamically determine the base path of the application
    $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');

    // Build and return the full base URL
    return $protocol . '://' . $_SERVER['HTTP_HOST'] . $basePath . '/' . ltrim($path, '/');
}
function url(){
    $url = 'https://alliedtechnologies.cloud/clients/pkg_return/api/v1/';
    return $url;
}
function match_url($url = '') {
    return (strpos($_SERVER['REQUEST_URI'], $url) !== false) ? 'active' : '';
}
function check_auth($module_id = '')
{
    $allowed = explode(',', $_SESSION['user_details']['module_ids']);
    if (!in_array($module_id, $allowed)) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'You are not authorized to access the page!';

        $redirect_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : base_url('login');
        header('Location: ' . $redirect_url);
        exit;
    }
}

function can($module_id=''){
    $allowed = explode(',', $_SESSION['user_details']['module_ids']);
    if (!in_array($module_id, $allowed)) 
        return false;
    else
        return true;
}
function no_image(){
    return base_url('assets/images/icons/user2.png');
}
function broken_img(){
    return base_url('assets/images/icons/default.png');
}


