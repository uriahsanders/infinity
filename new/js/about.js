$(document).ready(function(e) {
    $(document).on("click", "#cf_submit", function(){
		var err_sub = $(".cf tr:nth-child(2) td:nth-child(2)");
		var err_mail = $(".cf tr:nth-child(4) td:nth-child(2)");
		var err_msg	 = $(".cf tr:nth-child(6) td:nth-child(2)");
		if ($("#cf_subject").val().length <= 3) { 
			console.log(err_sub.find("div").is(":hidden"));
			if (err_sub.find("div").is(":hidden")) 
				err_sub.find("div").slideDown(500)
		} else err_sub.find("div").slideUp(500);
		if ($("#cf_email").val().search(/^(\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*)$/) == -1){ 
			if (err_mail.find("div").is(":hidden"))
				err_mail.find("div").slideDown(500); 
		} else err_mail.find("div").slideUp(500);
		if ($("#cf_msg").val().length < 30) {
			if (err_msg.find("div").is(":hidden"))
				err_msg.find("div").slideDown(500);	
		} else err_msg.find("div").slideUp(500);
		
		if (err_msg.find("div").is(":hidden") && err_mail.find("div").is(":hidden") && err_sub.find("div").is(":hidden")){ 
			$("#cf_form").attr("action", "/extra/contact");
			$("#cf_token").val(token);
			$("#cf_form").submit();
		}
	});
});