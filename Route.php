<?php

namespace app;

class Route
{
    private $_route;
    private $_controller;
    private $_action;
    private $_name_controller;
    private $_file_controller;        // файл, где лежит контроллер
    private $_name_class_controller;

    private $_array_route_parameters = [];
    private $_controller_object;

    public $_array_params = [];
    public $_array_val_params = [];   // для хранения переменных, которые будут передаваться в action
    public $_required_attr_func = [];

    public function __construct()
    {
        $this->_route = trim($_SERVER['REQUEST_URI'], '/');
        if (!empty($this->_route)) $this->_getRoute();      // ищем есть ли контроллер
        else $this->defaultRoute();                         // срабатывает елси это главная страница

        $this->_setInfoController();                        // делаем настройки контроллера
        if ($this->_checkDataController()) {                // проверка на все данные в контроллере
            $this->_checkDataUser();                        // проверка передаваемых данных от пользователя
        }
    }

    public function createObjectController() {
        $this->_controller_object = new $this->_name_class_controller;
    }

    public function getContentPage()                // подключить запрашиваемую страницу
    {
        ob_start();
        if (is_array($this->_array_val_params)) {
            $this->_controller_object->{$this->_action}(...$this->_array_val_params);
        } else $this->_controller_object->{$this->_action}();
        return ob_get_clean();
    }

    private function _getRoute()
    {
        $this->_array_route_parameters = explode('/', $this->_route);
        // если контроллер не обнаружен, то возможно это медод главного контроллера
        if (!file_exists(__DIR__."/controllers/" . ucfirst($this->_array_route_parameters[0]) . 'Controller.php')) {
            require_once __DIR__."./controllers/SiteController.php";
            if (method_exists('\Controllers\SiteController', 'action_' . $this->_array_route_parameters[0])) {
                $this->defaultRoute($this->_array_route_parameters[0]);
                array_shift($this->_array_route_parameters);
            } else {  // если  это параметр метода в главном контроллере
                if ($this->getParamsFunc('\Controllers\SiteController', 'action_index')) {
                    $this->defaultRoute();
                    $this->_setInfoController();
                    $this->_checkDataUser();
                    return true;
                } else redirect(error_page);
            }
        } else {
            $this->_controller = $this->_array_route_parameters[0] . 'Controller';
            $this->_action = !empty($this->_array_route_parameters[1]) ? 'action_' . $this->_array_route_parameters[1] : 'action_index';
            array_shift($this->_array_route_parameters);
            array_shift($this->_array_route_parameters);
        }
    }

    private function _setInfoController()
    {
        $this->_name_controller = ucfirst($this->_controller);
        $this->_file_controller = $this->_name_controller . '.php';
        $this->_name_class_controller = '\Controllers\\' . $this->_name_controller;
    }

    private function _checkDataController()
    {
        $this->_includeController();
        if (class_exists($this->_name_class_controller) && method_exists($this->_name_class_controller, $this->_action)) {
            // ищем название параметров, которые принимает метод в контроллере
            if ($this->getParamsFunc($this->_name_class_controller, $this->_action)) return true;
            else return false;
        } else redirect(error_page);
    }

    private function _includeController()
    {
        if (file_exists(__DIR__."/controllers/" . $this->_file_controller)) {
            require_once __DIR__."/controllers/" . $this->_file_controller;
        } else redirect(error_page);
    }

    protected function getParamsFunc($nameClass, $nameFunc)  // узнать какие параметры может принимать метод
    {
        $ref_function = new \ReflectionMethod($nameClass, $nameFunc);
        $count = count($this->_array_route_parameters);
        $count_params = $ref_function->getNumberOfParameters();
        if ($count_params == 0 and $count > 0) redirect(error_page);
        if ($count_params > 0) {
            foreach ($ref_function->getParameters() as $param => $v) {
                $this->_array_params[$param] = $v->getName();
                if(!$v->isOptional()) $this->_required_attr_func[$v->getName()] = $v->getName();
            }
            return true;
        } return;
    }

    private function defaultRoute($action = '')
    {
        $this->_controller = 'SiteController';
        $this->_action = (!empty($action)) ? 'action_' . $action : 'action_index';
    }

    private function _checkDataUser()
    {
        $newArr = [];
        $count = count($this->_array_route_parameters);
        if ($count % 2 != 0) redirect(error_page);  // если массив непарный, значит к какому-то ключу нет пары

        for ($i = 0; $i < $count; $i += 2) {
            $newArr[$this->_array_route_parameters[$i]] = $this->_array_route_parameters[$i + 1];
            $this->_array_val_params[] = $this->_array_route_parameters[$i + 1];
        }

        $this->_checkRequiredAttr($newArr);
        $this->_checkAttrFromUser($newArr);
        return true;
    }

    private function _checkRequiredAttr($Arr){ // проверка на обязательные аргументы в методе
        foreach ($this->_required_attr_func as $k => $v) {
            //if (!key_exists($k, $Arr)) redirect(error_page);
            if (!key_exists($k, $Arr)) die('Не было передано ни одного обязательного агрумента.');
        }
    }

    // проверяем массив  пользователя на соответствие ключей массива метода
    private function _checkAttrFromUser($Arr){
        $array_flip = array_flip($this->_array_params);
        foreach ($Arr as $k => $v) { // если ключи не совпадают, тогда пользователь мутит
            if (!key_exists($k, $array_flip)) redirect(error_page);
        }
    }

}