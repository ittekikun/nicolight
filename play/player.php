<html>
<head>
<script src="//vjs.zencdn.net/4.11.4/video.js"></script>
<link href="//vjs.zencdn.net/4.11.4/video-js.css" rel="stylesheet" type="text/css"></script>

<style>
	  #overlay {
  position: absolute;
  top: 100px;
  color: #000000;
  text-align: center;
  font-size: 20px;
  background-color: rgba(221, 221, 221, 0.3);
  width: 640px;
  padding: 10px 0;
  z-index: 2147483647;
}

#example_video_1 {
  z-index: 1;
}</style>
</head>
<body>

<video id="example_video_1" class="video-js vjs-default-skin" controls preload="auto" width="854" height="480" data-setup="{}">
  <?php
  require_once('download.php');

  $id = getVideo($_GET["id"]);
  //$download->cookie_free();
	//http://localhost/nicolight_local/test/player.php?test=http://smile-pso00.nicovideo.jp/smile?m=25518258.16111
	print "<source src='$id' type='video/mp4'>";
	?>
</video>
 <div id="overlay">ついでに実装</div>

<script>
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
</script>
</body>


</html>
