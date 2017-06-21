<?php

namespace App\Controllers;

use App\Core\Mvc\Controller;
use App\Models\Quest;
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
        $array = ['[NAME:discription]data[/NAME]'];
        if ($post['quest'] == 1) {
            $r = preg_match('/\[(\w+):(\w+)\](\w+)\[\/(\w+)\]/i', $array[0], $match);

            $arr1 = [$match[1], $match[3]];
            $arr2 = [$match[1], $match[2]];
            $quest = 'quest' . $post['quest'];
            $this->view->render('/test7winds/' . $quest . '.html', [
                'arr1' => $arr1,
                'arr2' => $arr2,
                'resource' => \PHP_Timer::resourceUsage()
            ]);
        }
//Дан текст в который включены ключи raz: dva: tri:
//текст может располагаться как перед ключами так и после
//
//На выходе нужно получить массив,
//где ключ это raz , dva , tri, а ДАННЫЕ - текст раполагающийся после ключа до следующего ключа или до конца текста,
// если не встретился ключ.
// Очередность ключей может быть – произвльная. Если в тексте ключ встречается второй раз - в массиве
// он должен быть переписан.
        $array = ['raz:znachenieRaz bred dva:znachenieDva tri:znachenieTri bredv conce raz:znachenieRazzzz'];
        if ($post['quest'] == 2) {
            $r = preg_match_all('/(\w*?)(raz:|dva:|tri:)(\w+)/i', $array[0], $match);
            $result = [];
            $i = 0;
            foreach ($match as $data) {
                $result[$match[2][$i]] = $match[3][$i];
                $i++;
            }
            echo '<pre>';
            $quest = 'quest' . $post['quest'];
            $this->view->render('/test7winds/' . $quest . '.html', [
                'result' => $result,
                'resource' => \PHP_Timer::resourceUsage()
            ]);
        }

//        Реализовать алгоритм выводящий это дерево, вида:
//EEE
//  ->KK
//  ->LK
//RE
//LO
//  ->EW
//  ->FS
//DF
//  ->JJJ
//	  ->WW
//	  ->LL
//		->SS
//		  ->SD
//		  ->HR
//			->JS
//			  ->PP
//			->ET
//  ->ED
//  ->AC
//PPP
//и т.д.
        if ($post['quest'] == 3) {
            $data = Quest::findAll();
            foreach ($data as $item) {
                $tree[$item->id] = [$item->parent, $item->name];
            }
            echo '<pre>';
            $this->setTree($tree);
            foreach ($data as $item) {
                $newtree[$item->parent][] = [$item->id, $item->name];
            }
            echo '<pre>';
            $this->setTree2($newtree);
            $quest = 'quest' . $post['quest'];
            $this->view->render('/test7winds/' . $quest . '.html', [
                'resource' => \PHP_Timer::resourceUsage()
            ]);
        }
        if ($post['quest'] == 4) {
            $parent = 0;
            $child = 3;
            $result = Quest::findByParentAndChild($parent, $child);
            $quest = 'quest' . $post['quest'];
            $this->view->render('/test7winds/' . $quest . '.html', [
                'result' => $result,
                'parent' => $parent,
                'child' => $child,
                'count' => count($result),
                'resource' => \PHP_Timer::resourceUsage()
            ]);
        }

        if ($post['quest'] == 5) {
            $result = Quest::findByParentNotChild();
            $quest = 'quest' . $post['quest'];
            $this->view->render('/test7winds/' . $quest . '.html', [
                'result' => $result,
                'resource' => \PHP_Timer::resourceUsage()
            ]);
        }

        if ($post['quest'] == 6) {
            $data = [];
            $result = [];
            for ($i = 0; $i < 1000000; $i++) {
                $data[] = rand(100000, 1500000);
            }
            foreach (array_count_values($data) as $key => $val) {
                if ($val === 1) {
                    continue;
                }
                $result[] = $key;
            }
            $quest = 'quest' . $post['quest'];
            $this->view->render('/test7winds/' . $quest . '.html', [
                'result' => $result,
                'count' => count($result),
                'resource' => \PHP_Timer::resourceUsage()
            ]);
        }
    }

    private function setTree($quest, $parent = 0, $level = 0)
    {
        foreach ($quest as $key => $item) {
            if ($item[0] == $parent) {
                for ($i = 1; $i <= $level; $i++) {
                    echo '  ';
                }
                if ($level != 0) {
                    echo '->';
                }
                echo $item[1] . '<br>';
                unset($quest[$key]);
                $this->setTree($quest, $key, ++$level);
                --$level;
            }

        }
    }

    private function setTree2($quest, $parent = 0, $level = 0)
    {
        foreach ($quest as $key => $item) {
            if ($key == $parent) {
                if (is_array($item)) {
                    foreach ($item as $key2 => $data) {
                        if (array_key_exists($data[0], $quest)) {
                            for ($i = 1; $i <= $level; $i++) {
                                echo '  ';
                            }
                            if ($key != 0) {
                                echo '->';
                            }
                            echo $data[1] . '<br>';
                            unset($quest[$key][$key2]);
                            $this->setTree2($quest, $data[0], ++$level);
                            --$level;
                        } else {
                            for ($i = 1; $i <= $level; $i++) {
                                echo '  ';
                            }
                            if ($key != 0) {
                                echo '->';
                            }
                            echo $data[1] . '<br>';
                        }
                    }
                    --$level;
                } else {

                }
            }
        }
    }

}