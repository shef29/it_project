<?php

namespace app\site\models;

use app\vendor\mvc\models\Auth;
use app\vendor\mvc\models\Image;
use app\vendor\mvc\models\Lang;
use app\vendor\mvc\models\Validator;

class RegistrationForm
{
    use loadPost;

    public $email;
    public $username;
    public $password;
    public $confirm_password;
    public $photo;

    public $errors;

    public function validate()
    {
        $valid = new Validator(get_object_vars($this));
        $valid->checkInput('email')->string()
            ->required()
            ->email()
            ->unique(User::class, 'email');

        $valid->checkInput('username')->required()->string()->min(3)->max(100);
        $valid->checkInput('password')->required()->string()->min(6)->max(50);
        $valid->checkInput('confirm_password')->required()->string()
            ->compare($this->password);

        $valid->checkInput('photo')->image();

        if (!empty($valid->hasErrors)) {
            $this->errors = $valid->hasErrors;
            return false;
        }

        return true;
    }

    public function registration()
    {
        if (!$this->validate()) return false;
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->password = $user->generatePass($this->password);

        if (!$this->uploadImage()) {
            return false;
        } else {
            $user->photo = $this->photo;
        }

        if (!$user->save(false)) {
            return $this->errors['username'] = Lang::t('Registration failed');
        }
        Auth::loginUser($user);

        return true;
    }

    public function uploadImage()
    {
        $this->photo = '';
        if (!empty($_FILES['photo'])) {
            $img = new Image($_FILES['photo']);
            // Имя для файла
            $this->photo = time() . '.' . $img->getExtension();
            $result = $img->saveImage($this->photo, 'images/avatars/');
            if (!$result) {
                $this->errors['photo'] = $img->error_msg;
                return false;
            }
        }
        return true;
    }
}