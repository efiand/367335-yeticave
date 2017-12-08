
        <section class="promo">
            <h2 class="promo__title">Нужен стафф для катки?</h2>
            <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
            <ul class="promo__list"><?php foreach ($data['categories_list'] as $k => $val) : ?>

                <li class="promo__item promo__item--<?= $k; ?>">
                    <a class="promo__link" href="all-lots.html"><?= strip_tags($val); ?></a>
                </li><?php endforeach; ?>

            </ul>
        </section><?php require 'templates/lots_list.php'; ?>