<?php
require_once '../logout/logout.php';
session_start();
mb_http_output('UTF-8');
$logout = new Logout();
echo '<script>alert("'.session_name().'")</script>';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>TOP PAGE</title>
</head>
<body>
	<p>ログイン完了</p>
	<?php $logout->logout();?>
</body>
</html>