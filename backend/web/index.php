<?php

use Basefm\ApiV1;
use Basefm\TweetRepository;

$loader = require_once __DIR__.'/../vendor/autoload.php';
//require_once __DIR__.'/../src/Basefm/Api.php';


$loader->add('Basefm', __DIR__.'/../src/Basefm/');
// TODO: move to controller bundles

$app = new Silex\Application();


$app['config'] = require_once __DIR__.'/../config.php';
$app['debug'] = $app['config']['debug'];

$app['dbh'] = null;

$app->before(function () use ($app) {
    $db = $app['config']['db'];
    $app['dbh'] = new PDO($db['dsn'], $db['user'], $db['password']);
    
    $app['tweet-repository'] = new TweetRepository($db);
});

// $app->register(new Acme\DatabaseServiceProvider(), array(
//     'database.dsn'      => 'mysql:host=localhost;dbname=myapp',
//     'database.user'     => 'root',
//     'database.password' => 'secret_root_password',
// ));


$app->get('/', function() { 
    return 'Hello!';
}); 

// v1 of the api
$app->mount('/1', new ApiV1);



$app->run();
