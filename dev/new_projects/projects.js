//no loading screen added so any pauses are not an error
$(document).ready(function(){
    //Vars
    var currentURL = '/new_projects/';
    var page = '/new_projects/script.php';
    var token = $('#token').val();
    var currentcat;
    var cats = ['Start', 'Focus', 'Fun', 'Technology', 'Art', 'Research', 'Fashion', 'Culinary', 'Theatre', 'Music', 'Medical', 'Education', 'Games'];
    //pagination
    /*
    *you'll need to add your own system of pagination, i suggest infinite scroll
    *atm, retrieve() and search() take a limiter to increase the number of rows displayed 
    *of each project, so you can use that when you add pagination
    *currently fixed at 10 projects shown in each category
    */
    //a quick function to allow us to loop through click handlers
    function callBack(cat){
        return function(){
            if(currentcat != cat) retrieve(cat, 10);
        }
    }
    //click handlers
    $(document).on('mousedown', 'li#navlink', function(){
        $('li#navlink').removeClass("active");
        $(this).addClass("active");
    });
    $(document).on('mousedown', '.back', function(){
        if(currentcat != 'Search') retrieve(currentcat, 10);
        else search(10);
    });
    //click handler for getting one project
    $(document).on('mousedown', 'a[class^="projectlink"]', function(){
        var id = $(this).attr('class').substring(11);
        getOne(id);
    });
    //click handlers for categories
    for(var i = 0; i < cats.length; i++){
        $(document).on('mousedown', '.'+cats[i],
        callBack(cats[i]));
    }
    $(document).on('keydown', '.searchbar', function(e){
        if(e.keyCode == 13){
            $(this).select();
            search(10);
        }
    });
    $(document).on('mousedown', 'a[class^="joinresp"]', function(){
        var id = $(this).attr('class').substring(8);
        join(id);
        alert('Request sent.');
        getOne(id);
    });
    $(document).on('mousedown', 'a[class^="commentbtn"]', function(){
        var id = $(this).attr('class').substring(10);
        comment(id);
        getOne(id);
    });
    //init()
    $('.Start').addClass('active');
    retrieve('Start', 10);
    //functions
    function retrieve(what, limiter){
        $.ajax({
            url: page,
            type: 'POST',
            data: {
                signal: 'retrieve',
                what: what,
                limiter: limiter
            },
            success: function(data){
                $('#main').html(data);
                history.pushState('{category: '+ what +'}', '', '?category='+ what);
                currentcat = what;
            }
        });
    }
    function search(limiter){
        var query = $('.searchbar').val();
        if(query != ''){
            $.ajax({
                url: page,
                type: 'POST',
                data: {
                    signal: 'search',
                    what: query,
                    limiter: limiter
                },
                success: function(data){
                    $('#main').html(data);
                    $('searchbar').val('');
                    currentcat = 'Search';
                }
            });
        }
    }
    function join(id){
        var request = $('.joinbox').val();
        $.ajax({
            url: page,
            type: 'POST',
            async: 'false',
            data: {
                signal: 'join',
                request: request,
                token: token,
                id: id
            }
        });
    }
    function getOne(id){
        $.ajax({
            url: page,
            type: 'POST',
            data: {
                signal: 'getOne',
                id: id
            }, 
            success: function(data){
                $('#main').html(data);
                history.replaceState('', '', '?project='+ id);
            }
        });
    }
    function comment(id){
        var mssg = $('.comment_form').val();
        $.ajax({
            url: page,
            type: 'POST',
            async: 'false',
            data: {
                signal: 'comment',
                mssg: mssg,
                token: token,
                id: id
            }
        });
    }
});