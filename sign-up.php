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

// проверка введенных данных
foreach ($fields as $k => $val) {
    $signup_data[$k] = [
        'value' => '',
        'invalid' => ''
    ];
    $signup_data['error'][$k] = '';
    if (isset($_POST[$k])) {
        $data[$k] = strip_tags(trim($_POST[$k]));
        if (! $data[$k]) {
            $error_count ++;
            $signup_data[$k]['invalid'] = ' form__item--invalid';
            $signup_data['error'][$k] = $val;
        }
        else {
            $signup_data[$k]['value'] = $data[$k];
        }
    }
}

// отдельная проверка email
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $data['e-mail']) {
    $mail = filter_var($data['e-mail'], FILTER_VALIDATE_EMAIL);
    if ($mail) {
        $result = mysqli_query($link, 'SELECT id FROM users WHERE email = \'' . $mail . '\'');
        if (! $result) {
            $query_errors[] = 'Нет доступа к базе пользователей.';
        }
        else if (mysqli_num_rows($result)) {
            $signup_data['error']['e-mail'] = 'Данный e-mail занят';
        }
    }
    else {
        $signup_data['error']['e-mail'] = 'Вы ввели некорректный e-mail';
    }
    if ($signup_data['error']['e-mail']) {
        $error_count ++;
        $signup_data['e-mail']['invalid'] = ' form__item--invalid';
    }
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
        // запись в БД
        $sql = 'INSERT INTO users (name, email, password_hash, contacts, registration_ts) VALUES (?, ?, ?, ?, ?)';
        $query_data = [
            $data['name'],
            $mail,
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['message'],
            $time
        ];
        if (isset($_SESSION['url'])) {
            $sql = str_replace(') VALUES (?, ?, ?, ?, ?)', ', img) VALUES (?, ?, ?, ?, ?, ?)', $sql);
            $query_data[] = $_SESSION['url'];
        }
        $result = db_get_prepare_stmt($link, $sql, $query_data);
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
print(layout($layout_data, $query_errors));
