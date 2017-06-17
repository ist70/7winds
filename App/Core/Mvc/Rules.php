<?php

namespace App\Core\Mvc;

class Rules
{

    public static function filters()
    {
        return [
            'required' => function ($v) {
                return strlen(trim($v)) > 0 ? true : false;
            },
            'trim' => function ($v) {
                trim($v);
                return true;
            },
        ];
    }

}
