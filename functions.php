<?php
/*
    Мини функции для дебага
 */

function p($arr, $stop = false)
{
    if (!empty($arr)) {
        print_r('<pre>' . print_r($arr, true) . '</pre>') ;
        if ($stop) die;
    } else {
        e('Пусто.');
    }
}

function emp()
{
    e('empty');
}

function g($msg = '', $n = false)
{
    e('good ' . $msg, $n);
}

function f($msg = '', $n = false)
{
    e('false ' . $msg, $n);
}

function non()
{
    e('non empty');
}

function br($n = 1)
{
    for ($i = 0; $i < $n; $i++) echo '<br>';
}

function e($str, $sn = false, $hr = false)
{
    echo $str;
    if (!$sn) br();
    else echo "\n";
    if ($hr) hr();
}

function is_if($m = '')
{
    e('is_if ' . $m);
}

function is_else($m = '')
{
    e('is_else ' . $m);
}

function hr($n = false)
{
    e("--------------- \n", $n);
}

function memory()
{
    $size = memory_get_usage();
    $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
    $mem = @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    e($mem);
}

?>