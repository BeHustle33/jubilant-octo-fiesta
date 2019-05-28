<?php

use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;

require_once  'vendor/autoload.php';
require_once ('sources.php');
require_once ('dbconfig.php');

const TIME_TO_RARE = 60 * 60 * 24 * 90;
const TIME_TO_LOOSE = 60 * 60 * 24 * 365;
const SYCRET_OFFSET = 60 * 60 * 24 * 14;

function asteriskConnect()
{
    static $connect;
    if ($connect === null) {
        try {
            $connect = new PDO(DSN, USER, PASS, OPT);
        } catch (PDOException $e) {
            die ('Подключение не удалось' . $e->getMessage());
        }
    }
    return $connect;
}

function promoConnect()
{
    static $connect;
    if ($connect === null) {
        try {
            $connect = new PDO(DSN_PROMO, USER_PROMO, PASS_PROMO, OPT);
        } catch (PDOException $e) {
            die ('Подключение не удалось' . $e->getMessage());
        }
    }
    return $connect;
}

function sycretConnect($salon_name)
{
    static $connect;
    static $salon;
    if ($connect === null || $salon !== $salon_name) {
        try {
            $connect = new PDO(SYCRET[$salon_name], SYCRET_LOGIN, SYCRET_PASSWORD, OPT);
            $salon = $salon_name;
        } catch (PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }
    }
    return $connect;
}

