<?php

$email = $_POST["email"];
$password = $_POST["password"];
class Download{
	private $account = array(
			"mail" => "unknown",
			"password" => "unknown"
	);
	private $cookie;
	function __construct($mail,$pass){
		$this->account["mail"] = $mail;
		$this->account["password"] = $pass;
		//Cookieをサーバ側のtmpフォルダに保存
		$this->cookie = tempnam(sys_get_temp_dir(),'cke');
		$this->login();
	}

	private function login(){
		$url = curl_init("https://secure.nicovide.jp/secure/login?site=niconico");
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
		//３項演算子に変えたほうがいい？
		if(!preg_match($pattern,file_get_contents($this->cookie, FILE_USE_INCLUDE_PATH))){
			return false;
		}
		else{
			return true;
		}
	}


	function getVideo($v){
		$id = $v;

		$url = curl_init("http://flapi.nicovideo.jp/api/getflv/".$id."?as3=1");
		curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($url, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($url, CURLOPT_COOKIEFILE, $this->cookie);

		$get_video = curl_exec($url);
		curl_close($url);
		$pattern = '/url=([^&]*)/';
		if(preg_match($pattern,$get_video,$video)){
			$video[1] = rawurldecode($video[1]);
//			デバッグ用
// 			echo "VIDEO::::::::::::::::::::::</br>".$video[1]."</br>";
		}
		else{
			echo "VIDEO URL NOT FOUND</br>";
			return null;
		}
		return $video[1];
	}

	function get_cookie(){
		return $this->cookie."</br>";
	}

	function cookie_free(){
		unlink($this->cookie);
	}
}
$download = new Download($email,$password);
$download->getVideo("sm8702");
$download->cookie_free();

