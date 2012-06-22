<?php

namespace Basefm;

use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class ApiV1 implements ControllerProviderInterface {


    public function connect(Application $app)
    {
        //return new ApiV1ControllerCollection($app);
        return $this->api($app);
    }

    public function api(Application $app)
    {

        $apiv1 = new ControllerCollection();

        $apiv1->get('/', function () { return 'v1'; });


        // check if there's new tracks to add to playlist
        $apiv1->get('/check', function(Request $request) use ($app) {
            $since = (int) $request->get('since') ?: time() - 7200;
            $spotify_user_id = $request->get('user');

            $tweets = $app['tweet-repository']->getAllSince($since);

            $tweets = array_map(function($tweet) {
                $tweet['text'] = preg_replace('/^[^"]*"/', '', $tweet['tweet']);
                $tweet['text'] = preg_replace('/".*/', '', $tweet['text']);
                return $tweet;
            }, $tweets);

            return new JsonResponse($tweets);

            // test tracks
            return new JsonResponse(array(
                array('id' => 'spotify:track:6JEK0CvvjDjjMUBFoXShNZ'),
                array('id' => 'spotify:track:5LJN5trTe8v9XRLvqi9SUl'),
                array('id' => 'spotify:track:5Xz0M0zDEanLfXdAgzOXvJ'),
                array('id' => 'spotify:track:7sDZGHKFGRI82AwpdpFRrl'),
                array('id' => 'BROKEN!'),
                array('id' => 'spotify:track:3KWTRlId9U5SHNh56Ds1gz'),
            ));

            // todo: look in db for new tracks since $since
        }); 



        // tell the server what's being played
        // todo: add to db, maybe search for the tweet it corresponds to
        $apiv1->post('/currently-playing', function(Request $request) use ($apiv1) {
            $since           = (int) $request->post('since');
            $spotify_user_id = $request->post('user');
            $track_data      = $request->post('track');

            return new JsonResponse(true);
        }); 



        $apiv1->get('/now-playing', function(Request $request) use ($apiv1) {
            $spotify_user_id = $request->get('user');

            // test tracks
            return new JsonResponse(array(
                'title'   => 'Hakuna Matata',
                'artist'  => 'Disney',
                'seconds' => '180',
            ));
        }); 

        $apiv1->get('/upcoming', function(Request $request) use ($apiv1) {
            $since = (int) $request->get('since');
            $spotify_user_id = $request->get('user');

            // test tracks
            return new JsonResponse(array(
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


        $apiv1->get('/history', function(Request $request) use ($apiv1) {
            $since = (int) $request->get('since');
            $spotify_user_id = $request->get('user');

            // test tracks
            return new JsonResponse(array(
                array(
                    'title'   => 'King of Pride Rock',
                    'artist'  => 'Disney',
                    'seconds' => '150',
                ),
                array(
                    'title'   => 'Supercalifragilisticexpialidocious',
                    'artist'  => 'Mary Poppins',
                    'seconds' => '240',
                ),
            ));
        }); 


        $apiv1->get('/stats', function(Request $request) use ($apiv1) {
            $since = (int) $request->get('since');
            $spotify_user_id = $request->get('user');

            // test tracks
            return new JsonResponse(array(
                'tweets'   => '9999',
                'played'  => '5',
            ));
        }); 

        $apiv1->get('/get-tweets', function(Request $request) use ($app) {
            $queries = $app['config']['twitter_searches'];

            $tweets = array();

            foreach ($queries as $query) {
                $url = 'http://search.twitter.com/search.json?' . http_build_query(array(
                    'result_type' => 'recent',
                    'q' => $query,
                ));
                $response = json_decode(file_get_contents($url));
                $tweets = array_merge($tweets, $response->results);        
            }

            $response = array();

            $added = 0;

            foreach ($tweets as $tweet) {
                if ($app['tweet-repository']->add($tweet)) {
                    $added++;
                }
            }

            return 'Added ' . $added . ' tweets';

            // todo: add tweets to db if they've not been added

            // maybe: tweet back at user

            // tweet message
            // tweet id
            // user
            // timestamp
            // track details
            // played?


            return new JsonResponse($response);
        }); 

        return $apiv1;
    }

}


