//***NEWS SLIDE START***//
function newsSlide(id) {
    //event.preventDefault();
    for (i = 1; i <= 10;i++) {
        $("#arrownews"+i).attr('src','images/arrowc.png');
    }
    
    if ($('#'+id).is(':hidden')) {
        $(".newstxt").slideUp(500).hide(function() {
            $(this).hide();
        });
        $("#arrow"+id).attr('src','images/arrowo.png');
        $("#"+id).slideDown(500).show(function() {
            $(this).show();
        });
    } else {
        $("#arrow"+id).attr('src','images/arrowc.png');
        $("#"+id).slideUp(500).hide(function() {
            $(this).hide();
        });
    }
}
$(document).ready(function(){

$('.bookmark_list_item').hover(function() {
                    $(".bookmark_list_btns").stop(true, true);
                    $(this).children(".bookmark_list_btns").stop(true, true).fadeIn(300);
                }, function() {
                    $(this).children(".bookmark_list_btns").stop(true, true).fadeOut(300);
                });

    $("#msgbox").draggable({ containment: "", 
                        scroll: false, 
                        handler: "#msgbox-title",
                        cancel: "#msgbox-text",
                        start: function () {
                                    $("body").css({'overflow-x':'hidden'});
                                },
                        stop: function () {
                                $("body").css({'overflow-x':'auto'});
                            }
                        });




});






function hide(id) {
    $("#"+id).fadeOut(500).hide(function() {
        $(this).hide();
    });
}
function hideC(id) {
    $("."+id).fadeOut(500).hide(function() {
        $(this).hide();
    });
}
function show(id) {
    if (id == 'register') {
        hide('recover');
    }else if(id == 'recover'){
        hide('register');
    }
    $("#"+id).fadeIn(500).show(function() {
        $(this).show();
    });
}

//***NEWS SLIDE END***//
function links(linkk) {
    if ($("#"+linkk).css('display')=='none') {
        $(".txtlink").slideUp(500);$
        ("#"+linkk).slideDown(500).show(function () {
            $(this).show();
        });
    }
    setTimeout(function() {
        $("#donate").fadeIn();
    }, 550);
}

function bookmarkadd() {
var ccoddee="<form action='/member/bookmark.php' method='post' id='bookmarkform'>";
ccoddee=ccoddee+"Enter description:<br/>";
ccoddee=ccoddee+"<input type='text' name='desc' id='bkdesc'>";
ccoddee=ccoddee+"<input type='button' value='save' onclick='savebookmark()'>";
ccoddee=ccoddee+"</form>";
    MsgBox("Add Bookmark", ccoddee,0,0,0,0,100);
}
function savebookmark() {
    if($("#bkdesc").val().length<=2) {
    alert("Description of the bookmark is to short");
    } else {
    $("#bookmarkform").submit();
    }
}

