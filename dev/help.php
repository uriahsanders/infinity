<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/top.php'); //DO NOT REMOVE OR CHANGE 
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/links.php'); // DO NOT REMOVE OR CHANGE

listlinks("Help"); // CHANGE TO THE ACTIVE LINK

include_once($_SERVER['DOCUMENT_ROOT'].'/libs/middle.php'); //DO NOT REMOVE OR CHANGE
// UNDER HERE THE DIV content
// REMEMBER DIV ID=MAIN
// REMEMBER DIV ID=NEWS or LINKS
?>
<div id="main" style="width:80%">

      <div id="hforums" class="txtlink">
             <div id="head">Forums</div><hr>
      <p>
          <div id="Q">Description:</div>
      The forum is the hot spot of user activity and interaction. Here, users may post in a huge variety of topics
      covering every specialty and field and how they can work together. The forum is a ground where users can truly
      interact in the community, share what they have learned and are learning, and find ways to innovate with 
      eachother. In the forum, many new ideas and friendships are born. We encourage you to join the forum, if you are
          looking for an amazing way to cummunicate with those who share the same interests as you.<br />
          A final bonus to the forum is that it provides a way for clients and project creators to get to know the
          skills and personalities of the people they work for, or with. Many other project management and freelancing
          website are missing this crucial feature of social interaction. Finally, if you are looking for a position
          as an infinity-forum staff member, contributing to the forums is a great way to get the job. Adittionally,
          through the forum you can huild a reputation for yourself, increasing your chances of getting into projects
          and even having us provide you with the funding you need.
          <div id="Q">How to use it:</div>
      
      </p>
      
        </div>
             
        <div id="hprojects" class="txtlink">
        <div id="head">Projects Page</div><hr>
        <p>
        <div id="Q">Description:</div>
        The projects page is very similar to the forum, except it focuses on user submitions of projects. Here, you
        may comment, join, and team up with other projects, businesses, or teams that are being formed. One thing that
        makes the projects page stand out is the fact that staff and VIP members also provide invaluable input and help
        in this section. Also, if we find a project to be especcially interesting or innovative, we appropriate funds
        to make it successful. That is a large difference between us and other websites, we care about our members,
            and actively strive to help them suceed.<br />
            Finally, the projects page includes "Freelancing". Here, you may also search and post, but these jobs are 
            quite a bit different from those found in the projects section. If you need help understanding the
            difference between projects and freelancing, please stop by the FAQ, or view the answer to this question
            provided in the neccesary parts of the projects page.
        <div id="Q">How to use it:</div>
        </p>

        
        </div>
        <div id="hchallenges" class="txtlink">
                <div id="head">Challenges</div><hr>
         <p>
         <div id="Q">Description:</div>
         To join or submit a community challenge, head over to the forum. If you would like to join a
         challenge hosted by Infinity-forum, take a look at "challenges", in the "Infinity" link.
         Here, you can view and participate in the challenges we make for amazing rewards and experiences.
         The information concerning how you join each project is always different, so take a look
         to find out! 
         Often times the challenges will be a product of staff creativity, but sometimes we organize a team
         to take on challenges from other places. Also, due to the nature of certain challenges, some
         require a certain rank to join.
        <div id="Q">How to use it:</div>
        </p>
                

        </div>
        <div id="hworkspace" class="txtlink">
                <div id="head">Workspace</div><hr>
           <p>
           <div id="Q">Description:</div>
           The workspace is where you can create and manage your projects. It provides a wide variety of tools
           and apps that allow ou to work more efficiently. Most importantly, in the workspace you may manage
               and communicate with other members of your team.<br />
               Also, in the workspace you may also manage your freelancing, and have the option to instantly
               switch interfaces from client to employee. While many of the tools here are similar to those used
               for projects, the are specially optimized for your purpose.
           <div id="Q">How to use it:</div>
           </p>
                

        </div>
    <div id="hmembers" class="txtlink">
        <div id="head">Lounge</div><hr />
        <p>
        <div id="Q">Description:</div>
        The Lounge is the heart of Infinity-forum. Also known as the members page, this is a place for members
        to hang out, communicating through live chat. It also serves as a quicklaunch of the entire website, 
        meaning that you can access everything from that one page. Finally, the lounge contains many features
        to enhance your experience, as here you may bookmark forum topics, challenges, and projects that capture
            your interest. You may also see which members are online, add friends, and join private chats.<br />
            We have worked hard to ensure our users have a pleasurable experience while performing their important
            tasks. We hope that you enjoy the culmination of these works in the Lounge.
        <div id="Q">How to use it:</div>
        </p>
    
    </div>
        
        </div>
       
        
        <div id="links">

            <div id="linksitem">
            <div id="linkssub">What is.........?</div>
                <div class="linkstxt">
                <a href="javascript:links('hmembers')">Lounge</a><br />
                <a href="javascript:links('hforums')">Forums</a><br />
                <a href="javascript:links('hprojects')">Projects</a><br />
                <a href="javascript:links('hchallenges')">Challenges</a><br />
                <a href="javascript:links('hworkspace')">Workspace</a><br />
                
            </div>
                
            </div>
            
            
            
            
        </div>
  
  <?php
include_once('libs/bottom.php'); // DO NOT REMOVE 