<?php
require 'app/common.php';

$layout_data['title'] = 'Вход';
$login_data = [
    'e-mail' => [
        'value' => $mail,
        'invalid' => ''
    ],
    'password' => [
        'invalid' => ''
    ],
    'error' => [
        'e-mail' => '',
        'password' => ''
    ],
    'error_main' => '',
    'invalid' => '',
    'categories_list' => $categories_list
];

// обработка формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // email
    $mail = strip_tags(trim($_POST['e-mail']));
    if ($mail) { // поиск пользователя по e-mail
        $mail = filter_var($mail, FILTER_VALIDATE_EMAIL);
        if ($mail) {
            $result = mysqli_query($link, 'SELECT * FROM users WHERE email = \'' . $mail . '\'');
            if (! $result) {
                $query_errors[] = 'Нет доступа к базе пользователей.';
            }
            else {
                if (! mysqli_num_rows($result)) {
                    $login_data['error']['e-mail'] = 'Данный e-mail отсутствует в базе';
                }
                else {
                    $user = mysqli_fetch_assoc($result);
                    $login_data['e-mail']['value'] = $mail;
                }
            }
        }
        else {
            $login_data['error']['e-mail'] = 'Вы ввели некорректный e-mail';
        }
    }
    else {
        $login_data['error']['e-mail'] = 'Вы не ввели e-mail';
    }
    if ($login_data['error']['e-mail']) {
        $login_data['e-mail']['invalid'] = ' form__item--invalid';
        $error = true;
    }

    // пароль
    $pass = $_POST['password'];
    if ($pass) {
        if (isset($user['password_hash']) && password_verify($pass, $user['password_hash'])) {
            $_SESSION['user'] = $user;
            unset($_SESSION['user']['password_hash']);
        }
        else {
            $login_data['error']['password'] = 'Вы ввели неверный пароль';
        }
    }
    else {
        $login_data['error']['password'] = 'Вы не ввели пароль';
    }
    if ($login_data['error']['password']) {
        $login_data['password']['invalid'] = ' form__item--invalid';
        $error = true;
    }

    // если ошибки
    if (isset($error)) {
        $login_data['invalid'] = ' form--invalid';
        $login_data['error_main'] = 'Пожалуйста, исправьте ошибки в форме.';
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
print(layout($query_errors, $layout_data));
