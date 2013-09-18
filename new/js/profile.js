
$(document).ready(function(e) {
	$("#pro_user_pic span img, #pro_bg_strip span img").click(function(e) {
		//var menu = $("#pro_user_pic span span");
		var menu = $(this).parent("span").children("span");
        if(menu.is(":visible"))
		{
			menu.fadeOut(500);	
		}
		else
		{
			menu.fadeIn(500);
		}
    });
	$(document).on("mouseleave", "#pro_user_pic", function(e){
		$("#pro_user_pic span span").fadeOut(400);
	});
	$(document).on("mouseleave", "#pro_user_pic, #pro_bg_strip", function(e){
		$(this).children("span").children("span").fadeOut(400);
	});
	
	$("#pro_usr_friend").click(function(){
		var menu = $("#pro_usr_friend_m");
        if(menu.is(":visible"))
		{
			menu.fadeOut(500);	
		}
		else
		{
			menu.fadeIn(500);
		}
	});
	
	$(document).on("mouseleave", "#pro_usr_friend", function(e){
		$("#pro_usr_friend_m").fadeOut(400);
	});
	
	$(document).on("click", "#pro_usr_friend_m b", function(){
		var id = $(this).attr("aID");
		var uId = $("#pro_usr_friend").attr("uId");
		switch (id)
		{
			case "1":
				friend("add", uId);
				break;
			case "2":
				friend("remove", uId);
				break;
			case "3":
				friend("block", uId);
				break;
			case "4":
				friend("unblock", uId);
				break;
		}
	});
	
	
	
	
		$(document).on("click", "#pro_user_pic #upload, #pro_bg_strip #upload", function(){
			$.ajax({
					url: "/imgUpload/" + (($(this).parents("div").attr("id") == "pro_user_pic")?"1" : "2"),
					async:false,
					beforeSend: function(){$("#loading").show();},
					
					success: function(data){
							$("#loading").hide();
							$(".boxx-main").html("Upload "+(((($(this).parents("div").attr("id") == "pro_user_pic")?"profile" : "banner")))+" picture<br />"+data)
						}
				});
			$(".boxx-main").show();
			$(".boxx").fadeIn(500);
			$(".boxx-main").attr("active", "1");
			XY();
		});
	
	
});
var ftemp = "";
setTimeout(function(){
	if ($("b[aID='1']").text().length > 0)
		ftemp = $("b[aID='1']").text();
	else 
		ftemp = $("b[aID='2']").text();
}, 500);
function friend(x, u)
	{
		$.ajax({
			url:"/user/" + x +  "/"+u+"/"+$("#f_t").val(),
			beforeSend: function(){$("#loading").hide();},
			success: function(data){
				$("#loading").hide();
					var status  = data.substr(2);
							////////////////////////////////////
		//	error codes
		///////////////
		// 	0: connection error
		//	3: not friends
		//	9: sucessfull
		//	666: you are blocked by the other user
		///////////////
		//	add
		// -1: can't friend yourself
		//	1: already sent a friend request but not accepted
		//	2: already friends
		///////////////
		//	accept
		//	3: no friend request
		///////////////
		//	block
		//	5: nothing to unblock
		///////////////
		//	unblock
		//  4: you do not own this block
		/////////////////////////////////////
		
				switch (status)
				{
					case "0":
						MsgBox("Error", "Sorry there was an connection error, pleast update the page and try again", 3);
						break;
					case "3":
						MsgBox("Information", "You are not freinds with this person",1);
						break;
					case "1":
						MsgBox("Information", "You've already sent a friend request<br>to this user, waiting on acceptance.",1);
						break;
					case "9":
						var menu = "#pro_usr_friend_m ";
						switch (x)
						{
							case "add":
								MsgBox("Sent", "You have now sent a freid request", 0);
								$(menu + "b[aID='1']").attr("aID", "2").html("Remove request");
								ftemp = "Remove request";
								break;
							case "remove":
								MsgBox("Removed", "you are no longer friends.", 0);
								$(menu + "b[aID='2']").attr("aID", "1").html("Add");
								ftemp = "Add";
								break;
							case "block":
								MsgBox("Blocked", "You have now blocked this person", 0);
								$(menu + "b[aID='3']").attr("aID", "4").html("Unblock");
								$(menu + "b[aID='1'], " +menu + "b[aID='2']").remove();
								break;
							case "unblock":
								MsgBox("Unblock", "This person is no longer blocked", 0)
								$(menu + "b[aID='4']").attr("aID", "3").html("Block");
								if (ftemp == "Add")
									$(menu).html("<b aID=\"1\">Add</b>"+$(menu).html());
								else
									$(menu).html("<b aID=\"2\">"+ftemp+"</b>"+$(menu).html());
									
								break;
						}
						break;
				}
					
			}
			});
}