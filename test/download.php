<?php

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
		$url = curl_init("https://secure.nicovideo.jp/secure/login?site=niconico");
		curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($url, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($url, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($url, CURLOPT_COOKIEFILE, $this->cookie);
		curl_setopt($url, CURLOPT_COOKIEJAR, $this->cookie);
		curl_setopt($url, CURLOPT_POST, true);
		curl_setopt($url, CURLOPT_POSTFIELDS, $this->account);

		if(curl_exec($url) === false){
			echo "Curl error".curl_error($url);
		}
		curl_close($url);
		echo "ログインできた";
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
