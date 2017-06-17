<?php

namespace App\Controllers;

use App\Core\AdminDataTable;
use App\Core\Mvc\Controller;
use App\Models\Author;
use App\Models\News as NewsModel;
use App\Core\Mvc\Exception404;
use App\Config;

class Admin extends Controller
{

    /**
     * Метод вывода всех новостей
     *
     */
    protected function actionAll()
    {
        $news = NewsModel::findAll();
        $this->view->render('/admin/all.html', [
            'news' => $news
        ]);
    }

    /**
     * Метод вывода одной новости по её id
     *
     */
    protected function actionOne()
    {
        $id = (int)$_GET['id'] ?: false;
        if (empty($id)) {
            $this->redirect('/admin/');
        }
        if (!empty($article = NewsModel::findById($id))) {
            $this->view->render('/admin/one.html', [
                'article' => $article
            ]);
        } else {
            $this->view->erroradmin = true;
            throw new Exception404('Страница с такой новостью не найдена');
        }
    }

    /**
     * Метод вывода формы для написания новой статьи
     *
     */
    protected function actionCreate()
    {
        $this->view->render('/admin/form.html');
    }

    /**
     * Метод для вывода формы редактирования выбранной статьи по её id
     *
     */
    protected function actionUpdate()
    {
        $id = (int)$_GET['id'] ?: false;
        if (empty($id)) {
            $this->redirect('/admin/');
        }
        if (!empty($id)) {
            if (!empty($article = NewsModel::findById($id))) {
                //$this->view->article = $article;
                $this->view->render('/admin/form.html', [
                    'article' => $article,
                    'id' => $id
                ]);
            } else {
                $this->view->erroradmin = true;
                throw new Exception404('Страница с такой новостью не найдена');
            }
        }
    }

    /**
     * Метод сохранения новой статьи или после внесения изменений в статье
     *
     */
    protected function actionSave()
    {
        $post = $_POST;
        if (empty($post)) {
            $this->redirect('/admin/');
        }
        if (empty($post['id_news'])) {
            $article = new NewsModel();
        } else {
            $article = NewsModel::findById($post['id_news']);
        }
        $article->fill($post)->save();
        $this->redirect('/admin/one/?id=' . $article->id_news);
    }

    /**
     * Метод удаления статьи по её id
     *
     */
    protected function actionDelete()
    {
        $id = (int)$_GET['id'] ?: false;
        if (!empty($article = NewsModel::findById($id))) {
            $article->delete();
        } else {
            $this->view->erroradmin = true;
            throw new Exception404('Страница с такой новостью не найдена');
        }
        $this->redirect('/admin/');
    }

    protected function actionTable()
    {
        $funcs = Config::instance()->funcs;
        $table = new AdminDataTable([1, 2, 3, 4, 5], $funcs);
        $table->render1();
        $this->view->render('/admin/table.html', [
            'data' => $table->data,
            'func' => $table->namefunc,
            'resource' => \PHP_Timer::resourceUsage()
        ]);
    }

    protected function actionAuthors()
    {
        $authors = Author::findAll();
        $table = new AdminDataTable($authors, [
            function (Author $author) {
                return $author->firstname;
            },
            function (Author $author) {
                return $author->lastname;
            },
            function (Author $author) {
                return $author->email;
            },
        ]);
        $this->view->render('/admin/authors.html', [
            'authors' => $table->render()
        ]);
    }

}
