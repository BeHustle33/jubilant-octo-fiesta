<?php

set_time_limit(3600);
$show_table = false;

require_once ('include/core.php');

if (isset($_POST['submit_btn'])) {
    try {
        if (empty($_POST['date_from'])) {
            throw new Exception('Не выбрана дата начала периода');
        }
        if (empty($_POST['date_to'])) {
            throw new Exception('Не выбрана дата окончания периода');
        }
        if (empty($_POST['salon'])) {
            throw new Exception('Нужно выбрать хотя бы один салон');
        }
        if (empty($_POST['channel'])) {
            throw new Exception('Нужно выбрать хотя бы один источник рекламы');
        }
        define ('DATE_FROM', htmlspecialchars($_POST['date_from']) . ' 00:00:00');
        define ('DATE_TO', htmlspecialchars($_POST['date_to']) . ' 23:59:59');
        define('SALON', $_POST['salon']);
        define('CHANNEL', $_POST['channel']);
        $show_table = true;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

if ($show_table && isset($_POST['type_report'])) {
    $report = getReport($_POST['type_report']);
}

?>
<html>
<head>
    <meta charset="utf-8" />
    <title>Сквозная аналитика</title>
    <link rel="stylesheet" href="css/bootstrap-3.3.2.min.css" type="text/css"/>
    <script type="text/javascript" src="js/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-3.3.2.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css"/>
</head>
<body>
<h1 style="margin: 15px">Сквозная аналитика</h1>
<form action="index.php" method="post" style="padding: 15px">
    <p><span style="margin: 10px">Выберите период</span>
        <div style="margin: 10px">
            <label for="date_from" style="font-weight: normal" >Начало</label>
            <input type="date" name="date_from" id="date_from" required value="<?= htmlspecialchars($_POST['date_from']) ?>">
            <label for="date_to" style="font-weight: normal">Конец</label>
            <input type="date" name="date_to" id="date_to" required value="<?= htmlspecialchars($_POST['date_to']) ?>">
    </div>
    <p><span style="margin: 10px"><label for="salon_choose" style="font-weight: normal">Выберите салон</label></span>

        <span style="margin: 30px"><label for="channel_choose" style="font-weight: normal">Выберите канал</label></span></p>
    <div style="margin: 10px">
    <select id="salon_choose" multiple="multiple" name="salon[]">
        <option value="tepliy_stan">Теплый стан</option>
        <option value="himki">Химки</option>
        <option value="belyaevo">Беляево</option>
        <option value="city">Сити</option>
        <option value="pyatnickaya">Пятницкая</option>
        <option value="galereya">Галерея</option>
        <option value="rumyantsevo">Румянцево</option>
        <option value="imperiya">Империя</option>
        <option value="kashirka">Каширка</option>
    </select>
        <span style="margin:10px"></span>
    <select id="channel_choose" multiple="multiple" name="channel[]">
        <option value="lending">Лендинг</option>
        <option value="promo">Promo</option>
        <option value="yandex_maps">Yandex & Google карты</option>
        <option value="leed_form_promo">Лид формы c PROMO</option>
        <option value="leed_form_lending">Лид формы c Лендинга</option>
        <!--option value="google_maps">Google карты</option-->
        <!--option value="persona_city">Persona-city.ru</option-->
    </select>
        <br><br>
        <span>Выберите тип отчета: &nbsp;</span>
    <input type="radio" name="type_report" id="consolidated" value="consolidated" checked>
        <label for="consolidated" style="margin:10px">Сводный</label>
    <input type="radio" name="type_report" id="detailed" value="detailed">
        <label for="detailed" style="margin:10px">Подробный</label>
    <input type="submit" value="Получить значения" name="submit_btn" style="margin-left: 15">
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function() {
        $('#salon_choose').multiselect({
            includeSelectAllOption: true
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#channel_choose').multiselect({
            includeSelectAllOption: true
        });
    });
</script>
<script type="text/javascript">
    var tableToExcel = (function() {
        var uri = 'data:application/vnd.ms-excel;base64,'
            , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
            , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
            , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
        return function(table, name) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
            window.location.href = uri + base64(format(template, ctx))
        }
    })()
