<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title><?= $current_page ?></title>

    <meta name="description" content="Fashion - интернет-магазин">
    <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">

    <meta name="theme-color" content="#393939">

    <link rel="preload" href="/fonts/opensans-400-normal.woff2" as="font">
    <link rel="preload" href="/fonts/roboto-400-normal.woff2" as="font">
    <link rel="preload" href="/fonts/roboto-700-normal.woff2" as="font">

    <link rel="icon" href="/img/favicon.png">
    <link rel="stylesheet" href="/css/style.min.css">
    <script src="/js/scripts.js" defer=""></script>
</head>

<body>
<header class="page-header">
    <a class="page-header__logo" href="#">
        <img src="/img/logo.svg" alt="Fashion">
    </a>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/include/header_menu.php') ?>
</header>