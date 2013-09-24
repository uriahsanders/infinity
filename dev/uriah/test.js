$(document).ready(function() {
    /*
     *Global Information
     */
    //general data
    var fileAppend = {
        uriah: '/infinity/dev'
    };
    var DATA = {
        scriptFile: fileAppend.uriah + '/uriah/test_script.php',
        //how many ways can we seperate users?
        groupTypes: ['me', 'one', 'multiple', 'group', 'privilege', 'project'],
        privileges: ['creator', 'manager', 'supervisor', 'member', 'observer'],
        categories: ['Start', 'Stream', 'Control', 'Chat', 'Wall', 'Events', 'Groups', 'Tasks', 'Boards', 'Notes', 'Tables', 'Updates', 'Files', 'Suggest'],
        projectTypes: ['Just for Fun', 'Art', 'Technology', 'Research', 'Acting', 'Games', 'Art', 'Fashion', 'Culinary', 'Music', 'Medical', 'Education'],
        //names of different cms buttons (server-side functionailty)
        CMS: ['create', 'launch', 'requests', 'messages', 'add', 'branch', 'delete', 'leave'],
        //names of special cms buttons (client-side functionality) DO NOT REPEAT ITEMS
        specialCMSStream: ['everything', 'document', 'task', 'table', 'event', 'update'],
        elements: ['Document', 'Task', 'Table', 'event', 'Update'],
        popups: [],
        specialCMSGroups: function() {
            return this.privileges;
        },
        specialCMSUpdates: ['Public', 'Member', 'all-updates']
    };
    //global vars
    var GLOBAL = {
        category: 'Start', //what page am i on?
        rutter: null, //are we filtering anything?
        numResults: null, //how many results do i currently have?
        limiter: 20, //results to filter out on avg.
        getOne: false, //am i getting one thing by itself?
        tour: false //has a tour been called yet?
    }
    /*END*/

    /*Javascript alterations*/
    Function.prototype.iterate = function(params) {
        //iterate over a single argument function EX. object.myFunction.iterate(['argumentForFirstRun', 'argumentForSecondRun']); //and so on
        for (var i = 0; i < params.length; ++i) {
            this(params[i]); //run the function
        }
    }
    //some basic stuff ya cant live without
    String.prototype.capitalize = function() {
        return this.charAt(0).toUpperCase() + this.slice(1);
    }
    String.prototype.lowerCase = function() {
        return this.charAt(0).toLowerCase() + this.slice(1);
    }

    /*END*/

    /*Functions*/
    //most common ajax run: post some data and refresh the GLOBAL.category
    //saves ultra repetitive and long code (this app uses so many ajax requests :P)

    function ajax(query, refresh, async, back) {
        async = (async === 'undefined') ? false : true;
        back = (back === 'undefined') ? '' : '<div style="float:left;margin-top:0px;"class="back">Back</div><br /><br />';
        $.ajax({
            url: DATA.scriptFile,
            async: async,
            cache: false,
            type: 'POST',
            //query string for ease of use in a function call
            data: query + '&projectID=' + $('#project_select').val() + '&branch=' + $('#branch_select').val() + '&token=' + $('#token').val(),
            success: function(data) {
                switch (refresh) {
                    case 0:
                        workspace.retrieve(GLOBAL.category); //refresh ajax call
                        break;
                    case 1:
                        location.reload(); //refresh entire page
                        break;
                    case 2:
                        break; //do nothing
                    case 3:
                        $('#main').html(back + data); //display data
                        break;
                    case 4:
                        workspace.refreshSelect();
                        break;
                }
                //alert(data); //temp
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert('An error has occured. Please try again later, or contact Infinity staff if the problems persist.' + thrownError);
            }
        });
    }

    function callBackCategory(what) {
        return function() {
            workspace.retrieve(what);
        }
    }

    function datePicker() {
        $('.datepicker').datepicker();
        $('.datepicker').datepicker('option', 'dateFormat', 'D M d, \'20\'y');
    }
    /*END*/

    /*Event handlers*/
    $(document).ajaxStart(function() {
        if (GLOBAL.category != 'Welcome') {
            timer = setTimeout(function() {
                $('#loader').fadeIn();
            }, 250);
        }
    });
    $(document).ajaxComplete(function() {
        $('#loader').fadeOut();
        clearTimeout(timer);
    });
    //infinite scroll - AJAX load
    $(document).on('scroll', window, function() {
        if ($(window).scrollTop() + $(window).height() === $(document).height()) {
            if (GLOBAL.category != 'Start' && GLOBAL.category != 'Control' && GLOBAL.getOne === false) {
                workspace.infiniteScroll(GLOBAL.category);
            }
        }
    });
    //categories ^
    for (var i = 0; i < DATA.categories.length; i++) {
        $(document).on('mousedown', '.' + DATA.categories[i], callBackCategory(DATA.categories[i]));
    }
    //cms options
    $(document).on('mousedown', 'span[class^="cms_opt_"]', function() {
        var which = $(this).attr('class').substring(8);
        //client-side (special)
        if ($.inArray(which, DATA.specialCMSStream) > -1) {
            if (GLOBAL.category === 'Stream') {
                //fade out irrelevent content
                $('tr.stream_link').hide();
                //put in what they want
                $('tr.' + which).fadeIn();
            } else {
                $('div.widget').hide();
                $('div.' + which).fadeIn();
            }
        } else if ($.inArray(which, DATA.privileges) > -1) {
            $('div.group').hide();
            $('div.' + which).fadeIn();
        } else if ($.inArray(which, DATA.specialCMSGroups) > -1 || $.inArray(which, DATA.specialCMSUpdates) > -1) {
            $('div.widget').hide();
            $('div.' + which).fadeIn();
        } else if (isNaN(which) === false) {
            $('.widget').fadeOut();
            switch (GLOBAL.category) {
                case 'Boards':
                    $('.doc_' + which).fadeIn();
                    break;
                case 'Tasks':

                    break;
                case 'Tables':

                    break;
            }
        } else if (which == 'ms-calendar') {
            events.calendar.showCalendar();
        } else if (which == 'ms-thumbnails') {
            workspace.retrieve(GLOBAL.category);
        } else {
            //server-side
            cms.popup(which);
        }
    });
    //cms popup and screen dimmer
    $(document).on('mousedown', '.dim, .cms_foot', function() {
        $('.cms_popup').fadeOut('normal', function() {
            $('.dim').fadeOut('normal', function() {
                $('.dim').remove();
                $('.cms_popup').remove();
            });
        });
    });
    $(document).on('mousedown', 'span[class^="request_link"]', function() {
        $('.canJoin').val($(this).attr('class').substring(12));
    });
    //buttons; a substring determines the function
    $(document).on('mousedown', 'button[class^="button_"]', function() {
        var sub = $(this).attr('class').substring(7);
        if (sub === 'create-branch' || sub === 'rename-branch' || sub === 'delete-branch') {
            control.manageBranch(sub);
        } else if (sub === 'update-element') {
            workspace.updateElement();
        } else if (sub === 'delete-element') {
            var elementID = (GLOBAL.category === 'Notes') ? 0 : $(this).attr('id').substring(2);
            workspace.deleteElement(elementID);
        } else {
            switch (sub) {
                case 'create':
                    workspace.create();
                    break;
                case 'launch':
                    workspace.launch();
                    break;
                case 'change':
                    control.change();
                    break;
                case 'create-doc':
                    boards.createDoc();
                    break;
                case 'delete-workspace':
                    workspace.deleteWorkspace();
                    break;
                case 'post-update':
                    updates.create();
                    break;
                case 'assign-task':
                    tasks.create();
                    break;
                case 'assign-event':
                    events.create();
                    break;
                case 'create-table':
                    tables.create();
                    break;
                case 'create-note':
                    notes.create();
                    break;
                case 'new-doc-version':
                    boards.newVersion();
                    break;
                case 'change-privileges':
                    groups.changePrivilege();
                    break;
                case 'pass-lead':
                    control.passLead();
                    break;
                case 'leave':
                    control.leave();
                    break;
                case 'send-message':
                    workspace.sendMessage();
                    break;
                case 'accept-member':
                    workspace.canJoin(true);
                    break;
                case 'deny-member':
                    workspace.canJoin(false);
                    break;
                case 'remove-member':
                    groups.removeMember();
                    break;
                case 'clear-suggests':
                    suggest.clear();
                    break;
                case 'suggest':
                    suggest.create();
                    break;
                case 'add-up':
                    Table.tbodyAddUp("tbody", [], 'data');
                    break;
                case 'add-down':
                    Table.tbodyAddDown("tbody", [], 'data');
                    break;
                case 'add-right':
                    Table.tbodyAddRight("tbody", [], 'data');
                    break;
                case 'add-left':
                    Table.tbodyAddLeft("tbody", [], 'data');
                    break;
                case 'delete-menu':
                    Table.toggleDeleteMenu('tbody');
                    break;
            }
        }
    });
    $(document).on('mousedown', 'button[class^="confirm-suggest"]', function() {
        suggest.confirm($(this).attr('class').substring(15));
    });
    $(document).on('mousedown', 'button[class^="deny-suggest"]', function() {
        suggest.deny($(this).attr('class').substring(12));
    });
    //change info given about launching
    $(document).on('change', '.launch_select', function() {
        var launchInfo;
        if ($('.launch_select').val() === 1) {
            launchInfo = '<b>Info:</b><br />Open your project to the public, allowing people to request permission to join your project.Projects are group of people working together to create something, where everyone plays a part in a major goal, for whatever the chosen incentive. If you would rather just pay a few people to do a task, no questions asked, launch this as a job.';
        } else {
            launchInfo = '<b>Info:</b><br />Allow the community to request the fufilling of a job. You can have multiple \'employees\' at one time, and use the workspace to manage them most efficiently.';
        }
        $('.launch_info').html(launchInfo).hide().fadeIn('slow');
    });
    //change between branches and projects without refreshing
    $(document).on('change', 'select[class^=fly]', function() {
        workspace.changeOnFly(parseInt($(this).attr('class').substring(3)));
    });
    //message form
    $(document).on('mousedown', '.message_send_link', function() {
        $('.message_form').slideToggle('slow');
    });
    //update status
    $(document).on('click', '#inputStatus', function() {
        $(this).select();
    });
    $(document).on('keydown', '#inputStatus', function(e) {
        if (e.keyCode === 13) {
            groups.updateStatus($('#inputStatus').val());
            $('#inputStatus').css('font-weight', 'bold');
        }
        setTimeout(function() {
            $('#inputStatus').css('font-weight', 'normal');
        }, 3000);
    });
    //slide down
    $(document).on('mousedown', 'div[class^="head"]:not(.version_select)', function() {
        var num = $(this).attr('class').substring(4);
        $('div[class^="body"]:not(.body' + num + ')').slideUp();
        $('.body' + num).slideToggle();
    });
    $(document).on('mousedown', '.stream_table tr', function() {
        var classes = $(this).attr('class').split(" ");
        var one = classes[2];
        var two = one.split('-');
        var type = two[0];
        var id = two[1];
        workspace.getOne(type, id);
    });
    $(document).on('change', '#quick_add', function() {
        cms.popup($(this).val());
        $('#quick_add').val('Quick Add'); //reset select
    });
    $(document).on('change', '#action_select', function() {
        cms.popup($(this).val());
        $('#action_select').val('Actions'); //reset select
    });
    $(document).on('mousedown', '.back', function() {
        if (GLOBAL.category === 'search' && $('#searchbar').val()) {
            workspace.search();
        } else if ($.inArray(GLOBAL.category, DATA.categories) > -1) {
            workspace.retrieve(GLOBAL.category);
        } else {
            workspace.getUser(GLOBAL.category); //num
            GLOBAL.category = 'Groups';
        }
    });
    $(document).on('mousedown', 'a[class^="more_"], button[class^="more_"]', function() {
        var sub = $(this).attr('class').substring(5);
        var subArray = sub.split('-');
        workspace.getOne(subArray[0], subArray[1]);
    });
    $(document).on('mousedown', 'a[class^="profile_"]', function() {
        workspace.getUser($(this).attr('class').substring(8));
    });
    $(document).on('mousedown', 'div[class$="note"]', function() {
        cms.popup('note', 0, $(this).attr('class').slice(0, -4));
    });
    $(document).on('mousedown', 'button[class$="version"]', function() {
        cms.popup('new-doc-version', 0, $(this).attr('class').slice(0, -7));
    });
    $(document).on('change', 'input[type=radio][name^="status"]', function() {
        tasks.mark($(this).attr('name').substring(6), $(this).val());
    });
    $(document).on('change', 'input[type=checkbox][name^="status"]', function() {
        var status = ($(this).is(':checked')) ? 1 : 0;
        events.mark($(this).attr('name').substring(6), status);
        status = (status == 0) ? 'Incomplete' : 'Complete';
        $('#mi-status').text(status).hide().fadeIn();
    });
    $(document).on('mousedown', '.back-groups', function() {
        workspace.retrieve('Groups');
    });
    $(document).on('mousedown', '.note-transform', function() {
        ajax("signal=createDoc&title=" + $('.page_update-title').val() + '&body=' + $('.page_update-body').val(), 0);
        alert("Document created.");
    });
    $(document).on('click', '#searchbar', function() {
        $(this).select();
    });
    //search
    $(document).on('keyup', '#searchbar', function(e) {
        $('#navigation li').removeClass('active');
        $('#navigation li:first-child').addClass('active');
        if (e.keyCode === 13) {
            $(this).select();
        }
        if ($('#searchbar').val()) {
            workspace.search();
        } else {
            $('#head').text("Search:");
            $('#cms').html('<hr />');
            $('#main').text("No search results.");
        }
    });
    $(document).on('change', 'select[class^="version_select"]', function() {
        boards.getVersion($(this).attr('class').substring(14), $(this).val());
        $('select[class^=version_select]').val($(this).val());
    });
    $(document).on('change', '.group_privilege_select', function() {
        groups.changePrivilege($(this).val());
    });
    $(document).on('mousedown', 'button[class^="remRow"]', function() {
        Table.removeRow('tbody', $(this).attr('class').substring(6));
        Table.toggleDeleteMenu.iterate(['tbody', 'tbody']);
    });
    $(document).on('mousedown', 'button[class^="remCol"]', function() {
        Table.removeCol('tbody', $(this).attr('class').substring(6));
        Table.toggleDeleteMenu.iterate(['tbody', 'tbody']);
    });
    //events: clicking thumbnails
    $(document).on('mousedown', 'div[id^="event-div"]', function() {
        var id = $(this).attr('id').substring(9);
        //Dont getOne for checkbox
        if (GLOBAL.category === 'Tasks') {
            if (!$(event.target).closest('input[type="checkbox"]').length > 0) workspace.getOne('task', id);
            else {
                if ($('#event-color' + id).css('color') === 'rgb(255, 0, 0)' || $('#event-color' + id).css('color') === '#FFF') $('#event-color' + id).css('color', 'green');
                else {
                    if ($('#event-color' + id).attr('class') == 'event_red') $('#event-color' + id).css('color', 'red');
                    else $('#event-color' + id).css('color', '#FFF');
                }
            }
        } else workspace.getOne('event', id);
    });
    $(document).on('click', '#workspace_tour', function() {
        workspace.tour();
    });
    /*END*/

    /*AUTOSAVE (optional-performance)*/
    //autosave workspace
    /*$(document).on('keyup change', 'input[class=project_title], textarea[class=project_description], select[class=project_GLOBAL.category]', function(){
      control.change(0);
  });
  //autosave elements 
  $(document).on('keyup, click, change', 'input[class^=page_update], textarea[class^=page_update], select[class^=page_update]', function(){
      workspace.updateElement(0);
    });*/
    /*END AUTOSAVE*/
    /*AUTOSAVE LOOP HANDLER (optional-performance)*/
    /*
     *check for page, cms popup
     *either control.change or workspace.updateElement depending
     *set timeout of desired time
     *end timeout on click of .dim, or workspace.retrieve
     */
    /*AUSTOSAVE NODE HANDLERS (preffered-performance)*/
    /*
     *Add node.js to server
     *Open connection on getOne and getUser
     *notify: additional editors, cursors, deletion
     */
    /*END AUTOSAVE*/


    /*Object literals*/
    var workspace = {
        init: function(num, retrieve) {
            //workspace.retrieve() afterwards by default
            retrieve = (typeof(retrieve) === 'undefined') ? true : retrieve;
            //branches/logo/statistics
            if (num === 0) { //0 for full page update
                $.ajax({
                    url: DATA.scriptFile,
                    type: 'POST',
                    async: false,
                    cache: false,
                    datatype: 'json',
                    data: {
                        signal: 'init',
                        projectID: $('#project_select').val()
                    },
                    success: function(data) {
                        var response = jQuery.parseJSON(data);
                        if (response.clear === true) {
                            $('#branch').html(response.branch); //branches
                            $('#logo').css('background', response.logo); //logo
                            $('#stats').html(response.stats); //statistics
                            if (retrieve === true) workspace.retrieve(GLOBAL.category); //main content
                        } else {
                            $('#branch').html("<select id='branch_select'><option>0</option></select>"); //branches
                            //throw up a big screen!
                            workspace.welcome();
                        }
                    }
                });
                $('#rss_link').attr('href', 'workspace_rss.php?feed=' + $('#project_select').val()); //correct RSS link
                setTimeout(0); //that's all that matters, so just catch up now
            }
            //just get role/privilege and additional select options
            $.ajax({
                url: DATA.scriptFile,
                type: 'POST',
                async: true,
                data: {
                    signal: 'getPlace',
                    projectID: $('#project_select').val(),
                    branch: $('#branch_select').val()
                },
                success: function(data) {
                    var response = jQuery.parseJSON(data);
                    $('#my_place').html(response.my_place).hide().fadeIn();
                    $('#quick_add').html(response.quick_add).hide().fadeIn();
                    $('#action_select').html(response.action_select).hide().fadeIn();
                    if (num != 0) {
                        workspace.retrieve(GLOBAL.category);
                    }
                }
            });
        },
        err: function() {
            $('#head').text('Nothing is here.');
            $('#main').html('<div id="empty"><span>Sorry! We couldnt find what you were looking for.</span></div>');
        },
        tour: function() {
            //Initiate tour, wrap in if to only create elements on first call
            if (GLOBAL.tour === false) { //has a tour been called yet?
                Tour.createElement({
                    attachTo: '#top',
                    txt: 'All your general workspace actions are up here.<br /> You can also change your status, and current project/branch.',
                    arrowDir: 'up',
                    style: 'margin-top:55px;'
                });
                Tour.createElement({
                    attachTo: '#top',
                    txt: 'Here you can view your RSS feed for this branch, <br /> get help using the workspace, <br /> or go back to the lounge.',
                    arrowDir: 'up',
                    style: 'margin-left:900px;margin-top:50px;'
                });
                Tour.createElement({
                    attachTo: '#logo',
                    txt: 'This is your workspace logo.',
                    arrowDir: 'left',
                    style: 'margin-left:400px;'
                });
                Tour.createElement({
                    attachTo: '#stats',
                    txt: 'Your workspace statistics and general information.',
                    arrowDir: 'up',
                    style: 'margin-top:40px;margin-left:300px;'
                });
                Tour.createElement({
                    attachTo: '#cms',
                    txt: 'This is where the CMS (content management) buttons go.<br /> Use these to perform special options on this page.',
                    arrowDir: 'up'
                });
                Tour.createElement({
                    attachTo: '#side',
                    txt: 'This is where the general content is displayed.',
                    arrowDir: 'up',
                    style: 'margin-left:300px;margin-top:300px;'
                });
                Tour.createElement();
                Tour.init({
                    page: 'workspace',
                    localstorage: false
                });
                GLOBAL.tour = true; //a tour has been called before now
            } else {
                Tour.resumeTour(); //restart the tour
            }
        },
        retrieve: function(what, opt) {
            //dont allow pointless retrievals
            if (opt === 'undefined') opt = 1;
            $.ajax({
                url: DATA.scriptFile,
                type: 'POST',
                datatype: 'json',
                cache: false,
                data: {
                    signal: what,
                    projectID: $('#project_select').val(),
                    branch: $('#branch_select').val()
                },
                success: function(data) {
                    //alert(data); //temp
                    if (GLOBAL.getOne === true) GLOBAL.getOne = false;
                    response = jQuery.parseJSON(data);
                    //display content
                    $('#head').text(what);
                    $('#cms').html(response.cms);
                    $('#main').html(response.main);
                    if (!response.main) {
                        $('#main').html('<div id="empty"><span>Nothing has been posted here yet.</span></div>');
                    }
                    //change the current GLOBAL.category
                    if (GLOBAL.category !== 'Welcome') GLOBAL.category = what;
                    //reset scroll
                    GLOBAL.limiter = 20;
                    //style stuff
                    $('#navigation li').removeClass('active');
                    $('.' + GLOBAL.category).addClass('active');
                    //canvas
                    if (what === 'Start') {
                        graphs.pie();
                        graphs.linear();
                    } else if (what === 'Tables') {
                        $('th, td').attr('contenteditable', 'false');
                    }
                },
                error: function() {
                    alert("retrieval error");
                }
            });
        },
        deleteWorkspace: function() {
            var input = $('.delete_input').val();
            if (input != 'DELETE') {
                alert("You need to type DELETE into the input field.");
            } else {
                var x = confirm('Are you sure you want to delete this project? ALL data will be lost, and it ain\'t ever coming back again.');
                if (x) {
                    ajax('signal=deleteWorkspace&input=' + input, 1);
                }
            }
        },
        infiniteScroll: function(category) {
            var query = (GLOBAL.category === 'search') ? $('#searchbar').val() : 0;
            $.ajax({
                url: DATA.scriptFile,
                type: 'POST',
                data: {
                    signal: 'infiniteScroll',
                    page: GLOBAL.category,
                    branch: $('#branch_select').val(),
                    projectID: $('#project_select').val(),
                    limiter: GLOBAL.limiter,
                    query: query,
                    rutter: GLOBAL.rutter
                },
                success: function(data) {
                    if (GLOBAL.category === 'Stream') $(data).hide().appendTo('.stream_table').fadeIn('slow');
                    else $(data).hide().appendTo('#main').fadeIn('slow');
                    GLOBAL.limiter++;
                },
                error: function() {
                    alert("NOOOOO!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
                }
            });
        },
        updateElement: function(num) {
            num = (num === undefined) ? 1 : 0;
            switch (GLOBAL.category) {
                case 'Updates':
                    ajax('signal=updateElement&title=' + $('.page_update-title').val() + '&body=' + $('.page_update-body').val() + '&elementID=' + $('.element-id').val() + '&page=' + GLOBAL.category, 2);
                    break;
                case 'Notes':
                    ajax('signal=updateElement&title=' + $('.page_update-title').val() + '&body=' + $('.page_update-body').val() + '&elementID=' + $('.element-id').val() + '&page=' + GLOBAL.category, 0);
                    break;
                case 'Boards':
                    ajax('signal=updateElement&title=' + $('.page_update-title').val() + '&body=' + $('.page_update-body').val() + '&elementID=' + $('.element-id').val() + '&page=' + GLOBAL.category + '&level=' + $('.doc_level').val(), 2);
                    break;
            }
            if (num === 1) alert("Element updated.");
        },
        deleteElement: function(id) {
            var level = (GLOBAL.category === 'Boards') ? $('.doc_dd' + id).val() : 0;
            if (GLOBAL.category === 'Notes') {
                ajax('signal=deleteElement&elementID=' + $('.element-id').val() + '&page=' + GLOBAL.category + '&level=' + level, 0);
                cms.killPopup();
            } else {
                ajax('signal=deleteElement&elementID=' + id + '&page=' + GLOBAL.category + '&level=' + level, 0);
            }
            alert("Deleted");
        },
        welcome: function() {
            GLOBAL.category = 'Welcome';
            var categorySelect;
            for (var i = 0; i <= DATA.projectTypes.length; i++) {
                categorySelect += '<option>' + DATA.projectTypes[i] + '</option>';
            }
            var form = '\
            <div id="dim"></div>\
            <div id="welcome_popup">\
                <br /><br /><br /><br /><br /><br /><br /><br /> \
                <span id="welcome_head">\
                  Welcome to the workspace!<br /><br />\
                </span>\
                It looks like you haven\'t created or joined any workspaces yet.\
                Before using the workspace, please join a project or job <a target="_blank"href="/projects">here</a>.<br />\
                Or, make your own right now.<br /><br />\
                <select class="create_GLOBAL.category">\
                  ' + categorySelect + '\
                </select><br />\
                <input type="text" class="create_title" placeholder="Title" autofocus/><br />\
                <textarea class="create_body" placeholder="Description"></textarea>\
                <br />\
                <button class="button_create">Create</button>\
            </div>\
            ';
            $(document.body).append(form);
        },
        verify: function(title, body) {
            if (title.length > 2 && body.length > 5) return true;
            else return false;
        },
        refreshSelect: function() {
            $.ajax({
                url: DATA.scriptFile,
                type: 'POST',
                data: {
                    signal: 'refreshSelect',
                    projectID: $('#project_select').val(),
                    branch: $('#branch_select').val()
                },
                success: function(data) {
                    $('#project_select').html(data)
                }
            });
        },
        //make a new workspace
        create: function() {
            var rfrsh = (GLOBAL.category === 'Welcome') ? 1 : 4;
            if (workspace.verify($('.create_title').val(), $('.create_body').val())) {
                alert('Workspace has been created.');
                ajax('signal=create&title=' + $('.create_title').val() + '&description=' + $('.create_body').val() + '&GLOBAL.category=' + $('.create_GLOBAL.category').val(), rfrsh);
            } else {
                alert('Please make sure your title contains at least two characters, and your description at least five.');
            }
        },
        //change branch/project without reload
        changeOnFly: function(num) {
            if (num === 0) {
                workspace.init(0); //get branches, statistics, and role
            } else {
                workspace.init(1); //get role
            }
        },
        launch: function() {
            var as = $('.launch_select').val();
            ajax('signal=launch&as=' + as, 0);
            //refresh the popup
            cms.popup('launch', 1);
        },
        search: function() {
            var query = $('#searchbar').val();
            $.ajax({
                type: 'POST',
                url: DATA.scriptFile,
                data: {
                    signal: 'search',
                    query: query,
                    projectID: $('#project_select').val(),
                    branch: $('#branch_select').val()
                },
                success: function(data) {
                    GLOBAL.category = 'search';
                    $('#head').html('Search: <span style="color:lightblue;">' + query + '</span>');
                    /*$('#cms').html(' \
                    <span class="cms_opt_everything"><b>*</b><br />Everything</span> \
                    <span class="cms_opt_document"><img src="/images/list.png"><br />Documents</span> \
                    <span class="cms_opt_task"><img src="/images/cog3.png"><br />Tasks</span> \
                    <span class="cms_opt_table"><img src="/images/list.png"><br />Tables</span> \
                    <span class="cms_opt_event"><img src="/images/cog3.png"><br />events</span> \
                    <span class="cms_opt_update"><b>!</b><br />Updates</span> \
                    ');*/
                    $('#cms').html('<hr />');
                    $('#main').html(data);
                }
            });
        },
        getOne: function(type, id) {
            $.ajax({
                url: DATA.scriptFile,
                type: 'POST',
                data: {
                    signal: 'getOne',
                    type: type,
                    id: id,
                    projectID: $('#project_select').val(),
                    branch: $('#branch_select').val()
                },
                success: function(data) {
                    if (data !== '') {
                        GLOBAL.getOne = true;
                        $('#navigation li').removeClass('active');
                        $('#cms').html('');
                        $('#head').text(type.capitalize());
                        $('#main').html(data);
                        $('#main').prepend('<div style="float:left;margin-top:0px;"class="back">Back</div><br /><br />');
                        if (type === 'document') $('select[class^=version_select]').val($('.doc_level').val());
                        datePicker();
                    } else workspace.err();
                }
            });
        },
        back: function() {
            workspace.retrieve(GLOBAL.category);
        },
        commentOne: function(id) {
            ajax('signal=commentOne&elementID=' + id, 0);
        },
        getUser: function(id) {
            $.ajax({
                url: DATA.scriptFile,
                type: 'POST',
                data: {
                    signal: 'getUser',
                    userID: id,
                    branch: $('#branch_select').val(),
                    projectID: $('#project_select').val()
                },
                success: function(data) {
                    var response = JSON.parse(data);
                    if (response.check === false) workspace.err();
                    else {
                        $('#main').html(response.main);
                        $('#head').text(response.head);
                        $('#cms').html('');
                        $('#main').prepend('<div style="float:left;margin-top:0px;"class="back-groups">Back</div><br /><br />');
                    }
                    GLOBAL.getOne = true;
                    $('#navigation li').removeClass('active');
                    GLOBAL.category = id;
                }
            });
        },
        //add a tag to something
        tagElement: function(id) {
            ajax('signal=tag&elementID=' + id, 0);
            $('.tags').innerHTML += $('.tag_txt').val();
        },
        canJoin: function(bool) {
            ajax('signal=canJoin&do=' + bool + '&person=' + $('.canJoin').val(), 2);
            cms.popup('requests', 1);
        },
        sendMessage: function() {
            var title = $('.msg_title').val();
            var body = $('.msg_body').val();
            var to = [];
            $('input[class^=member_check_]').each(function() {
                if ($(this).is(':checked')) {
                    to.push($(this).attr('class').substring(13));
                }
            });
            if (workspace.verify(title, desc) && to != '') {
                alert('Message sent.');
                ajax('signal=sendMessage&title=' + title + '&body=' + body + '&to=' + JSON.stringify(to), 2);
                cms.popup('messages', 1);
            } else {
                alert("Please make sure you have a title of at least 3 characters, a description of at least 6, and that you have assigned this task to at least one person.");
            }
        }
    };
    //popup forms for the cms options
    var cms = {
        //repetitive css function for popups and dimming screen
        cssFunc: function(type, data) {
            if (type === 1) {
                $('.dim').hide();
                $('.cms_popup').html(data);
            } else {
                $(document.body).append(data);
                $('.dim').hide().fadeIn();
                $('.cms_popup').hide().fadeIn();
            }
        },
        popup: function(what, type, id) {
            if (type === undefined) type = 0;
            if (id === undefined) id = 0;
            //if session storage var has not already been set
            if (sessionStorage[what] !== undefined) {
                var data = sessionStorage[what];
                cms.cssFunc(type, data); //create a popup with client data
            } else {
                //no client storage so get from server
                $.ajax({
                    url: DATA.scriptFile,
                    type: 'POST',
                    data: {
                        signal: 'cms',
                        what: what,
                        projectID: $('#project_select').val(),
                        branch: $('#branch_select').val(),
                        id: id
                    },
                    success: function(data) {
                        cms.cssFunc(type, data);
                        datePicker(); //make proper fields datepickers
                        sessionStorage[what] = data; //set sessionstorage for speed
                    }
                });
            }
        },
        killPopup: function() {
            $('.dim').mousedown();
        }
    }
    //continue on with major actions in each GLOBAL.category; majorly self explanatory
    var control = {
        change: function(num) {
            num = (num === undefined) ? 1 : 0;
            var title = $('.project_title').val();
            ajax('signal=change&title=' + title + '&description=' + $('.project_description').val() + '&GLOBAL.category=' + $('.project_GLOBAL.category').val(), 4, false);
            if (num === 1) alert("Project information has been updated.");
            $('#project_select option:selected').text(title);
        },
        deleteProject: function() {
            alert("Project has been deleted.");
            ajax('signal=deleteProject', 1);
        },
        manageBranch: function(opt) {
            var dataSecond = null;
            switch (opt) {
                case 'create-branch':
                    var data = $('.branch_title').val();
                    break;
                case 'rename-branch':
                    var data = $('.branch_rename-select').val();
                    dataSecond = $('.branch_rename-title').val();
                    break;
                case 'delete-branch':
                    var data = $('.branch_delete-select').val();
                    break;
            }
            if (opt != 'create-branch' && data === '-') {
                alert('There is no branch to do that to.');
            } else {
                ajax('signal=manageBranch&factor=' + opt + '&data=' + data + '&dataSecond=' + dataSecond, 0);
                alert("Done");
                //refresh everything
                workspace.init(0);
                cms.popup('branch', 1);
            }
        },
        leave: function() {
            alert('You have left the project.');
            ajax('signal=leave', 1);
        },
        passLead: function() {
            var who = $('.pass_member_select').val();
            if (who) {
                var check = confirm("You sure, bro?");
                if (check) ajax('signal=passLead&who=' + who, 1);
            }
        },
        leave: function() {
            var check = confirm("You sure, bro?");
            if (check) ajax('signal=leave', 1);
        }
    };
    var updates = {
        create: function() {
            var title = $('.update_title').val();
            var desc = $('.update_desc').val();
            if (workspace.verify(title, desc)) {
                ajax('signal=new-update&title=' + title + '&desc=' + desc + '&select=' + $('.update_select').val(), 0);
                alert('Update posted.');
                cms.popup('new-update');
            }
        }
    };
    var groups = {
        removeMember: function() {
            ajax('signal=removeMember&person=' + $('.userID').val(), 0);
        },
        changePrivilege: function(priv) {
            ajax('signal=changePrivilege&privilege=' + priv + '&user=' + $('.userID').val(), 2);
        },
        updateStatus: function(status) {
            ajax('signal=updateStatus&status=' + status, 2);
            if (GLOBAL.category === 'Groups') {
                workspace.retrieve('Groups', 0);
            }
        }
    };
    var tasks = {
        create: function() {
            var title = $('.task_title').val();
            var desc = $('.task_desc').val();
            var to = [];
            $('input[class^=member_check_]').each(function() {
                if ($(this).is(':checked')) {
                    to.push($(this).attr('class').substring(13));
                }
            });
            if (workspace.verify(title, desc) && to != '') {
                ajax('signal=assign-task&title=' + title + '&desc=' + desc + '&date=' + $('.task_due').val() + '&to=' + JSON.stringify(to), 0);
                cms.popup('assign-task', 1);
            } else {
                alert("Please make sure you have a title of at least 3 characters, a description of at least 6, and that you have assigned this task to at least one person.");
            }
        },
        update: function() {

        },
        mark: function(id, status) {
            ajax('signal=mark-task&taskID=' + id + '&status=' + status, 2);
        }
    };
    var events = {
        create: function() {
            ajax('signal=assign-event&title=' + $('#event_title').val() + '&from=' + $('#event_from').val() + '&to=' + $('#event_to').val(), 0);
            alert('Done.');
            cms.popup('assign-event', 1);
        },
        calendar: {
            showCalendar: function() {
                events.calendar.showThis('day');
            },
            showThis: function(what) {
                events.calendar.genCalAjax('events-calendar-init-' + what, 0);
            },
            genCalAjax: function(signal, level) {
                $.ajax({
                    type: 'POST',
                    url: DATA.scriptFile,
                    data: {
                        signal: signal,
                        interval: $('#events_calendar_interval').val(),
                        date: $('#events_calendar_find-date').val(),
                        projectID: $('#project_select').val(),
                        branch: $('#branch_select').val()
                    },
                    success: function(data) {
                        if (level === 0) $('#main').html(data);
                        else $('#events_calendar_body').html(data);
                    }
                });
            },
            findDate: function() {
                events.calendar.genCalAjax('findDate');
            },
            goBack: function() {
                events.calendar.genCalAjax('goBack');
            },
            goPrev: function() {
                events.calendar.genCalAjax('goPrev');
            }
        },
        update: function() {

        },
        mark: function(id, status) {
            ajax('signal=mark-event&eventID=' + id + '&status=' + status, 2);
        }
    };
    var boards = {
        createDoc: function() {
            ajax("signal=createDoc&title=" + $('.doc_title').val() + '&body=' + $('.doc_body').val(), 0);
            alert("Document created.");
            cms.popup('create-document', 1);
        },
        newVersion: function() {
            var id = $('.version-doc-mark').val();
            ajax('signal=newDocVersion&mark=' + id + '&level=' + $('.version-doc-level').val() + '&title=' + $('.version-doc-title').val() + '&body=' + $('.version-doc-body').val(), 2);
            $('.dim').mousedown();
            alert('New version created.');
            workspace.getOne('document', $('.element-id').val());
        },
        getVersion: function(id, version) {
            ajax('signal=getVersion&mark=' + id + '&version=' + version, 3, 'undefined', false);
        }
    };
    var tables = {
        create: function() {
            ajax('signal=create-table&table=' + $('.tableBody').html() + '&title=' + $('.table_name').val(), 0);
            alert('Table created');
            cms.popup('create-table', 1);
        },
        updateTable: function() {
            ajax('signal=updateTable&table=' + $('.tableBody').html() + '&title=' + $('.table_name').val(), 2);
        }
    };
    var Table = {
        /*functions: ['tbodyAddRight', 'tbodyAddLeft', 'tbodyAddUp', 'tbodyAddDown', 'removeRow', 'remCol'],
    memory: 20,
    storedData: [
      entry0: {
        identifier: null,
        html: '<tr><td>data</td><td>data</td></tr><tr><td>data</td><td>data</td></tr>'
      }
    ],
    undo_funcs: [],
    redo_funcs: [],
    undo: function(){
      var lastEntry = undo_funcs[-1];
      Table.execute(counterFunction(lastEntry));
      redo_funcs.push(lastEntry);
      undo_funcs.pop();
    },
    redo: function(){
      var lastEntry = redo_funcs[-1];
      Table.execute(lastEntry);
      undo_funcs.push(lastEntry);
      redo_funcs.pop();
    },
    counterFunction: function(to){
      if(to === 'tbodyAddRight' || to === 'tbodyAddLeft'){
        Table.removeCol('tbody', storedData[-1]);
      }else if(to === 'tbodyAddUp' || to === 'tbodyAddDown'){
        Table.removeRow('tbody', storedData[-1]);
      }else if(to === 'removeRow' || to === 'removeCol'){
        switch(storedData[-1].identifier){
          case 'top':

        }
      }
    }
    execute: function(what){
      undo_funcs.push(what);
      return Table[what] && Table[what].apply(Table, [].slice.call(arguments, 1));
    },*/
        tbodyAddRight: function(tbody_id, array, filler) {
            var tbody = document.getElementById(tbody_id);
            var array_len = array.length;
            var tbodyTr = tbody.children;
            var tbodyTr_len = tbodyTr.length;
            for (var i = 0; i < array_len; i++) {
                tbodyTr[i].innerHTML += "<td>" + array[i] + "</td>";
            }
            if (array_len < tbodyTr_len) {
                for (var i = array_len; i < tbodyTr_len; i++) {
                    tbodyTr[i].innerHTML += "<td>" + filler + "</td>";
                }
            }
        },
        tbodyAddLeft: function(tbody_id, array, filler) {
            var tbody = document.getElementById(tbody_id);
            var array_len = array.length;
            var tbodyTr = tbody.children;
            var tbodyTr_len = tbodyTr.length;
            for (var i = 0; i < array_len; i++) {
                tbodyTr[i].innerHTML = "<td>" + array[i] + "</td>" + tbodyTr[i].innerHTML;
            }
            if (array_len < tbodyTr_len) {
                for (var i = array_len; i < tbodyTr_len; i++) {
                    tbodyTr[i].innerHTML = "<td>" + filler + "</td>" + tbodyTr[i].innerHTML;
                }
            }
        },
        tbodyAddUp: function(tbody_id, array, filler) {
            var tbody = document.getElementById(tbody_id);
            var array_len = array.length;
            tbody.innerHTML = "<tr></tr>" + tbody.innerHTML;
            var tbodyTr = tbody.children;
            var tbodyTr_len = tbodyTr[1].children.length;
            for (var i = 0; i < array_len; i++) {
                tbodyTr[0].innerHTML += "<td>" + array[i] + "</td>";
            }
            if (array_len < tbodyTr_len) {
                for (var i = array_len; i < tbodyTr_len; i++) {
                    tbodyTr[0].innerHTML += "<td>" + filler + "</td>";
                }
            }
        },
        tbodyAddDown: function(tbody_id, array, filler) {
            var tbody = document.getElementById(tbody_id);
            var array_len = array.length;
            tbody.innerHTML += "<tr></tr>";
            var tbodyTr = tbody.children;
            var tbodyTr_len = tbodyTr[0].children.length;
            var tbodyTr_index = tbodyTr.length - 1;
            for (var i = 0; i < array_len; i++) {
                tbodyTr[tbodyTr_index].innerHTML += "<td>" + array[i] + "</td>";
            }
            if (array_len < tbodyTr_len) {
                for (var i = array_len; i < tbodyTr_len; i++) {
                    tbodyTr[tbodyTr_index].innerHTML += "<td>" + filler + "</td>";
                }
            }
        },
        removeRow: function(tbody_id, row) {
            var tbody = document.getElementById(tbody_id);
            var stuff = tbody.children[row];
            //Table.storedData.push(stuff);
            tbody.removeChild(stuff);
        },
        removeCol: function(tbody_id, col) {
            var tbody = document.getElementById(tbody_id);
            var tbody_len = tbody.children.length;
            var stuff = null;
            for (var i = 0; i < tbody_len; i++) {
                //stuff += tbody.children[i].children[col];
                tbody.children[i].removeChild(tbody.children[i].children[col]);
            }
            //Table.storedData.push(stuff);
        },
        edit: function(tbody_id, new_value, x, y) {
            var tbody = document.getElementById(tbody_id);
            tbody.children[y].children[x].innerHTML = new_value;
        },
        toggleContentEditable: function(tbody_id) {
            var tbody = document.getElementById(tbody_id);
            if (tbody.getAttribute("contenteditable") === "true") {
                tbody.setAttribute("contenteditable", "false");
            } else {
                tbody.setAttribute("contenteditable", "true");
            }
        },
        toggleDeleteMenu: function(tbody_id) {
            var tbody = document.getElementById(tbody_id);
            var edit_menu_delete_row_column = document.getElementById('edit_menu_delete_row_column');
            Table.toggleContentEditable(tbody_id);
            if (edit_menu_delete_row_column.innerHTML === "Delete Mode") {
                edit_menu_delete_row_column.innerHTML = "Edit Mode";
                var tbodyTr = tbody.children;
                var tbodyTr_len = tbodyTr.length;
                for (var i = 0; i < tbodyTr_len; i++) {
                    tbodyTr[i].innerHTML = "<td><button class='remRow" + i + "'>X</button></td>" + tbodyTr[i].innerHTML;
                }
                tbody.innerHTML = "<tr></tr>" + tbody.innerHTML;
                var tbodyTr = tbody.children;
                var tbodyTr_len = tbodyTr[1].children.length;
                tbodyTr[0].innerHTML += "<td></td>";
                for (var i = 1; i < tbodyTr_len; i++) {
                    tbodyTr[0].innerHTML += "<td><button class='remCol" + i + "'>X</button></td>";
                }
            } else {
                edit_menu_delete_row_column.innerHTML = "Delete Mode";
                Table.removeRow(tbody_id, 0);
                Table.removeCol(tbody_id, 0);
            }
        }
    };
    var graphs = {
        pie: function() {
            //values of each slice
            var data = [];
            var check = false;
            var vals = [];
            $.ajax({
                url: DATA.scriptFile,
                type: 'POST',
                async: false,
                datatype: 'json',
                data: 'signal=pie&branch=' + $('#branch_select').val() + '&projectID=' + $('#project_select').val(),
                success: function(res) {
                    var response = JSON.parse(res);
                    if (response != 'undefined') {
                        data[0] = response.document;
                        data[1] = response.task;
                        data[2] = response.table;
                        data[3] = response.file;
                        data[4] = response.event;
                        check = true;
                    }
                }
            });
            var canvas = document.getElementById('pie');
            var ctx = canvas.getContext('2d');
            //values of each slice
            //var data = [55,48,32,45,20];
            //colors of each slice, in order with data
            var colors = ["#7E3817", "#C35817", "#EE9A4D", "#A0C544", "#348017"];
            var center = [canvas.width / 2, canvas.height / 2];
            //radius is the /2 of the smallest dimension
            var radius = Math.min(canvas.width, canvas.height) / 2;
            var lastPosition = 0,
                total = 0;
            //total value is adding all data
            for (var i = 0; i < data.length; i++) {
                total += data[i];
            }
            for (var i = 0; i < data.length; i++) {
                ctx.fillStyle = colors[i];
                ctx.beginPath();
                ctx.moveTo(center[0], center[1]);
                //arc beginning from the most recent spot
                ctx.arc(center[0], center[1], radius, lastPosition, lastPosition + (Math.PI * 2 * (data[i] / total)), false);
                ctx.fill();
                lastPosition += Math.PI * 2 * (data[i] / total);
                ctx.lineWidth = 1;
                ctx.strokeStyle = 'gray';
                ctx.stroke();
            }

            function percent(val) {
                if (check) {
                    var it = Math.round((val / total) * 100) + '%';
                    if (it != 'NaN%') {
                        return it;
                    } else {
                        vals.push(0);
                        return 0;
                    }
                }
            }
            ctx.beginPath();
            ctx.rect(1, 1, 105, 100);
            ctx.fillStyle = 'gray';
            ctx.fill();
            ctx.lineWidth = 1;
            ctx.strokeStyle = 'grey';
            ctx.stroke();
            ctx.fillStyle = '#fff';
            ctx.font = '12px sans-serif';
            ctx.fillText('Documents: ' + percent(data[0]), 5, 15);
            ctx.fillText('Tasks: ' + percent(data[1]), 5, 35);
            ctx.fillText('Tables: ' + percent(data[2]), 5, 55);
            ctx.fillText('Files: ' + percent(data[3]), 5, 75);
            ctx.fillText('events: ' + percent(data[4]), 5, 95);
            if (vals.length > 0) {
                ctx.font = '25px sans-serif';
                ctx.fillText('Nothing has been created yet.', 0, center[1]);
            }
        },
        linear: function() {
            /*var dates = ['Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'];
          $.ajax({
              url: DATA.scriptFile,
              type: 'POST',
              async: false,
              datatype: 'json',
              data: 'signal=linear&branch='+$('#branch_select').val()+'&projectID='+$('#project_select').val(),
              success: function(res){
                  var response = JSON.parse(res);
                  data.values[0].Y = response.mon;
                  data.values[1].Y = response.tue;
                  data.values[2].Y = response.wed;
                  data.values[3].Y = response.thur;
                  data.values[4].Y = response.fri;
                  data.values[5].Y = response.sat;
                  data.values[6].Y = response.sun;
              }
            });*/
            var data = {
                values: [{
                    X: "Mon",
                    Y: 12
                }, {
                    X: "Tue",
                    Y: 28
                }, {
                    X: "Wed",
                    Y: 18
                }, {
                    X: "Thur",
                    Y: 34
                }, {
                    X: "Fri",
                    Y: 6
                }, {
                    X: "Sat",
                    Y: 15
                }, {
                    X: "Sun",
                    Y: 62
                }],
                getXValue: function(i) {
                    return data.padding + (i * (data.padding - 10) * 2.75);
                },
                getYValue: function(i) {
                    var value = ((canvas.height - (data.padding - 15)) - (data.padding - 20)) - 2.75 * i;
                    return value;
                },
                maxY: 90,
                padding: 30,
                colors: ['gray', 'lightblue'],
                axisWidth: 3,
                lineThickness: 2
            };
            var canvas = document.getElementById('linear');
            var ctx = canvas.getContext('2d');
            //X/Y axis lines
            ctx.beginPath();
            ctx.lineWidth = data.axisWidth;
            ctx.strokeStyle = data.colors[0];
            //X/Y axis
            ctx.moveTo(data.padding, 0);
            ctx.lineTo(data.padding, canvas.height - data.padding);
            ctx.lineTo(canvas.width, canvas.height - data.padding);
            ctx.stroke();
            ctx.font = '1em Arial';
            //bottom dates
            for (var i = 0; i < data.values.length; i++) {
                ctx.fillText(data.values[i].X, data.getXValue(i), canvas.height);
            }
            //left numbers
            for (var i = 0; i <= data.maxY; i += 10) {
                ctx.fillText(i, 0, data.getYValue(i));
            }
            //points
            ctx.beginPath();
            ctx.fillStyle = data.colors[0];
            for (var i = 0; i < data.values.length; i++) {
                ctx.arc(data.getXValue(i) + 15, data.getYValue(data.values[i].Y) - 5, 7, 0, Math.PI * 2, true);
                ctx.fill();
            }
            //lines
            ctx.beginPath();
            ctx.moveTo(data.getXValue(0), data.getYValue(0));
            ctx.strokeStyle = data.colors[1];
            for (var i = 0; i < data.values.length; i++) {
                ctx.lineTo(data.getXValue(i) + 15, data.getYValue(data.values[i].Y) - 5);
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
                ctx.stroke();
            }
        }
    };
    var suggest = {
        create: function() {
            var what = $('.suggest_select').val();
            var main = (what === 'document') ? $('.suggest_body').val() : $('.tableBody').html();
            ajax('signal=suggest&title=' + $('.suggest_title').val() + '&main=' + main + '&what=' + $('.suggest_select').val(), 0);
            cms.popup('suggest', 1);
            alert("Suggestion sent.");
        },
        confirm: function(id) {
            ajax('signal=confirmSuggest&elementID=' + id, 0);
        },
        deny: function(id) {
            ajax('signal=denySuggest&elementID=' + id, 0);
        },
        clear: function() {
            ajax('signal=clearSuggestions', 0);
            alert("Suggestions cleared.");
        }
    };
    var requests = {
        confirm: function() {

        },
        deny: function() {

        },
        reportAndDelete: function() {

        }
    };
    var messages = {

    };
    var notes = {
        create: function() {
            var title = $('.note_title').val();
            var body = $('.note_desc').val();
            //if(workspace.verify(title, body)){
            ajax('signal=create-note&title=' + title + '&body=' + body, 0);
            alert('Note created');
            cms.popup('create-note', 1);
            //}else{
            //alert('you need a longer title and/or body.');
            //}
        }
    };
    //stuff i have nothing to do with
    var files = {

    };
    var chat = {

    };
    var wall = {

    };
    /*END*/
    /*BEGIN*/
    workspace.tour();
    workspace.init(0, false); //show the start page, prepare everything, but dont retrieve any content
    //if arguments are in the URL (Links from RSS)
    if ($('#params').val() !== '0') {
        var params = $('#params').val();
        //grab key and value from $_GET
        var pair = params.split("=>");
        if (pair.length === 2 && pair[1].length >= 1) { //verify URL integrity
            //key => value pair
            var key = pair[0];
            var value = pair[1];
            //get the element in the URL
            if (key == 'member') workspace.getUser(value);
            else workspace.getOne(key, value);
            //error handling is within above functions
        } else {
            workspace.err();
        }
    } else {
        workspace.retrieve('Start'); //normal launch
    }
});