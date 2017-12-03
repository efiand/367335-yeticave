<?php
// подключаем библиотеку функций
require 'functions.php';

// подключаем данные
require 'data.php';
$bet_step = 500; // шаг ставки
$price = 0; // текущая цена

// получаем идентификатор лота
$id = $_GET['id'];
if (!$lots_list[$id]) {
    http_response_code(404);
    exit();
}
$bets = json_decode($_COOKIE['bets-' . $id], true) ?? [];
if (isset($_POST['cost'])) {
    $price = $_POST['cost-min'];
    if (is_numeric($_POST['cost']) && $_POST['cost'] > $price) {
        $cost = floor($_POST['cost']);
    }
    else {
        $cost = $price;
    }
    $bets[] = [
        'name' => $name,
        'price' => $cost,
        'ts' => $_SERVER['REQUEST_TIME']
    ];
    setcookie('bets-' . $id, json_encode($bets), $expires);
    setcookie('done-' . $id, 1, $expires);
    header('Location: mylots.php');
    exit();
}

// ставки пользователей
$bets = array_merge($bets, [
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) .' minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) .' hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) .' hour')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
]);
foreach ($bets as $k => $val) {
    if ($val['price'] > $price) {
        $price = $val['price'];
    }
}

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
    'real' => true,
    'empty' => $_COOKIE['done-' . $id] ? false : true
];
$layout_data['title'] = $lots_list[$id]['name'];

// получаем HTML-код тела страницы
$layout_data['content'] = include_template('lot', $lot_data);

// получаем итоговый HTML-код
$layout = include_template('layout', $layout_data);

print ($layout);
