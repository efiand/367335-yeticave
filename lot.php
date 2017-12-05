<?php
require 'common.php';

$bet_step = 500; // шаг ставки
$price = 0; // текущая цена

// получаем идентификатор лота
$id = $_GET['id'];
if (!$lots_list[$id]) {
    http_response_code(404);
    exit();
}

// получаем описание лота
$result = mysqli_query($link, 'SELECT description, price FROM lots WHERE id = ' . $id);
if (!$result) {
    $query_errors[] = 'Отсутствует описание лота.';
}
else {
    $lots_list[$id] = array_merge($lots_list[$id], mysqli_fetch_array($result));
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

// максимальная цена
foreach ($bets as $k => $val) {
    if ($val['price'] > $price) {
        $price = $val['price'];
    }
}

// получаем HTML-код тела страницы
$layout_data['content'] = include_template('lot', [
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
]);

// получаем итоговый HTML-код
$layout_data['title'] = $lots_list[$id]['name'];
print(layout($query_errors, $layout_data));
