<?php

if (!defined('DB_SERVER')) {
    define("DB_SERVER", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DB_NAME", "test-mvc");
}


function database() {
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME );
    return $connection;
}