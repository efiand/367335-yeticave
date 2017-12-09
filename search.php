<?php
require 'app/common.php';

// поисковая фраза
$search = $_GET['search'];

// получаем id результатов поиска
$sql = 'SELECT id, name, price, expire_ts, img, category_id FROM lots WHERE MATCH(name, description) AGAINST(? IN BOOLEAN MODE) ORDER BY id DESC';
$stmt = db_get_prepare_stmt($link, $sql, [$search]);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (! $result) {
    $query_errors[] = 'Ошибка поиска.';
}

// количество найденных лотов
$lots_count = mysqli_num_rows($result);

// настройки пагинации
$page_items = 9;
require 'app/paginator.php';

// запрос на характеристики найденных лотов
$lots_query = 'SELECT id, name, price, expire_ts, img, category_id FROM lots WHERE';
while ($row = mysqli_fetch_assoc($result)) {
    $lots_query .= ' id = ' . $row['id'] . ' OR';
}
$lots_query = substr($lots_query, 0, -2);
require 'app/lots_list.php';

// количество страниц
$pages_count = ceil($lots_count / 3);

// текущая страница
$cur_page = $_GET['page'] ?? 1;

// получаем HTML-код тела страницы
$layout_data['content'] = include_template('index', [
    'categories_list' => $categories_list,
    'announcements_list' => $lots_list,
    'header' => 'Результаты поиска по запросу «' . $search . '»',
    'categories' => $layout_data['categories'],
    'pagination' => range(1, $pages_count),
    'active' => $cur_page
]);

// получаем итоговый HTML-код
$layout_data['title'] = 'Главная';
$layout_data['index_link'] = '';
print(layout($layout_data, $query_errors));
