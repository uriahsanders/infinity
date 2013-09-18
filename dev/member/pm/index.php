<?php
include_once($_SERVER['DOCUMENT_ROOT']."/member/m_top.php");
include_once($_SERVER['DOCUMENT_ROOT']."/member/m_side.php");
?>
            
            
            
            
<style type="text/css">
    #mail_bar {
        -webkit-border-top-left-radius: 4px;
        -webkit-border-top-right-radius: 4px;
        -moz-border-top-left-radius: 4px;
        -moz-border-top-right-radius: 4px;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
    }
    #read {
    
        -webkit-border-bottom-right-radius: 4px;
        -moz-border-bottom-right-radius: 4px;
        border-bottom-right-radius: 4px;
    
    }
    #mail_bar, #read_bar, #mail ::-webkit-scrollbar-thumb {
        background: #686c80;
        background: -moz-linear-gradient(top,  #686c80 0%, #56596a 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#686c80), color-stop(100%,#56596a));
        background: -webkit-linear-gradient(top,  #686c80 0%,#56596a 100%);
        background: -o-linear-gradient(top,  #686c80 0%,#56596a 100%);
        background: -ms-linear-gradient(top,  #686c80 0%,#56596a 100%);
        background: linear-gradient(to bottom,  #686c80 0%,#56596a 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#686c80', endColorstr='#56596a',GradientType=0);
        color: rgba(222,230,244, .8);    
    }
    #mail_bar:hover, #read_bar:hover {
        color: rgba(255,255,255,1);
    }
    #mail {
        margin:0; 
        padding:0; 
        width:100%; 
        height:90%; 
        background-color: #fff; 
        color: #000;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }
    #mail_bar {
        width:100%; 
        height: 26px;
    }
    #inbox_link, #sent_link { 
        font-weight:bold;
        cursor: pointer;
    }
    #inbox_tbl {
        width:100%;
        border-spacing:0;
    }
    #inbox_tbl tr:nth-child(even) {
        background: #CCC
    }
    .message {
        cursor: pointer;
    }
    .m_new {
        font-weight: bold;
    }
    .mailbar_btn {
        opacity:0.6;
        filter:alpha(opacity=60);
    }
    .mailbar_btn:hover {
        opacity:1;
        filter:alpha(opacity=100);
    }
    #mail ::-webkit-scrollbar {
        width: 8px;
        }
 
        #mail ::-webkit-scrollbar-track {
        border-radius: 0;
        background-color: #fff;
        }
 
        #mail ::-webkit-scrollbar-thumb {
        border-radius: 2px;
        }

</style>

