<?php
$link = mysqli_connect('localhost', 'root', $_ENV['DB_PASS'] ?? '', 'yeticave');

// при ошибке соединения
if (! $link) {
    print(include_template('error', ['header' => 'Ошибка соединения с БД', 'errors' => [mysqli_connect_error()]]));
    exit();
}

mysqli_set_charset($link, 'utf8');
