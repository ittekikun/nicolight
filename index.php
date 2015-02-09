<!DOCTYPE html>
<html lang="ja">
	<head>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
		<title>nicolight(仮)</title>
		<meta charset="utf-8">
	</head>

	<body>
		<table class="table">
			<caption>ニコニコ動画ランキング(毎時)</caption>
				<thead>
			        <tr>
			          <th>順位</th>
			          <th width="100">サムネイル</th>
			          <th width="70%">動画名</th>
			          <th>投稿日時</th>
			        </tr>
				</thead>
		      <tbody>
			<?php
			require 'debuglib.php';


			//CSSはhttp://getbootstrap.com/の物です。
			//ここ見て良さ気なの見つけて下さい

				$rss = simplexml_load_file('http://www.nicovideo.jp/ranking/fav/hourly/all?rss=2.0&lang=ja-jp');
				$i=0;
				foreach($rss->channel->item as $item)
				{
					//20位まで表示
					if($i++==20){
						break;
					}
					$link=$item->link;
					$title=$item->title;
					$description=$item->description;
					$first=strpos($description, 'src="')+5;//srcの5文字分
					$last=strpos($description, 'width="94"')-2;//空白と"の分
					$img_url=substr($description, $first,$last-$first);//指定の場所から指定の文字数分を引いた文字を抽出、画像のURL取得

					$date=date('Y/m/d H:i', strtotime($item->pubDate));


					if(strstr($link, "sm") != null)
					{
						$id = strstr($link, "sm");
					}
					else if(strstr($link, "so") != null)
					{
						$id = strstr($link, "so");
					}
					else if(strstr($link, "nm") != null)
					{
						$id = strstr($link, "nm");
					}

					$xml = simplexml_load_file('http://ext.nicovideo.jp/api/getthumbinfo/'.$id.'');//ここで動画一つ一つの詳細情報を取得

					print '<tr><th scope="row">'.$i.'位</th><td><img src="'.$img_url.'" width="100" /></td><td><a href="'.$link.'" >'.$title.'</a></br>
							<div class="well well-sm">'.$xml->thumb->description.'</div>
			        		<span class="label label-primary">再生時間:'.$xml->thumb->length.'</span> <span class="label label-success">再生回数:'.$xml->thumb->view_counter.'</span> <span class="label label-success">コメント回数:'.$xml->thumb->comment_num.'</span> <span class="label label-success">マイリスト回数:'.$xml->thumb->mylist_counter.'</span></td>
							<td>'.$xml->thumb->first_retrieve.'</td>';


					print(PHP_EOL);


		        }
		      ?>
		      </tbody>
		</table>
	</body>
</html>