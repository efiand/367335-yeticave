<?php
require 'app/common.php';

// общее количество лотов
$result = mysqli_query($link, 'SELECT COUNT(*) AS cnt FROM lots');
$lots_count = mysqli_fetch_assoc($result)['cnt'];

// настройки пагинации
require 'app/paginator.php';

// получаем список лотов
$lots_query = 'SELECT id, name, price, expire_ts, img, category_id FROM lots LIMIT '
. $page_items . ' OFFSET ' . $offset;
require 'app/lots_list.php';

// получаем HTML-код тела страницы
$layout_data['content'] = include_template('index', [
    'script' => 'index',
    'categories_list' => $categories_list,
    'announcements_list' => $lots_list,
    'header' => 'Открытые лоты',
    'categories' => $layout_data['categories'],
    'pagination' => $pages,
    'active' => $cur_page,
    'query_str' => ''
]);

// получаем итоговый HTML-код
$layout_data['title'] = 'Главная';
$layout_data['main_container'] = '';
$layout_data['index_link'] = '';
print(layout($layout_data, $query_errors));
