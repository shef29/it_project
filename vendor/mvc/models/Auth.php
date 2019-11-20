<?php

namespace app\vendor\mvc\models;


class Auth
{
    function __construct()
    {
        $this->checkLogin();
    }

    public static function isGuest()
    {
        if (!isset($_SESSION['id'])) {
            return true;
        }
        return false;
    }

    /**
     * Вернуть id авторизованного пользователя
     */
    public static function id()
    {
        if (self::isGuest()) return false;
        return $_SESSION['id'];
    }

    public static function loginUser($user)
    {
        $_SESSION['id'] = $user->id;
        unset($user->password);
        $_SESSION['user'] = $user;
    }

    public static function logout()
    {
        unset($_SESSION['id'], $_SESSION['user']);
        session_destroy();
    }

    private function checkLogin()
    {
        if (isset($_SESSION['id'])) {
            $this->user_id = $_SESSION['id'];
        } else {
            unset($_SESSION['id']);
        }
    }

}