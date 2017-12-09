<?php
require 'app/common.php';

// поисковая фраза
$search = trim(strip_tags($_GET['search'])) ?? '';

if ($search) {
    // получаем id результатов поиска
    $sql = 'SELECT id, name, price, expire_ts, img, category_id FROM lots WHERE MATCH(name, description) AGAINST(? IN BOOLEAN MODE) ORDER BY id DESC';
    $stmt = db_get_prepare_stmt($link, $sql, [$search]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (! $result) {
        $query_errors[] = 'Ошибка поиска.';
        $lots_count = 0;
    }
    else {
        // количество найденных лотов
        $lots_count = mysqli_num_rows($result);
    }

    if ($lots_count) {
        // настройки пагинации
        $page_items = 9;
        require 'app/paginator.php';

        // запрос на характеристики найденных лотов
        $lots_query = 'SELECT id, name, price, expire_ts, img, category_id FROM lots WHERE';
        while ($row = mysqli_fetch_assoc($result)) {
            $lots_query .= ' id = ' . $row['id'] . ' OR';
        }
        $lots_query = substr($lots_query, 0, -2) . ' LIMIT ' . $page_items . ' OFFSET ' . $offset;
        require 'app/lots_list.php';

        $search_data = [
            'script' => 'search',
            'announcements_list' => $lots_list,
            'header' => 'Результаты поиска по запросу «' . $search . '»',
            'pagination' => $pages,
            'active' => $cur_page,
            'query_str' => 'search=' . $search . '&'
        ];
    }
    else {
        $search_data['blank'] = 'Ничего не найдено по вашему запросу.';
    }
    $layout_data['search_text'] = $search;
}
else {
    $search_data['blank'] = 'Пустой поисковый запрос.';
}

// получаем HTML-код тела страницы
$search_data['categories_list'] = $categories_list;
$search_data['categories'] = $layout_data['categories'];
$layout_data['content'] = include_template('search', $search_data);

// получаем итоговый HTML-код
$layout_data['title'] = 'Результаты поиска';
$layout_data['main_container'] = '';
print(layout($layout_data, $query_errors));
