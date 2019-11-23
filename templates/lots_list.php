        <div class="container">
            <section class="lots">
                <div class="lots__header">
                    <h2><?= $data['header']; ?></h2>
                </div>
                <ul class="lots__list"><?php foreach ($data['announcements_list'] as $k => $val) : ?>

                    <li class="lots__item lot">
                        <div class="lot__image">
                            <img src="<?= $val['img']; ?>" width="350" height="260" alt="<?= $val['name']; ?>">
                        </div>
                        <div class="lot__info">
                            <span class="lot__category"><?= $data['categories_list'][$val['category_id']]; ?></span>
                            <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $k; ?>"><?= $val['name']; ?></a></h3>
                            <div class="lot__state">
                                <div class="lot__rate">
                                    <span class="lot__amount"><?= $val['term']; ?></span>
                                    <span class="lot__cost"><?= $val['price']; ?><b class="rub">р</b></span>
                                </div>
                                <div class="lot__timer timer<?= $val['finishing']; ?>"><?= $val['expire']; ?></div>
                            </div>
                        </div>
                    </li><?php endforeach; ?>

                </ul>
            </section><? if (isset($data['pagination'])) : ?>

            <ul class="pagination-list">
                <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
                <?php foreach ($data['pagination'] as $val) : ?>
                    <?php if ($data['active'] == $val) : ?>
                        <li class="pagination-item pagination-item-active"><a><?= $val; ?></a></li>
                    <?php else : ?>
                        <li class="pagination-item">
                            <a href="<?= $data['script'] . '.php?' . $data['query_str'] . 'page=' . $val; ?>"><?= $val; ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
                <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
            </ul><?php endif; ?>
        </div>
