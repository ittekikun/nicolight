<html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</head>

<table class="table">
      <caption>ニコニコ動画ランキング</caption>
      <thead>
        <tr>
          <th>#</th>
          <th>サムネイル</th>
          <th>動画名</th>
          <th>なんかよくわからない日時</th>
        </tr>
      </thead>
      <tbody>
      <?php
$rss=simplexml_load_file('http://www.nicovideo.jp/ranking/fav/daily/all?rss=2.0&lang=ja-jp');
$i=0;
foreach($rss->channel->item as $item)
{
	if($i++==100){
		break;
	}
	$link=$item->link;
	$title=$item->title;
	$description=$item->description;
	$first=strpos($description, 'src="')+5;//srcの5文字分
	$last=strpos($description, 'width="94"')-2;//空白と"の分
	$img_url=substr($description, $first,$last-$first);//指定の場所から指定の文字数分を引いた文字を抽出、画像のURL取得

	$date=date('Y/m/d H:i', strtotime($item->pubDate));

	print '<tr><th scope="row">'.$i.'位</th><td><img src="'.$img_url.'" width="70" /></td><td><a href="'.$link.'" >'.$title.'</a></td><td>'.$date.'</td>';

	print(PHP_EOL);
        }
        ?>
      </tbody>
    </table>
</html>