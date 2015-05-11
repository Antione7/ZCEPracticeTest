<?php

require_once __DIR__.'/../vendor/autoload.php';

use ZCEPracticeTest\Silex\ZCEAppDev;

$app = new ZCEAppDev(array(
    'project.root' => dirname(__DIR__),
));

$app->run();
