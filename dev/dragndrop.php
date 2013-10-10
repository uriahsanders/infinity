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
            	alert("Succesfully created group: " + $('#groupInput').val());
            	$('#form').find('input[type=text]').val(''); //clear the input boxes
            }else{
            	alert("There was a problem making the group: " + $('#groupInput').val());
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
                    $('#groups').append("<div id='" + response[i] + "' class='group'>" + response[i] + "</div><a id='" + response[i] + "' class='showMembers'>Show Members</a><div id='" + response[i] + "-members' style='display:none'></div> <a class='edit' id='" + response[i] + "'>Edit Group</a>"); //make a div for each group and append it to groups
                    $('#' + response[i]).draggable({cursor: "move"}); //make each div draggable 
                    $('#' + response[i]).droppable({
                    	drop: function (event, ui){
                    		if(ui.draggable.attr("class").startsWith("member")){
                    			console.log("dropped");
                    			$.post("dragndrop_script.php", {
                    			group: $(this).attr("id"),
                    			member: ui.draggable.attr("id"),
                    			do: "copy"
                    			}, function(data){
                    				console.log(data);
                    				alert("Sucess");
                    			});
                    		}
                    	}
                    });
                }
                $('#groups').slideDown();
                $('#trash').show();
                //code for making trash can
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
                //code for showing members
                $('.showMembers').toggle(function (){
                	var group = $(this).attr("id"); //get the group name
                	$(this).text("Hide members");
                	if($('#members').children().length <= 1){
                		$.post("dragndrop_script.php", {
                		get: "members", //send what you want to get
                		group: group //send the group
                		}, function (data){
                			//console.log(data);
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
                //known problems: error when deleting even though successful and not being able to copy members
                $('.edit').toggle(function (){
                	$(this).text("Save");
                	var group = $(this).attr("id");
                	$('#' + group).draggable("disable"); //disable dragging so its easier to edit
                	$('#' + group).attr("contenteditable", "true"); //make div editable
                }, function (){
                	$(this).text("Edit Group");
                	var group = $(this).attr("id");
                	$('#' + group).draggable("enable"); //enable dragging
                	$('#' + group).attr("contenteditable", "false"); //turn editing off
                	$.post("dragndrop_script.php", {
                	edit: "group", //what your editing
                	group: group, //old group name
                	name: $('#' + group).text() //new group name
                	}, function(data){
                		$('#' + group).attr("id", $('#' + group).text()); //change the group id to the new one
                		console.log(data);
                	});
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
</script>
<div></div>
<a id='searchLink'>Search</a>
<div style='display:none' id='searchForm'><input type='text' id='query' /><input type='submit' id='searchButton' value='Search' /></div><div id='results'></div>
<script>
$('#searchLink').toggle(function (){
	$(this).text("Hide Search Form");
	$('#searchForm').slideToggle();
	$('#searchButton').click(function (){
		if($('#query').val() != ""){
			$.post("dragndrop_script.php", {
			query: $('#query').val()
			}, function(data){
				console.log(data);
				if(data != null && data != undefined){
					var results = jQuery.parseJSON(data);
					for(var i = 0; i <= results.length; ++i){
						if(results[i] == undefined) break;
						$('#results').append(results[i]);
					}
				}else{
					$('#results').append("No results");
				}
			});
		}else{
			alert("Please fill in the search feild.");
		}
	});
}, function (){
	$(this).text("Search");
	$('#searchForm').slideToggle();
});
</script>
</body>
</html>
