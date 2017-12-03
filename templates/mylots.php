
        <nav class="nav">
            <ul class="nav__list container"><?php foreach ($data['categories_list'] as $val) : ?>

                <li class="nav__item">
                    <a href="all-lots.html"><?=$val?></a>
                </li><?php endforeach; ?>

            </ul>
        </nav>
        <section class="rates container">
            <h2>Мои ставки</h2>
            <table class="rates__list"><?php foreach ($data['bets'] as $k => $val) : ?>

                <tr class="rates__item">
                    <td class="rates__info">
                        <div class="rates__img">
                            <img src="img/rate<?= $val['id'] + 1; ?>.jpg" width="54" height="40" alt="<?= $val['name']; ?>">
                        </div>
                        <h3 class="rates__title"><a href="lot.php?id=<?= $val['id']; ?>"><?= $val['name']; ?></a></h3>
                    </td>
                    <td class="rates__category"><?= $val['category']; ?></td>
                    <td class="rates__timer">
                        <div class="timer timer--finishing"><?= remaining($data['remaining']); ?></div>
                    </td>
                    <td class="rates__price"><?= $val['price']; ?></td>
                    <td class="rates__time"><?= time_relative($k); ?></td>
                </tr><?php endforeach; ?>

            </table>
        </section>
