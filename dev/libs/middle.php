 

  </div>
    <div id="termss">
    <div id="regnav"><a href="javascript:hide('termss');" id="statusclose">
        <img id="navclose" src="images/cross.png" border="0" onmousedown="$('#navclose').attr('src','images/cross_d.png');" onmouseup="$('#navclose').attr('src','images/cross.png');" onmouseout="$('#navclose').attr('src','images/cross.png');"></a></div>
    <textarea id="termtxt" readonly="readonly">
    <?php
    include_once($_SERVER['DOCUMENT_ROOT']."/libs/terms.txt");
    ?>
    </textarea>
</div>
    <div id="mid">
        <div id="midleft"><a href="/index.php"><div id="logo"></div><div id="logotxt"></div></a></div>
        <div id="midmid"></div>
        <div id="midright">
        
        
        
        
        
        
        
        <?php
        include_once($_SERVER['DOCUMENT_ROOT']."/libs/lib.php");
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != "YES") {
        include_once('log.php');
       }
    else if(isset($_SESSION["IP"]) && $_SESSION["IP"] == getRealIp() && isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == "YES" && isset($_SESSION["data"]) &&  $_SESSION["data"] == $_SERVER["HTTP_USER_AGENT"]) {
       echo '
       <table style="position:absolute;top:35px;left:1045px;">
       <tr>
       <td>Welcome <span style="color:rgb(63, 98, 143);font-weight: bold;">'.$_SESSION['usrdata']['screenname'].'</span></td>';
       echo ($_SESSION['admin'] == 1) ? '<td><span title="Admin Options"><a href="/member/admin.php"><b>A</b></a></span></td>' : '' ;
       echo '
       </tr>
       <tr>
       <td><a href="/accsummary.php">Profile</a>&nbsp; <a href="/member/logout.php">Logout</a></td>
       </tr>
       </table>';
       echo '<div style="padding:2px;background-color:#565a64;-webkit-border-radius: 5px; 
                                -moz-border-radius: 5px;border-radius: 5px; border: .1em solid rgba(0,0,0, .7);
                                
                                font-family:Tahoma;top:31px;right:5px;position:absolute;"><img src="/images/image.php?id='.$_SESSION["usrdata"]['usr_img'].'" id="profileimage"></div>';
    }  
    ?>
                   
            <div id="register" class="pupb">
                <div id="regnav"><a href="javascript:hide('register');" id="statusclose">
        <img id="navclose" src="/images/cross.png" border="0" onmousedown="$(this).attr('src','/images/cross_d.png');" onmouseup="$(this).attr('src','/images/cross.png');" onmouseout="$(this).attr('src','/images/cross.png');"></a></div>
                <?php
                    include_once($_SERVER['DOCUMENT_ROOT']."/libs/regform.php");
                ?>
        </div>
        
        
        <div id="recover" class="popb">
        <div id="regnav"><a href="javascript:hide('recover');" id="statusclose">
        <img id="navclose" src="/images/cross.png" border="0" onmousedown="$(this).attr('src','/images/cross_d.png');" onmouseup="$(this).attr('src','/images/cross.png');" onmouseout="$(this).attr('src','/images/cross.png');"></a></div>
                <?php
                    include_once($_SERVER['DOCUMENT_ROOT']."/libs/recform.php");
                ?>
                </div>
            
            </div>            
        
    
        </div>
        
    </div>
    
    
    

    <div id="content">