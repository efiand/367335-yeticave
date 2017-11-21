<?php
// подключаем библиотеку функций
require 'functions.php';

// подключаем данные
require 'data.php';

// получаем идентификатор лота
$id = $_GET['id'];
if (!$lots_list[$id]) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    exit;
}


// ставки пользователей
$bets = [
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) .' minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) .' hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) .' hour')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
];
$price = 11500; // текущая цена
$bet_step = 500; // шаг ставки

// настройки скрипта
$lot_data = [
    'id' => $id,
    'categories_list' => $categories_list,
    'lots_list' => $lots_list,
    'bets' => $bets,
    'price' => $price,
    'expire' => strtotime('tomorrow midnight'),
    'bet_min' => $price + $bet_step,
    'img' => true,
    'real' => true
];
$layout_data['title'] = $lots_list[$id]['name'];


// получаем HTML-код тела страницы
$layout_data['content'] = include_template('lot', $lot_data);

// получаем итоговый HTML-код
$layout = include_template('layout', $layout_data);

print ($layout);
