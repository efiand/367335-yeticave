<?php
require 'app/common.php';

// обработка формы
$fields = [
    'e-mail' => 'Введите e-mail',
    'password' => 'Введите пароль',
    'name' => 'Введите имя',
    'message' => 'Напишите, как с вами связаться'
];
$error_count = 0;
foreach ($fields as $k => $val) {
    if (isset($_POST[$k])) {
        $data[$k] = strip_tags(trim($_POST[$k]));
        if ($data[$k]) {
            if ($k == 'e-mail') {
                $mail = filter_var($data[$k], FILTER_VALIDATE_EMAIL);
                if ($mail) {
                    $result = mysqli_query($link, 'SELECT id FROM users WHERE email = \'' . $mail . '\'');
                    if (! $result) {
                        $query_errors[] = 'Нет доступа к базе пользователей.';
                    }
                    else if (mysqli_num_rows($result)) {
                        $signup_data['error']['e-mail'] = 'Данный e-mail занят';
                        $error = true;
                    }
                }
                else {
                    $signup_data['error']['e-mail'] = 'Вы ввели некорректный e-mail';
                    $error = true;
                }
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
        $signup_data[$k]['invalid'] = ' form__item--invalid';
        if (! isset($signup_data['error'][$k])) {
            $signup_data['error'][$k] = $val;
        }
    }
    else {
        $signup_data[$k]['invalid'] = '';
        $signup_data['error'][$k] = '';
    }
    $signup_data[$k]['value'] = $data[$k];
    unset($error);
}

// сохранение файла
require 'app/save_img.php';
$signup_data['uploaded'] = $uploaded_class;

// обработка ошибок
if ($error_count) {
    $signup_data['error_main'] = 'Пожалуйста, исправьте ошибки в форме.';
    $signup_data['invalid'] = ' form--invalid';
    $layout_data['title'] = 'Есть ошибки';
}
else {
    if (! isset($_POST['e-mail'])) {
        $signup_data['invalid'] = '';
        $signup_data['error_main'] = '';
    }
    else {
        $result = mysqli_query($link, 'INSERT INTO users SET name = \'' . $data['name']
        . '\', email = \'' . $mail . '\', password_hash = \''
        . password_hash($data['password'], PASSWORD_DEFAULT)
        . '\', contacts = \'' . $data['message'] . '\', registration_ts = '
        . $time . ', img = \'' . $_SESSION['url'] . '\'');
        if (! $result) {
            $query_errors[] = 'Регистрация невозможна по техническим причинам.';
        }
        else {
            header('Location: login.php');
            unset($_SESSION['url']);
            exit();
        }
    }
}

// получаем HTML-код тела страницы
$signup_data['categories_list'] = $categories_list;
$layout_data['content'] = include_template('sign-up', $signup_data);

// получаем итоговый HTML-код
$layout_data['title'] = 'Добавление лота';
print(layout($query_errors, $layout_data));
