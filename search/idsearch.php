<?php
$search_query=$_POST["que"];
require_once '../downloader/download.php';
require_once '../login/judgelogin.php';

if(judge()){
	$download = new Download();
	echo $download->getVideo($search_query);
}
echo '<form action="../logout/logout.php" method="post">
		<input type="submit" value="ログアウト">
	</form>';