<?php
// подключаем библиотеку функций
require 'functions.php';

// подключаем данные
require 'data.php';
$layout_data['title'] = 'Добавление лота';
$fields = [
    'lot-name' => 'Введите наименование лота',
    'category' => 'Выберите категорию',
    'message' => 'Напишите описание лота',
    'lot-rate' => 'Введите начальную цену',
    'lot-step' => 'Введите шаг ставки',
    'lot-date' => 'Введите дату завершения торгов'

];


// обработка формы
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
$filename = 'img/lot-' . $id . '.jpg';
if (is_uploaded_file($_FILES['file']['tmp_name'])) {
    $add_data['uploaded'] = ' form__item--uploaded';
    copy($_FILES['file']['tmp_name'], $filename);
}
else {
    $add_data['uploaded'] = '';
}

if ($error_count) {
    $add_data['invalid'] = ' form--invalid';
    $add_data['error'] = 'Пожалуйста, исправьте ошибки в форме.';
    $layout_data['title'] = 'Есть ошибки';
    foreach ($categories_list as $k => $val) {
        if ($data['category'] == $k) {
            $add_data[$k . '-sel'] = ' selected';
        }
        else {
            $add_data[$k . '-sel'] = '';
        }
    }
}
else {
    if (isset($_POST['lot-name'])) {
        $lot_data = [
            'id' => $id,
            'categories_list' => $categories_list,
            'lots_list' => [
                $id => [
                    'name' => $data['lot-name'],
                    'category' => $data['category'],
                    'picture' => $filename,
                    'description' => $data['message']
                ]
            ],
            'price' => $data['lot-rate'],
            'expire' => strtotime($data['lot-date']),
            'bet_min' => $data['lot-rate'] + $data['lot-step'],
            'real' => false
        ];
        if (file_exists($filename)) {
            $lot_data['img'] = true;
        }
        else {
            $lot_data['img'] = false;
        }
    }
    else {
        $add_data['invalid'] = '';
        $add_data['error'] = '';
    }
}
unset($_POST);

// получаем HTML-код тела страницы
if (isset($lot_data)) {
    $layout_data['content'] = include_template('lot', $lot_data);
}
else {
    $layout_data['content'] = include_template('add', $add_data);
}

// получаем итоговый HTML-код
$layout = include_template('layout', $layout_data);

print ($layout);
