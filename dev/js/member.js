$(document).ready(function() {
          var stick = false;
          var curricon = 0;
          var whaticon = 0;
          $(window).resize(fix_resize);
          
          $(window).scroll(function(){
              if  ($(window).scrollTop() > 30){
                  $("#mem_left_menu").css('top','-30px');
                $("#mem_left_menu").height(window.innerHeight - 11);            
              } else if ($(window).scrollTop() < 30) {
                  $("#mem_left_menu").css('top','-'+$(window).scrollTop()+'px');
                  $("#mem_left_menu").height(window.innerHeight - 40 + $(window).scrollTop());
              } 
            });
          $(window).scroll(function(){
                $("#mem_left_menu_friends").height($("#mem_left_menu").height() / 100 * 34.4);
                  $("#friends_list").height($("#mem_left_menu_friends").height() - 45);
                $("#friends_list_scroll").height($("#friends_list").height());
                $("#friend_list_space").height($("#friends_list").height()-14);
                
                $("#mem_left_menu_projects").height(($("#mem_left_menu").height() / 100) * 20);
                $("#project_list").height($("#mem_left_menu_projects").height() - 25);
                $("#project_list_scroll").height($("#project_list").height());
                $("#project_list_space").height($("#project_list").height()-14);
                
                $("#mem_left_menu_bookmarks").height(($("#mem_left_menu").height() / 100) * 42.5);
                $("#bookmark_list").height($("#mem_left_menu_bookmarks").height()-20);
                $("#bookmark_list_scroll").height($("#bookmark_list").height());
                $("#bookmark_list_space").height($("#bookmark_list").height()-18);
            });

    var speed = 25, scroll = 1, scrolling;
    
    $('#friends_scroll_up, #project_scroll_up, #bookmark_scroll_up').mouseenter(function() {
        if (this.id == 'friends_scroll_up') { var ele = $('#friends_list'); } else if (this.id == 'bookmark_scroll_up') { var ele = $('#bookmark_list'); } else { var ele =$('#projects_list');}
        scrolling = window.setInterval(function() {
            ele.scrollTop( function() { 
                ele.scrollTop( ele.scrollTop() - scroll );
            });
        }, speed);
        
    });
    
    $('#friends_scroll_down, #project_scroll_down, #bookmark_scroll_down').mouseenter(function() {
        if (this.id == 'friends_scroll_down') { var ele = $('#friends_list'); } else if (this.id == 'bookmark_scroll_down') { var ele = $('#bookmark_list'); } else { var ele =$('#projects_list');}

        scrolling = window.setInterval(function() {
            ele.scrollTop( ele.scrollTop() + scroll );
        }, speed);
    });
    
    $('#friends_scroll_up, #friends_scroll_down, #project_scroll_down, #bookmark_scroll_down, #project_scroll_up, #bookmark_scroll_up').bind({
        click: function(e) {
            e.preventDefault();
        },
        mouseleave: function() {
            if (scrolling) {
                window.clearInterval(scrolling);
                scrolling = false;
            }
        }
    });

          function fix_resize() {
              if ($(window).innerHeight() >= 350) {
                $("#rawr").height(window.innerHeight - 100);
                
                $("#mem_left_menu").height(window.innerHeight - 40);
                $("#mem_left_menu_friends").height($("#mem_left_menu").height() / 100 * 34.4);
                  $("#friends_list").height($("#mem_left_menu_friends").height() - 45);
                $("#friends_list_scroll").height($("#friends_list").height());
                $("#friend_list_space").height($("#friends_list").height()-14);
                
                $("#mem_left_menu_projects").height(($("#mem_left_menu").height() / 100) * 20);
                $("#project_list").height($("#mem_left_menu_projects").height() - 25);
                $("#project_list_scroll").height($("#project_list").height());
                $("#project_list_space").height($("#project_list").height()-14);
                
                $("#mem_left_menu_bookmarks").height(($("#mem_left_menu").height() / 100) * 43.4);
                $("#bookmark_list").height($("#mem_left_menu_bookmarks").height()-20);
                $("#bookmark_list_scroll").height($("#bookmark_list").height());
                $("#bookmark_list_space").height($("#bookmark_list").height()-18);
              }
          }
          fix_resize();
          $("#mem_left_menu").height(document.height-40);
          $("#rawr").height(document.height-100);
            $("#mem_left_menu_stick").click(function(){
                if (stick === false) {
                    stick = true;
                    $("#mem_left_menu_stick").attr('src','/member/images/pin2.png');
                }else{
                    stick = false;
                    $("#mem_left_menu_stick").attr('src','/member/images/pin.png');
                }
            });
            $("#mem_left_menu_stick").hover(function(){
                curricon = $("#mem_left_menu_stick").attr('src');
                $("#mem_left_menu_stick").attr('src','/member/images/pin3.png');
            },function(){
                if (stick == true){
                    $("#mem_left_menu_stick").attr('src','/member/images/pin2.png');
                } else {
                    $("#mem_left_menu_stick").attr('src','/member/images/pin.png');
                }
            });
            
            $("#mem_left_menu_search").hover(function(){
                $("#mem_left_menu_search").attr('src','/member/images/search3.png');
            },function(){
                $("#mem_left_menu_search").attr('src','/member/images/search.png');
            });
            $("#mem_left_menu_search").click(function(){$("#mem_left_menu_search").attr('src','/member/images/search2.png')});
            
            var images = new Array()
            function preload() {
                for (i = 0; i < preload.arguments.length; i++) {
                    images[i] = new Image();
                    images[i].src = preload.arguments[i];
                }
                images = null;
            }
            preload(
                "/member/images/1_o.png",
                "/member/images/2_o.png",
                "/member/images/3_o.png",
                "/member/images/5_o.png"
            )
            
            $(document).mousedown(function(){
                if (!$('#mem_left_menu').is(':hover')) {
                    if (stick===false) { 
                        $("#mem_left_menu").hide('slide', {direction: 'left'}, 1000);
                        setTimeout(function(){
                            $("#mem_left_show").fadeIn(500);
                        }, 1200);
                    }
                }
            });
            $("#mem_left_show").hover(
                function() {
                        $(this).fadeOut(500,function() {$("#mem_left_menu").show('slide', {direction: 'left'}, 1000);});
                });
            });
      function lol(what, how) {
          if (how != "h") {
                $(what).animate(500,function() {
                    $(this).attr('src',$(this).attr('src').substring(0,16)+'_o.png');
                    $(this).animate({width: 85, height: 85});
                    $(this).fadeIn(500);
                    });
          } else {
              $(what).animate({width: 60, height: 60},500,function() {
                    $(this).attr('src',$(this).attr('src').substring(0,16)+'.png');
                    $(this).fadeIn(500);
                    });
          }
      }