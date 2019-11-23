<?php
// конфиденциальные настройки окружения
require '../../env.php';

// сomposer
require 'vendor/autoload.php';

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
$result = mysqli_query($link, 'SELECT * FROM categories ORDER BY name');
if (! $result) {
    $query_errors[] = 'Нет доступа к списку категорий.';
}
else {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories_list[$row['id']] = $row['name'];
    }
}

// данные для основного шаблона
$user_avatar = isset($_SESSION['user']['img']) ? $_SESSION['user']['img'] : 'img/user.jpg';
$layout_data = [
	'search_text' => '',
    'user_avatar' => $user_avatar,
    'categories_list' => $categories_list,
    'categories' => include_template('categories', [
        'categories_list' => $categories_list
    ]),
    'index_link' => 'href="/" '
];
