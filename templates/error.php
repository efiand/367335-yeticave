<!DOCTYPE html>
<html>
<head>
    <title>Ошибки БД</title>
</head>
<body>
    <h2><?= $data['header']; ?></h2><?php foreach ($data['errors'] as $val) : ?>

    <p><?= $val; ?></p><?php endforeach; ?>

</body>
</html>
