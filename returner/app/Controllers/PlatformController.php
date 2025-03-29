<?php

namespace App\Controllers;

use Core\Controller;
use Core\Model;

class PlatformController extends Controller
{
    public function index()
    {
        check_auth(4);
        $model = new Model();
        $platforms = $model->rawQuery('SELECT * FROM platform ORDER BY created_at DESC');
        $this->view('platform/index',['platforms'=>$platforms]);
    }
public function create()
    {
        check_auth(4);
        $this->view('platform/create');
    }


    //  image path required 
public function store()
    {
        check_auth(4);
    $model = new Model();
    $name = $_POST['name'];
    $image = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/platforms/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image = $targetFile;
        }
    }

    if ($image) {
        $model->rawQuery('INSERT INTO platform (name, image) VALUES (?, ?)', [$name, $image]);
    } else {
        $model->rawQuery('INSERT INTO platform (name) VALUES (?)', [$name]);
    }

        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Platform Created Successfully';
        header('Location:' . base_url('platforms'));
        exit;


    }
public function edit()
    {
        check_auth(4);
        $model = new Model();
        $platform_id = $_GET['platform_id'];
        if($platform_id ==''){
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Platform not found';
            header('Location:'.$_SERVER['HTTP_REFERER']);
            exit;
        }
        $platform = $model->rawQuery('SELECT * FROM platform WHERE id = :id',['id'=>$platform_id])[0]??[];
        if(empty($platform)){
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Platform not found';
            header('Location:'.$_SERVER['HTTP_REFERER']);
            exit;
        }
        $this->view('platform/edit',['platform'=>$platform]);
    }
public function update()
    {
        check_auth(4);
        $id = $_POST['id'] ?? '';

    $model = new Model();
    $name = $_POST['name'];
    $image = null;

    $existingPlatform = $model->rawQuery('SELECT image FROM platform WHERE id = ?', [$id])[0] ?? null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/platforms/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            if ($existingPlatform && file_exists($existingPlatform['image'])) {
                unlink($existingPlatform['image']);
            }
            $image = $targetFile;
        }
    }

    if ($image) {
        $model->rawQuery('UPDATE platform SET name = ?, image = ? WHERE id = ?', [$name, $image, $id]);
    } else {
        $model->rawQuery('UPDATE platform SET name = ? WHERE id = ?', [$name, $id]);
    }

    $_SESSION['status'] = 'success';
    $_SESSION['message'] = 'Platform Updated Successfully';
    header('Location:' . base_url('platforms'));
    exit;
}
    public function delete()
    {
        check_auth(4);
        $id = $_POST['platform_id'] ?? '';
        $model = new Model();
        $platform = $model->rawQuery('SELECT image FROM platform WHERE id = ?', [$id])[0] ?? null;

        if ($platform && file_exists($platform['image'])) {
            unlink($platform['image']);
        }

        $model->rawQuery('DELETE FROM platform WHERE id = ?', [$id]);

        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Platform Deleted Successfully';
        header('Location:' . $_SERVER['HTTP_REFERER']);
        exit;
    }



}