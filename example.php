<?php

use BertMaurau\Serene\Config\AppConfig AS AppConfig;

require_once __DIR__ . '/src/BertMaurau/Serene/Config/AppConfig.php';

// load the config file
AppConfig::load(__DIR__ . '/example.config.json');

// get a nested setting (nodes are case sensitive)
echo AppConfig::setting('server.database.host');

try {
    // get an undefined setting
    echo AppConfig::setting('server.mail.host');
} catch (Exception $ex) {
    echo $ex -> getMessage();
}


// reload the configuration from file
AppConfig::reload();
