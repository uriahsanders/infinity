<html>
<head>
<link href="/css/dark.css" rel="stylesheet" type="text/css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
</head>
<body>
<p><a id="create">Create a new category</a> | <a id="delete">Delete a category</a> | <a id="search">Search categories</a></p>
<div style="display:none;" id="form">
<input type="text" name="title" id="title" /><br />
<textarea name="desc" id="desc" cols="50" rows="10"></textarea><input type="submit" value="Create" id="createbut" />
</div>
<div style="display:none;" id="searchbar"><input type="text" name="cat" id="cat" /><input type="submit" value="Search" id="searchbut" /></div>
<div id="results"></div>
<div id="delform" style="display:none;"><input type="text" id="cat" name="cat" /><input type="submit" value="Delete" id="delbut" /></div>
<script>
$('#create').toggle(function (){
    $(this).text("Hide create form");
    $('#form').slideToggle();
    $('#createbut').click(function (){
        var title = $('#title').val();
        var description = $('#desc').val();
        console.log(title);
        console.log(description);
        $.post("categorize_script.php", {what: "create", title: title, desc: description}, function (data){
            if(data == "succes"){
                alert("Succesfully created " + title);
                $('#form').find('input[type=text], textarea').val('');
            }else{
                alert("There was an error please try again.");
            }
        });
    });
}, function (){
    $(this).text("Create new category");
    $('#form').slideToggle();
});
$('#delete').toggle(function (){
    $(this).text("Hide delete form");
    $('#delform').slideToggle();
    $('#delbut').click(function (){
        var cat = $('#cat').val();
        $.post("categorize_script.php", {what: "delete", category: cat}, function (data){
            if(data == "succes"){
                alert("Succesfully deleted " + cat);
            }else{
                alert("There was an error please try again.");
            }
        });
    });
}, function (){
    $(this).text("Delete a category");
    $('#delform').slideToggle();
});

$('#search').toggle(function (){
    $(this).text("Hide searchbar");
    $('#searchbar').slideToggle();
    $('#searchbut').click(function (){
        var cat = $('#cat').val();
        var nullresp = "There were no results for " + cat;
        $.post("categorize_script.php", {what: "search", cat: cat}, function (data){
            if(data != "" && data != nullresp && data != "error"){
                $('#results').html("Search results:<br />" + data);
            }else if(data == "error"){
                $('#results').text("Sorry there was an error please try again.");
            }else{
                $('#results').text(nullresp);
            }
        });
    });
}, function (){
    $(this).text("Search categories");
    $('#searchbar').slideToggle();
    if($('#results').length != 0){
        $('#results').slideUp();
    }
});
</script>
</body>
</html>