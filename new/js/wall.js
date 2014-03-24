$(document).ready(function(e) {
	$(document).on("click", "#pro_usr_stream_write_send", function(){
		var sid = ((typeof $(this).parent("div").attr("sid") != "undefined")?$(this).parent("div").attr("sid"):0)
		var thiz = this;
		$.ajax({
			url: "/user/wall/post",
			type:"POST",
			//  array("txt","to","pri","child")))
			data: {"txt": $(this).parent("div").children("textarea").val(), "to": $("#usr_id").val(), "pri":0, "child":sid, "type": 0},
			success: function(data) {
				//console.log(data);	
				if (data.substring(0,2) =="OK") {
					if (sid == 0)
						WallAdd($(".pro_stream_box textarea").val(),null, data.substring(2));
					else
						WallAdd($(".pro_stream_box[sid='"+sid+"']").children("textarea").val(), sid);
					$(".pro_stream_box textarea").val("");	
					
					
				}
			}
		});
	});
	
	function WallAdd(txt, where, ID, usr, UD, time, to, likes)
	{
		var where = ((typeof where == "undefined" || where == null)? 0 : where)
		var ID = ((typeof ID == "undefined")? 0 : ID);
		var likes = ((typeof likes == "undefined")? 0 : likes);
		var txt = ((typeof txt == "undefined") ? "error" : txt);
		var to = ((typeof to == "undefined") ? ((Meee['usr'] ==  $("#pro_title").html().substring(0,$("#pro_title").html().indexOf("<")).replace(/\s/g, ''))? 0:$("#pro_title").html().substring(0,$("#pro_title").html().indexOf("<")).replace(/\s/g, '') ) : to);
		var time = ((typeof time == "undefined") ? "now" : time);
		//var usr = ((typeof usr == "undefined")? $("#pro_title").html().substring(0,$("#pro_title").html().indexOf("<")).replace(/\s/g, '') : usr);
		var usr= ((typeof usr == "undefined") ? Meee['usr'] : usr);
		if (where == 0)
			var code= '<div class="pro_usr_stream_log">\
			<a href="/user/'+usr+'"><img src="'+$("#pro_usr_stream_write .pro_pic_tumb").attr("src")+'" class="pro_pic_tumb" /></a> \
			<div class="pro_stream_box" sID="'+ID+'"> \
			<b><a href="/user/'+usr+'">'+usr+'</a> ' +((to !== 0)? " &raquo; <a href=\"/user/"+to+"\">" + to +"</a>" : "") + '</b> <i>'+time+'</i> \
			<span class="pro_stream_s"><img src="/images/s.png" /></span> \
			<p>'+ txt +'\
			<span class="pro_stream_l">'+likes+' people(s) liked this</span><img src="/images/like.png" title="Like" class="stream_like_ico"></p>\
			<textarea></textarea><span id="pro_usr_stream_write_send" class="btn">Send</span></div><br /><br />';
		else
		var code = '<hr>\
						<div class="pro_stream_log_a">\
							<a href="/user/'+usr+'"><img src="'+$("#pro_usr_stream_write .pro_pic_tumb").attr("src")+'" class="pro_pic_tumb_a" /></a>\
							<b><a href="/user/'+usr+'">'+usr+'</a></b> <i>'+time+'</i>\
							<span class="pro_stream_s"><img src="/images/s.png" /></span>\
							<p>\
								'+txt+'\
							<span class="pro_stream_l">'+likes+' person(s) liked this</span><img src="/images/like.png" title="Like" class="stream_like_ico">\
							</p>\
						</div>';		
		if (typeof UD == "undefined")
			if (where == 0)
				$("#pro_usr_wall").before(code);
			else
			{
				var sid = where;
				var start = $(".pro_stream_box[sid='"+sid+"']").html().substring(0,$(".pro_stream_box[sid='"+sid+"']").html().indexOf("<textarea>"));
				var end = $(".pro_stream_box[sid='"+sid+"']").html().substring($(".pro_stream_box[sid='"+sid+"']").html().indexOf("<textarea>"));
				$(".pro_stream_box[sid="+sid+"]").html(start+code+end);
			}
		else
			if (where == 0)
				$("#pro_usr_wall").after(code);
			
		
	}
var Meee = $.parseJSON($("#Mee").val());
});