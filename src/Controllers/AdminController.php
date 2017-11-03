<?php

namespace Phwoolcon\Skeleton\Controllers;

use Phwoolcon\Controller;

class AdminController extends Controller
{
    use Controller\Admin;

    public function getUsers()
    {
        // Example controller response
        return $this->render('example/users');
    }

    public function postCreateUser()
    {
        // Example controller response
        return $this->redirect('admin/users');
    }
}
