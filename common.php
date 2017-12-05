<?php
// подключаем библиотеку функций
require 'functions.php';

// подключение к БД
require 'init.php';

// для работы с подготовленными выражениями
require 'mysql_helper.php';

// настройки даты и времени
date_default_timezone_set('Europe/Moscow');
$time = $_SERVER['REQUEST_TIME'];
$expires = $time + 60*60*24*30;

// прочие настройки
session_start();
$name = $_SESSION['name'];
$query_errors = []; // собираем ошибки запросов к БД

// получение списка категорий
$result = mysqli_query($link, 'SELECT * FROM categories');
if (!$result) {
    $query_errors[] = 'Отсутствуют категории.';
}
else {
    while ($row = mysqli_fetch_array($result)) {
        $categories_list[$row['id']] = $row['name'];
    }
}

// получение списка лотов
$result = mysqli_query($link, 'SELECT id, name, category_id, price, img FROM lots');
if (!$result) {
    $query_errors[] = 'Отсутствуют лоты.';
}
else {
    while ($row = mysqli_fetch_array($result)) {
        $lots_list[$row['id']] = $row;
    }
}

$layout_data = [
    'user_avatar' => 'img/user.jpg',
    'categories_list' => $categories_list,
    'index_link' => 'href="/" '
];
