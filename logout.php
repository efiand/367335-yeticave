<?php
session_start();
$_SESSION = [];
foreach ($_COOKIE as $k => $val) {
    setcookie($k, '', $_SERVER['REQUEST_TIME'] - 3600);
}
header('Location: index.php');
