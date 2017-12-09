        <nav class="nav">
            <ul class="nav__list container"><?php foreach ($data['categories_list'] as $k => $val) : ?>

                <li class="nav__item">
                    <a href="all-lots.php?cat=<?= $k; ?>"><?= $val; ?></a>
                </li><?php endforeach; ?>

            </ul>
        </nav>
