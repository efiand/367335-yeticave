        <section class="lot-item container">
            <h2><?= $data['lots_list'][$data['id']]['name'] ?></h2>
            <div class="lot-item__content">
                <div class="lot-item__left"><?php if ($data['lots_list'][$data['id']]['img']) : ?>

                    <div class="lot-item__image">
                        <img src="<?= $data['lots_list'][$data['id']]['img'] ?>" width="730" height="548" alt="<?= $data['lots_list'][$data['id']]['name'] ?>">
                    </div><?php endif; ?>

                    <p class="lot-item__category">Категория: <span><?= $data['categories_list'][$data['lots_list'][$data['id']]['category_id']] ?></span></p>
                    <p class="lot-item__description"><?= $data['lots_list'][$data['id']]['description'] ?></p>
                </div>
                <div class="lot-item__right"><?php if (isset($_SESSION['user']) && $_SESSION['user']['name']) : ?>

                    <div class="lot-item__state">
                        <div class="lot-item__timer timer<?= $data['finishing']; ?>">
                            <?= $data['expire']; ?>
                        </div>
                        <div class="lot-item__cost-state">
                            <div class="lot-item__rate">
                                <span class="lot-item__amount">Текущая цена</span>
                                <span class="lot-item__cost"><?= $data['price']; ?></span>
                            </div>
                            <div class="lot-item__min-cost">
                                Мин. ставка <span><?= $data['bet_min']; ?> р</span>
                            </div>
                        </div><?php if ($data['real'] && $data['empty'] && ! $data['self'] && ! $data['expired']) : ?>

                        <form class="lot-item__form" action="lot.php?id=<?= $data['id']; ?>" method="post">
                            <p class="lot-item__form-item">
                                <label for="cost">Ваша ставка</label>
                                <input id="cost" type="text" name="cost" placeholder="<?= $data['bet_min']; ?>">
                            </p>
                            <button type="submit" class="button">Сделать ставку</button>
                        </form><?php endif; ?>

                    </div><?php endif; if ($data['real']) : ?>

                    <div class="history">
                        <h3>История ставок (<span><?= $data['count']; ?></span>)</h3>
                        <table class="history__list"><?php foreach ($data['bets'] as $val) : ?>

                            <tr class="history__item">
                                <td class="history__name"><?= $val['name']; ?></td>
                                <td class="history__price"><?= $val['price']; ?> р</td>
                                <td class="history__time"><?= time_relative($val['ts']); ?></td>
                            </tr><?php endforeach; ?>

                        </table>
                    </div><?php endif; ?>

                </div>
            </div>
        </section>
