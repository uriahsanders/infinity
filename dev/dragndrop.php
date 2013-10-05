<?php
$_SERVER['DOCUMENT_ROOT'] .= '/infinity/dev';
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
?>
<html>
<head>
<title>Drag and drop contacts</title>
<meta charset='utf8'>
<link href='/infinity/dev/css/dark.css' rel='stylesheet' type='text/css' />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src='/infinity/dev/js/jquery-1.8.3.min.js'></script>
<script src='http://code.jquery.com/ui/1.10.3/jquery-ui.js'></script>
</head>
<body>
<style>
body {
	margin: 0px;
	padding: 0px;
}

#backgroundPopup {
    z-index: 1;
    position: fixed;
    display: none;
    height: 100%;
    width: 100%;
    background: #000000;
    top: 0px;
    left: 0px;
}

#toPopup {
    font-family: "lucida grande",tahoma,verdana,arial,sans-serif;
    background: none repeat scroll 0 0 #FFFFFF;
    border: 10px solid #ccc;
    border-radius: 3px 3px 3px 3px;
    color: #333333;
    display: none;
    font-size: 14px;
    left: 50%;
    margin-left: -402px;
    position: fixed;
    top: 20%;
    width: 800px;
    z-index: 2;
}

div.close {
    bottom: 30px;
    cursor: pointer;
    float: right;
    height: 30px;
    left: 50px;
    position: relative;
    width: 30px;
}

#popup_content {
    margin: 4px 7px;
}
</style>
<a id='create'>Create a group</a><br />
<div id='form' style='display:none'>
Group: <input type='text' id='groupInput' /><br />
Members: <input type='text' id='memberInput' /><input type='submit' value='Submit' id='submit' />
</div>
<script>
$('#submit').click(function (){
    if($('#groupInput').val() != "" && $('#memberInput').val() != ""){ //check if the input boxes are empty
        $.post("dragndrop_script.php",{
        group: $('#groupInput').val(),
        members: $('#memberInput').val()
        }, function(data){
        	if(data != "error" && data != ""){ //check for errors 
            	alert("Succesfully created group: " + $('#group').val());
            	$('#form').find('input[type=text]').val(''); //clear the input boxes
            }else{
            	alert("There was a problem making the group: " + $('#group').val());
            }
        });
    }else{
        alert("You must fill in all fields");
    }
});
</script>
<a id='show'>Show groups</a>
<div id='groups' style='display:none'><div id='trash' style='display:none'>trash</div></div>
<script>
$('#create').toggle(function (){
    $(this).text("Hide form");
    $('#form').slideToggle();
}, function (){
    $(this).text("Create a group");
    $('#form').slideToggle();
});
$('#show').toggle(function (){
    $(this).text("Hide groups");
    if($('#groups').children().length <= 1){ //check if the groups were already retrieved
        $.post("dragndrop_script.php", {
        get: "groups"
        }, function(data){
        	//console.log(data);
            var response = jQuery.parseJSON(data); //parse the json
            //console.log(response);
            if(response.length > 0){ //check to see if response is empty
                for(var i = 0; i <= response.length; ++i){
                	if(response[i] == undefined) break; //check if theres nothing left in the array
                    $('#groups').append("<div id='" + response[i] + "' class='group'>" + response[i] + "</div><a id='" + response[i] + "' class='showMembers'>Show Members</a><div id='" + response[i] + "-members' style='display:none'></div> <a class='edit' id='" + response[i] + "'>Edit group</a> <div id='toPopup'><div class='close'><a>Close</a></div><div id='popup_content'></div></div><div id='backgroundPopup'></div>"); //make a div for each group and append it to groups
                    $('#' + response[i]).draggable({cursor: "move"}); //make each div draggable 
                }
                $('#groups').slideDown();
                $('#trash').show();
                $('#trash').droppable({
                    drop: function (event, ui){
                        var id = ui.draggable.attr("id"); //get the id of the dropped div
                        var className = ui.draggable.attr("class"); //get the class name of the dropped div
                        if(className.startsWith("group")){
                        	className = "group";
                        	group = "";
                        }
                        else{ 
                        	className = "member";
                        	group = ui.draggable.attr("name"); //get the group the member is in
                        }
                        $.post("dragndrop_script.php", {
                        del: className,
                        name: id,
                        group: group //only used if a member is being deleted
                        }, function(data){
                        	if(data != "error" && data != ""){
                        		alert("Succesfully deleted " + className + ": " + id);
                        	}else{
                        		alert("There was an error deleting " + className + ": " + id + ". Please try again later.");
                        	}
                            //console.log(data);
                        });
                    }
                });
                $('.showMembers').toggle(function (){
                	var group = $(this).attr("id"); //get the group name
                	$(this).text("Hide members");
                	if($('#members').children().length <= 1){
                		$.post("dragndrop_script.php", {
                		get: "members", //send what you want to get
                		group: group //send the group
                		}, function (data){
                			console.log(data);
                			if(data != "error" && data != ""){ //check for errors
                				var members = jQuery.parseJSON(data); //parse json
                				if(members.length > 0){ //check to see if any members were returned
                					for(var i = 0; i <= members.length; ++i){
                						if(members[i] == undefined) break;
                						$('#' + group + '-members').append("<div id='" + members[i] + "' class='member' name='" + group + "'>" + members[i] + "</div>"); //make a div for each member
                						$('#' + members[i]).draggable({move: "true"}); //make each member div draggable
                					}
                					$('#' + group + '-members').slideDown();
                				}else{
                					$('#' + group + '-members').text("There are no members in this group.");
                				}
                			}else{
                				alert("There was a problem getting the members for group: " + group + ". Please try again later.");
                			}
                		});
                	}else{
                		$('#' + group + '-members').slideDown();
                	}
                }, function (){
                	$(this).text("Show members");
                	$('#' + $(this).attr("id") + '-members').slideUp();
                });
                $('.edit').click(function (){
                	popup("edit", $(this).attr("id")); //make the popup
                });
            }else{
                $('#groups').text("You have no groups.");
            }
        });
    }else{
        $('#groups').slideDown();
    }
}, function (){
    $(this).text("Show groups");
    $('#groups').slideUp();
});
function disablePopup(){
    $('#toPopup').fadeOut("normal"); //fadeout the popup div
    $('#backgroundPopup').fadeOut("normal"); //fadeout the content div
}
function popup(type, group){
	$('#toPopup').fadeIn(0500);
    $('#popup_content').text("Loading...");
    $('#backgroundPopup').css('opacity', '0.7');
    $('#backgroundPopup').fadeIn(0001);
    if(type == "edit"){
    	$('#popup_content').text(""); //get rid of Loading...
    	$('#popup_content').append("<p>Group name: <input id='groudEdit' type='text' value='" + group + "'></input></p><input type='submit' value='Submit' id='submitEdit'></input>"); //append the edit form
    	$('#submitEdit').click(function (){
    		$.post("dragndrop_script.php", {
    		edit: "group", //send what your going to edit
    		group: $('#groupEdit').val() //send the new group name
    		}, function (data){
    			console.log(data);
    			if(data != "" && data != "error"){
    				alert("Successfully edited group: " + group);
    			}else{
    				alert("There was an error please try again.");
    			}
    		});
    	});
    }else{
    	$('#popup_content').text("Error");
    }
    $('.close').click(function (){
    	disablePopup();
    });
}
$(this).keyup(function (event){
    if(event.which == 27){ //check if key pressed was esc
        disablePopup();
    }
});
</script>
</body>
</html>
