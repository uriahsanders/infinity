<html>
    <head>
        <title>Workspace</title>
    </head>
    <body style="background-color:#2d3035;">
        <?php
                $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
                mysql_select_db(SQL_DB) or die(mysql_error());
                $result = mysql_query("SELECT * FROM projects WHERE creator = '$_SESSION[usr]' OR invited = '$_SESSION[usr]'");
                if(mysql_num_rows($result) == 0){
                    echo "<center>Sorry!<hr /><br />You seem to have not created or joined any projects yet. Please return to the workspace after you have done so.";
                    echo "<br /><br />";
                    echo "<a href='projects.php'>Back</a></center>";
                }else{
                    header("Location: projects.php");
                }
        ?>
    </body>
</html>