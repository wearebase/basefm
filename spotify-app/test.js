
var last_check = null,
    poll_time = 10 * 1000,
    api_url = 'http://fm.wearebase.com/api/1/check';


setInterval(function() {
    var url = api_url + '?&user=' . SPOTIFY.GET_USER() . 'since' = (new Date).getTime();
    $.getJSON(api_url, function(data) {
        for (var i in data)) {
            var track_id  data[i].id;
            SPOTIFY.ADD_TRACK_TO_NOW_PLAYING(track_id);
        }
    });

}, poll_time);
