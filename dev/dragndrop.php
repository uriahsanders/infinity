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
html, body {
	margin:0;
	padding:0;
	width:100%;
	min-width:1000px;
	height: 100%;
}
.group {
	display: inline-block;
	border: 1px solid black;
	border-radius: 10px;
	margin: 5px;
	padding: 10px;
	text-align: center;
	width: 25%;
	height: 250px;
	background: rgba(0, 0, 0, .3);
	overflow: hidden;
}

.member {	
	display: block;
	cursor: pointer;
}

#toolbar {
	border-bottom: 1px solid black;
	padding: 5px;
	text-align: center;
}

#control {
	float: left;
	width: 16%;
	padding: 5px;
	text-align: center;
}

#contacts {
	text-align: center;
}

::-webkit-scrollbar              { width:10px; height:10px; background:rgba(27,27,27,1);}
::-webkit-scrollbar-button       { 
background: -webkit-gradient(linear, left top, right top, color-stop(0%, #4d4d4d), color-stop(100%, #333333));
border: 1px solid #0d0d0d;
height: 10px;
width: 10px;
border-top: 1px solid #666666;
border-left: 1px solid #666666; }
::-webkit-scrollbar-button:vertical:increment {background: rgb(27,27,27); background:url(/infinity/dev/images/down.png) no-repeat; background-size:6px; background-position:center} 
::-webkit-scrollbar-button:vertical:increment:active, ::-webkit-scrollbar-button:vertical:increment:hover { background:url(/infinity/dev/images/down2.png) no-repeat; background-size:6px; background-position:center} 
::-webkit-scrollbar-button:vertical:decrement {background: rgb(27,27,27);background:url(/infinity/dev/images/up.png) no-repeat; background-size:6px; background-position:center} 
::-webkit-scrollbar-button:vertical:decrement:active, ::-webkit-scrollbar-button:vertical:decrement:hover { background:url(/infinity/dev/images/up2.png) no-repeat; background-size:6px; background-position:center} 
::-webkit-scrollbar-button:horizontal:increment { background:url(/infinity/dev/images/right.png) no-repeat; background-size:6px; background-position:center} 
::-webkit-scrollbar-button:horizontal:increment:active, ::-webkit-scrollbar-button:horizontal:increment:hover { background:url(/infinity/dev/images/right2.png) no-repeat; background-size:6px; background-position:center} 
::-webkit-scrollbar-button:horizontal:decrement { background:url(/infinity/dev/images/left.png) no-repeat; background-size:6px; background-position:center} 
::-webkit-scrollbar-button:horizontal:decrement:active, ::-webkit-scrollbar-button:horizontal:decrement:hover { background:url(/infinity/dev/images/left2.png) no-repeat; background-size:6px; background-position:center} 
::-webkit-scrollbar-track        { }
::-webkit-scrollbar-track-piece  {background:rgba(79,79,79,1);}
::-webkit-resizer                {  }
::-webkit-scrollbar-thumb { 
background: rgba(27,27,27,1);
opacity: 0.5;
border: 1px solid #0d0d0d;
border-top: 1px solid #666666;
border-left: 1px solid #666666;}
::-webkit-scrollbar-thumb:hover  { background:rgba(27,27,27,.6)}
::-webkit-scrollbar-corner       {  }

a {
	opacity: .7;
	-webkit-transition: all linear 0.2s;
    -moz-transition: all linear 0.2s;
    -ms-transition: all linear 0.2s;
    -o-transition: all linear 0.2s;
    transition: all linear 0.2s;
    cursor: pointer;
}

a:hover {
	opacity: 1;
}
</style>
<div id="control">
<div id='form'>
Group: <input type='text' id='groupInput' /><br />
Members: <input type='text' id='memberInput' /><input type='submit' value='Submit' id='submit' />
</div>
<div id='searchForm'><input type='text' id='query' /><input type='submit' id='searchButton' value='Search' /></div><div id='results'></div>
<div id="contacts">Contacts</div>
</div>
<script>
$('#submit').click(function (){
    if($('#groupInput').val() != "" && $('#memberInput').val()){ //check if the input boxes are empty
        $.post("dragndrop_script.php",{
        group: $('#groupInput').val(), //send the group name
        members: $('#memberInput').val() //send the member name
        }, function(data){
        	if(data != "error" && data != ""){ //check for errors
        		var group = $('#groupInput').val(); 
            	alert("Succesfully created group: " + $('#groupInput').val());
            	$('#form').find('input[type=text]').val(''); //clear the input boxes
            	$('#groups').append("<div id='" + group + "' class='group'><span id='" + group + "' class='name'>" + group + "</span><br ><span class='group-toolbar'><a id='" + group + "' class='showMembers'>Show Members</a> <a id='" + group + "' class='edit'>Edit</a></span></div>"); //append the new group to groups
            	$('span#' + response[i]).draggable({cursor: "move", cancel: ".edit, .showMembers", scroll: false, helper: "clone"}); //make each div draggable 
                $('#' + response[i]).droppable({
                    drop: function (event, ui){
                    	if(ui.draggable.attr("class").startsWith("member")){
                    		$.post("dragndrop_script.php", {
                    		group: $(this).attr("id"),
                    		member: ui.draggable.attr("id"),
                    		do: "copy"
                    		}, function(data){
                    			console.log(data);
                    			$('#' + $(this).attr("id")).append("<span class='member'>" + ui.draggable.attr("id") + "</span>");
                    			alert("Sucess");
                    		});
                    	}
                    }
               });
            }else{
            	alert("There was a problem making the group: " + $('#groupInput').val());
            }
            console.log(data);
        });
    }else{
        alert("You must fill in all fields");
    }
});
$('#searchButton').click(function (){
	if($('#query').val() != ""){
		$.post("dragndrop_script.php", {
		query: $('#query').val()
		}, function(data){
			data = data.substring(0, data.length - 2);
			console.log(data);
			if(data != null && data != undefined && data != "error"){
				$('#results').empty();
				var results = jQuery.parseJSON(data);
				//console.log(results);
				$('#results').slideDown();
				if(results[0] != "No results.") $('#results').append("<p style='text-align:left'>Found " + results.length + " result(s)</p>"); //if results[0] doesnt equal no results append the amount of results returned
				for(var i = 0; i <= results.length; ++i){
					if(results[i] == undefined) break;
					$('#results').append("<div style='text-align:left'>" + results[i] + "</div>"); //append each result
				}
			}else{
				$('#results').append("There was an error trying to search for " + $('#query').val());
			}
		});
	}else{
		alert("Please fill in the search feild.");
	}
});
</script>
<div id='groups' style='display:none'><div id='trash' style='display:none'>trash</div></div>
<script>
$(document).ready(function (){
    if($('#groups').children().length <= 1){ //check if the groups were already retrieved
        $.post("dragndrop_script.php", {
        get: "groups"
        }, function(data){
        	data = data.substring(0, data.length - 2);
        	//console.log(data);
            var response = jQuery.parseJSON(data); //parse the json
            //console.log(response);
            if(response.length > 0 && response[0] != "no groups"){ //check to see if response is empty
                for(var i = 0; i <= response.length; ++i){
                	if(response[i] == undefined) break; //check if theres nothing left in the array
                    $('#groups').append("<div id='" + response[i] + "' class='group'><span id='" + response[i] + "' class='name'>" + response[i] + "</span><br ><span class='group-toolbar'><a id='" + response[i] + "' class='showMembers'>Show Members</a> <a id='" + response[i] + "' class='edit'>Edit</a></span></div>"); //make a div for each group and append it to groups
                    $('span#' + response[i]).draggable({cursor: "move", cancel: ".edit, .showMembers", scroll: false, revert: "invalid", helper: "clone"}); //make each div draggable 
                    $('#' + response[i]).droppable({
                    	drop: function (event, ui){
                    		if(ui.draggable.attr("class").startsWith("member")){ //check if dropped object is a member
                    			$.post("dragndrop_script.php", {
                    			group: $(this).attr("id"),
                    			member: ui.draggable.attr("id"),
                    			do: "copy"
                    			}, function(data){
                    				//console.log(data);
                    				$('span#' + $(this).attr("id")).append("<span id='" + ui.draggable.attr("id") + "' class='member'>" + ui.draggable.attr('id') + "</span>"); //add the new member to the group div
                    				alert("Sucess");
                    			});
                    		}
                    	}
                    });
                }
                $('#groups').fadeIn();
                $('#trash').show();
                //code for making trash can
                $('#trash').droppable({
                    drop: function (event, ui){
                        var id = ui.draggable.attr("id"); //get the id of the dropped div
                        var className = ui.draggable.attr("class"); //get the class name of the dropped div
                        if(className.startsWith("name")){
                        	className = "group";
                        	group = ""; //group isnt needed so set it to null
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
                        		if(className == "group"){
                        			$('#' + id).remove(); //remove the group div
                        			//ill find a better way to do this later
                        			$(document.getElementById(id)).remove(); //remove the showMembers link
                        			$(document.getElementById(id)).remove(); //remove the edit link 
                        		}else{
                        			$('#' + id).remove(); //remove member div
                        		}
                        	}else{
                        		alert("There was an error deleting " + className + ": " + id + ". Please try again later.");
                        	}
                            //console.log(data);
                        });
                    }
                });
                //code for showing members
                $('.showMembers').toggle(function (){
                	var group = $(this).attr("id"); //get the group name
                	$('span#' + group).draggable("disable");
                	$(this).text("Hide members");
                	$.post("dragndrop_script.php", {
                	get: "members", //send what you want to get
                	group: group //send the group
                	}, function (data){
                		data = data.substring(0, data.length - 2);
                		//console.log(data);
                		if(data != "error" && data != ""){ //check for errors
                			var members = jQuery.parseJSON(data); //parse json
                			//console.log(members);
                			if(members.length > 0 && members[0] != "no members"){ //check to see if any members were returned
                				for(var i = 0; i <= members.length; ++i){
                					if(members[i] == undefined) break;
                					$('#' + group).append("<span id='" + members[i] + "' class='member' name='" + group + "'>" + members[i] + "</span>"); //make a span for each member
                					$('span#' + members[i]).draggable({move: "true", scroll: false, helper: "clone", revert: "invalid"}); //make each member span draggable
                				}
                			}else{
                				$('#' + group).append("<span class='member'>There are no members for this group.</span>");
                			}
                		}else{
                			alert("There was a problem getting the members for group: " + group + ". Please try again later.");
                		}
                	});
                }, function (){
                	$(this).text("Show members");
                	$('#' + $(this).attr("id")).find('.member').fadeOut(); //find all members and then fade them out
                	$('span#' + $(this).attr("id")).draggable("enable");
                });
                //code for editing
                $('.edit').toggle(function (){
                	$(this).text("Save");
                	$('#close').show();
                	var group = $(this).attr("id");
                	$('span#' + group).draggable("disable"); //disable dragging so its easier to edit
                	$('span.name:contains("' + group +'")').attr("contenteditable", "true"); //make div editable
                }, function (){
                	$(this).text("Edit Group");
                	var group = $(this).attr("id");
                	$('span#' + group).draggable("enable"); //enable dragging
                	$('span.name:contains("' + group +'")').attr("contenteditable", "false"); //turn editing off
                	$.post("dragndrop_script.php", {
                	edit: "group", //what your editing
                	group: group, //old group name
                	name: $('span#' + group).text() //new group name
                	}, function(data){
                		$('#' + group).attr("id", $('span#' + group).text()); //change the group id to the new one
                		$('span#' + group).attr("id", $('span#' + group).text()); //change the span group id to the new one
                		//console.log(data);
                	});
                });
            }else{
                $('#groups').text("You have no groups.");
                $('#groups').fadeIn();
            }
        });
    }
	$.post("dragndrop_script.php", {
	get: "contacts"
	}, function (data){
		data = data.substring(0, data.length - 2);
		//console.log(data);
		contacts = jQuery.parseJSON(data);
		//console.log(contacts);
		if(contacts.length > 0 && contacts[0] != "No contacts"){
			for(var i = 0; i < contacts.length; ++i){
				$('#contacts').append("<span id='" + contacts[i] + "' class='member'>" + contacts[i] + "</span>");
				$('#' + contacts[i]).draggable({move: "true", scroll: false, helper: "clone", revert: "invalid"});
			}
		}else{
			$('#contacts').append("You have no contacts.");
		}
	});
});
</script>
</body>
</html>
