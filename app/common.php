<?php
error_reporting(E_ALL);

// подключаем библиотеку функций
require 'app/functions.php';

// подключение к БД
require 'app/init.php';

// для работы с подготовленными выражениями
require 'app/mysql_helper.php';

// настройки даты и времени
date_default_timezone_set('Europe/Moscow');
$time = $_SERVER['REQUEST_TIME'];

// прочие настройки
session_start();
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

// данные для основного шаблона
$user_avatar = isset($_SESSION['user']['img']) ? $_SESSION['user']['img'] : 'img/user.jpg';
$layout_data = [
    'user_avatar' => $user_avatar,
    'categories_list' => $categories_list,
    'index_link' => 'href="/" '
];