function MsgBox(msgbox_title, msgbox_txt, msgbox_height, msgbox_width, msgbox_bottom, icon, msgbox_top,msgbox_left){
if (!msgbox_height)
    var msgbox_height = 120;
if (!msgbox_width)
    var msgbox_width = 300;
if (!msgbox_bottom || msgbox_bottom == 1) {
    var msgbox_bottom = true;
} else {
    var msgbox_bottom = false;
}
if (!msgbox_top)
    var msgbox_top = 0;
if (!msgbox_left) 
    var msgbox_left = 350;

    
if (!icon) {
    var icon = 0;
} else{
    switch (icon) {
        case 1: icon = '<img src="images/icons/_0007_Tick.png" border="0">'; break;
        case 2: icon = '<img src="images/icons/_0006_Cross.png" border="0">'; break;
        case 3: icon = '<img src="images/icons/_0011_Info.png" border="0">'; break;
        case 4: icon = '<img src="images/icons/_0010_Alert.png" border="0">'; break;
        case 5: icon = '<img src="images/icons/_0005_Delete.png" border="0">'; break;
        default: icon = 0; break;
    }
}



 var code = Math.floor(Math.random()*101)
 var src = "";
 src = src +"<div id='msgbox' class='msgbox"+code+"' style='width:"+msgbox_width+"px; padding-bottom:6px;";
 src = src +"left: " + msgbox_left + "px; top:"+msgbox_top+"px'>\n";
 src = src +"<div id='msgbox-title'>"+msgbox_title+"</div>\n";
 src = src +"<div id='msgbox-text' style='padding-bottom:0; font-weight:bold; font-size: 12px; height:"+msgbox_height+"px;'>\n";
 src = src +"<table id='msgbox-table' style='height:"+msgbox_height+"px; width:100%'>\n";
 src = src +"<tr>\n";
 if (icon != false) {
     src = src + "<td width='50'>"+icon+"</td>";
     src = src +"<td valign='midth' align='center' height='100%'>\n";
     src = src + msgbox_txt + "<br />\n";
     src = src +"</td>\n";
     src = src + "<td width='50'></td>";
 } else {
     src = src +"<td valign='midth' align='center' height='100%' colspan='3'>\n";
     src = src + msgbox_txt + "<br />\n";
     src = src +"</td>\n";
 }

 src = src +"</tr>\n";
 if (msgbox_bottom == true) {
     src = src +"<tr>\n";
     src = src +"<th valign='top' colspan='3'><div id='msgbox-line'></div></th>\n";
     src = src +"</tr>";
     src = src +"<tr>";
     src = src +"<td valing='middle' align='right' colspan='3'>\n";
     src = src +"<div style='margin-bottom:8px'></div><a onclick='hideC(\"msgbox"+code+"\")'";
     src = src +"style='font-weight:bold; padding-right:5px; color:#000;'>Close</a></div>\n";
     src = src +"</td>\n";
     src = src +"</tr>\n";
 }
 src = src +"</table>\n";
 src = src +"</div>";
 src = src +"</div>";

 
var boxes = document.getElementById('content');
var newmsgbox = document.createElement('div');
newmsgbox.setAttribute('id','boxID');
newmsgbox.innerHTML = src;
boxes.appendChild(newmsgbox);


            $(".msgbox"+code).css('left', ($(window).width () / 2) - ($(".msgbox"+code).width () /2) + "px");
            $(".msgbox"+code).css('top' , ($(window).height() / 2) - ($(".msgbox"+code).height() /2) + "px");

$(".msgbox"+code).draggable({ containment: "", 
                        scroll: false, 
                        handler: "#msgbox-title",
                        cancel: "#msgbox-text",
                        start: function () {
                                    $("body").css({'overflow-x':'hidden'});
                                },
                        stop: function () {
                                $("body").css({'overflow-x':'auto'});
                            }
                        });
}
/** VALIDATION START **/


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
function validName(e) {
    var filter = /^[\. a-zA-Z0-9_-]*$/;
    return String(e).search(filter) != -1;
}

function usernamedub(){
    var username = $('#inputusername').val();
    if(username.length < 4){
        //Do Nothing
    }else if(username_check() != 1){
        jQuery.ajax({
            type: "GET",
            url: "check.php",
            data: 'username=' + username,
            cache: false,
            success: function(response) {
                if(response == 1) {
                    $('#errusr3').slideDown(500);
                    return 1;
                }else{
                    $('#errusr3').slideUp(500);
                }
            }
        });
    }
}

function emaildub() {
    var email = $('#inputemail').val();
    if(email.length < 8){
        //Do nothing.
    } else if (email_check(email) != 1) {
        jQuery.ajax({
            type: "GET",
            url: "check.php",
            data: 'email='+ email,
            cache: false,
            success: function(response) {
                if(response == 1) {
                    $('#erremail2').slideDown(500);
                    return 1;
                }else{
                    $('#erremail2').slideUp(500);
                }
            }
        });
    }
}

