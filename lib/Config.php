<?php

define ('SERVER_NAME_PRODUCTION' , 'www.ameyoko.net');
define("DB_CONNECT_STRING_PROD", "host=/var/run/postgresql port=5432 dbname=ameyoko user=ameyoko");
define("DB_CONNECT_STRING_DEV",  "host=/var/run/postgresql port=5432 dbname=ameyoko-dev user=ameyoko");
define("_URL_", ( $_SERVER['HTTPS'] ? 'https' : 'http' ) . '://' . $_SERVER['SERVER_NAME'] . '/');
//ショップステータス
define("SHOP_STATUS_OPEN", '1');        //ショップステータス_オープン
define("SHOP_STATUS_CLOSE", '2');      //ショップステータス_クローズ
?>