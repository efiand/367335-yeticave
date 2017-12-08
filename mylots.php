<?php
require 'app/common.php';

// получаем список лотов
require 'app/lots_list.php';

// получаем все ставки
$my_bets = [];
$lots_count = count($lots_list);
for ($id = 0; $id < $lots_count; $id ++) {
    if (isset($_COOKIE['bets-' . $id])) {
        $bets = json_decode($_COOKIE['bets-' . $id], true);
        foreach ($bets as $k => $val) {
            if ($val['name'] == $_SESSION['user']['name']) {
                $my_bets[$val['ts']] = [
                    'id' => $id,
                    'name' => $lots_list[$id]['name'],
                    'category' => $categories_list[$lots_list[$id]['category']],
                    'price' => $val['price']
                ];
            }
        }
    }
}
krsort($my_bets);

// получаем HTML-код тела страницы
$mylots_data = [
    'categories_list' => $categories_list,
    'categories' => $layout_data['categories'],
    'bets' => $my_bets,
    'remaining' => strtotime('tomorrow midnight')
];
$layout_data['content'] = include_template('mylots', $mylots_data);

// получаем итоговый HTML-код
$layout_data['title'] = 'Мои ставки';
$layout_data['main_container'] = '';
print(layout($layout_data, $query_errors));
