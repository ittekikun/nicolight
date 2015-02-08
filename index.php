<?php
$nico=simplexml_load_file('http://www.nicovideo.jp/ranking/fav/daily/all?rss=2.0&lang=ja-jp');
print_a($nico);
?>