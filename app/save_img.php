<?php
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
    if (! isset($_SESSION['url'])) {
        $uploaded_class = '';
        $file_error = $file_error ?? 'Загрузите изображение.';
        if (! isset($signup_data)) { // не обязательно для регистрации
            $error_count ++;
        }
    }
    else {
        $uploaded_class =  ' form__item--uploaded';
        $file_error = '';
    }
}
else {
    $file_error = '';
}
