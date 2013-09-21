<?php

    echo '<form action="/infinity/dev/member/login.php" method="post">
                <input type="text" name="usr" id="inputusr" />&nbsp;&nbsp;
                <input type="password" name="pwd" id="inputpwd" />&nbsp;&nbsp;
                <input type="submit" name="login" id="loginbtn" value="Login" />&nbsp;
                <input type="button" name="new" id="newbtn" value="+" onclick="show(\'register\');"/>&nbsp;
                <input type="button" name="forgott" id="forgottbtn" value="?" onclick="show(\'recover\');" />
            </form><br />';


?>