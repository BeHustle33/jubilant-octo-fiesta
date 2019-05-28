<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/include/pre_header.php');

if ($_GET['login'] == 'no') {
    setcookie('login', null, -1, '/');
    session_destroy();
    header('location: ' . $_SERVER['PHP_SELF']);
    die;
}

if ($_GET['logout'] == 'yes') {
    session_destroy();
    header('location: ' . $_SERVER['PHP_SELF']);
    die;
}

if ($is_auth) {
    $user_category = getUserCategory($_SESSION['user_id']);
}

?>

<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/include/header.php');?>
    <h1 style="color: #ffffff">Сообщения</h1>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="left-collum-index">
                <?php if (!$is_auth) { ?>
                    <h2>Ошибка доступа</h2>
                    <p>У вас недостаточно прав на просмотр этой страницы. Пожалуйста, авторизуйтесь на сайте</p>
                <?php } elseif ($is_auth) {
                    if ($user_category) : ?>
                        <h2>Вы прошли модерацию и можете писать сообщения</h2>
                        <a href="/post/view/index.php">Прочитать личные сообщения</a>
                        <a href="/post/add/index.php">Написать сообщение</a>
                    <?php elseif(!$user_category) : ?>
                            <h2>Вы сможете отправлять  сообщения после прохождения модерации</h2>
                            <a href="/post/view/index.php">Прочитать личные сообщения</a>
                        <?php endif;
                }
                ?>
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
                        <form action="<?= $_SERVER['PHP_SELF'] ?>" name="auth" method="post" >
                            <?php
                            if (isset($result) && !$result) {
                                include($_SERVER['DOCUMENT_ROOT'] . '/include/error.php');
                            }
                            ?>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <?php if (isset($_COOKIE['login'])) : ?>
                                        <input type="hidden" name="login" value="<?= htmlspecialchars($_COOKIE['login']) ?>">
                                        <td class="iat"><?= htmlspecialchars($_COOKIE['login']) ?>
                                            <br><a href="?login=no">Сменить пользователя</a><br />
                                        </td>
                                    <?php else : ?>
                                        <td class="iat">Ваш e-mail: <br /> <input id="login_id" size="30" name="login" required value="<?= $error ? $login : null ?>"/></td>
                                    <?php endif ?>
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