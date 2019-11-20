<?php

namespace app\vendor\route;

/**
 * Class RouteManager - класс получает Uri и разбивает его на модуль, контроллер и action,
 *  чтобы все данные в итоге мог получить  app\vendor\mvc\Application;
 * @package app\vendor\route
 */
class RouteManager
{
    public $action;
    public $route;
    public $controller;
    public $module = null;
    public $modules = [];
    public $fileController;

    public $defaultController = 'web';
    public $defaultAction = 'index';

    public $requestUri;

    public function __construct($config = [])
    {
        if (!empty($config) and isset($config['modules'])) {
            $this->modules = $config['modules'];
        }
        $this->setRoutes();
        $this->setRequestUri();
    }

    public function setRoutes()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            $requestUri = $_SERVER['REQUEST_URI'];
            if ($requestUri !== '' && $requestUri !== '/') {
                // Удалить get из строки
                if (($pos = strpos($requestUri, "?")) > 0) {
                    $requestUri = substr($requestUri, 0, $pos);
                }
                $this->requestUri = preg_replace('/[^a-z\-\/]/i', '', $requestUri);
                $this->parseUrlAndSetRoutes();
            } else {
                $this->setDefaultRoutes();
            }
        } else {
            $this->setDefaultRoutes();
        }
    }

    /**
     * Получтить Uri. Разбрать ее по бекслешам. Найти в массиве модуль
     * Если первый элемент массива {$params} не модуль, то это контроллер
     */
    protected function parseUrlAndSetRoutes()
    {
        $params = explode('/', trim($this->requestUri, '/'));

        if ($this->isModule($params[0])) {
            $this->module = $params[0];
            $this->setModuleControllerAndAction($params);
        } else {
            $this->controller = $params[0];
            $this->action = (isset($params[1])) ? $params[1] : $this->defaultAction;
        }
    }

    public function setDefaultRoutes()
    {
        $this->controller = $this->defaultController;
        $this->action = $this->defaultAction;
    }

    public function setRequestUri()
    {
        $this->requestUri = '/' . strtolower($this->controller) . '/' . strtolower($this->action);
    }

    protected function setModuleControllerAndAction($params = [])
    {
        if (isset($params[1])) {
            $this->controller = $params[1];
            $this->setModuleAction($params);
        } else {
            $this->setConfigModuleController();
            $this->setConfigModuleAction();
        }
    }

    protected function setConfigModuleController()
    {
        if (isset($this->modules[$this->module]['controller'])) {
            $this->controller = $this->modules[$this->module]['controller'];
        } else {
            $this->controller = $this->defaultController;
        }
    }

    protected function setModuleAction($params)
    {
        if (isset($params[2])) {
            $this->action = $params[2];
        } else {
            $this->setConfigModuleAction();
        }
    }

    protected function setConfigModuleAction()
    {
        if (isset($this->modules[$this->module]['action'])) {
            $this->action = $this->modules[$this->module]['action'];
        } else {
            $this->action = $this->defaultAction;
        }
    }

    public function getRequestUri()
    {
        return $this->requestUri;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->toCamelCase($this->controller, 1);
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->toCamelCase($this->action);
    }

    /**
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }

    public function toCamelCase($string, $withFirstSymbol = false)
    {
        $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));

        if (!$withFirstSymbol) {
            $str = lcfirst($str);
        }

        return $str;
    }

    protected function isModule($string)
    {
        if (key_exists($string, $this->modules)) {
            return true;
        }
        return false;
    }
}