function username_check() {
    var usern = $('#inputusername').val();
    if(!validUsername(usern)) {
        $('#errusr').slideDown(300);
        return 1;
    } else {
        $('#errusr').slideUp(300);
    }
}
function username_checkL() {
    var usern = $('#inputusername').val();
    if(usern.length < 4 || usern.length > 16 || usern == "Username") {
        $('#errusr2').slideDown(300);
        return 1;
    } else {
        $('#errusr2').slideUp(300);
    }
}
function name_check() {
    var na = $('#inputname').val();
    if(!validName(na)) {
        $('#errname').slideDown(300);
        return 1;
    } else {
        $('#errname').slideUp(300);
    }
}
function name_checkL() {
    var na = $('#inputname').val();
    if(na.length < 4 || na.length > 16 || na == "Screen name") {
        $('#errname2').slideDown(300);
        return 1;
    } else {
        $('#errname2').slideUp(300);
    }
}
function email_check() {
    var ema = $('#inputemail').val();
    if(!validEmail(ema) || ema.length > 50 || ema == "Email") {
        $('#erremail').slideDown(300);
        return 1;
    } else {
        $('#erremail').slideUp(300);
    }
}
function password_check() {
    var pw = $('#inputpassword').val();
    if(pw.length < 6 || pw.length > 16) {
        return 1;
    }
    if(!validPassword(pw)) {
        $('#errpwd').slideDown(300);
        return 1;
    } else {
        $('#errpwd').slideUp(300);
    }
}
function password_checkL() {
    var pw = $('#inputpassword').val();
    if(pw == "Password" || pw === "") {
        return 1;
    }
    if(pw.length < 6 || pw.length > 16) {
        $('#errpwd3').slideDown(300);
        return 1;
    } else {
        $('#errpwd3').slideUp(300);
    }
}
function password2_check() {
    if($('#inputpassword2').val() != $('#inputpassword').val()) {
        $('#errpwd2').slideDown(300);
    }else{
        $('#errpwd2').slideUp(300);
    }
}
function password2_checkL(){
    if ($('#inputpassword').val().length == $('#inputpassword2').val().length) {
        password2_check();
    }
}
/** VALIDATION END **/

/** REGISTER CLICK START **/
function subrec() {
        var em2 = $("#inputemailforgot").val();
        if (!validEmail(em2) || em2 == "Please enter your email address.") {
            $("#hide2").slideDown(500);
        } else {
            $("#recf").submit();
        }
        
    }
function register() {
    var err = 0;
    if($("#inputusername").val() == "Enter a username") {
        $("#errusr2").slideDown(500); err++;
    } else {
        if(username_check() == 1) {
            err++;
        }
        if(username_checkL() == 1) {
            err++;
        }
    }
    if($("#inputname").val() == "Enter your desired screen name"){
        $("#errname2").slideDown(500); err++;
    } else {
        if(name_check() == 1) {
            err++;
        }
        if(name_checkL() == 1) {
            err++;
        }
    }
    if($("#inputemail").val() == "Enter your email"){
        $("#erremail").slideDown(500);
        err++;
    } else { 
        if(email_check() == 1) {
            err++;
        }
    }
    if($("#inputpassword").val() === "") {
        $("#errpwd3").slideDown(500); err++;
    } else {  
        if(password_check() == 1) {
            err++;
        }
        if(password_checkL() == 1) {
            err++;
        }
    }
    if(password2_check() == 1) {
        err++;
    }
    if($("#capcode").val() == "Enter The Code" || $("#capcode").val() === "") {
        $("#errcap2").slideDown(500);
        err++;
    }
     
    if(!$("#checkacc").attr("checked")) {
        $("#erracc").slideDown(500);
        err++;
    }
    if(err === 0){
        $("#reg").submit();    
    }
}

