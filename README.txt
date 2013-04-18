Base FM
=======

Turn tweets into music! This is an unfinished work-in-progress.

If you have Spotify, you can see the playlist that's being generated here: http://open.spotify.com/user/tomquay/playlist/6USVr60XeYrtYVs8xIe7il

Screenshot of current playlist: http://i.imgur.com/oi2xa.png

You can see what's currently being played by following @wearebasefm on Twitter: http://twitter.com/wearebasefm

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

Uses Silex framework.

Requires:

* PHP 5.3
* Apache with mod-rewrite (or nginx)
* A database (eg MySQL)
* Access to set up cron tasks (or an F5 key)

Installation:

1. Copy config.sample.php to config.php
2. Edit config.php
3. Set up cron: "* * * * * curl http://api.wearebase.com/music/1/get-tweets > /dev/null"

API:

Currently only JSON

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


License
-------

Released under the MIT license

Copyright 2013 Base and other contributors
http://wearebase.com/

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
