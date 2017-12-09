        <form class="form form--add-lot<?= $data['invalid']; ?> container" action="add.php" method="post" enctype="multipart/form-data">
            <h2>Добавление лота</h2>
            <div class="form__container-two">
                <div class="form__item<?= $data['lot-name']['invalid']; ?>">
                    <label for="lot-name">Наименование</label>
                    <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?= $data['lot-name']['value']; ?>">
                    <span class="form__error"><?= $data['error']['lot-name']; ?></span>
                </div>
                <div class="form__item<?= $data['category']['invalid']; ?>">
                    <label for="category">Категория</label>
                    <select id="category" name="category">
                        <option value="">Выберите категорию</option><? foreach ($data['categories_list'] as $k => $val) : ?>

                        <option value="<?= $k; ?>"<?= $data[$k . '-sel']; ?>><?= $val; ?></option><?php endforeach; ?>

                    </select>
                    <span class="form__error"><?= $data['error']['category']; ?></span>
                </div>
            </div>
            <div class="form__item form__item--wide<?= $data['message']['invalid']; ?>">
                <label for="message">Описание</label>
                <textarea id="message" name="message" placeholder="Напишите описание лота"><?= $data['message']['value']; ?></textarea>
                <span class="form__error"><?= $data['error']['message']; ?></span>
            </div>
            <div class="form__item form__item--file<?= $data['uploaded']; ?>">
                <label>Изображение</label>
                <div class="preview">
                    <button class="preview__remove" type="button">x</button>
                    <div class="preview__img">
                        <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
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
            <div class="form__container-three">
                <div class="form__item form__item--small<?= $data['lot-rate']['invalid']; ?>">
                    <label for="lot-rate">Начальная цена</label>
                    <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value="<?= $data['lot-rate']['value']; ?>">
                    <span class="form__error"><?= $data['error']['lot-rate']; ?></span>
                </div>
                <div class="form__item form__item--small<?= $data['lot-step']['invalid']; ?>">
                    <label for="lot-step">Шаг ставки</label>
                    <input id="lot-step" type="text" name="lot-step" placeholder="500" value="<?= $data['lot-step']['value']; ?>">
                    <span class="form__error"><?= $data['error']['lot-step']; ?></span>
                </div>
                <div class="form__item<?= $data['lot-date']['invalid']; ?>">
                    <label for="lot-date">Дата окончания торгов</label>
                    <input class="form__input-date" id="lot-date" type="date" name="lot-date" value="<?= $data['lot-date']['value']; ?>">
                    <span class="form__error"><?= $data['error']['lot-date']; ?></span>
                </div>
            </div>
            <span class="form__error form__error--bottom"><?= $data['error_main']; ?></span>
            <button type="submit" class="button">Добавить лот</button>
        </form>
