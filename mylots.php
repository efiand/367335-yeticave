<?php
// подключаем библиотеку функций
require 'functions.php';

// подключаем данные
require 'data.php';

// настройки скрипта
$mylots_data = [
    'categories_list' => $categories_list
];
$layout_data['title'] = 'Мои ставки';


// получаем HTML-код тела страницы
$layout_data['content'] = include_template('mylots', $mylots_data);

// получаем итоговый HTML-код
$layout = include_template('layout', $layout_data);

print ($layout);