$(document).ready(function(){
    
    //PREREQUISITES
    $("#inputusr").val("Username");
    $("#inputpwd").val("Password");
    
    
$("#inputusr").val("Username");
$("#inputpwd").val("Password");
//$("#loginbtn").attr("disabled", true);

$("#inputusr, #inputpwd").change(function () {
var timerId = setInterval(function() {

    if ($("#inputpwd").val() != "Password" && $("#inputusr").val() != "Username") {
            $("#loginbtn").attr("disabled", false);
    } else {
            $("#loginbtn").attr("disabled", true);
    }
    clearInterval(timerId);
}
    , 500);
    
});

    
   // $("#loginbtn").attr("disabled", true);
    
    //Actual code to make sure to enable login button(TEMPORARILY COMMENTED OUT BY URIAH AS I NEEDED TO LOGIN WHILE ITS NOT WORKING)
    /*$("#inputpwd").change(function() {
        if ($(this).val() != usr && $("#inputusr").val() != usr) {
            $("#loginbtn").removeAttr("disabled");
        }
    });
    $("#inputusr").change(function(e) {
        if ($(this).val() != usr && $("#inputpwd").val() != pwd) {
            $("#loginbtn").removeAttr("disabled");
        }
    });
    //disabling code
    $("#inputpwd").keyup(function() {
        if ($(this).val() === "") {
            $("#loginbtn").attr("disabled", true);
        }
    });
    $("#inputusr").keyup(function() {
        if ($(this).val() === "") {
            $("#loginbtn").attr("disabled", true);
        }
    });*/
    
    //***INPUT LOGIN CLEAR/RESTORE START***//
    
    var usr = $("#inputusr").val();
    var pwd = $("#inputpwd").val();
    $("#inputusr").focus(function() {
        if($(this).val() == usr) {
            $(this).val("");
        }
    });
    $("#inputusr").blur(function() {
        if($(this).val() === "") {
            $(this).val(usr);
        }
    });
    $("#inputpwd").focus(function() {
        if($(this).val() == pwd) {
            $(this).val("");
        }
    });
    $("#inputpwd").blur(function() {
        if($(this).val() === "") {
            $(this).val(pwd);
        }
    });
    
    //***INPUT LOGIN CLEAR/RESTORE END***//
    
    //***INPUT REGISTER CLEAR/RESTORE START***//
    
    $("#regclose").click(function() {
        $("#register").fadeOut(500);
    });
    
    $("#statusclose").click(function() {
        $("#status").fadeOut(500);
    });
    
    var username = $("#inputusername").val();
    var name = $("#inputname").val();
    var password = $("#inputpasswordc").val();
    var password2 = $("#inputpassword2c").val();
    var email = $("#inputemail").val();
    var capcode = $("#capcode").val();
    var inputemailforgot = $("#inputemailforgot").val();
    
    $("#inputusername").focus(function() {
        if($(this).val()==username) {
            $(this).val("");
        }
    });
    
    $("#inputusername").blur(function() {
        if($(this).val()==="") {
            $(this).val(username);
        }
    });
    
    $("#inputname").focus(function() {
        if($(this).val()==name) {
            $(this).val("");
        }
    });
    
    $("#inputname").blur(function() {
        if($(this).val()==="") {
            $(this).val(name);
        }
    });
    
    $("#inputpasswordc").focus(function() {
        if($(this).val()==password) {
            $(this).hide();
            $("#inputpassword").show();
            $("#inputpassword").focus();
        }
    });
    
    $("#inputpassword").blur(function() {
        if($(this).val()==="") {
            $(this).hide();
            $("#inputpasswordc").show();
        }
    });
    
    $("#inputpassword2c").focus(function() {
        if($(this).val()==password2) {
            $("#inputpassword2").show();
            $(this).hide();
            $("#inputpassword2").focus();
        }
    });
    
    $("#inputpassword2").blur(function() {
        if($(this).val()==="") {
            $(this).hide();
            $("#inputpassword2c").show();
        }
    });
    
    $("#inputemail").focus(function() {
        if($(this).val()==email) {
            $(this).val("");
        }
    });
    
    $("#inputemail").blur(function() {
        if($(this).val()==="") {
            $(this).val(email);
        }
    });
    
    $("#capcode").focus(function() {
        if($(this).val()==capcode) {
            $(this).val("");
        }
    });
    
    $("#capcode").blur(function() {
        if($(this).val()==="") {
            $(this).val(capcode);
        }
    });
    
    $("#inputemailforgot").focus(function() {
        if($(this).val()==inputemailforgot) {
            $(this).val("");
            $(this).css("color", "#666");
        }
    });
    
    $("#inputemailforgot").blur(function() {
        if($(this).val()==="") {
            $(this).val(inputemailforgot);
        }
    });
    /** INPUT REGISTER CLEAR/RESTORE END **/
    
    //
    // Validation?
    //
    
    $('#inputusername').blur(username_checkL);
    $('#inputusername').keyup(usernamedub);

    $('#inputname').keyup(name_check);
    $('#inputname').blur(name_checkL);

    $('#inputemail').blur(email_check);
    $('#inputemail').keyup(emaildub);

    $('#inputpassword').keyup(password_check);
    $('#inputpassword').blur(password_checkL);

    $('#inputpassword2').blur(password2_check);
    $('#inputpassword2').keyup(password2_checkL);

    $('#checkacc').click(function() {
        if ($('#checkacc').attr('checked')) {
            $('#erracc').slideUp(500).hide(function (){$(this).hide();});
        } else {
            $('#erracc').slideDown(500).show(function (){$(this).show();});
        }
    });
    
    // LINKS EFFECTS(Test): Just changes opacity on mouse over and off
    $('#links').mouseenter(function() {
        $('#links').fadeTo('fast', 1);
    });
    $('#links').mouseleave(function() {
        $('#links').fadeTo('fast', 0.8);
    }); 
    
    $('#linksitem').mouseenter(function() {
        $('#linksitem').fadeTo('fast', 1);
    });
    $('#linksitem').mouseleave(function() {
        $('#linksitem').fadeTo('fast',1);
    });
 /* Removing the above effect from the donate div
    Where is the CSS for #donate and .txtlink? Can't fix :O */
    
    $('#donate').mouseenter(function() {
        $('#donate').fadeTo('fast', 1);
    });
    $('#donate').mouseleave(function() {
        $('#donate').fadeTo('fast',1);
    }); 
    
    //fadeTo for myworkspace nav
    $('#stuff').mouseenter(function() {
        $('#stuff').fadeTo('fast', 1);
    });
    $('#stuff').mouseleave(function() {
        $('#stuff').fadeTo('fast', 0.7); /*0.6?*/
    });
    
    /*$('#nav').mouseenter(function() {
        $('#nav').fadeTo('fast', 1);
    });
    $('#nav').mouseleave(function() {
        $('#nav').fadeTo('fast', 0.8); //0.6?
    });*/
    
    /*Slide toggle workspace nav*/
    $("#flip").click(function(){
        $("#nav").slideToggle(500);
    });
    
    //fade to for news
    /*$('#news').mouseenter(function() {
        $('#news').fadeTo('fast', 1);
    });
    $('#news').mouseleave(function() {
        $('#news').fadeTo('fast', 0.8); /*0.6?*/
    /*});*/
    
    /*Slide toggle between Paypal logos. On hover -> original (Not currently working...?)
    $(document).ready(function(){
      $("#donate").click(function(){
        $("#paypal").show(500);
      });
      $("#donate").click(function(){
        $("#donate").hide(500);
    });
    */
    
    ////// This is the plan page below. This will both show plans and create new plans
    
    //This checks if we hover over the "buttons".
    // #createplan mouseenter checks
    $('#createplan').mouseenter(function() {
        //fade in
        $('#createplan').fadeTo('fast', 1);
    });
    // #createplan mouseleave checks
    $('#createplan').mouseleave(function() {
        // if we haven't switched away from #window
        if ($("#window").is(":visible")) {
            //fade out
            $('#createplan').fadeTo('fast', 0.8);
        }
    });
    // #viewplan mouseenter checks
    $('#viewplan').mouseenter(function() {
        //fade in
        $('#viewplan').fadeTo('fast', 1);
    });
    // #viewplan mouseleave checks
    $('#viewplan').mouseleave(function() {
        // if we haven't switched away from #window
        if ($("#window").is(":visible")) {
            // fade out
            $('#viewplan').fadeTo('fast', 0.8);
        }
    });
    
    // if we click the create plan button
    $('#createplan').click(function() {
        //hide #window
        $('#window').hide();
        //open #branch
        show('branch');
    });
    
    // Now in #branch, if #startplan is clicked, switch to branch1. then do complicated stuff. lots of it.
    $('#startplan').click(function() {
        //hide #branch
        $('#branch').hide();
        //show #branch1
        show('branch1');
        if ($("#smallprojplanbutton").is(":checked")) {
            $("#businessplan").hide();
            $("#smallprojplan").show();
        } else if ($("#businessplanbutton").is(":checked")) {
            $("#smallprojplan").hide();
            $("#businessplan").show();
        }
        $(".planform span").each(function(i) {
            $(this).attr("id","part"+i);
            $(this).children().val("");
            $(this).children().keydown(function() {
                if ($("#part"+(i+1)).is(":hidden")) {
                    $("#part"+(i+1)).show();
                }
            });
        });
    });
    
    //toggle between business plan and small project plan (well, really form).
    $("#smallprojplanbutton").click(function() {
        $("#businessplan").hide();
        $("#smallprojplan").show();
    });
    $("#businessplanbutton").click(function() {
        $("#smallprojplan").hide();
        $("#businessplan").show();
    });
    
    //on mouse enter, change donate button to paypal
    $("#alldonate").mouseenter(function() {
        $("#donate").hide();
        $("#paypal").show();
    });
    //on mouse leave, change back to donation
    $("#alldonate").mouseleave(function() {
        $("#paypal").hide();
        $("#donate").show();
    });
});
$('#stuff').mouseenter(function() {
        $('#stuff').fadeTo('fast', 1);
    });
    $('#stuff').mouseleave(function() {
        $('#stuff').fadeTo('fast', 0.6);
    });

