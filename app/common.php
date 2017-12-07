<?php
// подключаем библиотеку функций
require 'app/functions.php';

// подключение к БД
require 'app/init.php';

// для работы с подготовленными выражениями
require 'app/mysql_helper.php';

// настройки даты и времени
date_default_timezone_set('Europe/Moscow');
$time = $_SERVER['REQUEST_TIME'];
$expires = $time + 60*60*24*30;

// прочие настройки
session_start();
$name = $_SESSION['user']['name'];
$user_id = $_SESSION['user']['id'];
$query_errors = []; // собираем ошибки запросов к БД

// получение списка категорий
$result = mysqli_query($link, 'SELECT * FROM categories');
if (! $result) {
    $query_errors[] = 'Нет доступа к списку категорий.';
}
else {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories_list[$row['id']] = $row['name'];
    }
}

// получение списка лотов
$result = mysqli_query($link, 'SELECT id, name, category_id, price, step, expire_ts, img, user_id FROM lots');
if (! $result) {
    $query_errors[] = 'Нет доступа к списку лотов.';
}
else {
    while ($row = mysqli_fetch_assoc($result)) {
        $lots_list[$row['id']] = $row;
    }
}

$layout_data = [
    'user_avatar' => $_SESSION['user']['img'] ?? 'img/user.jpg',
    'categories_list' => $categories_list,
    'index_link' => 'href="/" '
];
