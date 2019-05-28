<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/include/pre_loader.php') ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/include/header.php') ?>

<main class="page-delivery">
  <h1 class="h h--1">Доставка</h1>
  <p class="page-delivery__desc">
    Способы доставки могут изменяться в зависимости от адреса доставки, времени осуществления покупки и наличия товаров.
  </p>
  <p class="page-delivery__desc page-delivery__desc--strong">
    <b>При оформлении покупки мы проинформируем вас о доступных способах доставки, стоимости и дате доставки вашего заказа.</b>
  </p>
  <section class="page-delivery__info">
    <header class="page-delivery__desc">
      Возможные варианты доставки:
      <b class="page-delivery__variant">Доставка на дом:</b>
    </header>
    <ul class="page-delivery__list">
      <li>
        <b class="page-delivery__item-title">Стандартная доставка - <?= DELIVERY_PRICE ?> РУБ / БЕСПЛАТНО (ДЛЯ ЗАКАЗОВ ОТ <?= PRICE_TO_FREE_DELIVERY ?> РУБ)</b>
        <p class="page-delivery__item-desc">
          Примерный срок доставки составит около <?= DELIVERY_TIME ?> рабочих дней, в зависимости от адреса доставки.
        </p>
      </li>
      <li>
        <b class="page-delivery__item-title">В день покупки - <?= DELIVERY_TODAY_PRICE ?> РУБ</b>
        <p class="page-delivery__item-desc">
          Доступна для жителей г. Москва в пределах МКАД. Заказы, оформленныес понедельника по пятницу до 14:00 будут доставлены в тот же день с 19:00 до 23:00. Изменение адреса доставки после оформления заказа невозможно.
        </p>
      </li>
      <li>
        <b class="page-delivery__item-title">Доставка с примеркой перед покупкой по Москве - <?= DELIVERY_FITTING_PRICE ?> РУБ / БЕСПЛАТНО (ПРИ ВЫКУПЕ НА СУММУ ОТ <?= PRICE_TO_FREE_DELIVERY_FITTING ?> РУБ)</b>
        <p class="page-delivery__item-desc">
          Доставка возможна только по Москве (в пределах МКАД) в течение 2-3 дней.
          Воспользовавшись услугой «Примерка перед покупкой», вы можете получить свой заказ и примерить заказанные товары. Вы оплачиваете только то, что вам подошло. Максимальное количество позиций в заказе, при котором доступна примерка, составляет 10 вещей. Время на примерку одного заказа – 15 минут.
        </p>
      </li>
    </ul>
    <p class="page-delivery__desc">
      Мы свяжемся с вами, чтобы подтвердить дату и время доставки. Кроме того, вы будете получать уведомления по электронной почте и SMS с информацией о номере заказа, его стоимости, а также с информацией о том, что заказ готов к выдаче. В день доставки заказа мы отправим вам SMS-уведомлениес номером телефона сотрудника службы доставки.
    </p>
    <a class="page-delivery__button button" href="/">Продолжить покупки</a>
  </section>
</main>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/include/footer.php') ?>