//viewplans

    $(document).ready(function() {
    $('#viewplan').click(function() {
        //hide #window
        $('#window').hide();
        //show #doneplan
        $('#doneplan').show();
    });
});
//
$(document).ready(function() {
    $('#wrktab1').mouseenter(function() {
        $('#wrktab1').fadeTo('fast', 1);
        });
        $('#wrktab1').mouseleave(function() {
            $('#wrktab1').fadeTo('fast', 0.8);
        });

});
//
$(document).ready(function() {
    $('#wrktab2').mouseenter(function() {
        $('#wrktab2').fadeTo('fast', 1);
        });
        $('#wrktab2').mouseleave(function() {
            $('#wrktab2').fadeTo('fast', 0.8);
        });

});
//
    $(document).ready(function() {
    $('#wrktab2').click(function() {
        //hide #window
        $('#mainwrk1').hide();
        //show #doneplan
        $('#mainwrk2').show();
    });
});
//
    $(document).ready(function() {
    $('#wrktab1').click(function() {
        //hide #window
        $('#mainwrk2').hide();
        //show #doneplan
        $('#mainwrk1').show();
    });
});
//
$(document).ready(function() {
    $('#cchoose').click(function() {
        $('#ebox').hide();
        $('#cbox').show();
    });
});
//
$(document).ready(function() {
    $('#echoose').click(function() {
        $('#cbox').hide();
        $('#ebox').show();
    });
});
//toggle for projects:projects, and projects:freelancing
$(document).ready(function() {
    $('#Qs').click(function() {
        $('#As').slideToggle('slow');
        });
});
//toggle for projects:projects, and projects:freelancing
$(document).ready(function() {
    $('#Qb').click(function() {
        $('#Ab').slideToggle('slow');
        });
});
//
$(document).ready(function() {
    $('#changeactive').click(function() {
        $('.changeactive').fadeToggle('slow');
    });
});

$(document).ready(function() {
    if ($('#midright div span').html() == "arty") {
         $('#midright div span').css("color", "#111");
         $('#midright div span').css("backgroundColor", "#eee");
         $('#midright div span').css("padding", "5px 5px 5px 5px");
    }
});
