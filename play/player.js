videojs("example_video_1").ready(function(){
	  var myPlayer = this;

	  myPlayer.volume(0.3);

	});

var overlay= document.getElementById('overlay');
var video= document.getElementById('v');
video.addEventListener('progress', function() {
  var show= video.currentTime>=5 && video.currentTime<10;
  overlay.style.visibility= show? 'visible' : 'visible';
}, false);