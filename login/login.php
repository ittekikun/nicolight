<?php
$email = $_POST["email"];
$password = $_POST["password"];
class Login{
	private $account = array(
			"mail" => "unknown",
			"password" => "unknown"
	);
	private $cookie;
	function __construct($mail,$pass){
		$this->account["mail"] = $mail;
		$this->account["password"] = $pass;
		$this->login_session();

	}
	private function login_session(){
		session_start();
		$login_url = 'login.html';//ログインページのURLが変わったらここを変更
		$top_url = 'toppage.html';//ログイン後最初に行くページのURLが変わったらここを変更
		function movepage($url){
			echo '<script>document.location = "'.$url.'"</script>';
		}
		//if(!isset($_COOKIE["PHPSESSID"])){
		$this->cookie = tempnam(sys_get_temp_dir(),'cke');

		if($this->login()){
			echo '<script charset="utf-8">alert("login complete\nPlease LogOut When left this site");</script>';
			$_SESSION["cke"] = $this->cookie;
			session_write_close();
			movepage($top_url);
		}
		else{
			echo '<script charset="utf-8">alert("login failed\nMove LogIn Page");</script>';
			$_SESSION["cke"] = $this->cookie;
			session_write_close();
			movepage($login_url);
		}

	//	}
// 		//今現在の使用上これが現れる可能性は低いはず(現れたら教えて)
// 		else{
// 			echo '<script charset="utf-8">alert("'.$_COOKIE["PHPSESSID"].'already login");</script>';
// 			echo '<script>alert("SID:'.session_id().'\nCookie:'.$_COOKIE["PHPSESSID"].'")</script>';
// 			session_write_close();
// 			movepage($top_url);
// 		}


	}
	//ログインできたらTRUE,失敗したらFALSE
	private function login(){
		$url = curl_init("https://secure.nicovideo.jp/secure/login?site=niconico");
		curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($url, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($url, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($url, CURLOPT_COOKIEFILE, $this->cookie);
		curl_setopt($url, CURLOPT_COOKIEJAR, $this->cookie);
		curl_setopt($url, CURLOPT_POST, true);
		curl_setopt($url, CURLOPT_POSTFIELDS, $this->account);

		if(!curl_exec($url)){
			echo "Curl error".curl_error($url);
		}

		curl_close($url);

		$pattern = '/user\_session[^@]*user\_session/';
		//ログインが正常にできたか判定
		//３項演算子に変えたほうがいい？
		if(!preg_match($pattern,file_get_contents($this->cookie, FILE_USE_INCLUDE_PATH))){
			return false;
		}
		else{
			return true;
		}
	}

}
$login = new Login($email,$password);
