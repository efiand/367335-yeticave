        <nav class="nav">
            <ul class="nav__list container"><?php foreach ($data['categories_list'] as $val) : ?>

                <li class="nav__item">
                    <a href="all-lots.html"><?=$val?></a>
                </li><?php endforeach; ?>

            </ul>
        </nav>
