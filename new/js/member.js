$(document).ready(function(e) {
    //validate.init();
});


var validate = validate || new function()
{
	var Public = {}, Private = {};
	
	Public.init = function()
	{
	}
	
	Public.checkDub = function(element) 
	{
		var name 	= $(element).attr("id");
		var value 	= $(element).val();
		element.setCustomValidity("");
		if (element.validity.valid)
		{
			return $.ajax({
				type: "GET",
				url: "/libs/check_dub.php",
				data: name + "=" + value,
				async: true,
				cache: true,
				success: function(data) { 
					if(data == 0)
						return false; //does not exist
					else if (data == 1) {
						element.setCustomValidity(((name == "reg_usr")? "Username taken" : "That email is already in use"));
						$("#reg_sub").click();
						return true; //does exist
					}
					else
						MsgBox("Error", "There was some kind of error, <br>please refresh and try again ",3);
					return false; //error but keep going
					
				}
			});
		}
	}
	Public.register = function()
	{
		document.getElementById('reg_pwd2').setCustomValidity("");			
		if(document.getElementById("reg_pwd").value != document.getElementById("reg_pwd2").value)
		{
			document.getElementById('reg_pwd2').setCustomValidity('Passwords must match');
			$("#reg_sub").click();
		}
	}
	return Public;
}
/*
$(document).ready(function(e) {
	//some simple restriction settings
	var usr_minlen = 3;
	var usr_maxlen = 20;
	var pwd_minlen = 6;
	var pwd_maxlen = 25;
	var email_minlen = 8;
	var email_maxlen = 30;
	var err_msg_speed = 10;
	var timer = null;
	var submitz; // small idiotic hack
	var error;
	var warning = {"outline": "none", "-webkit-box-shadow": "0 0 5px #ff0000", "-moz-box-shadow": "0 0 5px #ff0000", "box-shadow": "0 0 5px #ff0000"};
    var good = {"outline": "none", "-webkit-box-shadow": "0 0 5px #00ff00", "-moz-box-shadow": "0 0 5px #00ff00", "box-shadow": "0 0 5px #00ff00"};
    var none ={"outline": "none", "-webkit-box-shadow": "0 0 0 #000000", "-moz-box-shadow": "0 0 0 #000000", "box-shadow": "0 0 0 #000000"};
    
	$(document).on("click", ".login_btn", function()
	{
		if ($("#login_usr").val().length==0)
			$("#login_usr").css(warning);
		else if ($("#login_pwd").val().length==0)
			$("#login_pwd").css(warning);
		else 
		{
			$("#login_usr").css(none);
			$("#login_pwd").css(none);
			$("#login_frm").submit();	
		}
			
	});
	$("#login_pwd").keyup(function(event){
		if(event.keyCode == 13){
			$(".login_btn").click();
		}
	});
	$(document).on("keyup","#reg_usr", function(){
		clearTimeout(timer); //clear timer if this has been set before
		if ($(this).val().length >= usr_minlen && $(this).val().length <= usr_maxlen) { //check the username length
			//the username length is what it should be
			//check for illegal characters
			if (!validUsername($(this).val())) {
				$(this).css(warning); //display the username error
				error = 1;
			} else {
				// lets check if the user already exsist
				var thiz = this; // so we can access it in function
				timer = setTimeout(function(){ //this timer is so we don't have to do a request every keystroke and save some server bandwidth
					var status = checkDub($(thiz).val(), "username");// check if the username exists in database
					if (status == 0){
						$(thiz).css(good); // its all good
						$(".reg_error_usr").animate({opacity:0},err_msg_speed); //hide the message
						return true;
					} else {
						$(thiz).css(warning); // user exists
						$(".reg_error_usr").animate({opacity:1},err_msg_speed); //show error
						error = 1;
					}
				},500);
			}
			
		} else {
			$(this).css(warning);
			$(".reg_error_usr").animate({opacity:1},err_msg_speed); //show error
			error = 1;
		}
	});
	$(document).on("blur", "#reg_pwd2", function(){
		if ($("#reg_pwd").val().length>=pwd_minlen || submitz == true) {
			if ($(this).val() != $("#reg_pwd").val()) {
				$(this).css(warning);
				$(".reg_error_pwd2").animate({opacity:1},err_msg_speed);
				error = 1;
			} else if ($("#reg_pwd2").val().length >= pwd_minlen){
				$(this).css(good);
				$(".reg_error_pwd2").animate({opacity:0},err_msg_speed);
				return true;
			}
		}
			
	});
	$(document).on("blur", "#reg_pwd", function(){
			$("#reg_pwd2").trigger("blur");		
	});
	$(document).on("keyup","#reg_pwd", function(){
		if ($(this).val().length >= pwd_minlen && $(this).val().length <= pwd_maxlen) { //check the password length
			//the password length is what it should be
			//check for secure password
			if (!validPassword($(this).val())) {
				$(this).css(warning);
				$(".reg_error_pwd").animate({opacity:1},err_msg_speed);
				error = 1;
			} else {
				$(this).css(good);
				$(".reg_error_pwd").animate({opacity:0},err_msg_speed);
				return true;
			}
			
		} else {
			$(this).css(warning);
			$(".reg_error_pwd").animate({opacity:1},err_msg_speed);
			error = 1;
		}
	});
	
	$(document).on("keyup","#reg_email", function(){
		clearTimeout(timer); //clear timer if this has been set before
		if ($(this).val().length >= email_minlen && $(this).val().length <= email_maxlen) { //check the email length
			//the email length is what it should be
			//check that is actually is an email adress
			if (!validEmail($(this).val())) {
				$(this).css(warning); //display the username error
				$(".reg_error_email").animate({opacity:1},err_msg_speed); //show error
				error = 1;
			} else {
				// lets check if the email already exsist
				var thiz = this; // so we can access it in function
				timer = setTimeout(function(){ //this timer is so we don't have to do a request every keystroke and save some server bandwidth
					var status = checkDub($(thiz).val(), "email");// check if the email exists in database
					if (status == 0){
						$(thiz).css(good); // its all good
						$(".reg_error_email").animate({opacity:0},err_msg_speed); //hide the message
						return true;
					} else {
						$(thiz).css(warning); // email exists
						$(".reg_error_email").animate({opacity:1},err_msg_speed); //show error
						error = 1;
					}
				},500);
			}
			
		} else {
			$(this).css(none);
		}
	});
	
	$("#show_terms").click(function(e) {
        window.open("/terms/","_blank","height=500,width=800, location=no, menubar=no, status=no, toolbar=no"); 
    });
		
	// check fields with regex to see no unwanted charactes are pressent
	function validEmail(e) {
		var filter = /^(\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*)$/;
		return String(e).search(filter) != -1;
	}
	function validPassword(e) {
		var filter = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/;
		return String(e).search(filter) != -1;
	}
	function validUsername(e) {
		var filter = /^[\.a-zA-Z0-9_-]*$/;
		return String(e).search(filter) != -1;
	}
	$(document).on("click", "#reg_term", function(){
		if(!$("#reg_term").prop('checked')) { error = 1; $("#reg_term").addClass("err");}else{ $("#reg_term").removeClass("err"); };
	});
	$(document).on("keyup", "#captcha", function(){
		console.log("kl");
		if ($("#captcha").val().length == 0) {
			error = 1;
			$("#captcha").css(warning); 
			$(".reg_error_code").animate({opacity:1},err_msg_speed);
		} else {
			$("#captcha").css(none); 
			$(".reg_error_code").animate({opacity:0},err_msg_speed);
		};
	});
	$(document).on("click", ".reg_btn", function(){
		submitz = true;
		error = 0;
		$("#reg_usr").trigger("keyup");
		$("#reg_pwd").trigger("keyup");
		$("#reg_pwd2").trigger("blur");
		$("#reg_email").trigger("blur");
		$("#captcha").trigger("keyup");
		if(!$("#reg_term").prop('checked')) { error = 1; $("#reg_term").addClass("err");}else{ $("#reg_term").removeClass("err"); };
		
		if (error == 0){
			//	MsgBox("YAY", "everything vent fine",2);
			$("#reg_form").prop("action", "/member/register");
			$("#reg_form").submit();
		}
		submitz = false;
	});
	$(document).on("click", ".rec_btn", function(e) {
		if ($("#rec_usr").val().length < 3)
			$("#rec_usr").css(warning);
		else
		{
			var e = checkDub($("#rec_usr").val(), "username");
			if (e == 0)
			{
				var u =	checkDub($("#rec_usr").val(), "email");
				if (u == 0)
				{
					$("#rec_usr").css(warning);
					$(".rec_error_usr").animate({opacity:1},err_msg_speed);
					return 0;
				} 				
			}
			$("#rec_form").submit();
		}
	});
	// check for dubbletts in database
	function checkDub(e, w) {
		var res = $.ajax({
            type: "GET",
            url: "/libs/check_dub.php",
            data: w+"="+e,
            async: false,
			cache:true,
            success: function(data) { console.log(data);
                if(data == 1 || data == 0) {
					return data; // set code so we can return it outside the function
                } else {
					//error :S
					MsgBox("Error", "There was some kind of error, we do not know why, but please try again later ^^ ",3);
					return 1;
				}
				
            }
        }); 
		return res.responseText;
	}
	
	
	
});
*/