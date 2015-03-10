function geturl(){
	var id = getid();
	var url = "geturl.php";
	var param = {"mvid": id};
	jQuery.ajax({
		async: false,
		type:"POST",
		url: url,
		data: param,
		success: function(data){
			$("video").attr("src",data);
		}
	});
	}

function getid(){
	if(location.search.length > 1){
		var que = location.search.substring(1);
		return que.split("=")[1];
	}
	else
		return false;
}

function debug(){
	alert(getid());
}