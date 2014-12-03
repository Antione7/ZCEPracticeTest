<?php

require_once __DIR__.'/../vendor/autoload.php';

use ZCEPracticeTest\Silex\ZCEAppDev;

ini_set('display_errors', '1');

$app = new ZCEAppDev();

$app->run();
