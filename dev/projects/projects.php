<?php
include_once('../libs/top.php'); //DO NOT REMOVE OR CHANGE 
include_once('../libs/links.php'); // DO NOT REMOVE OR CHANGE

listlinks("Projects"); // CHANGE TO THE ACTIVE LINK

include_once('../libs/middle.php'); //DO NOT REMOVE OR CHANGE
// UNDER HERE THE DIV content
// REMEMBER DIV ID=MAIN
// REMEMBER DIV ID=NEWS or LINKS
?>
<div id="main" style="width:80%">

        <div id="myworkspace" class="txtlink">
        <div id="head"><center>My Workspace</center></div>
            <hr>
            <?php
include_once('nav.php');
?>
        <center><p style="font-size:1em">
        Welcome to your workspace! Here you can Create new Projects and jobs. You can also manage your project teams, communicate with team members, 
        and implement various applications to better manage your projects. 
        You can also manage the financial aspects of your 
        projects here, as well as layout your plans for your ideas.
        More information is available in each designated section, with extremely detailed assistance
        provided in the "Help" page.
        The tools provided in this area will help you to create a create a more successful project,
        with less stress on yourself.
        </p></center>
            
                </div>
                
        
             
        <div id="community" class="txtlink">
        <div id="head">Projects</div><hr>
        <p>
          <div id="Qs" style="cursor:pointer;"><a>Q: What is the difference between projects and freelancing?</a></div>
            <div id="As">A: By definition, you could say there is little difference, but at infinity-forum we divide the two. In projects, you reveal the full scope of your plan, can ask for donations, and can provide other incentives for help than money. You can not require work by the hour in a project. In freelancing, you only pay with money, you can pay by the hour or once the work is completed, you cannot request donations to help with your task, and you are not expected to reveal much of the purpose behind the work you are asking. In general, freelancing is better for companies, while projects are better for the average user.
            </div><hr>
            
            
        </p>

        
        </div>
        <div id="freelancing" class="txtlink">
        <div id="head">Freelancing</div><hr>
        <p>
            <div id="Qb" style="cursor:pointer;"><a>Q: What is the difference between projects and freelancing?</a></div>
            <div id="Ab">A: By definition, you could say there is little difference, but at infinity-forum we divide the two. In projects, you reveal the full scope of your plan, can ask for donations, and can provide other incentives for help than money. You can not require work by the hour in a project. In freelancing, you only pay with money, you can pay by the hour or once the work is completed, you cannot request donations to help with your task, and you are not expected to reveal much of the purpose behind the work you are asking. In general, freelancing is better for companies, while projects are better for the average user.
            </div><hr>
        </p>

        
        </div>
        
        
        </div>
        
        <div id="links">

            <div id="linksitem">
            <div id="linkssub">Links</div>
                <div class="linkstxt">
                <a href="javascript:links('myworkspace')">My Workspace</a><br />
                <a href="javascript:links('community')">Projects</a><br />
                <a href="javascript:links('freelancing')">Freelancing</a><br />
                
            </div>
                
            </div>
            
            
            
            
        </div>
  
  <?php
include_once('../libs/bottom.php'); // DO NOT REMOVE 