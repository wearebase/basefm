var sp = getSpotifyApi(1);
var models = sp.require('sp://import/scripts/api/models');
var player = models.player;
var session = models.session;

var playlist;

var poller;
var tracks = [];

var date = new Date();
var time = date.getTime()/1000 - (24*60*60);

//var playlist = new models.Playlist("FROON: " + date);	
//var api_url = 'http://basefm.dh.devba.se/backend/web/1';
var api_url = 'http://api.wearebase.com/music/1';


function baselog(str) {
	console.log(str);
	jQuery("#baselog").prepend("<br>[" + (new Date().toISOString()) + "] "+str);
}

exports.init = init;

if (localStorage.getItem("playlist")) {
	var playlistname = localStorage.getItem("playlist");
	playlist = models.Playlist.fromURI(playlistname);
	$("#playlistname").text('Got playlist: '+playlistname);
	baselog('Got playlist from sessionStorage: '+playlistname);
}

models.application.observe(models.EVENT.LINKSCHANGED, function() {
	//console.log(models.application.links);

	playlist = models.Playlist.fromURI(models.application.links[0]);
	$("#playlistname").text('Got playlist: '+models.application.links[0]);
	baselog('Got playlist: '+models.application.links[0]);
	localStorage.setItem("playlist", models.application.links[0]);
	baselog('Clearing track cache');
	tracks = [];
	time = date.getTime()/1000 - (24*60*60);
	//console.log(playlist);
});

function init() {

    //updatePageWithTrackDetails();
	
    player.observe(models.EVENT.CHANGE, function (e) {
		//poller = setInterval(poll, poll_time);
        // Only update the page if the track changed
      //  if (e.data.curtrack == true) {
        //    updatePageWithTrackDetails();
			
			//tellTheSite();
       // }
    });
	

}




function searchForURI(track) {
	var URI;
	baselog("Searching for: " + track);
	sp.core.search(track, true, true, {
		onSuccess: function(result) {
		//return the URI of the first track
		URI = result.tracks[0].uri; //grabbing the URI at index 0…
		generatePlaylist(URI);
	}
	});
}

function generatePlaylist(track_id){
	
	//If this is not currently in playlist, add it to playlist
	if( !(jQuery.inArray(track_id, tracks) > -1) ){
		var t = models.Track.fromURI(track_id, function(track) {	
			baselog("Track loaded: " + track.name);
		});
		tracks.push(track_id);
		if (playlist.indexOf(t) === -1) {
			playlist.add(t);
			//console.log(playlist.tracks, playlist.indexOf(t));
		} else {
			baselog("Track already in playlist: " + t.name);
		}
		//updatePageWithTrackDetails();
	} else {
		baselog("Skipping track: " + track.name);

	}

}

//console.log(time);
//jQuery(function($){
	var last_check = null;
    var poll_time = 5 * 1000;
	var user_id = $( '#userfill' ).val();

	function poll() {
		if (!playlist) {
			baselog("No playlist yet");
			
			return;
		}
		
		baselog("Polling for new tracks");
		
		var url = api_url + '/check?&user=' + user_id + '&since=' + time;
		jQuery.getJSON(url, function(data) {
			var delay = 0;
			var i = -1;
			for (i in data) {
				delay =+ 1000;
				(function(){
				var track_id = data[i].text;
				var latest = data[i].timestamp;
				time = latest + 1;
				//console.log(latest);
				setTimeout(function() { 
					searchForURI(track_id); }, delay);
				}());
			}
			baselog("Got "+(1+parseInt(i, 10))+' tracks since '+time);
		});


	}

	poller = setInterval(poll, poll_time);
	poll();

jQuery('#clearplaylist').click(function() {
	if (!playlist) {
		return;
	}
	while(playlist.length) {
		playlist.remove(playlist.get(0));
	}
	baselog("Cleared playlist");
});


jQuery('#cleartrackcache').click(function() {
	tracks = [];
	time = date.getTime()/1000 - (24*60*60);	
	baselog("Cleared track cache");
});


