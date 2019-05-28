<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/include/pre_header.php');

if ($_GET['login'] == 'no') {
    setcookie('login', null, -1, '/');
    session_destroy();
    header('location: ' . $_SERVER['REDIRECT_URL']);
    die;
}

if ($_GET['logout'] == 'yes') {
    session_destroy();
    header('location: ' . $_SERVER['REDIRECT_URL']);
    die;
}

?>

<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/include/header.php') ?>
<h1 style="color: #ffffff"><?= $current_page ?></h1>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="left-collum-index">

            <h2>Возможности проекта —</h2>
            <p>Вести свои личные списки, например покупки в магазине, цели, задачи и многое другое. Делится списками с друзьями и просматривать списки друзей.</p>


        </td>
        <td class="right-collum-index">

            <div class="project-folders-menu">
                <ul class="project-folders-v">
                    <li class="project-folders-v-active"><span>Авторизация</span></li>
                    <li><a href="#">Регистрация</a></li>
                    <li><a href="#">Забыли пароль?</a></li>
                </ul>
                <div style="clear: both;"></div>
            </div>
                <div class="index-auth">
                    <?php if ($is_auth) : ?>
                        <a href="?logout=yes">Выйти</a>
                        <?php if (isset($result) && $result) {
                            include($_SERVER['DOCUMENT_ROOT'] . '/include/success.php');
                        }
                        ?>
                    <?php endif;
                    if (!$is_auth) : ?>
                        <form action="<?= $_SERVER['REDIRECT_URL'] ?>" name="auth" method="post" >
                            <?php
                            if (isset($result) && !$result) {
                                include($_SERVER['DOCUMENT_ROOT'] . '/include/error.php');
                            }
                            ?>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <?php if (isset($_COOKIE['login'])) : ?>
                                        <input type="hidden" name="login" value="<?= $_COOKIE['login'] ?>">
                                        <td class="iat"><?= $_COOKIE['login'] ?>
                                            <br><a href="?login=no">Сменить пользователя</a><br />
                                        </td>
                                    <?php else : ?>
                                        <td class="iat">Ваш e-mail: <br /> <input id="login_id" size="30" name="login" required value="<?= $error ? $login : null ?>"/></td>
                                    <?php endif; ?>
                                </tr>
                                <tr>
                                    <td class="iat">Ваш пароль: <br /> <input type="password" id="password_id" size="30" name="password" required value="<?= $error ? $password : null ?>"/></td>
                                </tr>
                                <tr>
                                    <td><input type="submit" value="Войти" /></td>
                                </tr>
                            </table>
                        </form>
                    <?php endif ?>
                </div>
        </td>
    </tr>
</table>

<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/include/footer.php'); ?>

