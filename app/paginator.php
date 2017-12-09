<?php
/**
 * Сценарий настройки пагинации
 *
 * @param integer $lots_count Количество лотов в списке
 * @param integer $page_items Количество лотов на странице
 * @param integer $cur_page Номер текущей страницы
 * @param integer $offset Смещение в таблице лотов
 * @param integer $pages_count Количество страниц
 * @param array $pages Список страниц
 */

$page_items = $page_items ?? 3;
$cur_page = $_GET['page'] ?? 1;
$offset = ($cur_page - 1) * $page_items;

if (isset($lots_count)) {
    $pages_count = ceil($lots_count / $page_items);
    if ($cur_page > $pages_count || ! $cur_page) {
        http_response_code(404);
        exit();
    }
}

$pages = range(1, $pages_count);
