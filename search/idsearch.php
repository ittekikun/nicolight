<?php
$search_query=$_POST["que"];
require_once '../downloader/download.php';
require_once '../login/judgelogin.php';

if(judge()){
	$download = new Download();
	echo $download->getVideo($search_query);
	echo $download->getCookie();
}
echo '<form action="../logout/logout.php" method="post">
		<input type="submit" value="log out">
	</form>';