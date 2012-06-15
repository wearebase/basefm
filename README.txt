Base FM
=======

Tweet format
------------

    @wearebasefm #play "artist - track name" optional message
    #wearebasefm #play "artist - track name" optional message
    #wearebasefm #play "artist - track name" optional message
    #wearebasefm #play spotify:track:sometrackid
    #wearebasefm "artist - track name" http://j.mp/base-fm

Spotify App
-----------


WordPress Widget
----------------


Backend
-------

Requires:

* PHP 5.3
* Apache with mod-rewrite
* A database (eg MySQL)
* Access to set up cron tasks

Installation:

1. Copy config.sample.php to config.php
2. Edit config.php
3. Set up cron

Version 1 API endpoints (http://api.wearebase.com/1)

/check?user=<userid>&since=<timestamp>
/now-playing?user=<userid>
/upcoming?user=<userid>
/history?user=<userid>
/stats?user=<userid>&since=<timestamp>
