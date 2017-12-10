<?php
require 'app/common.php';

// получаем данные ставок и лотов
$result = mysqli_query($link, 'SELECT bets.create_ts, bets.price, lot_id, '
    .'lots.name, lots.img, winner_id, categories.name AS cat_name, contacts '
    .'FROM bets JOIN lots ON bets.lot_id = lots.id '
    .'JOIN categories ON lots.category_id = categories.id '
    .'JOIN users ON bets.user_id = users.id '
    .'WHERE bets.user_id = ' . $_SESSION['user']['id'] . ' ORDER BY bets.create_ts DESC');
if (! $result) {
    $query_errors[] = 'Нет доступа к данным.';
}
else {
    while ($bet = mysqli_fetch_assoc($result)) {
        $bet['remaining'] = remaining($bet['create_ts']);
        $bet['time_rel'] = time_relative($bet['create_ts']);
        $bet['finishing'] = '';
        $bet['rates_item'] = '';
        $bet['winner_contacts'] = '';
        if (substr($bet['remaining'], 0, 3) === '00:') {
            if ($bet['remaining'] === '00:00:00') {
                $bet['remaining'] = 'Торги окончены';
                $bet['finishing'] = ' timer--end';
                $bet['rates_item'] = ' rates__item--end';
            }
            else {
                $bet['finishing'] = ' timer--finishing';
            }
        }
        if ($bet['winner_id'] === $_SESSION['user']['id']) {
            $bet['remaining'] = 'Ставка выиграла';
            $bet['finishing'] = ' timer--win';
            $bet['rates_item'] = ' rates__item--win';
            $bet['winner_contacts'] = $bet['contacts'];
        }
        unset($bet['create_ts'], $bet['winner_id'], $bet['contacts']);
        $my_bets[] = $bet;
    }
}

// получаем HTML-код тела страницы
$layout_data['content'] = include_template('mylots', ['bets' => $my_bets]);

// получаем итоговый HTML-код
$layout_data['title'] = 'Мои ставки';
print(layout($layout_data, $query_errors));
