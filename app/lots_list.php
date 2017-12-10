<?php
/**
 * Сценарий получения списка лотов
 *
 * @param mysqli_link $link Текущая БД, с которой соединены
 * @param string $lots_query Кастомный запрос (иначе выдает все характеристики всех лотов)
 * @param mysqli_result $result Результат запроса всех лотов из БД
 * @param array $query_errors Перечень ошибок БД
 * @param array $lots_list Получаемый список лотов (двумерный массив)
 */

$lots_count = $lots_count ?? 0;
if (! isset($lots_query)) {
    $lots_query = 'SELECT * FROM lots';
}
$result = mysqli_query($link, $lots_query);
if (! $result) {
    $query_errors[] = 'Нет доступа к списку лотов.';
}
else {
    while ($row = mysqli_fetch_assoc($result)) {
        $lots_list[$row['id']] = $row;
    }
}

foreach ($lots_list as $k => &$val) {
    $val['term'] = 'Стартовая цена';
    $val['finishing'] = '';
    $val['expire'] = remaining($val['expire_ts']);
    if (substr($val['expire'], 0, 3) === '00:') {
        $val['finishing'] = ' timer--finishing';
    }
    $result = mysqli_query($link, 'SELECT id, price FROM bets WHERE lot_id = ' . $k . ' ORDER BY price DESC');
    if (! $result) {
        $query_errors[] = 'Нет доступа к списку ставок.';
    }
    else {
        $bets_count = mysqli_num_rows($result);
        if ($bets_count) {
            $val['price'] = mysqli_fetch_assoc($result)['price'];
            $val['term'] =  $bets_count . ' ставок';
        }
    }
}
