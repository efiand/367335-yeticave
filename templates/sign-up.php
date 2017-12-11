        <form class="form<?= $data['invalid']; ?> container" action="sign-up.php" method="post" enctype="multipart/form-data">
            <h2>Регистрация нового аккаунта</h2>
            <div class="form__item<?= $data['e-mail']['invalid']; ?>">
                <label for="email">E-mail*</label>
                <input id="email" type="text" name="e-mail" placeholder="Введите e-mail" value="<?= $data['e-mail']['value']; ?>">
                <span class="form__error"><?= $data['error']['e-mail']; ?></span>
            </div>
            <div class="form__item<?= $data['password']['invalid']; ?>">
                <label for="password">Пароль*</label>
                <input id="password" type="password" name="password" placeholder="Введите пароль">
                <span class="form__error"><?= $data['error']['password']; ?></span>
            </div>
            <div class="form__item<?= $data['name']['invalid']; ?>">
                <label for="name">Имя*</label>
                <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= $data['name']['value']; ?>">
                <span class="form__error"><?= $data['error']['name']; ?></span>
            </div>
            <div class="form__item<?= $data['message']['invalid']; ?>">
                <label for="message">Контактные данные*</label>
                <textarea id="message" name="message" placeholder="Напишите, как с вами связаться"><?= $data['message']['value']; ?></textarea>
                <span class="form__error"><?= $data['error']['message']; ?></span>
            </div>
            <div class="form__item form__item--file form__item--last<?= $data['uploaded']; ?>">
                <label>Аватар</label>
                <div class="preview">
                    <button class="preview__remove" type="button">x</button>
                    <div class="preview__img">
                        <img src="<?= $_SESSION['url'] ?? 'img/avatar.jpg'; ?>" width="113" height="113" alt="Ваш аватар">
                    </div>
                </div>
                <div class="form__input-file">
                    <input class="visually-hidden" type="file" id="photo2" name="file" value="">
                    <label for="photo2">
                        <span>+ Добавить</span>
                    </label>
                </div>
            </div>
            <div class="form__item" style="color: #f84646"><?= $data['error']['img']; ?></div>
            <span class="form__error form__error--bottom"><?= $data['error_main']; ?></span>
            <button type="submit" class="button">Зарегистрироваться</button>
            <a class="text-link" href="login.php">Уже есть аккаунт</a>
        </form>
