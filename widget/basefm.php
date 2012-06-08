<?php
/*
Plugin Name: Base FM
Plugin URI: http://fm.wearebase.com/
Description: Base FM
Author: Base Creative Agency
Version: 0.1
Author URI: http://www.basecreativeagency.com
*/

define('BASEFM_API_URL', 'http://fm.wearebase.com/api/');
define('BASEFM_API_VERSION', '1');

function basefm_request($query) {
    $url = BASEFM_API_URL . BASEFM_API_VERSION . '/' . $query;
    return json_decode(file_get_contents($url));
}

function basefm_now_playing() {
    return basefm_request('now-playing');
}

function basefm_upcoming() {
    return basefm_request('upcoming');
}

function basefm_history() {
    return basefm_request('history');
}

function basefm_stats() {
    return basefm_request('stats');
}

add_action('before_content', function() {
    echo '<h2>now playing</h2>';
    print_r(basefm_now_playing());

    echo '<h2>upcoming</h2>';
    print_r(basefm_upcoming());
});


