<?php

namespace app\vendor\mvc\models;


class Config
{
    public static function getLocal()
    {
        return $_COOKIE['local'];
    }

    public static function setLocal($local)
    {
        setcookie('local', $local);
    }

}