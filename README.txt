Base FM
=======

Turn tweets into music!

Tweet format
------------

    @wearebasefm #play "artist - track name" optional message
    

Spotify App
-----------

This is currently hard-coded to our API URL: http://api.wearebase.com/music/1

Usage:

* Be a spotify developer (free). http://developer.spotify.com
* Place in "Spotify" folder in "My Documents" or your user home if on Linux/Mac
* Type spotify:app:base-fm into the Spotify search bar


WordPress Widget
----------------

We haven't really made this yet. You can see the general idea in 
./widget/basefm.php


Backend
-------

Requires:

* PHP 5.3
* Apache with mod-rewrite (or nginx)
* A database (eg MySQL)
* Access to set up cron tasks (or an F5 key)

Installation:

1. Copy config.sample.php to config.php
2. Edit config.php
3. Set up cron: "* * * * * curl http://api.wearebase.com/music/1/get-tweets > /dev/null"


Version 1 API endpoints (http://api.wearebase.com/music/1):

/check?since=<timestamp>
    See if any new tweets have come up since <timestamp>

/now-playing?user=<userid>
    Not implemented. See what's playing now & how many seconds it has left.

/upcoming?user=<userid>
    Not implemented. 

/history?user=<userid>
    Not implemented. 

/stats?user=<userid>&since=<timestamp>
    Not implemented. 
