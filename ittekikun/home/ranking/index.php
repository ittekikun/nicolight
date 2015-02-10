<!DOCTYPE html>
<html lang="ja">
	<head>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<title>ランキング</title>
		<meta charset="utf-8">
	</head>

	<body>

	<div class="navbar navbar-default">
  <div class="container">
    <a class="navbar-brand" href="#">nicolight</a>
    <ul class="nav navbar-nav">
      <li><a href="../">Home</a></li>
      <li class="active"><a href="index.php">ランキング</a></li>
    </ul>
  </div>
</div>


<div class="container">
<div class="row">
		<table class="table">
			<caption>ニコニコ動画ランキング(毎時)</caption>
				<thead>
			        <tr>
			          <th>順位</th>
			          <th width="100">サムネイル</th>
			          <th width="80%">動画名</th>
			          <th>投稿日時</th>
			        </tr>
				</thead>
		      <tbody>
			<?php
			//CSSはhttp://getbootstrap.com/の物です。
			//ここ見て良さ気なの見つけて下さい

				$rss = simplexml_load_file('http://www.nicovideo.jp/ranking/fav/hourly/all?rss=2.0&lang=ja-jp');
				$i = 0;
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
					$title = preg_split('/^第[1-9]*位：/', $title, -1, PREG_SPLIT_NO_EMPTY);
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

					print '<tr><th scope="row">'.$i.'位</th><td><img src="'.$img_url.'" width="100" /></td><td><a href="'.$link.'" >'.$title[0].'</a></br>
							<div class="well well-sm">'.$xml->thumb->description.'</div>
			        		<span class="label label-primary">再生時間:'.$xml->thumb->length.'</span> <span class="label label-success">再生回数:'.$xml->thumb->view_counter.'</span> <span class="label label-success">コメント回数:'.$xml->thumb->comment_num.'</span> <span class="label label-success">マイリスト回数:'.$xml->thumb->mylist_counter.'</span></td>
							<td>'.$xml->thumb->first_retrieve.'</td>';


					print(PHP_EOL);


		        }
		      ?>
		      </tbody>
		</table>
		</div>
	</div> <!-- /container -->
	</body>
</html>
