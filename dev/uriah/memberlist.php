<!DOCTYPE html>
<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/member/check_auth.php");
    include_once('memberlist_script.php');
?>
<html>
    <head>
        <title>Memberlist</title>
        <script src="http://code.jquery.com/jquery-latest.min.js"></script>
        <style>
            html, body{
                margin:0;
                padding:0;
                font-family: 'Droid Sans', sans-serif;
                width:100%;
                min-width:1000px;
                height: 100%;
            }
            .selected{
                background: lightblue;
                opacity: 1;
            }
            a{
                cursor: pointer;
                color: grey;
                text-decoration: none;
            }
            a:hover{
                cursor: pointer;
                color: darkgray;
            }
            #IMG{
                border: 1px solid black;
                padding: 10px;
                font-size: 1em;
                margin-bottom: 10px;
            }
            #MAIN{
                padding-left: 5px;
            }
            #MAIN input, select, textarea{
                border-radius: 3px;
                border: 1px solid black;
            }
            #members{
                border: 1px solid black;
                border-radius: 5px;
                border-collapse: collapse;
                margin-top: 10px;
            }
            #members th{
                text-decoration: underline;
            }
            #members tr{
                opacity: .8;
                cursor: pointer;
                -webkit-transition: all linear 0.2s;
                -moz-transition: all linear 0.2s;
                -ms-transition: all linear 0.2s;
                -o-transition: all linear 0.2s;
                transition: all linear 0.2s;
            }
            #members tr td{
                border-bottom: 1px solid black;
            }
            #members tr:hover:not(:first-child){
                background: lightblue;
                opacity: 1;
            }
            #extraInfo{
                float: right;
                border: 1px solid black;
                border-radius: 5px;
                width: 600px;
                margin-right: 30px;
                margin-left: 10px;
                padding: 5px;
                font-size: 2em;
            }
            #filter{
                float: right;
                border: 1px solid black;
                clear: right;
                padding: 5px;
                width: 600px;
                border: 1px solid black;
                border-radius: 5px;
                margin-right: 30px;
                margin-top: 10px;
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function(){
                $('tr:eq(1)').addClass('selected');
                var Memberlist = {
                    scriptFile: 'memberlist_script.php',
                    filtering: {
                        all: true,
                        username: '',
                        location: '',
                        member: null,
                        trusted: null,
                        VIP: null,
                        MOD: null,
                        GMOD: null,
                        admin: null,
                        age: '',
                        male: null,
                        female: null,
                        skills: ''
                    },
                    limiter: 30,
                    get: function(id){
                        //show a profile excerpt of selected person
                        $.ajax({
                            type: 'POST',
                            url: Memberlist.scriptFile,
                            data: {id: id, signal: 'get'},
                            success: function(data){
                                $('#extraInfo').html(data);
                            }
                        });
                    },
                    search: function(){
                        //find a person
                        $.ajax({
                            type: 'POST',
                            url: Memberlist.scriptFile,
                            data: {filtering: JSON.stringify(Memberlist.filtering), signal: 'search'},
                            success: function(data){
                                $('tr[class^=memberRow]:not(first-child)').fadeOut().remove();
                                $('#members').html(data).hide().fadeIn();
                            }
                        });
                    },
                    infiniteScroll: function(){
                        //fadeIn 1 more entry
                        $.ajax({
                            type: 'POST',
                            url: Memberlist.scriptFile,
                            data: {filtering: Memberlist.filtering, limiter: Memberlist.limiter, signal: 'infiniteScroll'},
                            success: function(data){
                                $('#members').append.hide().fadeIn(data);
                                Memberlist.limiter++;
                            }
                        });
                    }
                };
                $(document).on('mousedown', 'tr[class^=memberRow]', function(){
                    $('tr').removeClass('selected');
                    $(this).addClass('selected');
                    Memberlist.get($(this).attr('class').substring(9).split(' ')[0]);
                });
                $(document).on('mousedown', '#find', function(){
                    Memberlist.search();
                });
                //form click handlers
                $(document).on('keyup click', 'input[class^=f_e], textarea[class^=f_e]', function(event){
                    var Class = $(this).attr('class');
                    var tag = $(this).prop('tagName');
                    var type = $(this).attr('type');
                    if(Class != 'f_eall' && (((type === 'text' || tag === 'TEXTAREA') && event.type === 'keyup') || (type === 'checkbox' && event.type === 'click'))){
                        $('.f_eall').prop('checked', false);
                        Memberlist.filtering['all'] = false;
                    }
                    var value = (tag === 'INPUT' && (type === 'checkbox' || type === 'radio')) ? $(this).prop('checked') : $(this).val();
                    var obj = Class.substring(3);
                    Memberlist.filtering[obj] = value;
                });
                Memberlist.get($('tr:eq(1)').attr('class').substring(9).split(' ')[0]);
            });
        </script>
    </head>
    <body>
        <div id="MAIN">
            <h1>Super ugly memberlist</h1>
            <br />
            <div id="extraInfo"></div>
            <div id="filter">
                <strong>Advanced search:</strong><br />
                <input type="checkbox"class="f_eall" checked /> All
                <br />
                <strong>Username:</strong><br />
                <input type="text"class="f_eusername" /><br />
                <strong>Location:</strong><br />
                <input type="text"class="f_elocation" /><br />
                <strong>Rank:</strong><br />
                <input type="checkbox"class="f_emember"> Member <input type="checkbox"class="f_etrusted"> Trusted 
                <input type="checkbox"class="f_eVIP"> VIP <input type="checkbox"class="f_eMOD"> MOD 
                <input type="checkbox"class="f_eGMOD"> GMOD <input type="checkbox"class="f_eadmin"> Admin
                <br />
                <strong>Age:</strong><br />
                <input type="text"class="f_eage" />
                <br />
                <strong>Sex:</strong><br />
                <input type="checkbox"class="f_emale" /> Male <input type="checkbox"class="f_efemale" /> Female
                <br />
                <strong>Skills:</strong><br />
                <textarea id="skills"class="f_eskills"></textarea>
                <br />
                <button id="find">FIND</button>
            </div>
            <table id="members"cellpadding="10">
                <tr>
                    <th>Name</th><th>Rank</th><th>Reputation</th><th>Join Date</th><th>Status</th>
                </tr>
                <?php 
                    $memberlist = new Memberlist();
                    echo $memberlist->main(); 
                ?>
            </table>
        </div>
    </body>
</html>