<?php

namespace App\Controllers;

use App\Core\Mvc\Controller;

class Error extends Controller
{

    public function actionError404($error)
    {
        $this->view->render('/errors/error404.html', [
            'error' => $error
        ]);
    }

    public function actionError($errors)
    {
        $this->view->render('/errors/errors.html', [
            'errors' => $errors
        ]);
    }

}
