<?php
function judge(){
	if(isset($_COOKIE["PHPSESSID"])){
		seddion_id($_COOKIE["PHPSESSID"]);
		session_start();
		if(isset($_SESSION["cke"])){
			echo "<p>Logined</p>";
			return true;
		}
		else{
			echo '<script>alert("Please Login");</script>';
			echo '<script>location.replace("../login/login.html");</script>';

		}
	}
	else{
		echo '<script>alert("Please Login");</script>';
		echo '<script>location.replace("../login/login.html");</script>';
	}
}
