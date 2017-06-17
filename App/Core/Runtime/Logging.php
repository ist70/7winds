<?php

namespace App\Core\Runtime;

use App\Config;
use Exception;

class Logging
{

    /**
     * Метод записывает в файл информацию о возникших во время работы Исключениях
     * @param Exception $e
     * @param string $filename по умолчанию DEFAULT_FILENAME
     */
    public static function toFile(Exception $e, $filename = '')
    {
        $filename = !empty($filename) ? $filename : Config::DEFAULT_FILENAME_LOG;
        $data = date('d-m-Y H:m:s') . '  ' . $e->getFile() . '  в строке: ' .
            $e->getLine() . ' код ошибки:  ' . $e->getCode() . '  ' . $e->getMessage();
        file_put_contents($filename, $data . PHP_EOL, FILE_APPEND);
    }

}
