var sp = getSpotifyApi(1);
var models = sp.require('sp://import/scripts/api/models');
var player = models.player;
var session = models.session;

exports.init = init;

function init() {

    updatePageWithTrackDetails();
	
    player.observe(models.EVENT.CHANGE, function (e) {

        // Only update the page if the track changed
        if (e.data.curtrack == true) {
            updatePageWithTrackDetails();
        }
    });
	

}


	var date = ""+new Date();
	var playlist = new models.Playlist("FROON: " + date);	


function updatePageWithTrackDetails() {

    var current_song = document.getElementById("cur-song");
	var tweeter = document.getElementById("tweeter");

    // This will be null if nothing is playing.
    var playerTrackInfo = player.track;
	var userInfo = player.session;

    if (playerTrackInfo == null) {
        current_song.innerText = "Nothing playing";
    } else {
        var track = playerTrackInfo.data;
        current_song.innerHTML = track.name;
		
		//TODO: Fetch twitter user who suggested this track
		twitter_user = "someone";
		tweeter.innerHTML = twitter_user;
		
		jQuery(function($){
			$('#userfill').val(session.anonymousUserID);
			$('#songfill').val(track.uri);
		});		
		
    }
}


var tracks = new Array();
function generatePlaylist(track_id){

	//If this is not currently in playlist, add it to playlist
	if( !(jQuery.inArray(track_id, tracks) > -1) ){
		var t = models.Track.fromURI(track_id, function(track) {	
			console.log("Track loaded:", track.name);			
		});
		tracks.push(track_id);
		playlist.add(t);
		updatePageWithTrackDetails();

	}

}

jQuery(function($){
	var last_check = null;
    var poll_time = 5 * 1000;
    var api_url = 'http://api.wearebase.com/music/1/check';//'http://basefm-api.dh.devba.se/1/check';
	var user_id = $( '#userfill' ).val();

	setInterval(function() {
		var date = new Date();
		var time = date.getTime();
		var url = api_url + '?&user=' . user_id + 'since=' . time;
		$.getJSON(api_url, function(data) {
			var delay = 0;
			for (var i in data) {
				delay =+ 1000;
				(function(){
				var track_id = data[i].id;
				setTimeout(function() { generatePlaylist(track_id); }, delay);
				}());
			}
		});
	
	}, poll_time);
	
	// Remove value on click of input
	$("input.blurValue:not(.wrong), textarea.blurValue:not(.wrong)").focus(function() {
		if (this.value == this.defaultValue) {	this.value = ""; }
	}).blur(function() {
		if (this.value == "") { this.value = this.defaultValue; }
	})
	
	//TODO: Populate save form with previous information based on user.
		//Get details for this user
		//$('#save-form') .val()'s...
	
	//TODO: For when users want to update their stuff
	$("#save-form").submit(function(event) {
    /* stop form from submitting normally */
    event.preventDefault(); 
        
    /* get some values from elements on the page: */
    var $form = $( this ),
        tweeter = $form.find( 'textarea[name="s"]' ).val(),
		hash = $form.find( 'textarea[name="h"]' ).val(),
		user = $form.find('#userfill').val();
        url = $form.attr( 'action' );
		

		    /* Send the data using post and put the results in a div */
			$.post( url, { s: tweeter, h: hash, user: user },
				function( ) {
				  
				}
			);

		$('#save-result').val('');
	});
});
