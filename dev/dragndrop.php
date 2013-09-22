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
<a id='create'>Create a group</a><br />
<div id='form' style='display:none'>
Group: <input type='text' id='group' /><br />
Members: <input type='text' id='members' /><input type='submit' value='Submit' id='submit' />
<script>
$('#submit').click(function (){
    if($('#group').val() != "" && $('#members').val() != ""){
        $.post("dragndrop_script.php",{
        group: $('#group').val(),
        members: $('#members').val()
        }, function(data){
        	if(data != "error" || data != ""){
            	alert("Succesfully created group " + $('#group').val());
            	$('#form').find('input[type=text]').val('');
            }else{
            	alert("There was a problem making the group: " + $('#group').val());
            }
        });
    }else{
        alert("You must fill in all fields");
    }
});
</script>
</div>
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
            var response = jQuery.parseJSON(data);
            $('#groups').slideDown();
            if(response.length > 0){
                for(var i = 0; i <= response.length; i++){
                	if(response[i] == undefined) break; //check if theres nothing left in the array
                    $('#groups').append("<div id='" + response[i] + "' class='group'>" + response[i] + "</div>");
                    $('#' + response[i]).draggable({cursor: "move"}); //make each div draggable
                }
                $('#trash').show();
                $('#trash').droppable({
                    drop: function (event, ui){
                        var id = ui.draggable.attr("id"); //get the id of the dropped div
                        var className = ui.draggable.attr("class"); //get the class name of the dropped div
                        if(className.startsWith("group")) className = "group";
                        else className = "member";
                        $.post("dragndrop_script.php", {
                        del: className,
                        name: id
                        }, function(data){
                            alert("Succesfully deleted " + className + ": " + id)
                            console.log(data);
                        });
                    }
                });
                $('#showMembers').toggle(function (){
                	$(this).text("Hide members");
                	$.post("dragndrop.php", {
                	get: "members",
                	group: ""
                	}, function (data){
                		console.log(data);
                		var response = jQuery.parseJSON(data);
                		//$('#members').append(response);
                	});
                }, function (){
                	$(this).text("Show members");
                	//$('#members').slideUp();
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
</body>
</html>
