<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD)or die(mysql_error());
mysql_select_db(SQL_DB)or die(mysql_error());
?>
<html>
<head>
<meta charset="utf8"></meta>
<link href='milestone.css' rel='stylesheet' type='text/css' />
<link href='/css/dark.css' rel='stylesheet' type='text/css' />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
<script src='/js/jquery-1.8.3.min.js'></script>
</head>
<body>
<h2 style="text-align: center;">Milestones</h2>
<div id="form">
Title: <input type="text" name="title" id="title" /><br />
Description: <br /><textarea id="desc" cols="60" rows="10"></textarea><br />
User: <input type="text" name="user" id="user" /><br />
Date:
<?php 
echo "<select id='year'>";
$year = date("Y");
for($i = $year; $year + 10 > $i; $i++){
    echo "<option value='$i'>$i</option>";
}
echo "</select>";
echo "<select id='month'>";
for($i = 1; $i <= 12; $i++){
    echo "<option value='$i'>$i</option>";
}
echo "</select>";
echo "<select id='day'>";
$num = cal_days_in_month(CAL_GREGORIAN, date("n"), $year);
for($i = 1;$i <= $num; $i++){
    echo "<option value='$i'>".$i."</option>";
}
echo "</select>"
?>
<br />
Due Date: 
<?php
echo "<select id='yeardue'>";
$year = date("Y");
for($i = $year; $year + 10 > $i; $i++){
    echo "<option value='$i'>$i</option>";
}
echo "</select>";
echo "<select id='monthdue'>";
for($i = 1; $i <= 12; $i++){
    echo "<option value='$i'>$i</option>";
}
echo "</select>";
echo "<select id='daydue'>";
$num = cal_days_in_month(CAL_GREGORIAN, date("n"), $year);
for($i = 1;$i <= $num; $i++){
    echo "<option value='$i'>".$i."</option>";
}
echo "</select>";
?>
<input type="submit" id="submit" value="Create" /><br />
</div>
<select class="project_select">
                 <?php
                             //Changing projects. Coded in main file for first priority
                             $sql = new SQL;
                             //Get unique returns from database, oldest -> newest
                             $result = $sql->Query("
                                 SELECT DISTINCT
                                 `projectID`
                                 FROM `projects_invited` 
                                 WHERE `person` = %d
                                 AND `accepted` = %d
                                 GROUP BY `projectID` ASC
                             ", $_SESSION['ID'], 1);
                             while($row = mysql_fetch_assoc($result)){
                                 //actual .val() is $id
                                 echo "<option value='".$row['projectID']."'>".$row['projectID']."</option>";
                             }
                        ?>
            </select>
<script>
$('document').ready(function (){
    $('#submit').click(function (){
        if($('#title').val() != "" && $('#desc').val() != "" && $('#user').val() != "" && $('#date').val() != "" && $('.project_select').val() != ""){
            var title = $('#title').val();
            var desc = $('#desc').val();
            if($('#month').val() < 10) var month = "0" + $('#month').val();
            else var month = $('#monthdue').val();
            if($('#day').val() < 10) var day = "0" + $('#day').val();
            else var day = $('#day').val();
            var date = $('#year').val() + "-" + month + "-" + day;
            var user = $('#user').val();
            var project = $('.project_select').val();
            if($('#monthdue').val() < 10) var monthdue = "0" + $('#monthdue').val();
            else var monthdue = $('#monthdue').val();
            if($('#daydue').val() < 10) var daydue = "0" + $('#daydue').val();
            else var daydue = $('#daydue').val();
            var duedate = $('#yeardue').val() + "-" + monthdue + "-" + daydue;
            console.log(duedate);
            $.post("milestone_script.php", {
            title: title,
            desc: desc,
            date: date,
            user: user,
            project: project,
            duedate: duedate
            }, function (data){
                if(data != ""  && data != "error"){
                    alert("Succesfully added milestone " + title);
                    $('#form').find('input[type=text], textarea, input[type=date]').val('');
                }else{
                    alert("There was a problem creating milestone " + title);
                }
            });
        }else{
            alert("You must fill in all feilds.");
        }
    });
});
function change(month, year, project){
    $('#milestones').text("Loading...");
    $.post("milestone_script.php", {
            calendar: "yes",
            month: month,
            year: year,
            project: project
        }, function (data){
            if(data != "error" && data != ""){
                $('#milestones').html(data);
            }else{
                alert("There was an error while loading the calendar please try again.");
            }
            console.log(data);
        });
}
$(this).keyup(function(event){
    if(event.which == 27){
        disablePopup();
    }
});
function popup(date){
    $('#toPopup').fadeIn(0500);
    $('#popup_content').text("Loading...");
    $('#backgroundPopup').css('opacity', '0.7');
    $('#backgroundPopup').fadeIn(0001);
    var project = $('.project_select').val();
    $.post("milestone_script.php", {
    get: "data",
    date: date,
    project: project
    }, function (data){
        var nullresp = "There are no milestones for this date.";
        if(data != nullresp && data != ""){
            var response = jQuery.parseJSON(data);
            $('#popup_content').html("<h3>" + response[0] + "</h3>User: " + response[1] + "<br />Task: " + response[2] + "<br />Date: " + date + "<br />Finished: " + response[3] + "<br /><a id='delete' name='" + response[4] + "' style='color:black'>Delete</a> <a id='finish' name='" + response[4] + "' style='color:black'>Finish</a> <a id='edit' name='" + response[4] + "' style='color:black'>Edit</a>");
            $('#delete').click(function (){
                var id = this.name;
                $.post("milestone_script.php", {what: "delete", id: id}, function (data){
                    if(data != "" && data != "error"){
                        alert("Succesfully deleted");
                    }else{
                        alert("There was an error please try again later.");
                    }
                });
            });
            $('#finish').click(function (){
                var id = this.name;
                $.post("milestone_script.php", {what: "finish", id: id}, function (data){
                    if(data != "" && data != "error"){
                        alert("Marked as finished");
                    }else{
                        alert("There was an error please try again later.");
                    }
                });
            });
            $('#edit').click(function (){
                var id = this.name;
                disablePopup();
                editPopup(id);
            });
        }else{
            $('#popup_content').html(data);
        }
    });
    $('.close').click(function (){
        disablePopup();
    });
}
function disablePopup(){
    $('#toPopup').fadeOut("normal");
    $('#backgroundPopup').fadeOut("normal");
}
function editPopup(id){
    $('#toPopup').fadeIn(0500);
    $('#popup_content').text("Loading...");
    $('#backgroundPopup').css('opacity', '0.7');
    $('#backgroundPopup').fadeIn(0001);
    $.post("milestone_script.php", {
    what: "getInfo",
    id: id
    }, function(data){
        if(data != "error" && data != ""){
            var response = jQuery.parseJSON(data);
            $('#popup_content').html("<p>Title: </p><input type='text' id='Title' value='" + response[0] + "' /> <br /> <p>Description: </p><input type='text' id='Desc' value='" + response[1] + "' /> <br /> <p>User: </p><input type='text' id='User' value='" + response[2] + "' /> <br /> <input type='submit' id='update' value='Submit' />");
            $('#update').click(function (){
                console.log($('#Title').val() + " | " + $('#Desc').val() + " | " + $('#User').val());
                if($('#Title').val() != "" && $('#Desc').val() != "" && $('#User').val() != ""){
                    $.post("milestone_script.php", {
                    title: $('#Title').val(),
                    desc: $('#Desc').val(),
                    user: $('#User').val(),
                    id: id,
                    what: "update"
                    }, function(data){
                        if(data != "error" && data != ""){
                            alert("Sucessfully updated milestone.");
                        }else{
                            alert("There was a problem updating. Please try again.");
                        }
                        console.log(data);
                    });
                
                }else{
                    alert("You must fill something in for every input box.");
                }
            });
        }else{
            alert("There was an error please try again later.");
            disablePopup();
        }
    });
}
</script>
<a id="cal">Show milestones</a>
<div id="milestones"></div>
<script>
$('#cal').toggle(function (){
    $(this).text("Hide milestones");
    $('#form').fadeOut("fast");
    if($('#milestones').is(':empty')){
        $('#milestones').text("Loading...");
        var date = new Date();
        var project = $('.project_select').val();
        $.post("milestone_script.php", {
            calendar: "yes",
            month: date.getMonth() + 1,
            year: date.getFullYear(),
            project: project
        }, function (data){
            if(data != "error" && data != ""){
                $('#milestones').html(data);
            }else{
                alert("There was an error while loading the calendar please try again.");
                $('#milestones').slideUp();
            }
        });
    }else{
        $('#milestones').slideDown();
    }
}, function (){
    $(this).text("Show milestones");
    $('#milestones').slideUp();
    $('#form').fadeIn("fast");
});
</script>
</body>
</html>
