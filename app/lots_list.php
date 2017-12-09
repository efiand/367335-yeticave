<?php
/**
 * Сценарий получения списка лотов
 *
 * @param mysqli_link $link Текущая БД, с которой соединены
 * @param string $lots_sql Подготовленный запрос
 * @param array $lots_query_data Данные для подготовленного запроса
 * @param function db_get_prepare_stmt() Функция обработки подготовленного запроса
 * @param string $lots_query Кастомный запрос (иначе выдает все характеристики всех лотов)
 * @param mysqli_result $result Результат запроса всех лотов из БД
 * @param array $query_errors Перечень ошибок БД
 * @param array $lots_list Получаемый список лотов (двумерный массив)
 */

$lots_count = 0;
if (isset($lots_sql) && isset($lots_query_data)) {
    $result = db_get_prepare_stmt($link, $lots_sql, $lots_query_data);
}

else {
    if (! isset($lots_query)) {
        $lots_query = 'SELECT * FROM lots';
    }
    $result = mysqli_query($link, $lots_query);
}

if (! $result) {
    $query_errors[] = 'Нет доступа к списку лотов.';
}
else {
    while ($row = mysqli_fetch_assoc($result)) {
        $lots_list[$row['id']] = $row;
    }
}
