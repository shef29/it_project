<?php

namespace app\vendor\mvc\models;

class Image
{
    public $width;
    public $height;
    public $max_width = 320;
    public $max_height = 240;
    public $file;           // приходит от пользователя
    public $size_file;      // приходит от пользователя
    public $new_image;
    public $type_image;
    public $error_msg;

    public $new_name_img;
    public $filename;   // оригинальное имя файла
    public $extension;
    public $_number_type_image;
    public $_types_images = array("", "gif", "jpeg", "jpg", "png"); // Массив с типами изображений ;

    public function __construct($file)
    {
        $this->file = $file['tmp_name'];
        $this->filename = $file['name'];
        $this->size_file = $file['size'];
        $this->setExtension();
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function setExtension()
    {
        $this->extension = pathinfo($this->filename, PATHINFO_EXTENSION);
    }

    public function getNameFile()
    {
        return $this->new_name_img;
    }

    public function saveImage($name = '', $dir = '')
    {
        if (move_uploaded_file($this->file, $dir . $name)) {
            return true;
        }
        return false;
    }

    public function resizeImage($directory = '')
    {
        if (!empty($directory) && !file_exists($directory)) {
            die("Директории с именем '$directory' не существует");
        }
        if ($this->width < 0 || $this->height < 0) {
            $this->error_msg = 'Ваше фото так себе). Попробуйте загрузить другое.';
            return false;
        }
        if ($this->width > $this->height && $this->width > $this->max_width) {
            // если ширина больше высоты и ширина больше чем 320, тогда масштабируем по ширине
            $this->resize($directory, $this->max_width);
            return true;
        } elseif ($this->height > $this->width && $this->height > $this->max_height) {
            if ($this->resize($directory, false, $this->max_height)) return true;
            else return false;
        } elseif ($this->height == $this->width && $this->height > $this->max_height && $this->width > $this->max_width) {
            // фото квадратное, масштабируем по высоте
            if ($this->resize($directory, false, $this->max_height)) return true;
            else return false;
        } else { // сохранить фото без изменений
            if ($this->saveImage($directory)) return true;
        }
    }

    public function checkImage()
    {
        if ($this->_issetFile() && $this->getDataImage() && $this->getTypeImage() && $this->getCheckSizeImage()) {
            return true;
        } else return false;
    }

    public function _issetFile()
    {
        if (empty($this->file)) {
            $this->error_msg = Lang::t('Not selected image');
            return false;
        }
        return true;
    }

    public function getDataImage()
    {
        list($this->width, $this->height, $this->_number_type_image) = getimagesize($this->file);
        return true;
    }

    public function getTypeImage()
    {
        $this->type_image = $this->_types_images[$this->_number_type_image];
        if (!empty($this->type_image)) return true;
        $this->error_msg = Lang::t('Wrong file expansion') . '.jpg, .png, .gif';
        return false;
    }

    public function getCheckSizeImage()
    {
        if ($this->size_file > 2048000) {
            $this->error_msg = 'Файл слишком большой. Должен быть меньше 2 Mb.';
            return false;
        }
        return true;
    }

    public function resize($directory = '', $new_width = false, $new_height = false)
    {
        if (!$new_height) $new_height = $new_width / ($this->width / $this->height);
        if (!$new_width) $new_width = $new_height / ($this->height / $this->width);

        $img_create_color = imagecreatetruecolor($new_width, $new_height);

        imagecopyresampled($img_create_color, $this->new_image, 0, 0, 0, 0, $new_width, $new_height, $this->width, $this->height);
        $function = 'image' . $this->type_image;  // Получаем функцию для сохранения результата
        return $function($img_create_color, $directory . $this->getNameFile());
    }

    public function NewNameImg($par = '', $length = 5)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $name = '';
        for ($i = 0; $i < $length; $i++) {
            $name .= $characters[rand(0, $charactersLength - 1)];
        }
        return $this->new_name_img = $name . '_' . $par . '.' . $this->type_image;
    }

}