<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
include_once($_SERVER['DOCUMENT_ROOT']. '/new_projects/script.php');
mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD)or die(mysql_error());
mysql_select_db(SQL_DB);
?>
<html>
<head>
<link href='projects.css' rel='stylesheet' type='text/css' />
<link href='/css/dark.css' rel='stylesheet' type='text/css' />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
<script src='/js/jquery-1.8.3.min.js'></script>
<script src='projects.js'></script>
</head>
<body>
<?php
$result = mysql_query("SELECT * FROM projects WHERE completed = 'false' LIMIT 6")or die(mysql_error());
if(mysql_num_rows($result) != 0){
    echo "<div id='projects'>";
    while($row = mysql_fetch_array($result)){
        $name = $row['name'];
        $desc = $row['description'];
        $creator = $row['creator'];
        $invited = $row['invited'];
        $health = $row['health'];
        $date = $row['date'];
        $popular = $row['popularity'];
        $form  = $row['form'];
        $slogan = $row['slogan'];
        $complete = $row['completed'];
        $category = $row['category'];
        $rewards = $row['rewards'];
        $short  = $row['short'];
        $budget = $row['budget'];
        $risks = $row['risks'];
        $skills = $row['skills'];
        $level = "standard";
        echoThumbnail($name, $creator, $invited, $date, $health, $complete, $popular, $level, $category, $desc, $slogan, $form, $rewards, $skills, $risks, $budget, $short);
    }
    echo "</div>";
    $check = mysql_query("SELECT * FROM projects WHERE completed = 'false'")or die(mysql_error());
    $num = mysql_num_rows($check);
    $pagenum = floor($num / 6) + 1;
    for($i = 1; $i <= $pagenum; $i++){
        echo "<a class='page' name='".$i."'>".$i."</a> ";
    }
}
?>
<script>
$(document).ready(function (){
    var num = null;
    $('.page').click(function (){
        num = $(this).attr('name') * 6;
        $('#projects').text("loading...");
        $.post("pages.php", {limit: num}, function(data){
            console.log(data);
            $('#projects').html(data);
        });
    });
});
</script>
</body>
</html>