<link rel="stylesheet" href="/member/pm/style/infinity-token.css" type="text/css" />
<script type="text/javascript" src="/member/pm/js/jquery.tokeninput.js"></script>
<script type="text/javascript">
        $(document).ready(function() {
            $("#search").tokenInput("/member/pm/test/1/examples/php-example.php", {
              theme: "infinity",
              preventDuplicates: true,
              tokenLimit: 8,
              propertyToSearch: "username",
              hintText: "Enter user or screen name",
              method: "POST",
              width: 1000,
              tokenValue: "ID",
              resultsFormatter: function(item){ return "<li>" + "<img src='/images/image.php?id=" + item.image + "' title='" + item.screenname + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.screenname + "</div><div class='email'>" + item.username + "</div></div></li>" },
              tokenFormatter: function(item) { return "<li><p>" + item.username + "</p></li>" },
            });
            $("#search").width(500);
        });
        </script>
            <script>
                        function fix() {
               $("#main_mail").css('width', $("#mail_bar").width() - $("#folders").width()-0.5);
               $("#inbox").css('width', $("#mail_bar").width() - $("#folders").width()-0.5);
               $("#inbox_t").css('width', $("#mail_bar").width() - $("#folders").width()-0.5);
               $("#main_mail").css('height', $("#mail").height() - $("#mail_bar").height());
               $("#drag1").css('height', $("#mail").height() - $("#mail_bar").height());
               $("#folders").css('height', $("#mail").height() - $("#mail_bar").height());
               $("#read").css('height', $("#main_mail").height() - $("#inbox").height() - $("#read_bar").height());
            }
            function close_mail() {
                $(".token-input-dropdown-infinity").hide();
                $(".msgbox_mail").fadeOut(500);
                $("#sub").val("");
                $("#msg_txt").val("");
                $("#search").tokenInput("clear");
                
            }
                $(document).ready(function(){
                        $('#inbox_link').click(function(e){
                            e.preventDefault();
                            e.stopPropagation();
                            fetch_inbox();
                        });
                        $('#sent_link').click(function(e){
                            e.preventDefault();
                            e.stopPropagation();
                            fetch_sent();
                        });
                        $('.reply_btn').click(function(e){
                            e.preventDefault();
                            e.stopPropagation();
                            idd = $(this).attr('id');
                            $("#search").tokenInput("add", {id: msgu[idd], username: msgf[idd]});
                            $("#sub").val("Re: " + msgs[idd]);
                            var msg_rep = "\n\n\n>> " + msg[idd];
                            msg_rep = msg_rep.replace(/<br\s*[\/]?>/gi, "\n>> ");
                            msg_rep = msg_rep.replace(/&gt;/gi, ">");
                            
                            $("#msg_txt").val(msg_rep +"\n");
                            $(".msgbox_mail").fadeIn(500);
                        });
                        $('.del_btn').click(function(e){
                        
                            e.preventDefault();
                            e.stopPropagation();
                            idd = $(this).attr('id');
                            MsgBox("Confirmation", "Are you sure you want to delete <br>" + msgs[idd] +"?<br/><br/><a class='del_yes' id='del_"+idd+"'>YES</a>&nbsp;&nbsp;<a class='del_no'>Cancel</a>",120,300,4);
                            
                        });
                        $('#write_new').click(function(e){
                            e.preventDefault();
                            e.stopPropagation();
                            $(".msgbox_mail").fadeIn(500);
                        });
                        $(document).on("click", ".del_no", function(){ $("#msgbox").remove();});
                        $(document).on("click", ".del_yes", function(e){ 
                        
                        idd = $(this).attr('id').substring(4);
                        $("#msgbox").remove();
                            $.ajax({
                                 type: "POST",
                                 url: "/member/pm/ajax/script.php",
                                 data: { "action" : "del", "id":idd}                                 
                             });
                             fetch_inbox();
                             
                         });
                         var woot = 0;
                         var list = "";var sub="";var txt="";
                        $('#send').click(function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            if (woot == 0) {
                                woot=1;
                                list = $("#search").tokenInput("get");
                                sub = $("#sub").val();
                                txt = $("#msg_txt").val();
                                var error = "";
                                if (sub.length < 4) { error += "Your subject is to short,"; }
                                if (txt.length < 5) { error += "<br/>Your message is to short,"; }
                                if (list.length == 0) {error += "<br/>You need to specify who you want to send the PM to,"; }
                                var to = "";
                                if (error == "") {
                                    for (var i = 0; i< list.length; i++) {
                                        to += list[i].id + ",";
                                    }
                                    to = to.substring(0,to.length-1);
                                    $.ajax({
                                         type: "POST",
                                         url: "/member/pm/ajax/script.php",
                                         data: { "action" : "send", "to" : to, "sub": sub, "txt":txt}    
                                    }).done(function (data) {
                                          MsgBox("Send Message",data);
                                          close_mail();
                                    });
                                } else {
                                    MsgBox("Error", error.substring(0,error.length-1));
                                }
                                  setTimeout(function(){woot=0},3000)
                              }
                        });
                });
            message("h");