</script>
<?php if (isset($error)) : ?>
<p class="error"><?= $error ?></p>
<?php endif ?>
<!-- подробный отчет -->
<?php if ($show_table && $_POST['type_report'] == 'detailed') : ?>
    <h2 style="margin: 15px">Подробный отчет</h2>
    <span style="margin: 15px; font-weight: bold">С <?= dateFormat(DATE_FROM) .' - '. dateFormat(DATE_TO) ?></span>
    <table border="1" style="margin: 15px" id="testTable">
    <tr>
        <th>Салон</th>
        <th>Канал</th>
        <th>Номер клиента</th>
        <th>Статус клиента</th>
        <th>Сумма</th>
        <th>Услуг</th>
        <th>Визитов</th>
        <th>Звонков</th>
    </tr>
    <?php foreach ($report as $client) : ?>
    <tr>
        <td><?= transliterate($client['salon']) ?></td>
        <td><?= transliterate($client['channel']) ?></td>
        <td><?= $client['phone'] ?></td>
        <td><?= $client['status'] ?></td>
        <td><?= $client['sum_services'] ?></td>
        <td><?= $client['count_services'] ?></td>
        <td><?= $client['count_visits'] ?></td>
        <td><?= $client['count_calls'] ?></td>
    </tr>
    <?php endforeach ?>
    </table>
<input type="button" onclick="tableToExcel('testTable', '<?= dateFormat(DATE_FROM) .'-'. dateFormat(DATE_TO) ?>')" value="Export to Excel" style="margin: 15px">
<?php endif ?>
<!-- подробный отчет -->

<!-- сводный отчет -->
<?php if ($show_table && $_POST['type_report'] == 'consolidated') : ?>
    <h2 style="margin: 15px">Сводный отчет</h2>
    <span style="margin: 15px; font-weight: bold">С <?= dateFormat(DATE_FROM) . ' по ' . dateFormat(DATE_TO) ?></span>
    <table border="1" style="margin: 15px" id="testTable">
    <tr><td colspan="16" style="text-align: center"><b><?= dateFormat(DATE_FROM) .' - '. dateFormat(DATE_TO) ?></b></td></tr>
    <tr><td colspan="16">&nbsp;</td></tr>
<tr>
    <th>Канал</th>
    <th>ЦД</th>
    <th>Услуг</th>
    <th>Визитов</th>
    <th>Затраты</th>
    <th>Выручка</th>
    <th>Конверсия</th>
    <th>Средний чек</th>
    <th>Перв</th>
    <th>Пост</th>
    <th>Редк</th>
    <th>Потер</th>
    <th>$ Перв</th>
    <th>$ Пост</th>
    <th>$ Редк</th>
    <th>$ Потер</th>
