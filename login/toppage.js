function move(){
	var id = $("#mvid").val();
	var url = "../play/player.html?v="+id;
	document.location = url;
}

function access(){
	var id = $("#mvid").val();
	Nicowindow = window.open('http://www.nicovideo.jp/watch/'+id,'Nicowindow','width=300,height=200,menubar=no,toobalr=no');
	Closewindow = setTimeout('Close()',1000);
}

function Close(){
	Nicowindow.close();
	clearTimeout('CloseWindow');
	move();
}

function load(){
	//window.addEventListener("beforeunload", function(){
		return "ページを離れますか?";
	//},false);
}