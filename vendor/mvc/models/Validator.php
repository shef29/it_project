<?php

namespace app\vendor\mvc\models;

class Validator
{
    public $returnValue = [];
    public $hasErrors = [];

    private $attr;
    private $_object;

    public function __construct($object)
    {
        $this->_object = $object;
    }

    public function checkInput($attr)
    {
        if (!array_key_exists($attr, $this->_object)) die('Поля с именем "' . $attr . '" не существует.');
        $this->attr = $attr;
        return $this;
    }

    public function required()
    {
        if (!isset($this->hasErrors[$this->attr])) {
            if (empty($this->getValThisAttr())) {
                $this->setError(Lang::t('required'));
            }
        }
        return $this;
    }

    public function string()
    {
        if (!isset($this->hasErrors[$this->attr])) {
            if (!is_string($this->getValThisAttr())) {
                $this->setError(Lang::t('string'));
            }
        }
        return $this;
    }

    public function integer()
    {
        if (!isset($this->hasErrors[$this->attr])) {
            if (!preg_match("/^[0-9]+$/", $this->getValThisAttr())) $this->setError(Lang::t('integer'));
        }
        return $this;
    }

    public function email()
    {
        if (!isset($this->hasErrors[$this->attr])) {
            $pattern = "/[a-z0-9][a-z0-9\._-]*[a-z0-9]@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)[a-z]+/i";
            if (!preg_match($pattern, $this->getValThisAttr())) {
                $this->setError(Lang::t('is_email'));
            }
        }
        return $this;
    }

    public function max($max = 255)
    {
        if (!isset($this->hasErrors[$this->attr])) {
            if (strlen($this->getValThisAttr()) > $max)
                $this->hasErrors[$this->attr] = Lang::t('max') . $max;
        }
        return $this;
    }

    public function min($min = 0)
    {
        if (!isset($this->hasErrors[$this->attr])) {
            if (strlen($this->getValThisAttr()) < $min)
                $this->hasErrors[$this->attr] = Lang::t('min') . $min;
        }
        return $this;
    }

    public function boolean()
    {
        if (!isset($this->hasErrors[$this->attr])) {
            if (!is_bool($this->getValThisAttr()))
                $this->hasErrors[$this->attr] = Lang::t('Wrong value');
        }
        return $this;
    }

    public function compare($secondValue, $msg = '')
    {
        if (!isset($this->hasErrors[$this->attr])) {
            if ($this->getValThisAttr() !== $secondValue) {
                $this->hasErrors[$this->attr] = (!empty($msg)) ? $msg : Lang::t('passwords do not match');
            }
        }
        return $this;
    }

    /**
     * Проверить на уникальность поле
     * @param $class - класс для проверки
     * @param $col - колонка(поле), например : User::find('first', ['email' => $this->attr])
     * @param string $msg
     * @return $this
     */
    public function unique($class, $col, $msg = '')
    {
        if (!isset($this->hasErrors[$this->attr])) {
            $record = $class::find('first', [$col => $this->getValue($this->attr)]);
            if ($record !== null) {
                $this->hasErrors[$this->attr] = (!empty($msg)) ? $msg : Lang::t('This value is already taken up');
            }
        }

        return $this;
    }

    public function file($ex = [])
    {
        if (!isset($this->hasErrors[$this->attr])) {
            p($_FILES);
        }
        return $this;
    }

    public function image()
    {
        if (!isset($this->hasErrors[$this->attr])) {
            if (!empty($_FILES[$this->attr]['name'])) {
                $img = new Image($_FILES[$this->attr]);
                if (!$img->checkImage()) {
                    $this->hasErrors[$this->attr] = $img->error_msg;
                }
            }
        }
        return $this;
    }

    protected function setError($my_error = '')
    {
        $this->hasErrors[$this->attr] = $my_error;
    }

    private function getValThisAttr()
    {
        return $this->getValue($this->attr);
    }

    private function getValue($attr)
    {
        return trim($this->_object[$attr]);
    }

}