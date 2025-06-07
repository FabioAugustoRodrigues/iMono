<?php

use app\cache\CacheFacade;

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

# ERROR REPORTING
ini_set("error_log", __DIR__ . '/../../storage/logs/error_logs.log');

# DATABASE CONFIGS
define("DB_DRIVER", $_ENV['DB_DRIVER']);
define("DB_HOST", $_ENV['DB_HOST']);
define("DB_USER", $_ENV['DB_USER']);
define("DB_PASS", $_ENV['DB_PASS']);
define("DB_NAME", $_ENV['DB_NAME']);

# CACHE CONFIGS
CacheFacade::setCacheType(
    $_ENV['CACHE_TYPE']
);