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

function playSong(track_id){
	
	var t = models.Track.fromURI(track_id, function(track) {
		
		console.log("Track loaded:", track.name);
		
		player.play(track);
	});
		
}

jQuery(function($){
	var last_check = null;
    var poll_time = 10 * 1000;
    var api_url = 'http://basefm-api.dh.devba.se/1/check';
	var user_id = $( '#userfill' ).val();

	setInterval(function() {
		var date = new Date();
		var time = date.getTime();
		var url = api_url + '?&user=' . user_id + 'since=' . time;
		$.getJSON(api_url, function(data) {
			for (var i in data) {
				var track_id = data[i].id;
				playSong(track_id);
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
