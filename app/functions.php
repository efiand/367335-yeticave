<?php
/**
 * Функция-шаблонизатор
 *
 * @param string $template_name Имя PHP-шаблона (без расширения)
 * @param array $data Массив с данными для шаблона
 * @param string $template_file Путь к файлу шаблона
 *
 * @return string $output Итоговый HTML-код из шаблона, где элементы $data заменены их значениями
 */
function include_template($template_name, $data) {
    $template_file = 'templates/' . $template_name . '.php';
    if (file_exists($template_file)) {
        ob_start();
        include($template_file);
        $output = ob_get_clean();
    }
    else {
        $output = '';
    }
    return $output;
}


/**
 * Функция представления времени в относительном формате
 *
 * @param integer $ts Время в виде timestamp
 * @param integer $time_diff Разница текущего и переданного времени в виде timestamp
 *
 * @return string $time_return Время в различном формате в зависимости от давности
 */
function time_relative($ts) {
    $time = $_SERVER['REQUEST_TIME'];
    $time_diff = $time - $ts;
    if ($time_diff > 86400) {
        $time_return = date('d.m.Y в H:i', $ts);
    }
    else if ($time_diff > 3600) {
        $time_return = floor($time_diff / 3600) . ' часов назад';
    }
    else {
        $time_return = floor($time_diff / 60) . ' минут назад';
    }
    return $time_return;
}


/**
 * Функция представления времени действия лота
 *
 * @param integer $ts Время окончания действия лота в виде timestamp
 * @param integer $time_diff Оставшееся до окончания время в виде timestamp
 * @param integer $hour Оставшееся время в часах
 * @param integer $min_ts Timestamp для минут неполного часа
 * @param integer $min Число минут неполного часа
 * @param integer $sec Число секунд неполной минуты
 *
 * @return string $time_return Оставшееся время в формате ЧЧ:ММ:СС
 */
function remaining($ts) {
    $time_diff = $ts - $_SERVER['REQUEST_TIME'];
    $time_return = '00:00:00';
    if ($time_diff > 0) {
        $hour = floor($time_diff / 3600);
        $min_ts = $time_diff - $hour * 3600;
        $min = floor($min_ts / 60);
        $sec = $time_diff - $hour * 3600 - $min * 60;
        $time_return = sprintf('%02d:%02d:%02d', $hour, $min, $sec);
    }
    return $time_return;
}


/**
 * Функция выбора итогового шаблона
 *
 * @param array $query_errors Перечень ошибок запросов к БД для их вывода вместо основного содержимого
 * @param function include_template Функция-шаблонизатор (принимает имя шаблона и массив данных)
 * @param array $layout_data Массив данных для основного шаблона
 *
 * @return string $layout Итоговый HTML-код из выбранного шаблона
 */
function layout($layout_data, $query_errors = []) {
    if ($query_errors) {
        $layout = include_template('error', ['header' => 'Ошибка БД', 'errors' => $query_errors]);
    }
    else {
        $layout = include_template('layout', $layout_data);
    }
    return $layout;
}
