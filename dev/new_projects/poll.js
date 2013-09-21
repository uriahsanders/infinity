/*
*AJAX long polling script
*gets most recent data and puts it where it needs to be
*the stream handles data creation/completions but...
*long polling will handle real time messages/comments/updates/requests
*messages: in a num next to link, (comments: in a drop down, updates: in a drop down), requests: in num next to link
*will also grab comments from projects page
*/
$(document).ready(function(){
    //run notification loop while getting required info
    getCurrentUsers(1);
});
//last request
var timestamp = null;
//controller for when to wipe old data
//this way, new notifications happen, but the old ones still stick around for a while
var x = 0;
function getData(tick, status){
    //if they are on the project
    if(status != 'offline'){
        //work x so that it only reaches 20 after every 10 minutes (30 seconds between each loop)and then resets. At this 10 minutes, old data is wiped
        if(x > 20){
            //reset timer every 20 loops
            x = 0;
        }
        $.ajax({
            type: 'POST',
            //timestamp is sent so that we can only grab most recent updates
            url: 'get_data.php',
            async: true,
            cache: false,
            data: {
                signal: 'poll',
                timestamp: timestamp,
                x: x,
                status: status
            },
            dataType: 'json',
            success: function(data){
                if(json['check'] != ''){
                    //put that data where it needs to be
                    $('.messages').text('Messages['+ data.messages +']');
                    $('.requests').text('Requests['+ data.requests +']');
                    //if we're keeping old data still
                    if(json['check'] == 1){
                        var notifications = $('.notifications').html() + data.notifications;
                        $('.notifications').html(notifications);
                    }else if(json['check'] == 2){
                        //replace old data with only new
                        $('.notifications').html(data.notifications);
                    }
                    $('.status').html(status);
                }
                //reset the time so we dont get old data
                timestamp = data.timestamp;
                //re-run the function
                setTimeout('getCurrentUsers(1)', tick);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                //call error
                alert('Error: ' + textStatus + '('+ errorThrown +')');
                setTimeout('getCurrentUsers(1)', tick);
            }
        });
        x++;
    }else{
        //they left
    }
}
//now, to create a handler that increases/decreases the amount of time it takes to resend data depending on the amount of users online
//sets statuses as well
//called in doc.ready
function getCurrentUsers(type){
    //call 1 except...
    //call 2 when they logout
    //also call 2 whenever they leave the site (go offline)
    $.ajax({
        type: 'POST',
        url: 'get_data.php',
        async: true,
        cache: false,
        data: {
            signal: 'getCurrentUsers',
            type: type
        },
        dataType: 'json',
        success: function(data){
            if(type == 1){
                //the amount of time between each loop
                var tick = data.tick;
                //are they online or did they leave
                var status = data.status;
                getData(tick, status);
            }
        }
    });
}
function notify(what, info){
    $.ajax({
        type: 'POST',
        url: 'get_data.php',
        data: {
            signal: 'notify',
            what: what,
            info: info
        }
    });
}