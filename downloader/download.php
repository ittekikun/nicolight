<?php

class Download{
	private $cookie;
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
		}
		else{
			echo "VIDEO URL NOT FOUND</br>";
			return null;
		}
		return $video[1];
	}

}
$download = new Download();
$download->getVideo("sm8702");
$download->cookie_free();