function message(vis){
var msgbox_title = "New Private Message";
var msgbox_txt = '<table border=0>'+
                 '<tr><td width=20>To:</td><td><input type="text" id="search" name="users"/></td></tr>'+
                 '<tr><td>Subject:</td><td><input id=\"sub\" type=text name=subject></td></tr>'+
                 '<tr><td colspan=2><textarea cols="80" rows="20" maxlength="5000" name="txt" id="msg_txt" style="resize:none"></textarea></td></tr>'+
                 '</table>';
 var code = Math.floor(Math.random()*101)
 var src = "";
 src = src +"<div id='msgbox2' class='msgbox_mail' style='z-index:1; width:700px; padding-bottom:6px; "+((vis == "h") ? "display:none" : "")+"'>\n";
 src = src +"<div id='msgbox-title' style='height:19px'><table><tr><td></td><td width='100%'>"+msgbox_title+"</td><td><a onclick='close_mail();' style='cursor:pointer; font-size:15px;'>&times;</a>&nbsp;</td></tr></table></div>\n";
 src = src +"<div id='msgbox-text' style='padding-bottom:0; font-weight:bold; font-size: 12px; height:auto;'>\n";
 src = src +"<table id='msgbox-table' style='height:auto; width:100%'>\n";
 src = src +"<tr>\n";
 src = src +"<td valign='midth' align='center' height='100%' colspan='3'>\n";
 src = src + msgbox_txt + "\n</td></tr><tr><td colspan='3' align='right'>";
 src = src +"<a id='send' style='font-weight:bold; color:#000;'>Send</a>&nbsp;&nbsp;&nbsp;&nbsp;";
 src = src +"</div>\n";
 src = src +"</td>\n";
 src = src +"</tr>\n";
 src = src +"</table>\n";
 src = src +"</div>";
 src = src +"</div>";

 
var boxes = document.getElementById('content');
var newmsgbox = document.createElement('div');
newmsgbox.setAttribute('id','boxID');
newmsgbox.innerHTML = src;
boxes.appendChild(newmsgbox);
$(".msgbox_mail").draggable({ containment: "", 
                        scroll: false, 
                        handler: "#msgbox-title",
                        cancel: "#msgbox-text",
                        start: function () {
                                    $("body").css({'overflow':'hidden'});
                                },
                        stop: function () {
                                $("body").css({'overflow':'auto'});
                            }
                        });
                        
                        $("#msgbox2").css("position","absolute");
            $("#msgbox2").css('left', ($(window).width()  / 2) - 600 + "px");
            $("#msgbox2").css('top' , ($(window).height() / 2) - ($("#msgbox2").height() /2) + "px");
            fix();
}
                $(document).on('click', ".message", function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            id = e.target.id.substring(2);
                            $("#read").html(msg[id]);
                            $("#r_"+id).removeAttr('class');
                            $("#new_img_"+id).remove();
                            $(".reply_btn, .del_btn").attr('id',id);
                            $("#read_bar").show();
                            $.ajax({
                                 type: "POST",
                                 url: "/member/pm/ajax/script.php",
                                 data: { "action" : "isread", "id" : id}    
                            });
                });
                var msg = new Array();
                
                function fetch_inbox() {
                    $.ajax({
                         type: "POST",
                         url: "/member/pm/ajax/script.php",
                         data: { "action" : "fetch_inbox"},
                         success: function (data) {
                             var inbox_items = $.parseJSON(data);
                             var src = "<table id=\"inbox_tbl\">";
                             src += "<tr><th width=\"5\"></th><th>Subject</th><th width=\"100\">From</th><th width=\"180\">Date</th></tr>";
                             msg = new Array(); msgs = new Array(); msgf = new Array(); msgu = new Array();
                             inbox_items.forEach(function(entry) {
                                 src += "<tr"+((entry[0] == 0) ? " class=\"m_new\" id=\"r_"+entry[5]+"\"" : "" ) +">";
                                 src += "<td>" + ((entry[0] == 0) ? "<img src=\"/member/pm/images/new.png\" height=\"12\" id=\"new_img_"+entry[5]+"\" width=\"12\">" : "")+ "</td width=\"12\">";
                                 src += "<td  class=\"message\" id=\"m_"+entry[5]+"\">"+ entry[1] + "</td>";
                                 src += "<td>" + entry[3] + "</td>";
                                 src += "<td>" + entry[4] + "</td>";
                                 src += "</tr>";
                                 msg[entry[5]]  = entry[2]; // txt
                                 msgs[entry[5]] = entry[1]; //subject
                                 msgf[entry[5]] = entry[3]; // from
                                 msgu[entry[5]] = entry[6] // user id
                             });
                             src += "</table>";
                             $("#inbox_t").html(src);
                             $("#read").html("");
                             $("#read_bar").hide();
                         }    
                    });
                }
                function fetch_sent() {
                    $.ajax({
                         type: "POST",
                         url: "/member/pm/ajax/script.php",
                         data: { "action" : "fetch_sent"},
                         success: function (data) {
                             $("#inbox_t").html(data);
                         }    
                    });
                }
            </script>
            
            
            <div id="mail" style="position: relative;">
                <div id="mail_bar" style="position: relative;">&nbsp;<a id="write_new" class="mailbar_btn"><img src="/member/pm/images/mail.png" border="0" width="24" height="24"></a>
                </div>
                <div id="folders" style="float:left; width:225px;">
                    <table id="fol" style="float:left">
                        <tr>
                            <td width=24><img src="/member/pm/images/folder.png" height="24" width="24"></td>
                            <td id="inbox_link">Inbox</td>
                        </tr>
                        <tr>
                            <td width=24><img src="/member/pm/images/folder.png" height="24" width="24"></td>
                            <td id="sent_link">Sent</td>
                        </tr>
                     </table>
                     <div id="drag1" class="ui-resizable-handle ui-resizable-ew" style="height:200px; width:3px;float:right;background-color: rgba(0,0,0,.4);cursor:e-resize;"></div>
                </div>
                <div id="main_mail" style="float:left;">
                        <div id="inbox" style="width:100%">
                            <div id="inbox_t" style="width:100%; height:150px; overflow:auto;">
                            Click on inbox ;)                        
                            </div>
                            <div id="drag2" class="ui-resizable-handle ui-resizable-sn;" style="background-color: rgba(0,0,0,.4);cursor:n-resize; width:100%;height:3px"></div>
                        </div>
                        <div id="read_bar" style="height:25px; width:100%; display:none; padding-top:3px">
                           &nbsp;<a class="reply_btn"><img src="/member/pm/images/mr.png" width="20" height="20" alt="Reply" title="Reply" border="0"></a> <a class="del_btn"><img src="/member/pm/images/mrm.png" alt="Delete" title="Delete" width="22" height="20" border="0"></a> 
                        </div>
                        <div id="read" style="overflow:auto;width:100%;">
                           
                        </div>

                </div>
            </div>
                </div>
            
        <!-- MOVE LATER TO CORRECT POSITION -->
        <script>
            $(document).ready(function() {
                  $(window).resize(fix);
                   fix();
            });

            $(document).ready(function() {
            
                $("#folders").resizable({ 
                                        handles: {"w,e": "#drag1"},
                                        minWidth:150,
                                        maxWidth: $("#mail").width() /2,
                                        containment: "#mail",
                                        resize: function(event, ui){fix()}
                                        });
                                        
                                        
                                        
                $("#inbox").resizable({ 
                                        handles: {"n,s": "#drag2"},
                                        minHeight:150,
                                        maxHeight: $("#main_mail").height() -250,
                                        alsoResize: "#inbox_t",
                                        containment: "#mail",
                                        resize: function(event, ui){fix()}
                                        });
            });
        </script>
        <?php
include_once($_SERVER['DOCUMENT_ROOT']."/member/m_bottom.php");
?>