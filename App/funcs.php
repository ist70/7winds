<?php
return [
        'sqrt' => function($data) {
            return sqrt($data);
        },
        'square' => function($data) {
            return $data*$data;
        },
        'coub' => function($data) {
            return pow($data, 3);
        },
];
