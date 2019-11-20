<?php

namespace app\vendor\mvc\controllers;

class MainController
{
    public $hasErrors;

    public function render($url, $attributes = [])
    {
        global $has_error;
        $this->hasErrors = $has_error;

        $directory = substr(str_replace(['controllers\\', 'controller'], '', mb_strtolower(get_class($this))), 4);
        if (!empty($directory)) {
            $path = explode('\\', $directory);
            $mainDir = $path[0];
            $controllerDir = $path[1];
            $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $mainDir . '/views/' . $controllerDir . '/' . $url . '.php';
            try {

                if (!file_exists($fullPath)) {
                    throw new  \Exception("File $fullPath не найден");
                }
                extract($attributes);
                return include "$fullPath";
            } catch (\Exception $e) {
                echo $e->getMessage();
                die;
            }
        } else redirect(error_page);
    }

}

?>