<?php
// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

// подключаем данные лотов
require 'data_lots.php';

// общие данные сайта
$layout_data = [
    'title' => 'Главная',
    'user_name' => 'Константин',
    'user_avatar' => 'img/user.jpg',
    'categories_list' => $categories_list,
    'is_auth' => (bool) rand(0, 1),
    'index_link' => 'href="/" '
];

// данные главной страницы
$index_data = [
    'categories_list' => $categories_list,
    // список объявлений (вынесли в отдельный файл в module4-task1)
    'announcements_list' => $lots_list
];
