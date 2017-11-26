<?php
// подключаем библиотеку функций
require 'functions.php';

// подключаем данные
require 'data.php';
require 'userdata.php';
$layout_data['title'] = 'Вход';


// обработка формы
$mail = strip_tags(trim($_POST['e-mail']));
$pass = $_POST['password'];
$login_data = [
    'e-mail' => [
        'value' => $mail,
        'error' => '',
        'invalid' => ''
    ],
    'password' => [
        'error' => '',
        'invalid' => ''
    ],
    'categories_list' => $categories_list
];
$pass_hash = '';
if ($mail) {
    foreach ($users as $k => $val) {
        if ($val['email'] == $mail) {
            $pass_hash = $val['password'];
            $name = $val['name'];
            break;
        }
    }
    if ($pass_hash) {
        if (!$pass) {
            $login_data['password']['error'] = 'Вы не ввели пароль';
        }
        else if (!password_verify($pass, $pass_hash)) {
            $login_data['password']['error'] = 'Вы ввели неверный пароль';
        }
        else {
            $_SESSION['name'] = $name;
        }
    }
    else {
        $login_data['e-mail']['error'] = 'Вы ввели неверный e-mail';
    }
}
else {
    $login_data['e-mail']['error'] = 'Вы не ввели e-mail';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($login_data['e-mail']['error']) {
        $login_data['e-mail']['invalid'] = ' form__item--invalid';
        $error = true;
    }
    if ($login_data['password']['error']) {
        $login_data['password']['invalid'] = ' form__item--invalid';
        $error = true;
    }
    if ($error) {
        $login_data['invalid'] = ' form--invalid';
        $login_data['error'] = 'Пожалуйста, исправьте ошибки в форме.';
        $layout_data['title'] = 'Ошибка авторизации';
        $_POST = [];
    }
    else {
        header('Location: index.php');
        exit();
    }
}


// получаем HTML-код тела страницы
$layout_data['content'] = include_template('login', $login_data);

// получаем итоговый HTML-код
$layout = include_template('layout', $layout_data);

print ($layout);
