<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/include/pre_loader.php');

const GROUP_NAME = 'Администраторы';

$access = false;
if (isset($_SESSION['user_id'])) {
    $access = getUserCategory($_SESSION['user_id']);
} else {
    $access = false;
}

define("IMG_MAX_FILE_SIZE", 5000000);
define("IMG_MAX_FILES_COUNT", 5);

$current_page = 'Добавление товара';
$categories = getCategories();

if ($access && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product = getProductById($_GET['id']);
    $categories = getCategories();
}

?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/include/header.php'); ?>
<?php if ($access == true) : ?>

    <main class="page-add">
  <h1 class="h h--1">Изменение товара</h1>
  <?php if (!$product) : ?>
  <p style="color:red">Товар не обнаружен в базе!</p>
  <?php endif ?>
  <form name="add_product" class="custom-form" method="post" id="ajax_form" action="">
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
        <p class="custom-form__input-wrapper page-add__first-wrapper">
            <b>id: <?= $product['id'] ?></b>
        </p>
      <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
        <input type="text" class="custom-form__input" name="product-name" id="product-name" value="<?= $product['name'] ?>">
      </label>
      <label for="product-price" class="custom-form__input-wrapper">
        <input type="text" class="custom-form__input" name="product-price" id="product-price" value="<?= $product['price'] ?>">
      </label>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Изменить фотографию</legend>
      <ul class="add-list">
        <li class="add-list__item add-list__item--add" >
          <input type="file"  name="product-photo" id="product-photo" hidden="">
            <img src="<?= $product['img_path'] ?>">
            <label for="product-photo" ></label>
        </li>
      </ul>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Раздел</legend>
      <div class="custom-form__select-wrapper page-add__select">
        <select id="categories" name="category" class="custom-form__select">
            <?php foreach ($categories as $category) :?>
                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach ?>
        </select>
      </div>
      <input type="checkbox" name="new" id="new" class="custom-form__checkbox">
      <label for="new" class="custom-form__checkbox-label">Новинка</label>
      <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox">
      <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
    </fieldset>
    <button class="button" type="submit">Изменить товар</button>
  </form>
  <section class="shop-page__popup-end page-add__popup-end" hidden="">
    <div class="shop-page__wrapper shop-page__wrapper--popup-end">
      <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно обновлен</h2>
    </div>
  </section>
</main>

<?php else: ?>
    <p>Ошибка доступа! У вас недостаточно прав на просмотр этой страницы</p>
<?php endif ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/include/footer.php') ?>


