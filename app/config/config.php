<?php

require_once dirname(dirname(__FILE__)) . '/helpers/Env.php';
Env::load(dirname(dirname(dirname(__FILE__))) . '/.env');

define('APPROOT', dirname(dirname(__FILE__)));

define('URLROOT', getenv('URLROOT') ?: 'http://localhost');

define('SITENAME', getenv('SITENAME') ?: 'Luam Candles');

define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'luamcandle');

date_default_timezone_set(getenv('TIMEZONE') ?: 'UTC');

define('PAYPAL_API_KEY', getenv('PAYPAL_API_KEY'));
define('FONT_AWESOME_KIT', getenv('FONT_AWESOME_KIT'));
