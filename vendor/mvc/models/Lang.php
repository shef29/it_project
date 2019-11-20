<?php

namespace app\vendor\mvc\models;


class Lang
{
    public static function t($k, $file = 'app')
    {
        $local = $_COOKIE['local'];
        $path = createRoute('/lang/' . $local . '/' . $file . '.php');

        $app = include "$path";
        if (isset($app[$k])) {
            return $app[$k];
        }

        return $k;
    }
}