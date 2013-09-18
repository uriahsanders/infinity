$(document).ready(function () { 
   $('#btn_new').click(function(e){
        e.preventDefault();
        e.stopPropagation();
        post_new();
   });
   $('.btn_del').click(function(e){
        e.preventDefault();
        e.stopPropagation();
        if (confirm("Are you sure you want to delete this post?")) {
            post_del(e.target.id.substring(4));
        }
   });
   $('.btn_rep').click(function(e){
        e.preventDefault();
        e.stopPropagation();
        post_rep(e.target.id.substring(8));
        
   });
    $('.read_more').click(function(e){
        e.preventDefault();
        e.stopPropagation();
        id = e.target.id.substring(10);
        if ($("#more_"+id).is(":hidden")) {
            $("#read_more_"+id).hide();
            $("#more_"+id).show(500);
            $("#read_less_"+id).show();
        }
   });
   $('.read_less').click(function(e){
        e.preventDefault();
        e.stopPropagation();
        id = e.target.id.substring(10);
        if ($("#more_"+id).is(":visible")) {
            $("#read_more_"+id).show();
            $("#more_"+id).hide(500);
            $("#more_"+id).css('display','none');
            $("#read_less_"+id).hide();
        }
   });
   $('.rep_txt').focus(function(e){
        e.preventDefault();
        e.stopPropagation();
        var he = $(this).css('height');
        he = parseFloat(he.substring(0,he.length -2));

        $("#"+e.target.id).animate({
            height: (he + (18*2)) + 'px'
          }, 300, function() {
            $(this).css('resize','vertical');
            $(this).css('max-height','150px');
          });
        
        
   });
   $('.rep_txt').blur(function(e){
        var lines = $(this).val().split(/\r|\r\n|\n/).length;
        lin = lines * 18 + 4;
        
        $("#"+e.target.id).animate({
            height: lin + 'px'
          }, 300, function() {
            $(this).css('resize','none');
          });
   });
});
function post_new() {
    if ($("#txt").val().length < 5) {
        alert("You need to write atleast 5 characters.");
    }else if ($("#txt").val().length > 2000) {
        alert("You have to many characters");
    }else{
        $.ajax({
             type: "POST",
             url: "ajax_<?php echo $table; ?>.php",
             data: { "action" : "add", "txt" : $("#txt").val() },
             success: function (data) {
                 window.location.reload(true);
             }    
        });
    }
}
function post_del(id) {
    $.ajax({
         type: "POST",
         url: "ajax_<?php echo $table; ?>.php",
         data: {"action" : "del", "id" : id },
         success: function (data) {
             window.location.reload(true);
         }    
    });
}
function post_rep(id) {
    $.ajax({
         type: "POST",
         url: "ajax_<?php echo $table; ?>.php",
         data: {"action" : "rep", "id" : id, "txt" : $("#rep_"+id).val()},
         success: function (data) {
         //alert(data);
             window.location.reload(true);
         }    
    });
}
/*
setInterval(function()
{ 
   // get();
}, 10000);//time in milliseconds 
get();
function get() {
$.ajax({
         type: "POST",
         url: "ajax_wall.php",
         data: {"action" : "get"},
         success: function (data) {
             $("#wall").html(data);
             $("#wall").fadeIn(500);
         }    
    });
}*/