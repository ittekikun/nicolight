<?php
class Logout{
	private $cookie;
	function logout(){

		if(isset($_COOKIE["PHPSESSID"])){
			session_id($_COOKIE["PHPSESSID"]);
			session_start();
// 			echo '<script>alert("SID:'.session_id().'\nCookie:'.$_SESSION["cke"].'")</script>';
// 			session_id($_COOKIE["PHPSESSID"]);
// 			echo '<script>alert("SID:'.session_id().'\nCookie:'.$_SESSION["cke"].'")</script>';
			if(isset($_SESSION["cke"])){
				$this->cookie = $_SESSION["cke"];
				setcookie(session_id(),'',time()-3600,"/");
				unlink($this->cookie);
				$_SESSION = array();
				session_destroy();
				echo '<script charset="utf-8">alert("'.session_id().'");</script>';
				echo '<script charset="utf-8">alert("log out success");</script>';
				echo '<script>location.replace("../login/login.html");</script>';
			}
			else{

				echo '<script>alert("NOT FOUNDE COOKIE")</script>';
				echo '<script>location.replace("../login/login.html");</script>';
			}
		}
		else{
			echo '<script>alert("NOT FOUNDE SESSION")</script>';
			echo '<script>location.replace("../login/login.html");</script>';
		}
	}
}
$logout = new Logout();
$logout->logout();