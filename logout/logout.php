<?php
//session開始は他で
class Logout{
	private $cookie;
	function logout(){
		if($_COOKIE["PHPSESSID"]){
			$this->cookie = $_SESSION["cke"];
			unlink($this->cookie);
			$_SESSION = array();
			session_destory();
			setcookie(session_name(),'',time()-3600,"/");
			echo '<script>alter("ログアウトしました")</script';
		}
	}
}