<?php

//optall
const OPT = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

//asterisk connect
const HOST = 'ip';
const DB   = 'dbase';
const USER = 'login';
const PASS = 'password';
const CHARSET = 'utf8';
const DSN = 'mysql:host=' . HOST. ';dbname=' . DB . ';charset=' . CHARSET;


//sycret connect

const SYCRET_LOGIN = 'login';
const SYCRET_PASSWORD = 'password';

//server promo.persona-city.ru connect
const HOST_PROMO = 'ip';
const DB_PROMO   = 'dbase';
const USER_PROMO = 'user';
const PASS_PROMO = 'password';
const CHARSET_PROMO = 'utf8';
const DSN_PROMO = 'mysql:host=' . HOST_PROMO. ';dbname=' . DB_PROMO . ';charset=' . CHARSET_PROMO;


//local server sycret connect
const SYCRET = [
    'tepliy_stan' => 'firebird:dbname=ip/3050:path_todb.fdb',
    'himki' => 'firebird:dbname=ip/3050:path_todb.fdb',
    'city' => 'firebird:dbname=ip/3050:path_todb.fdb',
    'pyatnickaya' => 'firebird:dbname=ip/3050:path_todb.fdb',
    'galereya' => 'firebird:dbname=ip/3050:path_todb.fdb',
    'rumyantsevo' => 'firebird:dbname=ip/3050:path_todb.fdb',
    'imperiya' => 'firebird:dbname=ip/3050:path_todb.fdb',
    'kashirka' => 'firebird:dbname=ip/3050:path_todb.fdb',
    'belyaevo' => 'firebird:dbname=ip/3050:path_todb.fdb'
];

