$(document).ready(function(){
   /* var cats = ['start', 'stream', 'control', 'chat', 'wall', 'milestones', 'groups', 'tasks', 'boards', 'files', 'suggest', 'tables'];
    var tops = ['new', 'requests', 'messages', 'launch', 'help'];
    function callBack(it, type){
        return function(){
            if(type == 1){
                if(current != it) retrieve(it);
            }else{
                topClicks(it);
            }
        }
    }
    //click handlers for categories
    for(var i = 0; i < cats.length; i++){
        $(document).on('mousedown', '.'+cats[i],
        callBack(cats[i]), 1);
    }
    //click handlers for top
    for(var i = 0; i < tops.length; i++){
        $(document).on('mousedown', '.'+tops[i],
        callBack(tops[i]), 2);
    }*/
    //Click commands
    $('.stream').click(function(){ //What to nav to
        retrieve('stream'); //Send to php
    });
    $('.control').click(function(){ //What to nav to
        retrieve('control'); //Send to php
    });
    $('.chat').click(function(){
        retrieve('chat');
    });
    $('.wall').click(function(){
        retrieve('wall');
    });
    $('.milestones').click(function(){
        retrieve('milestones');
    });
    $('.groups').click(function(){
        retrieve('groups');
    });
    $('.tasks').click(function(){
        retrieve('tasks');
    });
    $('.boards').click(function(){
        retrieve('boards');
    });
    $('.files').click(function(){
        retrieve('files');
    });
    $('.new').click(function(){
        topClicks('new'); //Do correct action
    });
    $('.requests').click(function(){
        topClicks('requests');
    });
    $('.messages').click(function(){
        topClicks('messages');
    });
    $('.launch').click(function(){
        topClicks('launch');
    });
    $('.help').click(function(){
        topClicks('help');
    });
    $('.start').click(function(){
        retrieve('start');
    });
    $('.suggest').click(function(){
        retrieve('suggest');
    });
    $('.tables').click(function(){
        retrieve('tables');
    });
    //Starters
    init(1);
    retrieve('start');
    var current = $('.currentSelect').val();
    //I wont constantly update page for now: too much on server
});
//functions
function init(num){
    //creates all starting data with one ajax call
    var name = $('.project_select').val(); //Get the name of selected project
    var branch = $('.branch_select').val();
    //set roles
    $.post('workspace_script.php', {signal: 'setRole', name: name}, function(data){
        $('.role').text(data);
    });
    //fill search span
    $.post('workspace_script.php', {
        signal: 'fillSearchSpan',
        name: name,
        branch: branch
        }, function(data){
            $('.searchspan').html(data);
    });
    if(num == 1){
        //get branches
        $.post('workspace_script.php', {signal: 'getBranches', name: name}, function(data){
            $('.branch_select').html(data);
        });
    }
}
function retrieve(what){ //which section they are retrieving
    var name = $('.project_select').val(); //Get the name of selected project
    var branch = $('.branch_select').val(); //Get selected branch
    $.post('workspace_script.php', {signal: 'cat', what: what, name: name, branch: branch}, function(data){
        $('#main').text('Loading...').html(data); //Show returned
        slideDownCMS();
        if(what == 'milestones'){
            //milestones need additional variables
            var date = new Date();
            $.post("workspace_script.php", {
                signal: 'calendar',
                calendar: "yes",
                month: date.getMonth() + 1,
                year: date.getFullYear()
            }, function (data){
                $('#milestones').html(data);
            });
        }
    });
    $('.currentSelect').val(what);
    $('.lastfunction').val('');
    init(2);
    tr = 0;
    th = 0;
}
function topClicks(what){ // onclicks for header
    var name = $('.project_select').val(); //Get the name of selected project
    var branch = $('.branch_select').val();
    if(what == 'new'){
        //form for creating a new workspace
                var form = '<div id="head"><h2>Create New Project</h2></div><hr /><div id="content">\
                *After this, you must launch your project in order to make it available to the community. Until then it is private.<br /><br /> \
                <div id="form"> \
                           Category<br />\
                            <select id="category"name="category">\
                                <option>Just for Fun</option>\
                                <option>Art</option>\
                                <option>Technology</option>\
                                <option>Research</option>\
                                <option>Acting</option>\
                                <option>Games</option>\
                                <option>Art</option>\
                                <option>Fashion</option>\
                                <option>Culinary</option>\
                                <option>Music</option>\
                                <option>Medical</option>\
                                <option>Education</option>\
                            </select><br />\
                            Project Name<br /><input id="name" id="name" type="text" /><br />\
                            Description<br /><textarea class="bigtxt"id="description"name="description"></textarea><br /><br />\
                            <a id="btn" onclick="checkAndCreate()">Create</a>\
                            <br /><br />\
                            <span class="extra"></span>\
                            <br /><br />\
                           </span>\
               </div></div>\
            ';
            $('#main').text("Loading...").html(form);     
    }else{
        what = (what == 'launch') ? 'launchForm' : what;
        $.post('workspace_script.php', {
                signal: what,
                projectname: name,
                branch: branch
            }, function(data){
                $('#main').text('Loading...').html(data);
                slideDownCMS();
            });
    }
    $('.currentSelect').val(what);
    tr = 0;
    th = 0;
}
function getProjects(){
    //project select box
    $.post('workspace_script.php', {signal: 'getProjects'}, function(data){
        $('.project_select').html(data);
    });
}
function checkAndCreate(){
    //create new workspace
    var description = $('#description').val();
    var name = $('#name').val();
    if(name.length >= 5 && description != ''){
        //if all requirements are met, actually send data to script.php, with following function
        createNew();
    }else{
        //Tell them why it cant be posted
        $('.extra').text("Project could not be submitted, please enter a project name, which must be at least 5 characters, and fill in both descriptions.");
    }
}
//Actually creating a new project
function createNew(){
    var signal = "create"; //Just teling the script what to do, to narrow it down and make it easier for me to keep track too
    var category = $('#category').val();
    var name = $('#name').val();
    var description = $('#description').val();
    var token = $('#token').val();
    $.ajax({
        url: 'workspace_script.php',
        type: 'POST',
        data: {
            category: category,
            name: name,
            description: description,
            signal: signal,
            token: token
        },
        success: function(data){
            alert(data);
            //window.location.reload(true);
        }
    });
}
function changeInfo(){
    //update project information
    var current = $('.project_select').val(); //Get the name of selected project
    var signal = 'change';
    var category = $('.category').val();
    var name = $('.name').val();
    var slogan = $('.slogan').val();
    var description = $('.description').val();
    var short = $('.short').val();
    var rewards = $('.rewards').val();
    var skills = $('.skills').val();
    var risks = $('.risks').val();
    var form = $('.form').val();
    var budget = $('.budget').val();
    $.post('workspace_script.php', 
    {
        category: category,
        name: name,
        slogan: slogan,
        description: description,
        short: short,
        rewards: rewards,
        skills: skills,
        risks: risks,
        form: form,
        budget: budget,
        signal: signal,
        current: current
    },
    function(data){
        retrieve('control');
        alert("changes saved.");
    }
    );
}
function updateStatus(projectname, user){
    //updating statuses
    var status = $('.statustxt').val();
    $.post('workspace_script.php', {
        projectname: projectname,
        user: user,
        status: status,
        signal: 'updateStatus'
    }, function(data){
        retrieve('groups');
    });
}
function leaveProject(projectname, user){
    //allow user to leave the project
    var makeSure = confirm("Are you absolutely sure that you want to leave this project?");
    if(makeSure){
        $.post('workspace_script.php', {
            projectname: projectname,
            user: user,
            signal: 'leaveProject'
        }, function(data){
         //page must be reloaded so no errors from erased privileges occur
         window.location.reload(true);
    });
    }
}
function removeMember(projectname){
    //allow creator to remove members
    var makeSure = confirm("Are you absolutely sure that you want to remove this member from the project?");
    var user = $('.deleteSelect').val();
    var projectname = projectname;
    if(makeSure){
        $.post('workspace_script.php', {
            projectname: projectname,
            user: user,
            signal: 'removeMember'
        }, function(data){
         retrieve('groups');
    });
    }
}
function setAnotherRole(projectname){
    //set a role
    var newRole = $('.setRoleTXT').val();
    var whichMember = $('.whichMember').val();
    $.post('workspace_script.php', {
            projectname: projectname,
            newRole: newRole,
            whichMember: whichMember,
            signal: 'setAnotherRole'
        }, function(data){
           retrieve('groups');
    });
}
function acceptMember(user, projectname){
    //accepting requests
    var user = user;
    var projectname = projectname;
    var signal = 'acceptMember';
    $.post('workspace_script.php', {
        user: user,
        projectname: projectname,
        signal: signal
    }, function(data){
        topClicks('requests');
    });
}function denyMember(user, projectname){
    //denying requests
    var user = user;
    var projectname = projectname;
    var signal = 'denyMember';
    $.post('workspace_script.php', {
        user: user,
        projectname: projectname,
        signal: signal
    }, function(data){
        topClicks('requests');
    });
}
function msgSend(projectname){
    //sending messages
    var projectname = projectname;
    var subject = $('.msgsubject').val();
    var body = $('.msgbody').val();
    var who =$('.msgSelect').val();
    $.post('workspace_script.php', {
        signal: 'msgSend',
        projectname: projectname,
        subject: subject,
        body: body,
        who: who
    }, function(data){
        $('.ifSent').text(data);
    });
    $('.msgsubject').val('');
    $('.msgbody').val('');
}
function changeOnFly(num){
    //allows them to change their current project or branch while staying on the same section
    var current = $('.currentSelect').val();
    if(current != 'messages' && current != 'new' && current != 'requests' && current != 'help' && current != 'launch'){
        retrieve(current);
    }
    else{
        topClicks(current);
    }
    if(num == 1){
        init(1);
    }else{
        init(2);
    }
}
//num- 1: create, 2: suggest
function docCreate(projectname, num){
    //create a document in correct branch
    var branch = $('.branch_select').val(); //Get selected branch
    var current = $('.currentSelect').val();
    var projectname = $('.project_select').val();
    var title = $('.doctitle').val();
    var body = $('.docbody').val();
    if(title.length > 2 && body.length > 5){
        $.post('workspace_script.php', {
            signal: 'newDoc',
            projectname: projectname,
            title: title,
            body: body,
            branch: branch,
            num: num
        }, function(data){
            if(num == 2){
                alert('Document suggested.');
                retrieve('suggest');
            }else{
                retrieve('boards');
            }
        });
    }else{
        alert('You must have a title of at least 2 characters and a body of at least 5.');
    }
}
//num- 1: create, 2: update, 3: suggest
function createTask(projectname, num){
    //create a task in selected branch
    var branch = $('.branch_select').val(); //Get selected branch
    var current = $('.currentSelect').val();
    var projectname = projectname;
    var what = 'task';
    var txtdate = $('.taskdate').val();
    var title = $('.taskname').val();
    var body = $('.taskdesc').val();
    var to = $('.taskto').val();
    if(title.length > 2 && body.length > 5){
        $.post('workspace_script.php', {
            signal: 'newTask',
            projectname: projectname,
            what: what,
            txtdate: txtdate,
            title: title,
            body: body,
            to: to,
            branch: branch,
            num: num
        }, function(data){
            if(num == 2){
                alert('Task updated.');
            }else if(num == 3){
                alert('Task suggested');
                retrieve('suggest');
            }else{
                retrieve('tasks');
            }
        });
    }else{
        alert('You must have a title of at least 2 characters and a description of at least 5.');
    }
}
function taskStatus(id){
    //Change task to complete/incomplete/almost complete
    var id = id;
    var newStatus = $('.taskStatus'+id).val();
    $.post('workspace_script.php', {
        signal: 'taskStatus',
        newStatus : newStatus,
        id: id
    }, function(data){
        $('.whendone'+id).html(data);
    });
}
function deleteuni(priv, id, which){
    //delete something
    var signal = 'deleteuni';
    $.post('workspace_script.php', {
        signal: signal,
        id: id,
        priv: priv
    }, function(data){
        if(which == 'messages'){
            topClicks(which);
        }else if(which == 'suggest'){
            retrieve('suggest');
        }else if(which == 'editmode'){
            retrieve('docEditMode');
        }else{
            retrieve(which);
        }
    });
}
function updateDoc(id){
    //update selected document
    var signal = 'updateDoc';
    var doctitle = $('.doctitle'+id).val();
    var docbody = $('.docbody'+id).val();
    $.post('workspace_script.php', {
        id: id,
        signal: signal,
        doctitle: doctitle,
        docbody: docbody
    }, function(data){
        alert('Document updated.');
    });
}
function createBranch(){
    //create a new branch
    var newBranch = $('.branchName').val();
    var pname = $('.project_select').val();
    if(newBranch != 'Master' && newBranch != ''){
        $.post('workspace_script.php', {
            signal: 'createBranch',
            newBranch: newBranch,
            pname: pname
        }, function(data){
            retrieve('control');
            init(1);
        });
    }else{
        //the branch cannot be called Master, which is the default branch
        alert('You can\'t create another branch called \'Master\'.');
    }
}
function deleteBranch(){
    //remove a branch, and everything associated with it
    var branch = $('.branch_delete').val();
    var pname = $('.project_select').val();
    $.post('workspace_script.php', {
        signal: 'deleteBranch',
        branch: branch,
        pname: pname
    }, function(data){
        retrieve('control');
        init(1);
    });
}
function getUser(id){
    //get a users contributions/pending assignments/recent activity
    var signal = 'getUser';
    var project = $('.project_select').val();
    $.post('workspace_script.php', {
        signal: signal,
        id: id,
        project: project
    }, function(data){
        $('#main').html(data);
    });
    //this is used by the back function
    $('.lastfunction').val(18);
    $('.extra').val(id);
}
function getOne(id, kind){
    //Get one element from projects_data by itself
    var name = $('.project_select').val();
    $.post('workspace_script.php', {
        signal: 'getOne',
        id: id,
        kind: kind,
        name: name
    }, function(data){
        $('#main').html(data);
    });
    //get one also supports edit mode
    if(kind == 'edit'){
        //this is used by the back function
        $('.lastfunction').val(17);
        $('.extra').val(id);
    }
}
function launch(as, id){
    //launch as a job or project
    var signal = 'launch';
    var secsignal = as;
    $.post('workspace_script.php', {
        signal: signal,
        secsignal: secsignal,
        id: id
        }, function(data){
            topClicks('launch');
    });
}
function branchPrivilege(id){
    //change someones privilege in the selected branch
    var name = $('.theBranchName').val();
    var person = $('.theBranchPerson').val();
    var privilege = $('.theBranchPrivilege').val();
    $.post('workspace_script.php', {
        signal: 'branchPrivilege',
        person: person,
        name: name,
        privilege: privilege,
        id: id
        }, function(data){
            retrieve('groups');
    });
}
function search(id){
    //search for project data by title
    var search = $('.searchbar').val();
    var branch = $('.branch_select').val();
    $('.searchbar').val('');
    $.post('workspace_script.php', {
        signal: 'search',
        search: search,
        id: id,
        branch: branch
        }, function(data){
            $('#main').html(data);
    });
}
function editOne(id, which){
    //edit something
    $.post('workspace_script.php', {
        signal: 'editOne',
        id: id,
        which: which
        }, function(data){
            $('#main').html(data);
    });
}
function back(){
    //back works by seeing what the last function was
    var current = $('.currentSelect').val();
    if($('.lastfunction').val() == 18){
        move('back');
    }else if($('.lastfunction').val() == 17){
        move('back2');
    }else{
        if(current != ''){
            retrieve(current);
        }
    }
    $('.lastfunction').val('');
}
function move(where){
    if(where == 'back'){
        getUser($('.extra').val());
    }else{
        getOne($('.extra').val());
    }
}
function slideDownCMS(){
    //just fades in the cms whenever a section is retrieved
    $(document).ready(function(){
        $('.cms').fadeIn();
    });
}
function switchForm(){
    //function for allowing things to be suggested, one form at once
    var form = $('.form_select').val();
    if(form == 'Task'){
        $('.docform').hide();
        $('.taskform').fadeIn();
    }else{
        $('.taskform').hide();
        $('.docform').fadeIn();
    }
}
function confirm(id, projectid){
    //sets `suggest` to 0 to confirm a project suggestion
    $.ajax({
        type: 'POST',
        url: 'workspace_script.php',
        data: {
            signal: 'confirm',
            id: id,
            projectID: projectid
        },
        success: function(data){
            alert('Suggestion confirmed.');
            retrieve('suggest');
        }
    });
}
function commentOne(id){
    //comment on something
    var name = $('.project_select').val();
    var comment = $('.commentbox').val();
    $.ajax({
        type: 'POST',
        url: 'workspace_script.php',
        data: {
            signal: 'commentOne',
            id: id,
            name: name,
            comment: comment
        },
        success: function(data){
            getOne(id);
        }
    });
}
var tr = 0;
var th = 0;
function tableForm(){
    var table = '<table class="tableBody">';
    table += '<tr class="tableHeaders"></tr>';
    table += '</table>';
    $('#tableForm').html(table);
}
function addToTable(what){
    //create a new table row
    if(what == 'column'){
        //create a new table column
        //add new <th> tags to the header span
        if($('.rowspan').css('display') == 'none'){
            $('.rowSpan').fadeIn();
        }
        $('.tableHeaders').append('<th>Header</th>');
        //add a new td below the header for each row that there is
        for(var i = 0; i <= tr; i++){
            $('.tableData'+ i).append('<td>Data</td>');
        }
        $('.columntxt').val('');
        //mark that you added one column
        th++;
    }else if(what == 'row'){
        var td;
        //for each column, add another <td>
        for(var i = 0; i <= th - 1; i++){
            td += '<td>Data</td>';
        }
        //add a new row to the table with the tds just created. give it the class num of the amount of <tr>'s
        var row = '<tr class="tableData'+ tr +'">'+ td +'</tr>';
        //insert all of this into the table tags
        $('.tableBody').append(row);
        $('.rowtxt').val('');
        //mark that we added one row
        tr++;
    }
}
function createTable(){
    //get code of entire table, send to database
    var table = $('#tableBody').html();
    $.ajax({
        url: 'workspace_script.php',
        type: 'POST',
        data: {
            signal: 'createTable',
            table: table
        }
    });
}
/*
*Milestones scripting, done by Jeremy
*/
function milestoneSubmit(){
        if($('#title').val() != "" && $('#desc').val() != "" && $('#user').val() != "" && $('#date').val() != "" && $('.project_select').val() != ""){
            var title = $('#title').val();
            var desc = $('#desc').val();
            var date = $('#date').val();
            var user = $('#user').val();
            var project = $('.project_select').val(); 
            var branch = $('.branch_select').val();
            $.post("milestone_script.php", {
            signal: 'calendar',
            title: title,
            desc: desc,
            date: date,
            user: user,
            project: project,
            branch: branch
            }, function (data){
                alert("Succesfully added milestone " + title);
                console.log(data);
                $('#form').find('input[type=text], textarea, input[type=date]').val('');
            });
        }else
            alert("You must fill in all feilds.");
}
function change(month, year){
    $.post("workspace_script.php", {
            signal: 'calendar',
            calendar: "yes",
            month: month,
            year: year
        }, function (data){
            if(data != "error"){
                $('#milestones').html(data);
            }else{
                alert("There was an error while loading the calendar please try again.");
            }
        });
}
$(this).keyup(function(event){
    if(event.which == 27){ 
        disablePopup();
    }
});
function popup(date){
    $('#toPopup').fadeIn(0500);
    $('#popup_content').text("Loading...");
    $('#backgroundPopup').css('opacity', '0.7');
    $('#backgroundPopup').fadeIn(0001);
    $.post("workspace_script.php", {
    signal: 'calendar',
    get: "data",
    date: date,
    project: $('.project_select').val()
    }, function (data){
        var nullresp = "There are no milestones for this date.";
        if(data != nullresp && data != ""){
            var response = data.split(' ');
            $('#popup_content').html("<h3 style='color:black;'>"+ response[0] +"</h3>User: " + response[1] + "<br />Task: " + response[2] + "<br />Date: " + date);
        }else{
            $('#popup_content').html(data);
        }
    });
    $('.close').click(function (){
        disablePopup();
    });
}
function disablePopup(){
    $('#toPopup').fadeOut("normal");
    $('#backgroundPopup').fadeOut("normal");
}     
function notify(what, info){
    $.ajax({
        type: 'POST',
        url: 'get_data.php',
        data: {
            signal: 'notify',
            what: what,
            info: info
        },
        success: function(data){
            alert('x');
        }
    });
}