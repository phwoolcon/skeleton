<?php

namespace Phwoolcon\Skeleton\Controllers;

use Phwoolcon\Controller;
use Router;

class WebApiController extends Controller
{
    use Controller\Api;

    public function initialize()
    {
        Router::disableCsrfCheck();
    }

    public function any404Request()
    {
        return $this->jsonApiReturnErrors([
            [
                'code'  => 404,
                'title' => $message = __('404 NOT FOUND'),
            ],
        ], ['status' => false, 'message' => $message], [], 404);
    }

    public function postUploadAvatar()
    {
        // Example controller response
        return $this->jsonApiReturnMeta([
            'status'  => true,
            'message' => __('Avatar uploaded successfully'),
        ]);
    }
}