function getClientNumbers($did){
    $place_holders = implode(',', array_fill(0, count($did), '?'));
    $stmt = asteriskConnect()->prepare("SELECT src, did, MIN(calldate) as calldate FROM cdr 
    WHERE calldate >= ? AND calldate <= ? AND did IN ($place_holders) AND LENGTH(src) > 11 GROUP BY src;");
    $array[] = DATE_FROM;
    $array[] = DATE_TO;
    foreach ($did as $value) {
        $array[] = $value;
    }
    $stmt->execute($array);
    return $stmt;
}

function getSumCountByNumbers($salon_name, $numbers)
{
    $place_holders = implode(',', array_fill(0, count($numbers), '?'));
    $stmt = sycretConnect($salon_name)->prepare
    ("SELECT c.CELLPHONE as CELLPHONE, SUM(a.PAYMENT) as SUM_SERVICES, COUNT(a.PAYMENT) as COUNT_SERVICES FROM APPOINTMENT as a 
    JOIN client as c ON a.CLIENTID = c.id WHERE c.CELLPHONE IN ($place_holders) 
    AND START_EVENT >= ? AND START_EVENT <= ? AND MANIPULATIONSTATUSID = 3 GROUP BY c.CELLPHONE;");
    foreach ($numbers as $value) {
        $array[] = $value;
    }
    $array[] = DATE_FROM;
    $array[] = sycretOffset(DATE_TO);
    $stmt->execute($array);
    return $stmt;
}

function getClientStatus($salon_name, $number)
{
    $client_status_phone = sycretConnect($salon_name)->prepare
    ("SELECT MAX(a.START_EVENT) AS LAST_VISIT FROM appointment as a 
    JOIN client as c ON a.clientid = c.id WHERE c.CELLPHONE = :cellphone 
    AND START_EVENT < :date_from AND MANIPULATIONSTATUSID = 3;");
    $client_status_phone->execute(['cellphone' => $number, 'date_from' => DATE_FROM]);
    $client_status = $client_status_phone->fetch();
    if ($client_status['LAST_VISIT']) {
            $last_visit = strtotime($client_status['LAST_VISIT']);
            if ($last_visit > time() - TIME_TO_RARE) {
                $status = 'Постоянный';
            } elseif ($last_visit < time() - TIME_TO_RARE && $last_visit > time() - TIME_TO_LOOSE) {
                $status = 'Редкий';
            } else {
                $status = 'Потерянный';
            }
        } else {
            $status = 'Первичный';
        }
    return $status;
}

function getCountVisitsByPhone($salon_name, $number)
{
    $client_count_visits = sycretConnect($salon_name)->prepare
    ('SELECT a.START_EVENT as VISITS FROM APPOINTMENT as a JOIN client as c ON a.CLIENTID = c.id
    WHERE c.CELLPHONE = :cellphone AND a.START_EVENT >= :date_from AND START_EVENT <= :date_to AND MANIPULATIONSTATUSID = 3');
    $client_count_visits->execute(['cellphone' => $number, 'date_from' => DATE_FROM, 'date_to' => sycretOffset(DATE_TO)]);
    foreach ($client_count_visits as $visit) {
        $visits_array[] = mb_strimwidth($visit['VISITS'], 0, 10);
    };
    $visits_array = array_unique($visits_array);
    return count($visits_array);
}

function getCountCallsByPhone($phone)
{
    $count_calls = asteriskConnect()->prepare
    ("SELECT COUNT(src) as user_calls FROM cdr WHERE calldate >= :date_from AND calldate <= :date_to AND src= :src AND disposition = 'ANSWERED' AND LENGTH(src) > 11 GROUP BY src;");
    $count_calls->execute(['src' => '+7' . $phone, 'date_from' => DATE_FROM, 'date_to' => DATE_TO]);
    $count = $count_calls->fetch();
    return $count['user_calls'] ? $count['user_calls'] : 1;
}

function transliterate($input){
    switch ($input) {
        case 'tepliy_stan':
            return 'Теплый стан';
        case 'himki':
            return 'Химки';
        case 'belyaevo':
            return 'Беляево';
        case 'city':
            return 'Сити';
        case 'pyatnickaya':
            return 'Пятницкая';
        case 'galereya':
            return 'Галерея';
        case 'rumyantsevo':
            return 'Румянцево';
        case 'imperiya':
            return 'Империя';
        case 'kashirka':
            return 'Каширка';
        case 'lending':
            return 'Лендинг';
        case 'promo':
            return 'Промо';
        case 'yandex_maps':
            return 'Карты';
        case 'leed_form_lending':
            return 'Лид формы лендинг';
		case 'leed_form_promo':
            return 'Лид формы Promo';	
        default:
            return $input;
    }
}

function dateFormat($date_str)
{
    $time = strtotime($date_str);
    return date('d.m.Y', $time);
}

function getNumbersFromGSheets($salon_name)
{
    putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/mysecret.json');
    /*  SEND TO GOOGLE SHEETS */
    $client = new Google_Client;
    try{
        $client->useApplicationDefaultCredentials();
        $client->setApplicationName("Something to do with my representatives");
        $client->setScopes(['https://www.googleapis.com/auth/drive','https://spreadsheets.google.com/feeds']);
        if ($client->isAccessTokenExpired()) {
            $client->refreshTokenWithAssertion();
        }
        $accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];
        ServiceRequestFactory::setInstance(
            new DefaultServiceRequest($accessToken)
        );
        // Get our spreadsheet
        $spreadsheet = (new Google\Spreadsheet\SpreadsheetService)
            ->getSpreadsheetFeed()
            ->getByTitle(GOOGLE_SHEETS[$salon_name]);
        // Get the first worksheet (tab)
        $worksheets = $spreadsheet->getWorksheetFeed()->getEntries();
        $worksheet = $worksheets[0];
        $listFeed = $worksheet->getListFeed();
        $values = [];
        $numbers = [];
        foreach ($listFeed->getEntries() as $entry) {
            $values[] = $entry->getValues();
        }
        foreach ($values as $value) {
            if (strtotime($value['sended']) > strtotime(DATE_FROM) && strtotime($value['sended']) < strtotime(DATE_TO)) {
                $numbers[] = [
                    'src' => formatToAsterisk($value['phone']),
                    'calldate' => $value['sended']
                ];
            }
        }
        return $numbers;
    }catch(Exception $e){
        die ($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile() . ' ' . $e->getCode);
    }
}

function formatToAsterisk($number)
{
    $chars = [' ', ')', '(', '-'];
    return (str_replace($chars, '', $number));
}

function getNumbersFromDBPromo($salon_name)
{
    $stmt = promoConnect()->prepare('SELECT tel, created FROM leads 
    WHERE created >= :date_from AND created <= :date_to AND salon = :salon;');
    $stmt->execute(['date_from' => DATE_FROM, 'date_to' => DATE_TO, 'salon' => PROMO[$salon_name]]);
    $numbers = [];
    foreach ($stmt as $value) {
        $numbers[] = [
            'src' => formatToAsterisk($value['tel']),
            'calldate' => $value['created']
        ];
    }
    return $numbers;
}

function addNumber($client, $channel_name, $client_numbers)
{
    $key_exists = array_search($client['src'], array_column($client_numbers, 'number'));
    if ($key_exists !== false) {
        if (strtotime($client_numbers[$key_exists]['date']) > strtotime($client['calldate'])) {
            $array = [
                'number' => $client['src'],
                'source' => $channel_name,
                'date' => $client['calldate']
            ];
        }
    } else {
        $array = [
            'number' => $client['src'],
            'source' => $channel_name,
            'date' => $client['calldate']
        ];
    }
    return $array;
}

function sycretOffset($date)
{
	$time = strtotime($date);
	return date('Y-m-d H:m:s', $time + SYCRET_OFFSET);
}

function getReport ($type_report)
{
    $clients = [];
    $report = [];
    foreach (SALON as $salon_name) {
        $client_numbers = [];
        $did = [];
        foreach (CHANNEL as $channel_name) { //получаем массив client_numbers['number'], ['source'], ['date']
            if (in_array($channel_name, array_keys(SOURCES[$salon_name]))) {
                $did[] = SOURCES[$salon_name][$channel_name];
            } elseif ($channel_name == 'leed_form_lending' && in_array($salon_name, array_keys(GOOGLE_SHEETS))) {
                foreach (getNumbersFromGSheets($salon_name) as $client) {
                    $client_numbers[] = addNumber($client, 'leed_form_lending', $client_numbers);
                }
            } elseif ($channel_name == 'leed_form_promo' && in_array($salon_name, array_keys(PROMO))) {

                foreach (getNumbersFromDBPromo($salon_name) as $client) {
                    $client_numbers[] = addNumber($client, 'leed_form_promo', $client_numbers);
                }
            }
        }
        if (!empty($did)) {  //записываем данные из астериска в массив
            foreach (getClientNumbers($did) as $client) {
                $client_numbers[] = addNumber($client, array_search($client['did'], SOURCES[$salon_name]), $client_numbers);
            }
        }
        foreach (CHANNEL as $channel_name) {
            $numbers = [];
            foreach ($client_numbers as $client_number) {
                if ($client_number['source'] == $channel_name) {
                    $numbers[] = substr($client_number['number'], 2);
                }
            }
            if (!empty($numbers)) {
                if ($type_report == 'consolidated') {
                    $report[$salon_name][$channel_name] = [
                        'salon' => $salon_name,  //салон
                        'channel' => $channel_name,  //digital канал
                        'target_actions' => 0,   //количество целевых действий
                        'count_services' => 0,  //количество услуг
                        'count_visits' => 0,  //количество визитов
                        'expenses' => 0,  //расходы
                        'conversion' => 0,  //конверсия
                        'revenue' => 0,  //прибыль
                        'count_first' => 0,  //количество первичных
                        'count_constant' => 0,  //количество постоянных
                        'count_rare' => 0,  //количество редких
                        'count_lost' => 0,  //количество потерянных
                        'revenue_first' => 0,  //выручка по первичным
                        'revenue_constant' => 0,  //выручка по постоянным
                        'revenue_rare' => 0,  //выручка по редким
                        'revenue_lost' => 0,  //выручка по потерянным
                    ];
                    foreach (getSumCountByNumbers($salon_name, $numbers) as $client) {
                        $report[$salon_name][$channel_name]['target_actions'] += getCountCallsByPhone($client['CELLPHONE']);
                        $report[$salon_name][$channel_name]['count_services'] += $client['COUNT_SERVICES'];
                        $report[$salon_name][$channel_name]['count_visits'] += getCountVisitsByPhone($salon_name, $client['CELLPHONE']);
                        $report[$salon_name][$channel_name]['revenue'] += round($client['SUM_SERVICES']);
                        switch (getClientStatus($salon_name, $client['CELLPHONE'])) {
                            case 'Первичный':
                                $report[$salon_name][$channel_name]['count_first']++;
                                $report[$salon_name][$channel_name]['revenue_first'] += $client['SUM_SERVICES'];
                                break;
                            case 'Постоянный':
                                $report[$salon_name][$channel_name]['count_constant']++;
                                $report[$salon_name][$channel_name]['revenue_constant'] += $client['SUM_SERVICES'];
                                break;
                            case 'Редкий':
                                $report[$salon_name][$channel_name]['count_rare']++;
                                $report[$salon_name][$channel_name]['revenue_rare'] += $client['SUM_SERVICES'];
                                break;
                            case 'Потерянный':
                                $report[$salon_name][$channel_name]['count_lost']++;
                                $report[$salon_name][$channel_name]['revenue_lost'] += $client['SUM_SERVICES'];
                                break;
                        }
                    }
                    if ($report[$salon_name][$channel_name]['revenue'] == 0) {
                        unset ($report[$salon_name][$channel_name]);
                    }
                }
                if ($type_report == 'detailed') {
                    foreach (getSumCountByNumbers($salon_name, $numbers) as $client) {
                        $clients[] = [
                            'salon' => $salon_name,
                            'channel' => $channel_name,
                            'phone' => $client['CELLPHONE'],
                            'sum_services' => round($client['SUM_SERVICES']),
                            'count_services' => $client['COUNT_SERVICES'],
                            'count_visits' => getCountVisitsByPhone($salon_name, $client['CELLPHONE']),
                            'status' => getClientStatus($salon_name, $client['CELLPHONE']),
                            'count_calls' => getCountCallsByPhone($client['CELLPHONE'])
                        ];
                    }
                }
            }
        }
    }
    return ($type_report == 'detailed') ? $clients : $report;
}