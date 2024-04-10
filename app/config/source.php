<?php

use app\cache\CacheFacade;

require_once __DIR__ . '/../../vendor/autoload.php';

# DATABASE CONFIGS
define("DB_DRIVER", "db_driver");
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "root");
define("DB_NAME", "name");

# CACHE CONFIGS
CacheFacade::setCacheType(
    "array"
);