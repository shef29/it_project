<?php

function encode($value)
{
    $value = trim(stripslashes($value));
    return htmlspecialchars($value);

}

function redirect($url)
{
    header("location: $url");
    exit();
}

function createRoute($url = '')
{
    if (empty($url)) {
        return $_SERVER['DOCUMENT_ROOT'] . '/';
    }
    return $_SERVER['DOCUMENT_ROOT'] . '/' . trim($url, '/');
}

function toSiteViews($url = '')
{
    return $_SERVER['DOCUMENT_ROOT'] . '/site/views/' . trim($url, '/');
}

function toUrl($url = '')
{
    return "http://" . $_SERVER['SERVER_NAME'] . '/' . $url;
}


function goHome()
{
    return redirect(toUrl());
}

function toLogin()
{
    redirect(toUrl('web/login'));
}

function to_404()
{
    redirect(toUrl('web/error'));
}

function goBack()
{
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}