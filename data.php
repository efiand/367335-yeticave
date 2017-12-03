<?php
// настройки даты и времени
date_default_timezone_set('Europe/Moscow');
$time = $_SERVER['REQUEST_TIME'];
$expires = $time + 60*60*24*30;

$name = $_SESSION['name'];

// подключаем данные лотов
require 'data_lots.php';

// общие данные сайта
$layout_data = [
    'title' => 'Главная',
    'user_avatar' => 'img/user.jpg',
    'categories_list' => $categories_list,
    'index_link' => 'href="/" '
];

// данные главной страницы
$index_data = [
    'categories_list' => $categories_list,
    // список объявлений (вынесли в отдельный файл в module4-task1)
    'announcements_list' => $lots_list
];
