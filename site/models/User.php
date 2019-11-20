<?php

namespace app\site\models;

use ActiveRecord\Model;

class User extends Model
{

    public static function findOne($id)
    {
        return self::find('first', ['id' => (int)$id]);
    }

    public function generatePass($pass)
    {
        return sha1($pass);
    }
}