<?php

session_name('session_id');
session_start(['cookie_lifetime' => 60 * 20]);
setcookie('session_id', session_id(), time() + 60 * 20, '/');
if (isset($_COOKIE['login'])) {
    setcookie('login', $_COOKIE['login'], time() + 60 *60 * 24 * 30, '/');
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/include/main_menu.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/include/dbconfig.php');

if (isset($_GET['page'])) {
    $current_page = getCurrentPage($_GET['page'], $main_menu);
} else {
    $current_page = 'Главная';
}

$error = false;
$is_auth = false;

if (!empty($_POST['login']) && !empty($_POST['password'])) { // проверяем массив POST на пустоту
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);
    $result = checkUser($login, $password);
    $result ? $is_auth = true : $error = true;
}
if ($is_auth && !isset($_COOKIE['login'])) {
    setcookie('login', $login, time() + 60 *60 *24 * 30, '/');
}

if ($_SESSION['is_auth']) {
    $is_auth = true;
}

if ($is_auth && !isset($_SESSION['is_auth'])) {
    $_SESSION['is_auth'] = $is_auth;
    $_SESSION['user_id'] = $result;
}