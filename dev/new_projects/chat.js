//open connection
    var socket = io.connect('http://err.gr:81');
    // current room for opening and closing rooms
    var currentroom = "";
    var thenameid = new Array();
    var theroomid = new Array();
    var idnum = 0;
    var id = function(name, action) {
        if (action == "c") { // create name id
            thenameid[name] = ++idnum;
            return thenameid[name];
        } else if (action == "n") { // new room id
            theroomid[name] = ++idnum;
            return theroomid[name];
        } else if (action == "r") { // remove name id
            thenameid[name] = null;
        } else if (action == "d") { // destroy room id
            theroomid[name] = null;
        } else if (action == "g") { // get name id
            return thenameid[name];
        } else if (action == "a") { // access room id
            return theroomid[name];
        }
    }
    // open and close rooms :)
    var roomswitch = function(room) {
        if (id(currentroom, 'a')) {
            $("#roomlog" + id(currentroom, 'a')).hide();
            $(".room" + id(currentroom, 'a')).hide();
        }
        $(".room" + id(room, 'a')).show();
        $("#roomlog" + id(room, 'a')).show();
        currentroom = room;
    }
    
    var nexttab = function(room) {
        // do we have any tabs?
        if ($("#tabs").children().length == 0) {
            // join room default
            socket.emit('join room', "default");
            // add room log
            $("#log").append("<div class=\"log\" id=\"roomlog" + id("default", 'n') + "\"></div>");
            // add tab room
            $("#tabs").append("<span class=\"tab\" id=\"tabroom" + id("default", 'a') + "\" onclick=\"roomswitch('default');\">default</span>");
            // switch to newly created room
            roomswitch("default");
        } else {
            // switch to first tab
            roomswitch($("#tabs").children()[0].innerHTML);
        }
        $(".room" + id(room, 'a')).each(function(index) {
            alert($(this).html());
            $(this).removeClass("room" + id(room, 'a'));
            if ($(this).is(":not([class]),[class=\"\"]")) {
                $(this).remove();
            }
        });
        id(room, 'd');
    }
    
    //var tmp = null;
    socket.on('list', function (action, nickname, room) {
        if (action == "join") {
            if (!id(nickname, 'g')) {
                $("#names").append("<p id=\"person" + id(nickname, 'c') + "\" class=\"room" + id(room, 'a') + "\">" + nickname + "</p>");
            } else {
                $("#person" + id(nickname, 'g')).addClass("room" + id(room, 'a'));
            }
        } else if (action == "part") {
            $("#person" + id(nickname, 'g')).removeClass("room" + id(room, 'a'));
            if ($("#person" + id(nickname, 'g')).is(":not([class]),[class=\"\"]")) {
                $("#person" + id(nickname, 'g')).remove();
                id(nickname, 'r');
            }
        } else if (action == "alter") {
            var corg = "c"; if (id(room, "g")) corg = "g";
            $("#person" + id(nickname, 'g')).attr("id", "person" + id(room, corg));
            id(nickname, 'r');
            $("#person" + id(room, 'g')).html(room);
        }
    });
    socket.on('message', function (room, hour, minute, second, nick, message) {
        // we are given room, hour, minute, second, nickname, message
        if (hour.length == 1) hour = "0" + hour; if (minute.length == 1) minute = "0" + minute; if (second.length == 1) second = "0" + second;
        // add to the log
        if (nick == "server") {
            $("#roomlog" + id(room, 'a')).append("<p class=\"server\">[" + hour + ":" + minute + ":" + second + "] <b>&lt;" + nick + "&gt;</b> " + message + "</p>");
        } else {
            //all of the regexes are parsed, like emoticons, urls, and italics, etc
            message = message.replace(/(\()((?:ht|f)tps?:\/\/[a-z0-9\-._~!$&'()*+,;=:\/?#[\]@%]+)(\))|(\[)((?:ht|f)tps?:\/\/[a-z0-9\-._~!$&'()*+,;=:\/?#[\]@%]+)(\])|(\{)((?:ht|f)tps?:\/\/[a-z0-9\-._~!$&'()*+,;=:\/?#[\]@%]+)(\})|(<|&(?:lt|#60|#x3c);)((?:ht|f)tps?:\/\/[a-z0-9\-._~!$&'()*+,;=:\/?#[\]@%]+)(>|&(?:gt|#62|#x3e);)|((?:^|[^=\s'"\]])\s*['"]?|[^=\s]\s+)(\b(?:ht|f)tps?:\/\/[a-z0-9\-._~!$'()*+,;=:\/?#[\]@%]+(?:(?!&(?:gt|#0*62|#x0*3e);|&(?:amp|apos|quot|#0*3[49]|#x0*2[27]);[.!&',:?;]?(?:[^a-z0-9\-._~!$&'()*+,;=:\/?#[\]@%]|$))&[a-z0-9\-._~!$'()*+,;=:\/?#[\]@%]*)*[a-z0-9\-_~$()*+=\/#[\]@%])/img,"$1$4$7$10$13<a href='$2$5$8$11$14'>$2$5$8$11$14</a>$3$6$9$12");
            message = message.replace(/:\)/g,"<img class='emote' src='imgs/smile.png' />");
            message = message.replace(/:P/g,"<img class='emote' src='imgs/tongue.png' />");
            message = message.replace(/\|-\(/g,"<img class='emote' src='imgs/meh.png' />");
            message = message.replace(/:\(/g,"<img class='emote' src='imgs/sad.png' />");
            message = message.replace(/:O/g,"<img class='emote' src='imgs/surprise.png' />");
            message = message.replace(/:D/g,"<img class='emote' src='imgs/lol.png' />");
            message = message.replace(/\(taco\)/g,"<img class='emote' src='imgs/taco.png' />");
            message = message.replace(/\(hanorotu\)/g,"<img class='emote' src='imgs/hano.png' />");
            message = message.replace(/\(jeremy\)/g,"<img class='emote' src='imgs/jeremy.png' />");
            message = message.replace(/\(kulverstukas\)/g,"<img class='emote' src='imgs/kulver.png' />");
            message = message.replace(/\(uriah\)/g,"<img class='emote' src='imgs/uriah.png' />");
            message = message.replace(/\(wabi\)/g,"<img class='emote' src='imgs/wabi.png' />");
            message = message.replace(/\(relax\)/g,"<img class='emote' src='imgs/relax.png' />");
            message = message.replace(/\(artymig\)/g,"<img class='emote' src='imgs/arty.png' />");
            message = message.replace(/`\)/g,")");
            message = message.replace(/\(`/g,"(");
            message = message.replace(/`\]/g,"]");
            message = message.replace(/\[`/g,"[");
            message = message.replace(/\/`/g,"/");
            message = message.replace(/\[u\](?=\S)([\s\S]*?\S)\[\/u\]/ig, "<u>$1</u>");
            message = message.replace(/\[b\](?=\S)([\s\S]*?\S)\[\/b\]/ig, "<b>$1</b>");
            message = message.replace(/\[i\](?=\S)([\s\S]*?\S)\[\/i\]/ig, "<em>$1</em>");
            $("#roomlog" + id(room, 'a')).append("<p>[" + hour + ":" + minute + ":" + second + "] <b>&lt;" + nick + "&gt;</b> " + message + "</p>");
        }
        // scroll log to bottom
        $("#roomlog" + id(room, 'a')).scrollTop($(this).prop("scrollHeight"));
    });
    $(document).ready(function() {
        //join default
        socket.emit('join room', "default");
        // add room log
        $("#log").append("<div class=\"log\" id=\"roomlog" + id("default", "n") + "\"></div>");
        // add tab room
        $("#tabs").append("<span class=\"tab\" id=\"tabroom" + id("default", "a") + "\" onclick=\"roomswitch('default');\">default</span>");
        // switch to newly created room
        roomswitch("default");
        // if nickname has one old
        if (localStorage.nick) {
            socket.emit('set nickname', localStorage.nick, "");
        }
        //on message keypress
        $('#message').keypress(function(e) {
            if ( e.keyCode == 13 && this.value ) {
                if ($(this).val().indexOf("/nick ") == 0) {
                    socket.emit('set nickname', $(this).val().replace("/nick ", ""), currentroom);
                    localStorage.nick = $(this).val().replace("/nick ", "");
                } else if ($(this).val().indexOf("/join ") == 0) {
                    var room = $(this).val().replace("/join ", "");
                    if (!id(room, 'a')) {
                        socket.emit('join room', room);
                        // add room log
                        $("#log").append("<div class=\"log\" id=\"roomlog" + id(room, 'n') + "\"></div>");
                        // add tab room
                        $("#tabs").append("<span class=\"tab\" id=\"tabroom" + id(room, 'a') + "\" onclick=\"roomswitch('" + room + "');\">" + room + "</span>");
                    }
                    // switch to newly created room
                    roomswitch(room);
                } else if ($(this).val().indexOf("/part ") == 0) {
                    var room = $(this).val().replace("/part ", "");
                    socket.emit('part room', room);
                    $("#roomlog" + id(room, 'a')).remove();
                    $("#tabroom" + id(room, 'a')).remove();
                    nexttab(room);
                } else if ($(this).val() == "/part") {
                    socket.emit('part room', currentroom);
                    $("#roomlog" + id(currentroom, 'a')).remove();
                    $("#tabroom" + id(currentroom, 'a')).remove();
                    nexttab(currentroom);
                } else {
                    socket.emit('message', $(this).val(), currentroom);
                }
                $(this).val("");
            }
        });
    });