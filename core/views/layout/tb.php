
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TASK BOOK</title>
    <meta name="google-site-verification" content="eOIT_qcT9BwbK70g70tVmrNZZRE557vl-SBzv8VbRvo" />
    <meta name="yandex-verification" content="e4cca6155409a817"/>
    <?php if (!empty($this -> description)): ?>
        <meta name="Description" content="<?= $this -> description ?>"/>
    <?php endif; ?>
    <?php if (!empty($this -> css)):
        foreach ($this -> css as $css):?>
            <link rel="stylesheet" href="/assets/css/<?= $css ?>.css">
        <?php
        endforeach;
    endif; ?>
    <link href="<?=$this->icon?>" rel="shortcut icon" type="image/png"/>

</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm mb-3">
                <a class="nav-link" href="/">Главная</a>
            <?php if (!$_SESSION['admin']):?>
                <a class="nav-link " href="auto">Авторизация</a>
            <?php else:?>
                <a class="nav-link" href="/admin/list">Админка</a>
                <a class="nav-link" href="/admin/exit">Выход</a>
            <?php endif;?>
        </nav>
        <?php include 'core/views/includes/' . $this->includes . '.inc.php';?>
    </div>
</body>
</html>