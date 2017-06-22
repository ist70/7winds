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

    private function quest1()
    {
        $array = ['[NAME:discription]data[/NAME]'];
        $r = preg_match('/\[(\w+):(\w+)\](\w+)\[\/(\w+)\]/i', $array[0], $match);
        $arr1 = [$match[1], $match[3]];
        $arr2 = [$match[1], $match[2]];
        $this->view->render('/test7winds/quest1.html', [
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
    private function quest2()
    {
        $array = ['raz:znachenieRaz bred dva:znachenieDva tri:znachenieTri bredv conce raz:znachenieRazzzz'];
        $r = preg_match_all('/(\w*?)(raz:|dva:|tri:)(\w+)/i', $array[0], $match);
        $result = [];
        $i = 0;
        foreach ($match as $data) {
            $result[$match[2][$i]] = $match[3][$i];
            $i++;
        }
        $this->view->render('/test7winds/quest2.html', [
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
    private function quest3()
    {
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
        $this->view->render('/test7winds/quest3.html', [
            'resource' => \PHP_Timer::resourceUsage()
        ]);
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

    private function quest4()
    {
        $parent = 0;
        $child = 3;
        $result = Quest::findByParentAndChild($parent, $child);
        $this->view->render('/test7winds/quest4.html', [
            'result' => $result,
            'parent' => $parent,
            'child' => $child,
            'count' => count($result),
            'resource' => \PHP_Timer::resourceUsage()
        ]);
    }

    private function quest5()
    {
        $result = Quest::findByParentNotChild();
        $this->view->render('/test7winds/quest5.html', [
            'result' => $result,
            'resource' => \PHP_Timer::resourceUsage()
        ]);
    }

    private function quest6()
    {
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
        $this->view->render('/test7winds/quest6.html', [
            'result' => $result,
            'count' => count($result),
            'resource' => \PHP_Timer::resourceUsage()
        ]);
    }

    private function quest7()
    {
        $data = [['a1', 'a2', 'a3'], ['b1', 'b2'], ['c1', 'c2', 'c3'], ['d1']];
        echo '<pre>';
//            $count = [];
//            $cnt = 1;
//            var_dump($data);
//            foreach ($data as $item) {
//                $count[] = count($item);
//            }
//            for ($i = 0; $i <= count($data) - 1; $i++) {
//                $cnt *= $count[$i];
//            }
//            var_dump($cnt);
//            $data2 = [];
//            $j = 0;
//            foreach ($data as $row) {
//                $i = 0;
//                foreach ($row as $item) {
//                    $data2[$i][$j] = $item;
//                    ++$i;
//                }
//                ++$j;
//            }
//            var_dump($data2);
//            for ($i = 0; $i <= $cnt - 1; $i++) {
//
//            }
        $array_index[] = 0;
        $array_text = [];
        $index = 0;
        while (true)// выполняем бесконечный цикл
        {
            $next = false;// переключение на следующую линию не требуется
            for ($it = 0; $it < count($data); $it++)// проходим по всем блокам и составляем комбинацию
            {
                $cnt = sizeof($data[$it]);// кол-во комбинаций текущего блока
                echo 'cnt = ' . $cnt . '<br>';
                var_dump($array_index);
                echo 'индекс = ' . $index . '<br>';
                var_dump($array_text);
                // если требуется переключить следующий блок
                if ($next) {
                    $array_index[$it]++;
                    $next = false;
                }
                if ($array_index[$it] >= $cnt) {
                    $array_index[$it] = 0;
                    $next = true;
                }
                $array_text[$index] .= $data[$it][$array_index[$it]] . ' ';// добавляем значение из блока
            }
            //$array_text[$index] = trim($array_text[$index]);// убираем на всяк случай пробелы в начале и в конце предложения / фразы / текста
            // если все варианты пройдены, но нужен еще проход по последнему значению / корректировка
            if ($next) {
                break;
            }
            $array_index[0]++;// увеличиваем индекс в первом массиве
            $index++;// увеличиваем индекс общего значения полученных комбинаций
        }
        //array_pop($array_text);// убираем последний блок ибо он повторный получается
        var_dump($array_text);


        die;
        $this->view->render('/test7winds/quest7.html', [
            'result' => $result,
            'resource' => \PHP_Timer::resourceUsage()
        ]);
    }

    public function actionQuests()
    {
        $post = $_POST;
        if (empty($post)) {
            $this->redirect('/winds7/');
        }
        if ($post['quest'] == 1) {
            $this->quest1();
        }
        if ($post['quest'] == 2) {
            $this->quest2();
        }
        if ($post['quest'] == 3) {
            $this->quest3();
        }
        if ($post['quest'] == 4) {
            $this->quest4();
        }

        if ($post['quest'] == 5) {
            $this->quest5();
        }

        if ($post['quest'] == 6) {
            $this->quest6();
        }

        if ($post['quest'] == 7) {
            $this->quest7();
        }
    }

//    private function fill(&$arr, $idx = 0)
//    {
//        $line = [];
//        if ($idx == 0) {
//            $keys = array_keys($arr);
//            $max = count($arr);
//            $results = [];
//        }
//        if ($idx < $max) {
//            $values = $arr[$keys[$idx]];
//            foreach ($values as $value) {
//                array_push($line, $value);
//                $this->fill($arr, $idx + 1);
//                array_pop($line);
//            }
//        } else {
//            $results[] = $line;
//        }
//        if ($idx == 0) {
//            return $results;
//        }
//    }

}