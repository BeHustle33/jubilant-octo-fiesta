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

$msg_error = false;

if ($is_auth) {
    $user_category = getUserCategory($_SESSION['user_id']);
    $categories = showCategories();
    if (isset($_POST['message_submit'])) {
        try {
            if (empty($_POST['caption'])) {
                throw new Exception('Введите название сообщения');
            }
            if (mb_strlen($_POST['caption']) > 255) {
                throw new Exception('Длина названия сообщения не может быть больше 255 символов');
            }
            if (empty($_POST['content'])) {
                throw new Exception('Введите текст сообщения');
            }
            if (mb_strlen($_POST['caption']) > 5000) {
                throw new Exception('Длина сообщения не может быть больше 5000 символов');
            }
            if (empty($_POST['email'])) {
                throw new Exception('Email получателя не может быть пустым');
            }
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Введите действительный email адрес');
            }
            $email = checkEmail($_POST['email']);
            if (!$email['id']) {
                throw new Exception('Пользователь с таким email не найден в базе');
            }
            $caption = htmlspecialchars($_POST['caption']);
            $content = htmlspecialchars($_POST['content']);
            $category_id = (int) ($_POST['category']);
            $send_message = sendMessage($caption, $content, $_SESSION['user_id'], $email['id'], $category_id);
            if ($send_message) {
                $msg_error = true;
                $submit_message = 'Пиьсмо успшено отправлено';
            } else {
                $submit_message = 'Пиьсмо не отправлено. Проверьте вводимые параметры';
            }
        } catch (Exception $e) {
            $submit_message = $e->getMessage();
        }
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
                    if ($user_category) { ?>
                        <p><?php if (isset($submit_message)) {
                            echo $submit_message;
                        } ?></p>
                        <h2>Написать сообщение</h2>
                        <form action="<?= $_SERVER['PHP_SELF'] ?>" name="send_message" method="post" >
                            <p><input type="text" name="caption" placeholder="Заголовок сообщения" maxlength="120" size="40" value="<?= $msg_error ? null : htmlspecialchars($_POST['caption'])  ?>" required></p>
                            <textarea name="content" placeholder="Текст сообщения" rows="5" cols="38" maxlength="5000" required><?= $msg_error ? null : htmlspecialchars($_POST['content'])  ?></textarea>
                            <p><input type="email" name="email" placeholder="Получатель сообщения" maxlength="120" size="40" value="<?= $msg_error ? null : htmlspecialchars($_POST['email'])  ?>" required></p>
                            <p><label for="category">Выберите категорию</label></p>
                            <p><select name="category" id="category">
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?= $category['id'] ?>" style="color: <?= $category['color'] ?>"><?= $category['name'] ?></option>
                                <?php endforeach ?>
                                </select></p>
                            <input type="submit" name="message_submit">
                        </form>
                    <?php } elseif(!$user_category) { ?>
                            <h2>Вы сможете отправлять  сообщения после прохождения модерации</h2>
                            <a href="/">Вернуться на главную</a>
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