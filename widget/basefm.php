<?php
/*
Plugin Name: Base FM
Plugin URI: http://fm.wearebase.com/
Description: Base FM
Author: Base Creative Agency
Version: 0.1
Author URI: http://www.basecreativeagency.com
*/

if (!defined('ABSPATH')) {
    // not in WP, for testing
    function get_option($k) {
        $opts = array(
            //'base-fm-url' => 'http://api.wearebase.com/',
            'base-fm-url' => 'http://basefm-api.dh.devba.se/',
            'base-fm-user' => 'test',
        );
        return $opts[$k];
    }
    function add_action($hook, $cb) {$cb();}
}

define('BASEFM_API_VERSION', '1');
define('BASEFM_API_URL', get_option('base-fm-url'));
define('BASEFM_USER', get_option('base-fm-user'));



function basefm_request($query, $options='') {
    $url = BASEFM_API_URL . BASEFM_API_VERSION . 
        '/' . $query . '?user=' .BASEFM_USER;
    $url = $options ? $url . '&' . $options : $url;
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

function basefm_stats($since) {
    return basefm_request('stats', 'since=' . $since);
}

add_action('before_content', function() {
    echo '<h2>now playing</h2>';
    print_r(basefm_now_playing());

    echo '<h2>upcoming</h2>';
    print_r(basefm_upcoming());

    echo '<h2>history</h2>';
    print_r(basefm_history());

    echo '<h2>stats</h2>';
    print_r(basefm_stats(strtotime('yesterday')));
});


