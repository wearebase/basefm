<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;
$app['config'] = require_once __DIR__.'/../config.php';

$app->get('/', function() { 
    return 'Hello!';
}); 

$app->get('/1/{query}', function($query) { 
    return 'this is where the api will be';
}); 

$app->run();
