<?php
    if (!defined("INFINITY"))
        die(); // do not allow direct access to this fie

    if(defined("PAGE") && PAGE == "start") 
    {
        echo '
        <div id="mid_bar" class="bar"style="padding:0px;">
            <a id="tour-link"style="color:#000"class="fa fa-play-circle fa-4x"></a>
        </div>';
    }
    ?>
    <div id="main<?php if(defined("PAGE") && PAGE == "start") echo "2"; ?>">
    <?php
        include_once(PATH ."libs/messages.php");
    ?>
    <div class="MsgBox_bg">
        <div class="MsgBox">
            <div id="msgbox_title">Title <span id="msgbox_close">&times;</span></div>
            <div id="msgbox_icon"><img id="msgbox_icon_img" src="/images/checkmark_64.png" /></div>
            <div id="msgbox_txt">This is a message</div>
        </div>
    </div>
        <div id="main-body">