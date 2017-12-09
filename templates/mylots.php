        <section class="rates container">
            <h2>Мои ставки</h2>
            <table class="rates__list"><?php foreach ($data['bets'] as $val) : ?>

                <tr class="rates__item<?= $val['rates_item']; ?>">
                    <td class="rates__info">
                        <div class="rates__img">
                            <img src="<?= $val['img']; ?>" width="54" height="40" alt="<?= $val['name']; ?>">
                        </div>
                        <div>
                            <h3 class="rates__title"><a href="lot.php?id=<?= $val['lot_id']; ?>"><?= $val['name']; ?></a></h3><?php if ($val['winner_contacts']) : ?>

                            <p><?= $val['winner_contacts']; ?></p><?php endif; ?>

                        </div>
                    </td>
                    <td class="rates__category"><?= $val['cat_name']; ?></td>
                    <td class="rates__timer">
                        <div class="timer<?= $val['finishing']; ?>"><?= $val['remaining']; ?></div>
                    </td>
                    <td class="rates__price"><?= $val['price']; ?> р</td>
                    <td class="rates__time"><?= $val['time_rel']; ?></td>
                </tr><?php endforeach; ?>

            </table>
        </section>
