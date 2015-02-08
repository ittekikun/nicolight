<?php
$search_query=$_POST["que"];
$search_filed=$_POST["field"];

class Search{
	private $result = "";

	function getter(){
		return $this->result;
	}

	function time($seconds){
		$hours = floor($seconds / 3600);
		$minutes = floor(($seconds / 60) % 60);
		$seconds = $seconds % 60;

		$time = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

		return $time;
	}

	function searching($query,$filed){
		if($filed == "keyword"){
			$filed_var = '["title","description","tags"]';
		}
		else{
			$filed_var = '["tags_exact"]';
		}
		$que = '{
			"query" : "'.$query.'",
			"service" : ["video"],
			"search" : '.$filed_var.',
			"join" : [
				"cmsid",
				"title",
				"thumbnail_url",
				"view_counter",
				"comment_counter",
				"mylist_counter",
				"length_seconds"
			],
			"issuer" : "testaplication"
		}';
		/* queのオプション
		 	"filters" : "",
			"sort_by" : "",
			"order" : "",
			"from" : "",
			"size" : "",
		 */
		$opts = array(
			'http' =>
			array(
				'method'=>"POST",
				'header'=>"Content-Type: application/json; charset=uft-8\r\n",
				'content'=>$que
			)
		);
		$context = stream_context_create($opts);
		$res = file_get_contents('http://api.search.nicovideo.jp/api/snapshot/', false, $context);
		$body = preg_split('/{\"dqnid/', $res, -1, PREG_SPLIT_NO_EMPTY);
		//$body[0]以降のJSONの塊は検索結果に必要ない(たぶん)
		$var_json = '{"set'.$body[0];
		$var_stdClass = json_decode($var_json);
		foreach($var_stdClass->values as $var){
// 			echo "<p>動画ID:".$var->cmsid." コメント数:".$var->comment_counter."</p>";
			$time = $this->time($var->length_seconds);
			$this->result = $this->result.'<tr><td><img src="'.$var->thumbnail_url.'" width="100" />
					</td><td><a href="http://www.nicovideo.jp/watch/'.$var->cmsid.'">'.$var->title.'</a></br>
					<span>再生時間:'.$time.'</span><span>再生回数:'.$var->view_counter.'</span><span>コメント数'.$var->comment_counter.'</span><span>マイリスト数:'.$var->mylist_counter.'</span></td>
					</tr>';
		}
	}
}
$search = new Search();
$search->searching($search_query,$search_filed);
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<title>動画検索</title>
		<meta charset="utf-8">
	</head>
	<body>
		<table>
			<caption>検索結果</caption>
				<thead>
					<tr>
						<th width="100">サムネイル</th>
						<th width="70%">動画名</th>
					</tr>
				</thead>
				<tbody>
					<?php echo $search->getter();?>
				</tbody>
		</table>
	</body>
</html>