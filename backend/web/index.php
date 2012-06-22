<?php

use Basefm\ApiV1;
use Basefm\TweetRepository;
use Basefm\NowPlayingRepository;

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
    $app['dbh']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

    $app['tweet-repository'] = new TweetRepository($app['dbh']);
    $app['nowplaying-repository'] = new NowPlayingRepository($app['dbh']);
});



$app->get('/', function() { 
    return 'Hello!';
}); 

// v1 of the api
$app->mount('/1', new ApiV1);



$app->run();
