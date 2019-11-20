<?php

namespace app\vendor\mvc;

use ActiveRecord\Config;
use app\vendor\mvc\models\Auth;
use app\vendor\route\RouteManager;

/**
 * Class Application - класс служит для запуска приложения.
 * Получает данные от класса app\vendor\route\RouteManager;
 * Проверяет контроллер и методы.
 * Возвращает страницу, если та найдена.
 * @package app\vendor\mvc
 */
class Application
{
    public $controller;
    public $action;

    public function __construct($config = null)
    {
        $auth = new Auth();
        $routes = new RouteManager($config);

        $module = $routes->getModule();
        $this->controller = $this->checkController($routes->getController(), $module);
        $this->action = $this->checkAction($this->controller, $routes->getAction());
        if (!isset($config['db']['password'], $config['db']['username'], $config['db']['database'])) {
            throw new \Exception('Нет подключения для подключения базы данных');
        }

        Config::initialize(function ($cfg) use ($config) {
            //$cfg->set_model_directory('site/models');
            $pass = $config['db']['password'];
            $user = $config['db']['username'];
            $dbName = $config['db']['database'];
            $cfg->set_connections(
                array(
                    'development' => "mysql://{$user}:{$pass}@localhost/{$dbName}",
                )
            );
        });
    }

    /**
     * Веруть контент страницы
     * @return false|string
     */
    public function getContentPage()
    {
        $action = $this->action;
        $newClass = new $this->controller();

        ob_start();
        $newClass->$action();
        return ob_get_clean();
    }

    protected function checkController($controllerClass, $module = null)
    {
        return $this->checkClass($this->buildPathController($controllerClass, $module));
    }

    protected function checkClass($class)
    {
        if (class_exists($class, 1)) {
            return $class;
        } else {
            throw new  \Exception('class : ' . $class . ' not found');
        }
    }

    protected function checkAction($controllerClass, $method)
    {
        if (method_exists($controllerClass, $method)) {
            return $method;
        }
        if (PROD == false) {
            throw new  \Exception('method : ' . $controllerClass . ' method {' . $method . '} not found');
        } else {
            return to_404();
        }
    }

    private function buildPathController($class, $module = null)
    {
        if (isset($module)) {
            return "app\\modules\\$module\\controllers\\" . $class . 'Controller';
        } else {
            return "app\\site\\controllers\\{$class}Controller";
        }
    }

}