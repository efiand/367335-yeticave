<?php
// подключаем библиотеку функций
require 'functions.php';

// подключаем данные
require 'data.php';

// получаем все ставки
$my_bets = [];
$lots_count = count($lots_list);
for ($id = 0; $id < $lots_count; $id ++) {
    if (isset($_COOKIE['bets-' . $id])) {
        $bets = json_decode($_COOKIE['bets-' . $id], true);
        foreach ($bets as $k => $val) {
            if ($val['name'] == $name) {
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

// настройки скрипта
$mylots_data = [
    'categories_list' => $categories_list,
    'bets' => $my_bets,
    'remaining' => strtotime('tomorrow midnight')
];
$layout_data['title'] = 'Мои ставки';


// получаем HTML-код тела страницы
$layout_data['content'] = include_template('mylots', $mylots_data);

// получаем итоговый HTML-код
$layout = include_template('layout', $layout_data);

print ($layout);
