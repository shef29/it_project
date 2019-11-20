<?php
session_start();
require(__DIR__ . '/../config/functions.php');
require_once __DIR__ . "/../vendor/autoload.php";
$config = require(__DIR__ . '/../config/config.php');

$app = (new \app\vendor\mvc\Application($config));
$content = $app->getContentPage();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
</head>
<body>
<div>bla</div>
<?= $content ?>

<!--===============================================================================================-->

<script src="/vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="/vendor/bootstrap/js/popper.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/js/jquery.validate.js"></script>
<script src="/js/loc/<?= $_COOKIE['local'] ?>.js"></script>
<script src="/js/main.js"></script>
<script src="/js/validate.js"></script>

</body>
</html>