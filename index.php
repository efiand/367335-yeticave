<?php
// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

// подключаем библиотеку функций
require 'functions.php';

// подключаем данные
require 'data.php';

// записать в эту переменную оставшееся время в этом формате (ЧЧ:ММ)
$lot_time_remaining = "00:00";

// временная метка для полночи следующего дня
$tomorrow = strtotime('tomorrow midnight');

// временная метка для настоящего времени
$now = strtotime('now');

// временная метка оставшегося до полуночи времени
$lot_time_remaining__ts = $tomorrow - $now;

// оставшееся время в часах
$lot_time_remaining__hours = floor($lot_time_remaining__ts / 3600);

// временная метка для минут неполного часа
$lot_time_remaining__min_ts = $lot_time_remaining__ts - $lot_time_remaining__hours * 3600;

// число минут неполного часа
$lot_time_remaining__min = floor($lot_time_remaining__min_ts / 60);

// оставшееся время в формате ЧЧ:ММ
$lot_time_remaining = sprintf('%02d:%02d', $lot_time_remaining__hours, $lot_time_remaining__min);

// добавляем оставшееся время к настройкам шаблона вывода
$index_data['lot_time_remaining'] = $lot_time_remaining;


// получаем HTML-код тела страницы
$layout_data['content'] = include_template('index', $index_data);

// получаем итоговый HTML-код
$layout = include_template('layout', $layout_data);

print ($layout);
