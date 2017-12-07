
        <nav class="nav">
            <ul class="nav__list container"><?php foreach ($data['categories_list'] as $val) : ?>

                <li class="nav__item">
                    <a href="all-lots.html"><?=$val?></a>
                </li><?php endforeach; ?>

            </ul>
        </nav>

        <form class="form<?= $data['invalid']; ?> container" action="login.php" method="post">
            <h2>Вход</h2>
            <div class="form__item<?= $data['e-mail']['invalid']; ?>">
                <label for="email">E-mail*</label>
                <input id="email" type="text" name="e-mail" placeholder="Введите e-mail" value="<?= $data['e-mail']['value']; ?>">
                <span class="form__error"><?= $data['error']['e-mail']; ?></span>
            </div>
            <div class="form__item<?= $data['password']['invalid']; ?> form__item--last">
                <label for="password">Пароль*</label>
                <input id="password" type="password" name="password" placeholder="Введите пароль">
                <span class="form__error"><?= $data['error']['password']; ?></span>
            </div>
            <span class="form__error form__error--bottom"><?= $data['error_main']; ?></span>
            <button type="submit" class="button">Войти</button>
        </form>
