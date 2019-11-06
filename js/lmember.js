$(document).ready(function(e) 
{
	setTimeout(function()
	{
    	$(".member_bar").slideDown(500);
		setTimeout(function()
		{
			$("#member_bar_body").fadeIn(200);
			$("#member_bar_icons").fadeIn(200);	
		},800);
	},800);
	
	
	
	///////////////////////////////////////////////
	//	Notification script
	//	for friends requests
	///////////////////////////////////////////////
	
	$(document).on("click", ".n_f_a, .n_f_d", function()
	{
		var id = $(this).parent("i").attr("id").substring(4);
		var type = $(this).attr("class").substr(-1);
		
		var status = $.ajax({
					url:"/user/" + ((type=="a")?"accept":"decline") +  "/"+id+"/bd37ce8feede107dba4dcc87efde2b94912c20b9fef9ce85f87d7c32ff44d06f",
					async:false,
					success: function(data){
							var stat = data.substring(2);
							$("#n_f_"+id).parent("b").remove();
							if (stat== "9")
							{
								// MsgBox("Done", "Friend request " + ((type=="a") ? "accepted" : "declined"),0); // comment this one because it seemed annoying tbh
							}
							else
							{
								MsgBox("Error", "There was an error, please try again<br/> or conact support with errorcode:<br/>"+ ((data.lenght > 10) ? data.substring(0,10) : data),3);
							}
						}
		});
	});
	
	$(document).on("click", "#member_notification h6", function()
	{
		if ( $("#member_notifications").is(":hidden"))
		{
			$("#member_notifications").fadeIn(200);
			if ($(this).attr("new") !== false)
			{
				$(this).parent("span").removeAttr("new");
				$(this).html("0");
				$.ajax({
						url: "/mix/notification/0",
						cache:false,
						async:false,success: function(data){console.log(data);}		
					}); // we don't have a succefull output for this beacuse that might be annoying and unessesary
				
			}
		}
		else
			$("#member_notifications").fadeOut(200);
	});
	
});