</tr>
<?php
    $total = [];
    foreach ($report as $key => $salon) {
    $current = []; ?>
    <tr><td colspan="16" style="text-align: center"><b>#<?= transliterate($key) ?></b></td></tr>
    <?php foreach ($salon as $channel) : ?>
        <tr>
        <td><?= transliterate($channel['channel']) ?></td>
        <td><?= $channel['target_actions'] ?></td>
        <td><?= $channel['count_services'] ?></td>
        <td><?= $channel['count_visits'] ?></td>
        <td><?= $channel['expenses'] ?></td>
        <td><?= $channel['revenue'] ?></td>
        <td><?= $channel['conversion'] ?></td>
        <td><?= round($channel['revenue'] / $channel['count_services']) ?></td>
        <td><?= $channel['count_first'] ?></td>
        <td><?= $channel['count_constant'] ?></td>
        <td><?= $channel['count_rare'] ?></td>
        <td><?= $channel['count_lost'] ?></td>
        <td><?= $channel['revenue_first'] ?></td>
        <td><?= $channel['revenue_constant'] ?></td>
        <td><?= $channel['revenue_rare'] ?></td>
        <td><?= $channel['revenue_lost'] ?></td>
        </tr>
    <?php
        //итого для салона
        $current['target_actions'] += $channel['target_actions'];
        $current['count_services'] += $channel['count_services'];
        $current['count_visits'] += $channel['count_visits'];
        $current['expenses'] += $channel['expenses'];
        $current['revenue'] += $channel['revenue'];
        $current['conversion'] += $channel['conversion'];
        $current['count_first'] += $channel['count_first'];
        $current['count_constant'] += $channel['count_constant'];
        $current['count_rare'] += $channel['count_rare'];
        $current['count_lost'] += $channel['count_lost'];
        $current['revenue_first'] += $channel['revenue_first'];
        $current['revenue_constant'] += $channel['revenue_constant'];
        $current['revenue_rare'] += $channel['revenue_rare'];
        $current['revenue_lost'] += $channel['revenue_lost'];
        //итого для всех салонов
        $total['target_actions'] += $channel['target_actions'];
        $total['count_services'] += $channel['count_services'];
        $total['count_visits'] += $channel['count_visits'];
        $total['expenses'] += $channel['expenses'];
        $total['revenue'] += $channel['revenue'];
        $total['conversion'] += $channel['conversion'];
        $total['count_first'] += $channel['count_first'];
        $total['count_constant'] += $channel['count_constant'];
        $total['count_rare'] += $channel['count_rare'];
        $total['count_lost'] += $channel['count_lost'];
        $total['revenue_first'] += $channel['revenue_first'];
        $total['revenue_constant'] += $channel['revenue_constant'];
        $total['revenue_rare'] += $channel['revenue_rare'];
        $total['revenue_lost'] += $channel['revenue_lost'];
    endforeach; ?>
    <tr>
        <td><b>Итого: </b></td>
        <td><b><?= $current['target_actions'] ?></b></td>
        <td><b><?= $current['count_services'] ?></b></td>
        <td><b><?= $current['count_visits'] ?></b></td>
        <td><b><?= $current['expenses'] ?></b></td>
        <td><b><?= $current['revenue'] ?></b></td>
        <td><b><?= $current['conversion'] ?></b></td>
        <td><b><?= round($current['revenue'] / $current['count_services']) ?></b></td>
        <td><b><?= $current['count_first'] ?></b></td>
        <td><b><?= $current['count_constant'] ?></b></td>
        <td><b><?= $current['count_rare'] ?></b></td>
        <td><b><?= $current['count_lost'] ?></b></td>
        <td><b><?= $current['revenue_first'] ?></b></td>
        <td><b><?= $current['revenue_constant'] ?></b></td>
        <td><b><?= $current['revenue_rare'] ?></b></td>
        <td><b><?= $current['revenue_lost'] ?></b></td>
    </tr>
<?php } ?>
    <tr><td colspan="16">&nbsp;</td></tr>
    <tr><td colspan="16" style="text-align: center"><b>#Общий итог</b></td></tr>
     <tr>
         <td><b>Итого: </b></td>
         <td><b><?= $total['target_actions'] ?></b></td>
         <td><b><?= $total['count_services'] ?></b></td>
         <td><b><?= $total['count_visits'] ?></b></td>
         <td><b><?= $total['expenses'] ?></b></td>
         <td><b><?= $total['revenue'] ?></b></td>
         <td><b><?= $total['conversion'] ?></b></td>
         <td><b><?= round($total['revenue'] / $total['count_services']) ?></b></td>
         <td><b><?= $total['count_first'] ?></b></td>
         <td><b><?= $total['count_constant'] ?></b></td>
         <td><b><?= $total['count_rare'] ?></b></td>
         <td><b><?= $total['count_lost'] ?></b></td>
         <td><b><?= $total['revenue_first'] ?></b></td>
         <td><b><?= $total['revenue_constant'] ?></b></td>
         <td><b><?= $total['revenue_rare'] ?></b></td>
         <td><b><?= $total['revenue_lost'] ?></b></td>
     </tr>
</table>
<input type="button" onclick="tableToExcel('testTable', '<?= dateFormat(DATE_FROM) .'-'. dateFormat(DATE_TO) ?>')" value="Export to Excel" style="margin: 15px">
<?php endif ?>
<!-- сводный отчет -->

</body>
</html>