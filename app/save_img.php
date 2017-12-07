<?php
/**
 * Сценарий загрузки файла
 *
 * @param string $file_error Текст ошибки загрузки
 * @param string $uploaded_class Фрагмент HTML для доп. класса при ошибке
 * @param string $_SESSION['url'] Запись имени файла в сессию до конца операции
 * @param array $signup_data Признак регистрационной страницы, где img не обязателен
 */
$file_error = '';
$uploaded_class = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // загрузка валидного файла на сервер
    $tmp = $_FILES['file']['tmp_name'];
    if (is_uploaded_file($tmp)) {
        if (mime_content_type($tmp) == 'image/png' || mime_content_type($tmp) == 'image/jpeg') {
            $_SESSION['url'] = 'img/' . $_FILES['file']['name'];
            copy($tmp, $_SESSION['url']);
        }
        else {
            $file_error = 'Выберите правильный формат (jpeg или png).';
        }
    }

    // проверка при промежуточных исправлениях ошибок
    if (! isset($_SESSION['url']) && ! isset($signup_data)) {
        $file_error = $file_error ? $file_error : 'Загрузите изображение.';
        $error_count ++;
    }
    else {
        $uploaded_class =  ' form__item--uploaded';
    }
}
