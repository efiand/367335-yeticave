<?php
require 'app/common.php';

// запрет для незарегистрированных
if (! isset($_SESSION['user'])) {
    http_response_code(403);
    exit();
}

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
            if (($k == 'lot-rate' || $k == 'lot-step') && ! is_numeric($data[$k])) {
                $error = true;
            }
            else if ($k == 'lot-date') {
                // переводим в метку времени
                $data['lot-date'] = strtotime($data['lot-date']);
                if ($data['lot-date'] - $time < 86400) {
                    $error = true;
                    $add_data['error']['lot-date'] = 'Выберите период больше суток!';
                }
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
        $error_count ++;
        $add_data[$k]['invalid'] = ' form__item--invalid';
        $add_data['error'][$k] = $add_data['error'][$k] ?? $val;
    }
    else {
        $add_data[$k]['invalid'] = '';
        $add_data['error'][$k] = '';
    }
    $add_data[$k]['value'] = $data[$k];
}

// сохранение файла
require 'app/save_img.php';
$add_data['uploaded'] = $uploaded_class;
$add_data['error']['img'] = $file_error;

// обработка ошибок
if ($error_count) {
    $add_data['error_main'] = 'Пожалуйста, исправьте ошибки в форме.';
    $add_data['invalid'] = ' form--invalid';
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
    if (! isset($_POST['lot-name'])) {
        $add_data['invalid'] = '';
        $add_data['error_main'] = '';
    }
    else {
        $result = mysqli_query($link, 'INSERT INTO lots SET name = \''
            . $data['lot-name'] . '\', description = \'' . $data['message']
            . '\', price = ' . $data['lot-rate'] . ', step = ' . floor($data['lot-step'])
            . ', create_ts = ' . $time . ', expire_ts = '. $data['lot-date']
            . ', img = \'' . $_SESSION['url'] . '\', category_id = \''
            . $data['category'] . '\', user_id = ' . $_SESSION['user']['id']);
        if (! $result) {
            $query_errors[] = 'Регистрация невозможна по техническим причинам:' . mysqli_error($link);
        }
        else {
            header('Location: lot.php?id=' . mysqli_insert_id($link));
            unset($_SESSION['url']);
            exit();
        }
    }
}

// получаем HTML-код тела страницы
$add_data['categories_list'] = $categories_list;
$layout_data['content'] = include_template('add', $add_data);

// получаем итоговый HTML-код
$layout_data['title'] = 'Добавление лота';
print(layout($query_errors, $layout_data));
