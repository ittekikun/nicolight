<ul>
<?php
$rss=simplexml_load_file('http://www.nicovideo.jp/ranking/fav/daily/all?rss=2.0&lang=ja-jp');
$i=0;
foreach($rss->channel->item as $item){
	if($i++==10){
		break;
	}
	$link=$item->link;
	$title=$item->title;
	$description=$item->description;
	$first=strpos($description, 'src="')+5;//srcの5文字分
	$last=strpos($description, 'width="94"')-2;//空白と"の分
	$img_url=substr($description, $first,$last-$first);//指定の場所から指定の文字数分を引いた文字を抽出、画像のURL取得

	$date=date('Y/m/d H:i', strtotime($item->pubDate));
	print '<li><img src="'.$img_url.'" width="70" align="left" /><a href="'.$link.'" >'.$title.'（'.$date.'）</a></li>';
	print(PHP_EOL);
}
?>
</ul>