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
        if (isset($_GET['msg_id'])) {
            $message_stmt = showCurrentMessage($_GET['msg_id'], $_SESSION['user_id']);
        } else {
            $messages = showMessages($_SESSION['user_id']);
        }
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
                    if (!isset($message_stmt)) {  ?>
                        <h3>Непрочитанные сообщения</h3>
                        <?php if ($messages) {
                            foreach ($messages as $row) : ?>
                                <p><b>Cообщение:</b> <a href="?msg_id=<?= $row['msg_id'] ?>"><?= $row['message_caption'] ?></a>
                                    <b>Категория:</b> <?= $row['category'] ?></p>
                            <?php endforeach;
                        }
                    }
                    elseif (isset($message_stmt) && $message_stmt != false) { ?>
                        <h3><?= $message_stmt['caption'] ?></h3>
                        <p>Дата отправки: <b><?= $message_stmt['createdate'] ?></b></p>
                        <p>Отправитель:<b><?=  $message_stmt['surname'] . ' ' . $message_stmt['name'] . ' ' . $message_stmt['patronymic'] ?></b></p>
                        <p>Email:<b><?= $message_stmt['email'] ?></b></p>
                        <p><b>Текст сообщения: </b></p>
                        <p><?= $message_stmt['content'] ?></p>
                        <?php  ?>
                        <a href="/post/view/">Вернуться назад</a>
                    <?php } else { ?>
                        <p>К этому сообщению нет доступа. Возможно, оно было прочитано ранее, либо адресовано не вам</p>
                        <a href="/post/view/">Вернуться назад</a>
                    <?php }
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