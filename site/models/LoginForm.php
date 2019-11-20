<?php

namespace app\site\models;

use app\vendor\mvc\models\Auth;
use app\vendor\mvc\models\Lang;
use app\vendor\mvc\models\Validator;

class LoginForm
{
    use loadPost;

    public $email;
    public $password;

    public $errors;

    public function validate()
    {
        $valid = new Validator(get_object_vars($this));

        $valid->checkInput('email')->required()->email()->string();
        $valid->checkInput('password')->required()->string();

        if (!empty($valid->hasErrors)) {
            $this->errors = $valid->hasErrors;
            return false;
        }
        return true;
    }

    public function login()
    {
        if (!$this->validate()) return false;

        $user = User::find('first', ['email' => $this->email]);
        if ($user == null) {
            $this->errors['email'] = Lang::t('wrong email or password');
            return false;
        } else {
            $this->password = $user->generatePass($this->password);
            if ($this->password !== $user->password) {
                $this->errors['email'] = Lang::t('wrong email or password');
                return false;
            }
            Auth::loginUser($user);

            return true;
        }
    }

}