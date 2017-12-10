<?php
/**
 * Сценарий определения победителей по истекшим лотам
 *
 * @param mysqli_result $list_result Результат запроса списка закрытых лотов без победителя
 * @param array $query_errors Список ошибок БД
 * @param array $lot Данные одного лота
 * @param mysqli_result $result Результат выполнения запроса для каждого лота
 * @param array $winner Параметры победившей ставки
 * @param mysqli_result $winner_write Запись id победителя в таблицу текущего лота

 * Отправка сообщения победителю с помощью Swift Mailer
 */

$list_result = mysqli_query($link, 'SELECT id, name FROM lots WHERE expire_ts <= ' . $time . ' AND winner_id IS NULL');
if (! $list_result) {
    $query_errors[] = 'Нет доступа к списку лотов.';
}
else {
    while ($lot = mysqli_fetch_assoc($list_result)) {
        $result = mysqli_query($link, 'SELECT users.id, name, email FROM bets '
        . 'JOIN users ON bets.user_id = users.id WHERE lot_id = ' . $lot['id']
        . ' ORDER BY price DESC LIMIT 1');
        if (! $result) {
            $query_errors[] = 'Нет доступа к списку ставок.';
        }
        else if (mysqli_num_rows($result)) {
            $winner = mysqli_fetch_assoc($result);
            $winner_write = mysqli_query($link, 'UPDATE lots SET winner_id = ' . $winner['id']
                . ' WHERE id = ' . $lot['id']);
            if (! $winner_write) {
                $query_errors[] = 'Ошибка записи победителя.';
            }
            else {
                $transport = new Swift_SmtpTransport('smtp.mail.ru', 465, 'ssl');
                $transport->setUsername('doingsdone@mail.ru');
                $transport->setPassword('rds7BgcL');
                $message = new Swift_Message('Ваша ставка победила');
                $message->setTo([$winner['email'] => $winner['name']]);
                $message->setBody(include_template('email', [
                    'name' => $winner['name'],
                    'id' => $lot['id'],
                    'lot-name' => $lot['name'],
                ]), 'text/html');
                $message->setFrom('doingsdone@mail.ru', 'Yeticave');
                $mailer = new Swift_Mailer($transport);
                $mailer->send($message);
            }
        }
    }
}
