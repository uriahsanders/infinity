<html>
    <head>
        <script type="text/javascript" src="poll.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>  
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
        <link rel="shortcut icon" href="/favicon.ico" />
        <link rel="stylesheet" type="text/css" href="projects.css" />
        <meta charset="UTF-8">
        <title>
            Infinity-Workspace
        </title>
        <script>
            getCurrentUsers(1);
        </script>
    </head>
    <body>
        <?php
            $what = 'update';
            $info = $_SESSION['ID'].'pressed the notification button';
            echo '<br /><br /><br /><br /><br /><br /><center><h1><a id="btn"onclick="notify('.$what.', '.$info.');">Send notification test</a></h1></center><br />';
        ?>
    </body>
</html>