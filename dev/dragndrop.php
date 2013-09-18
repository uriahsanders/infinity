<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
?>
<html>
<head>
<title>Drag and drop contacts</title>
<meta charset='utf8'>
<link href='/css/dark.css' rel='stylesheet' type='text/css' />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src='/js/jquery-1.8.3.min.js'></script>
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
            alert("Succesfully created group " + $('#group').val());
            $('#form').find('input[type=text]').val('');
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
    if($('#groups').children().length <= 1){
        $.post("dragndrop_script.php", {
        get: "groups"
        }, function(data){
            var response = jQuery.parseJSON(data);
            $('#groups').slideDown();
            if(response.length > 0){
                for(var i = 0; i <= response.length; i++){
                    $('#groups').append("<div id='" + response[i] + "' class='group'>" + response[i] + "</div>");
                    $('#' + response[i]).draggable({cursor: "move"});
                }
                $('#trash').show();
                $('#trash').droppable({
                    drop: function (event, ui){
                        var id = ui.draggable.attr("id");
                        var className = ui.draggable.attr("class");
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