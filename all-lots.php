<?php
require 'app/common.php';

// Категория
if (isset($_GET['cat']) && $_GET['cat']) {
    $cat = $_GET['cat'];
    $cat_name = $categories_list[$cat];
}
else {
    $cat = '';
}

if ($cat) {
    // получаем количество подходящих лотов
    $result = mysqli_query($link, 'SELECT id FROM lots WHERE category_id = \'' . $cat . '\' AND expire_ts > ' . $time);
    if (! $result) {
        $query_errors[] = 'Нет доступа к списку лотов.';
        $lots_count = 0;
    }
    else {
        // количество лотов категории
        $lots_count = mysqli_num_rows($result);
    }

    if ($lots_count) {
        // настройки пагинации
        $page_items = 9;
        require 'app/paginator.php';

        // запрос на характеристики лотов категории
        $lots_query = 'SELECT id, name, price, expire_ts, img, category_id FROM lots WHERE category_id = \'' . $cat . '\' AND expire_ts > ' . $time . ' ORDER BY id DESC LIMIT 9 OFFSET ' . $offset;
        require 'app/lots_list.php';

        $cat_data = [
            'announcements_list' => $lots_list,
            'header' => 'Все лоты в категории «' . $cat_name . '»'
        ];
        if ($lots_count > $page_items) {
            $cat_data['pagination'] = $pages;
            $cat_data['script'] = 'all-lots';
            $cat_data['active'] = $cur_page;
            $cat_data['query_str'] = '';
        }
    }
    else {
        $cat_data['blank'] = 'Активные лоты в категории «' . $cat_name . '» отсутствуют.';
    }
}
else {
    $cat_data['blank'] = 'Выберите категорию.';
}

// получаем HTML-код тела страницы
$cat_data['categories_list'] = $categories_list;
$layout_data['content'] = include_template('search', $cat_data);

// получаем итоговый HTML-код
$layout_data['title'] = 'Все лоты';
print(layout($layout_data, $query_errors));
