<?php
$video_id=$_POST["mvid"];
require_once '../downloader/download.php';
require_once '../login/judgelogin.php';

 if(judge()){
	$download = new Download();
	echo $download->getVideo($video_id);
}
else
	echo '<p>judge error</p>';