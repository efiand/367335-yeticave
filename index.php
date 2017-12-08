<?php
require 'app/common.php';

// получаем HTML-код тела страницы
$layout_data['content'] = include_template('index', [
    'categories_list' => $categories_list,
    'announcements_list' => $lots_list,
    'categories' => $layout_data['categories']
]);

// получаем итоговый HTML-код
$layout_data['title'] = 'Главная';
$layout_data['index_link'] = '';
print(layout($layout_data, $query_errors));
