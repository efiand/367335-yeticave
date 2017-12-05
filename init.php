<?php
$link = @mysqli_connect('localhost', 'root', '', 'yeticave');

// При ошибке соединения:
if (! $link) {
    print(include_template('error', ['header' => 'Ошибка соединения с БД', 'error' => mysqli_connect_error()]));
    exit();
}

mysqli_set_charset($link, 'utf8');

// Для работы с подготовленными выражениями:
require 'mysql_helper.php';

// Для обработки ошибок запроса (будет значением $data_layout['content'] для layout.php):
function query_error($link) {
    return include_template('error', ['header' => 'Ошибка БД', 'error' => mysqli_error($link)]);
}
