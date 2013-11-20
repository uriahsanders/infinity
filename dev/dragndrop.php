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
	height: 100%;
	display: none;
}

#toolbar {
	border-bottom: 1px solid black;
	padding: 5px;
	text-align: center;
}

#trash {
	display: block;
	padding 2px;
	position: fixed;
	bottom: 0;
	right: 0;
}
</style>
<div id='toolbar'><input type='text' placeholder="Search Groups" id='groupQuery' /><input type='submit' value='Search' id='searchGroups' /> <a onclick='window.location.reload();'>View All</a></div>
<div id="control">
<div id='form'>
Create Group: <br/><input type='text' id='groupInput' placeholder="Group Name" /><input type='submit' value='Submit' id='submit' />
</div>
<div id='searchForm'><input type='text' id='query' placeholder="Search Contacts" /><input type='submit' id='searchContacts' value='Search' /></div><div id='results'></div>
<div id="contacts">Contacts</div>
</div>
<script>
$('#submit').click(function (){
    if($('#groupInput').val() != ""){ //check if the input boxes are empty
        $.post("dragndrop_script.php",{
        group: $('#groupInput').val(), //send the group name
        do: "create" //send whats supposed to happen
        }, function(data){
        	if(data != "error" && data != ""){ //check for errors
        		var group = $('#groupInput').val(); 
            	alert("Succesfully created group: " + $('#groupInput').val());
            	$('#form').find('input[type=text]').val(''); //clear the input boxes
            	$('#groups').append("<div id='" + group + "' class='group'><span id='" + group + "' class='name'>" + group + "</span><br ><span class='group-toolbar'><a id='" + group + "' class='showMembers'>Show Members</a> <a id='" + group + "' class='edit'>Edit</a></span></div>"); //append the new group to groups
            	$('span#' + group).draggable({cursor: "move", scroll: false, revert: "invalid", helper: "clone"}).dblclick(function (){
					if($(this).is('.ui-draggable-dragging')){
                 		return;
            		}
            		window.location.replace("/group/" + $(this).attr("id"));
				});
                $('div#' + group).droppable({
                    drop: function (event, ui){
                    	var group = $(this).attr("id");
                    	if(ui.draggable.attr("class").startsWith("member")){
                    		$.post("dragndrop_script.php", {
                    		group: group,
                    		member: ui.draggable.attr("id"),
                    		do: "copy"
                    		}, function(data){
                    			console.log(data);
                    			$('span#' + group).append("<span id='" + ui.draggable.attr('id') + "' class='member' name='" + group + "'>" + ui.draggable.attr('id') + "</span>");
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
$('#searchContacts').click(function (){
	if($('#query').val() != ""){
		$.post("dragndrop_script.php", {
		query: $('#query').val(),
		what: "contact" //send what your searching for
		}, function(data){
			data = data.substring(0, data.length - 2);
			console.log(data);
			if(data != undefined && data != "error"){
				$('#contacts').empty(); //empty the contacts so you can see the results
				var results = jQuery.parseJSON(data);
				//console.log(results);
				if(results[0] != "No results.") $('#contacts').append("<p style='text-align:center'>Found " + results.length + " result(s)</p>"); //if results[0] doesnt equal no results append the amount of results returned
				for(var i = 0; i < results.length; ++i){
					$('#contacts').append("<div style='text-align:center'>" + results[i] + "</div>"); //append each result
				}
			}else{
				$('#results').append("There was an error trying to search for " + $('#query').val());
			}
		});
	}else{
		alert("Please fill in the search feild.");
	}
});
$('#searchGroups').click(function (){
	if($('#groupQuery').val() != ""){
		$.post("dragndrop_script.php", {
		query: $('#groupQuery').val(),
		what: "groups"
		}, function (data){
			data = data.substring(0, data.length - 2);
			console.log(data);
			$('#groups').empty(); //make the groups empty so the results can be displayed
			var results = jQuery.parseJSON(data);
			console.log(results);
			if(results[0] != "No results.") $('#groups').append("<p style='text-align:center'>Found " + results.length + " result(s).</p>");
			for(var i = 0; i < results.length; i++){
				$('#groups').append("<div style='text-align:center'>" + results[i] + "</div>")
			}
		});
	}else{
		alert("Please fill in the search field.");
	}
});
</script>
<div id='groups' style='display:none'><div id='trash' style='display:none'><img src='images/trash.png' width='50' height='50'></img></div></div>
<script>
$(document).ready(function (){
	$.post("dragndrop_script.php", {
    get: "groups"
    }, function(data){
        data = data.substring(0, data.length - 2);
        //console.log(data);
        var response = jQuery.parseJSON(data); //parse the json
        //console.log(response);
        if(response.length > 0 && response[0] != "no groups"){ //check to see if response is empty
        	for(var i = 0; i < response.length; ++i){
            	$('#groups').append("<div id='" + response[i] + "' class='group'><span id='" + response[i] + "' class='name'>" + response[i] + "</span><br ><span class='group-toolbar'><a id='" + response[i] + "' class='showMembers'>Show Members</a> <a id='" + response[i] + "' class='edit'>Edit</a></span></div>"); //make a div for each group and append it to groups
                $('span#' + response[i]).draggable({cursor: "move", scroll: false, revert: "invalid", helper: "clone"}).dblclick(function (){
					if($(this).is('.ui-draggable-dragging')){
                 		return;
            		}
            		window.location.replace("/group/" + $(this).attr("id"));
				}); //make each div draggable
                $('div#' + response[i]).droppable({
                	drop: function (event, ui){
                    	var group = $(this).attr("id");
                    	if(ui.draggable.attr("class").startsWith("member")){ //check if dropped object is a member
                    		$.post("dragndrop_script.php", {
                    		group: group,
                    		member: ui.draggable.attr("id"),
                    		do: "copy"
                    		}, function(data){
                    			//console.log(data);
                    			$('div#' + group).append("<span style='display:none' id='" + ui.draggable.attr("id") + "' class='member' name='" + group + "'>" + ui.draggable.attr('id') + "</span>"); //add the new member to the group div
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
                    }else{ 
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
                        		$('span#' + id + ".member").remove(); //remove member div
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
                			for(var i = 0; i < members.length; ++i){
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
           	});
            //code for editing
            $('.edit').toggle(function (){
              	$(this).text("Save");
                var group = $(this).attr("id");
                $('span#' + group).draggable("disable"); //disable dragging so its easier to edit
                $('span#' + group).attr("contenteditable", "true"); //make div editable
            }, function (){
                $(this).text("Edit");
                var group = $(this).attr("id");
                $('span#' + group).draggable("enable"); //enable dragging
                $('span#' + group).attr("contenteditable", "false"); //turn editing off
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
    //code for contacts
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
				$('#' + contacts[i]).draggable({move: "true", scroll: false, helper: "clone", revert: "invalid"}).dblclick(function (){
					if($(this).is('.ui-draggable-dragging')){
                 		return;
            		}
            		window.location.replace("user/" + $(this).attr("id"));
				});
			}
			$('#contacts').fadeIn();
		}else{
			$('#contacts').append("You have no contacts.");
			$('#contacts').fadeIn();
		}
	});
});
</script>
</body>
</html>
