<?php
session_set_cookie_params(0,'/nicolight/',$httponly=true);
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
		session_write_close();
	}
	private function login_session(){
		session_start();
		$login_url = 'login.html';//ログインページのURLが変わったらここを変更
		$top_url = 'top.php';//ログイン後最初に行くページのURLが変わったらここを変更
		if(!isset($_COOKIE["PHPSESSID"])){
			$this->cookie = tempnam(sys_get_temp_dir(),'cke');
			function movepage($url){
				echo '<script>document.location = "'.$url.'"</script>';
			}
			if($this->login()){
				echo '<script>alert("ログインしました\nnicolightを離れる際は必ずログアウトをお願いします！");</script>';
				movepage($top_url);
			}
			else{
				echo '<script>alert("ログインに失敗しました\nログイン画面に戻ります");</script>';
				movepage($login_url);
			}
			$_SESSION['cke'] = $this->cookie;
		}
		//今現在の使用上これが現れる可能性は低いはず(現れたら教えて)
		else{
			echo '<script>alert("既にログインしています");</script>';
			movepage($top_url);
		}
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
	/*
	function logout(){
		$this->cookie_free();
	}

	function cookie_get(){
		return $this->cookie;
	}

	private function cookie_free(){
		unlink($this->cookie);
	}
	*/
}
$login = new Login($email,$password);
