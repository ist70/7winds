<?php

namespace App\Controllers;

use App\Core\Mvc\Controller;
use App\Core\Mvc\Exception404;

class winds7 extends Controller
{

    public function actionTest7winds()
    {
        $this->view->render('/test7winds/index.html', [
            'resource' => \PHP_Timer::resourceUsage()
        ]);
    }

    public function actionQuests()
    {
        $post = $_POST;
        if (empty($post)) {
            $this->redirect('/winds7/');
        }
        $quest = 'quest' . $post['quest'];
        $this->view->render('/test7winds/' . $quest . '.html', [
            'resource' => \PHP_Timer::resourceUsage()
        ]);
    }

}