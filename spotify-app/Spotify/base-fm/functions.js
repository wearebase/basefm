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

    var header = document.getElementById("intro-text");

    // This will be null if nothing is playing.
    var playerTrackInfo = player.track;
	var userInfo = player.session;

    if (playerTrackInfo == null) {
        header.innerText = "Nothing playing!";
    } else {
        var track = playerTrackInfo.data;
        header.innerHTML = "You are listening to " + track.name + ". Why not tell everyone else what you think of it?";
		console.log(session.anonymousUserID);
		jQuery(function($){
			$('#userfill').val(session.anonymousUserID);
			$('#songfill').val(track.uri);
		});		
		fetchCommentsForThisSong(track.uri, session.anonymousUserID);
		
    }
}

function fetchCommentsForThisSong(song_id, user_id) {
	console.log(song_id);
    /*var req = new XMLHttpRequest();
    req.open("GET", "http://adamburt.com/sats.php?song=" + song_id , true);
	console.log("http://adamburt.com/sats.php?song=" + song_id );
    req.onreadystatechange = function() {

        console.log(req.status);

        //if (req.readyState == 4) {
           // if (req.status == 200) {
                //console.log("Search complete!");
                console.log(req.responseText);
            //}
        //}
    };

    req.send();*/
	
	
	var mygetrequest = new XMLHttpRequest();
	mygetrequest.onreadystatechange=function(){
	console.log(mygetrequest.readyState);
	 if (mygetrequest.readyState==4){
		console.log('Correct ready state');
	  if (mygetrequest.status==200 || window.location.href.indexOf("http")==-1){
		console.log('Status is correct, or the other weird thing');
		console.log("Response: " + mygetrequest.responseText);
		document.getElementById("result").innerHTML=mygetrequest.responseText
	  }
	  else{
	   alert("An error has occured making the request")
	  }
	 }
	}

	mygetrequest.open("GET", "http://www.adamburt.com/sats.php?song=" + song_id + "&user=" + user_id, true)
	mygetrequest.send(null);
	
}

jQuery(function($){
	// Remove value on click of input
	$("input.blurValue:not(.wrong), textarea.blurValue:not(.wrong)").focus(function() {
		if (this.value == this.defaultValue) {	this.value = ""; }
	}).blur(function() {
		if (this.value == "") { this.value = this.defaultValue; }
	})
	
	$("#search-form").submit(function(event) {
    /* stop form from submitting normally */
    event.preventDefault(); 
        
    /* get some values from elements on the page: */
    var $form = $( this ),
        term = $form.find( 'textarea[name="s"]' ).val(),
		song_id = $form.find( 'input[name="song_id"]' ).val(),
		user_id = $form.find( 'input[name="user_id"]' ).val(),
        url = $form.attr( 'action' );
		

		    /* Send the data using post and put the results in a div */
			$.post( url, { s: term, user: user_id, song: song_id },
				function( ) {
				  
				}
			);
			
		fetchCommentsForThisSong(song_id, user_id);
		$('#comment-actual').val('');
	});
});
