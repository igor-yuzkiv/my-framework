<?php

namespace core;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class Error {

    /***
     * @param $error_text
     * @param string $log_name
     * @param string $typ_error
     * @param bool $show_error
     * @throws \Exception
     */
    public static function ShowError ($error_text, $log_name = "", $typ_error = "warning", $show_error = true)
    {
        if (_DEBUG == false) exit();
        if ($show_error) echo $show_error;

        if ($log_name !== "") {
            $log = new Logger($log_name);
            $log->pushHandler(new StreamHandler("storage/log/$log_name.log"));
            $log->{$typ_error}($error_text);
        }
    }

    /***
     * @param $error_text
     * @param $log_name
     * @param string $typ_error
     * @throws \Exception
     */
    public static function writeLog($error_text, $log_name, $typ_error = "warning") {

        $log = new Logger($log_name);
        $log->pushHandler(new StreamHandler("storage/log/$log_name.log"));
        $log->{$typ_error}($error_text);

    }

}
