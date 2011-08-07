<?php

define('CONSOLE_REQUEST', true);
require('public/index.php');

$application->bootstrap();

$map = new Application_Model_Map();
$map->regenerate();
