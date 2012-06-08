<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


$app = new Silex\Application();

$app['debug'] = true;
$app['config'] = require_once __DIR__.'/../config.php';

$app->get('/', function() { 
    return 'Hello!';
}); 

$app->get('/1/check', function(Request $request) use ($app) {
    $since = (int) $request->get('since');
    $spotify_user_id = $request->get('user');

    // test tracks
    return $app->json(array(
        array('id' => 'spotify:track:6JEK0CvvjDjjMUBFoXShNZ'),
        array('id' => 'spotify:track:5LJN5trTe8v9XRLvqi9SUl'),
        array('id' => 'spotify:track:5Xz0M0zDEanLfXdAgzOXvJ'),
        array('id' => 'spotify:track:7sDZGHKFGRI82AwpdpFRrl'),
        array('id' => 'BROKEN!'),
        array('id' => 'spotify:track:3KWTRlId9U5SHNh56Ds1gz'),
    ));
}); 


$app->get('/1/now-playing', function(Request $request) use ($app) {
    $since = (int) $request->get('since');
    $spotify_user_id = $request->get('user');

    // test tracks
    return $app->json(array(
        'title'   => 'Hakuna Matata',
        'artist'  => 'Disney',
        'seconds' => '180',
    ));
}); 

$app->get('/1/upcoming', function(Request $request) use ($app) {
    $since = (int) $request->get('since');
    $spotify_user_id = $request->get('user');

    // test tracks
    return $app->json(array(
        array(
            'title'   => 'Circle of Life',
            'artist'  => 'Disney',
            'seconds' => '150',
        ),
        array(
            'title'   => 'Prodigy',
            'artist'  => 'Fire Starter',
            'seconds' => '240',
        ),
    ));
}); 


$app->get('/1/history', function(Request $request) use ($app) {
    $since = (int) $request->get('since');
    $spotify_user_id = $request->get('user');

    // test tracks
    return $app->json(array(
        array(
            'title'   => 'Circle of Life',
            'artist'  => 'Disney',
            'seconds' => '150',
        ),
        array(
            'title'   => 'Prodigy',
            'artist'  => 'Fire Starter',
            'seconds' => '240',
        ),
    ));
}); 


$app->get('/1/stats', function(Request $request) use ($app) {
    $since = (int) $request->get('since');
    $spotify_user_id = $request->get('user');

    // test tracks
    return $app->json(array(
        'tweets'   => '9999',
        'played'  => '5',
    ));
}); 


$app->run();
