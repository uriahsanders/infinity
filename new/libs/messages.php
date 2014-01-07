<?php
if (!defined("INFINITY"))
    die(); // do not allow direct access to this fie
	
	
/**
	[TODO] - fix the messages to be correct spellt etc.
*/
$start = "<script type=\"text/javascript\">\n $(document).ready(function(){\n";
$end   = " \n});</script>";

if (isset($_GET['restricted']))
{
    echo $start . "MsgBox(\"Access Denied\", \"You need to be logged in to see this page\",4);" . $end;
}
else if (isset($_GET['feedback']) && $_GET['feedback'] == "thanks")
{
    echo $start . "MsgBox(\"Thank you\", \"Thank you for leaving feedback.</br>We try to improve the site all the time, bla bla bla\",0);" . $end;
}
else if (isset($_GET['feedback']) && $_GET['feedback'] == "error")
{
    echo $start . "MsgBox(\"Error\", \"There was some kind of error, we do not know why, but please try again later ^^ \",3);" . $end;
}
else if (isset($_SESSION['reg_error']) && strlen($_SESSION["reg_error"]) > 0)
{
    $arr = json_decode($_SESSION['reg_error']);
    unset($_SESSION['reg_error']);
    $txt = "";
    foreach($arr as $val)
        $txt .= $val . "<br />";
    echo $start . "MsgBox(\"Error\",\"".$txt."\" ,3);" . $end;
} 
else if (isset($_SESSION['reg_done'])) 
{
    echo $start . "MsgBox(\"Done\", \"Your account has been created.<br/>You need to activate you account.<br/>We have sent an email to<br/> $_SESSION[reg_email] \",0);" . $end;
    unset($_SESSION['reg_email']);
    unset($_SESSION['reg_done']);
}
else if (isset($_GET['activate']))
{
    switch ($_GET['activate'])
        {
            case 0:
                echo $start . "MsgBox(\"Error\", \"There was a problem with the connection.<br>Please try again later or contact support if the error persist.\",3);" . $end;
                break;
            case 1:
                echo $start . "MsgBox(\"Done\", \"Your account is now active,<br/>You may login.\",0);" . $end;
                break;
            case 2:
                echo $start . "MsgBox(\"Done\", \"Your account is already active.<br/>If you forgott your password, please use the password recovery function.\",0);" . $end;
                break;
            case 3:
                echo $start . "MsgBox(\"Error\", \"That activation code is invalid,<br/>please check the code and try again.\",3);" . $end;
                break;
        }    
}
else if (isset($_GET['login']) && preg_match("/^([0-9])$/",$_GET['login']) && @!empty($_SESSION['login_error']))
{
        echo $start . "MsgBox(\"".(($_GET['login'] == 1)?"Info":"Error")."\", \"".@$_SESSION['login_error']."\",".$_GET['login'].");" . $end;
        unset($_SESSION['login_error']);
} 
else if (isset($_GET['recover']))
{
    switch($_GET['recover'])
    {
        case "email":
            if (isset($_SESSION['rec_email']))
                echo $start . "MsgBox(\"Done\", \"An email with a recovery link was sent to<br>".@$_SESSION['rec_email']." \",0);" . $end;
            break;
        case "error":
            if (isset($_SESSION['rec_error']))
                echo $start . "MsgBox(\"Error\", \"". @$_SESSION['rec_error']." \",3);" . $end;        
            break;
        case "code":
            if (!isset($_GET['code']) || strlen($_GET['code']) != 32)
                echo $start . "MsgBox(\"Error\", \"That code is invalid, please try again\",3);" . $end;
            $sql = Database::getInstance();
            $res = $sql->query("SELECT ID_usr FROM recover WHERE `code`=?", $_GET['code']);
            if ($res->rowCount() !== 1)
            {
                echo $start . "MsgBox(\"Error\", \"That code is invalid, please try again\",3);" . $end;
            } 
            else
            {
                echo $start . "MsgBox(\"Change Password\", \" \
                <form action='/recover/change' method='post' id='rec_f_frm'>\
                Password: <span id='rec_f_err1'>Not secure</span><br/>\
                <input type='password' id='rec_f_pwd' name='rec_f_pwd' style='width:200px' /><br/><br/>\
                Re-type Password:<span id='rec_f_err2'>No match</span><br/><br/>\
                <input id='rec_f_pwd2' name='rec_f_pwd2' type='password' style='width:200px' /><br/><br/>\
                <div class='rec_f_btn'>Save</div><br /><br />\
                <input type='hidden' name='code' value='$_GET[code]' />\
                <input type='hidden' name='token' value='$token' />\
                </form>\",-1,\"text-align: left;padding-left: 70px;\");" . $end;
            }
            break;
        case "done":
            echo $start . "MsgBox(\"Done\", \"Your password has now been changed,<br/>You can now login with your new password.\",0);" . $end;    
            break;
    }
    unset($_SESSION['rec_error']);
    unset($_SESSION['rec_email']);
}
?>