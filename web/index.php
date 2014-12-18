<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../app/AppDev.php';

ini_set('display_errors', '1');

$app = new AppDev(array(
    'project.root' => dirname(__DIR__),
));

$app->run();
