<?php

define('PROD', true);

$lang = (isset($_COOKIE['local'])) ? $_COOKIE['local'] : $_COOKIE['local'] = 'ua';

return [
    'db' => [
        'database' => 'it_project',
        'username' => 'root',
        'password' => '',
    ],
    'local' => $lang,
    'modules' => [
        'admin' => [
            /*
             Если controller не установлен, то
                будем искакать деф.контроллер app\modules\admin\WebController
             */
            //'controller' => 'Hello',
            //'action' => 'blaBlaBla',
        ],
    ],
];
