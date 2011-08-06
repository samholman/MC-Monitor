<?php

define('CONSOLE_REQUEST', true);
require('public/index.php');

$application->bootstrap();

$server = new Application_Model_Map();
$server->regenerate();
