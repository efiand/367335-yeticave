<?php
// подключаем библиотеку функций
require 'functions.php';


// запрет для незарегистрированных
if (!isset($_SESSION['name'])) {
    http_response_code(403);
    exit();
}

// подключаем данные
require 'data.php';
$layout_data['title'] = 'Добавление лота';


// обработка формы
$fields = [
    'lot-name' => 'Введите наименование лота',
    'category' => 'Выберите категорию',
    'message' => 'Напишите описание лота',
    'lot-rate' => 'Введите начальную цену',
    'lot-step' => 'Введите шаг ставки',
    'lot-date' => 'Введите дату завершения торгов'
];
$error_count = 0;
foreach ($fields as $k => $val) {
    if (isset($_POST[$k])) {
        $data[$k] = strip_tags(trim($_POST[$k]));
        if ($data[$k]) {
            if (($k == 'lot-rate' || $k == 'lot-step') && !is_numeric($data[$k])) {
                $error = true;
            }
            else {
                $error = false;
            }
        }
        else {
            $error = true;
        }
    }
    else {
        $error = false;
    }
    if ($error) {
        $error_count++;
        $add_data[$k]['invalid'] = ' form__item--invalid';
        $add_data[$k]['error'] = $val;
    }
    else {
        $add_data[$k]['invalid'] = '';
        $add_data[$k]['error'] = '';
    }
    $add_data[$k]['value'] = $data[$k];
}

// Сохранение файла
$id = count($lots_list) + 1;
$add_data['filename'] = 'img/lot-' . $id . '.jpg';
if (is_uploaded_file($_FILES['file']['tmp_name'])) {
    $add_data['uploaded'] = ' form__item--uploaded';
    copy($_FILES['file']['tmp_name'], $add_data['filename']);
}
else {
    $add_data['uploaded'] = '';
}

if ($error_count) {
    $add_data['invalid'] = ' form--invalid';
    $add_data['error'] = 'Пожалуйста, исправьте ошибки в форме.';
    foreach ($categories_list as $k => $val) {
        if ($data['category'] == $k) {
            $add_data[$k . '-sel'] = ' selected';
        }
        else {
            $add_data[$k . '-sel'] = '';
        }
    }
    $layout_data['title'] = 'Есть ошибки';
}
else {
    if (!isset($_POST['lot-name'])) {
        $add_data['invalid'] = '';
        $add_data['error'] = '';
    }
}

// получаем HTML-код тела страницы
if (isset($_POST['lot-name']) && !$add_data['error']) {
    $lot_data = [
        'id' => $id,
        'categories_list' => $categories_list,
        'lots_list' => [
            $id => [
                'name' => $add_data['lot-name']['value'],
                'category' => $add_data['category']['value'],
                'picture' => $add_data['filename'],
                'description' => $add_data['message']['value']
            ]
        ],
        'price' => $add_data['lot-rate']['value'],
        'expire' => strtotime($add_data['lot-date']['value']),
        'bet_min' => $add_data['lot-rate']['value'] + $add_data['lot-step']['value'],
        'real' => false,
        'empty' => false
    ];
    $layout_data['content'] = include_template('lot', $lot_data);
}
else {
    $layout_data['content'] = include_template('add', $add_data);
}

// получаем итоговый HTML-код
$layout = include_template('layout', $layout_data);

print ($layout);
