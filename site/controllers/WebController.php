<?php

namespace app\site\controllers;

use app\site\models\LoginForm;
use app\site\models\RegistrationForm;
use app\site\models\User;
use app\vendor\mvc\controllers\MainController;
use app\vendor\mvc\models\Auth;
use app\vendor\mvc\models\Config;
use app\vendor\mvc\models\Lang;

class WebController extends MainController
{
    public function index()
    {
        if (Auth::isGuest()) {
            return toLogin();
        }
        $user = User::findOne(Auth::id());

        return $this->render('index', ['user' => $user]);
    }

    public function login()
    {
        if (!Auth::isGuest()) {
            goHome();
        }
        $model = new LoginForm;
        if (isset($_POST['send']) and $model->postAttributes() && $model->login()) {
            goHome();
        }

        return $this->render('login', ['model' => $model]);
    }

    public function registration()
    {
        if (!Auth::isGuest()) {
            goHome();
        }
        $model = new RegistrationForm();
        if (isset($_POST['send']) and $model->postAttributes() && $model->registration()) {
//        if (isset($_POST['send'])) {
            goHome();
        }

        return $this->render('registration', ['model' => $model]);
    }

    public function logout()
    {
        if (Auth::isGuest()) {
            return toLogin();
        }
        Auth::logout();
        return toLogin();
    }

    public function error()
    {
        return $this->render('404');
    }

    /**
     * Изменить язык
     */
    public function lang()
    {
        if (!isset($_GET['lang'])) {
            return goBack();
        }
        if (in_array($_GET['lang'], ['ua', 'ru'])) {
            Config::setLocal($_GET['lang']);
        }
        return goBack();
    }
}