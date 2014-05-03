<?php
define("INFINITY", true); // this is so the includes can't get directly accessed
define("PAGE", "start"); // this is what page it is, for the links at the top
include_once("libs/relax.php"); // use PATH from now on
include_once(PATH ."core/top.php");
include_once(PATH ."core/slide.php");
include_once(PATH ."core/bar_main_start.php");
?>
        <!-- <br />
            <div class="btn_box" id="boxiz">
            <div id="mnu_left" data="News">
            <ul>
                <?php
                $sql = Database::getInstance(); 
                $res = $sql->query("SELECT * FROM news");
				$result = $res->fetchAll();
                foreach($result as $row){
                    echo "<li id=\"$row[ID]\" ".(($row['ID']==0)?"active":"").">$row[subject].</li>\n";
                    if ($row['ID']==0)
                        $welcome = $row;
                }
                ?>
            </ul>
            </div>
            <div id="mnu_main">
                <?php
                    echo @$welcome['text'];
                ?>
            </div>
            </div><br /><br /> -->
                <span class="lead i">Be productive, creative, and social at the same time.</span>
                <br><br><br><br>
                <a href="#idea"class="feature yellow">
                    <i class="fa fa-lightbulb-o fa-4x"></i><br>
                    Idea
                </a>
                &emsp;&emsp;
                <i class="feature">
                    <i class="fa fa-plus fa-3x math-icon"></i><br>
                </i>
                &emsp;&emsp;
                <a href="#information"class="feature green">
                    <i class="fa fa-globe fa-4x"></i><br>
                    Information
                </a>
                &emsp;&emsp;
                <i class="feature">
                    <i class="fa fa-plus fa-3x math-icon"></i><br>
                </i>
                &emsp;&emsp;
                <a href="#collaboration"class="feature blue">
                    <i class="fa fa-users fa-4x"></i><br>
                    Collaboration
                </a>
                &emsp;&emsp;
                <i class="feature">
                    <i class="fa fa-plus fa-3x math-icon"></i><br>
                </i>
                &emsp;&emsp;
                <a href="#freedom"class="feature red">
                    <i class="fa fa-flag fa-4x"></i><br>
                    Freedom
                </a>&emsp;&emsp;
                <span class="fa-4x math-icon">=</span>&emsp;&emsp;
                <a href="#amazing"class="feature orange">
                    <i class="fa fa-check fa-4x"></i><br>
                    Something Amazing
                </a>
                <br>
                <br>
                <br>
                <br>
                <div id="idea"class="panel panel-default yellow">
                    <div class="panel-heading">
                      <span class="panel-title lead yellow"><i class="fa fa-lightbulb-o fa-lg"></i> Come up with an idea.</span>
                    </div>
                    <div class="panel-body lead yellow">
                      Infinity makes it easy to come up with ideas. <br> Consult the community for advice or check out
                      the Projects page for inspiration. <br> And it doesn't just have to be your own idea that
                      captures your imagination: <br> The Forums are teeming with brilliant discussions
                      and several projects are awaiting more contributors. 
                      <br><br>
                      <!-- <button class="btn">Launch Your Idea</button> -->
                    </div>
                </div>
                <br>
                <div id="information"class="panel panel-default">
                    <div class="panel-heading">
                      <span class="panel-title lead green"><i class="fa fa-globe fa-lg green"></i> Learn more about what you want to do.</span>
                    </div>
                    <div class="panel-body lead">
                      One of the most difficult things about starting a project is that you never seem to know enough. <br>
                      Time to forget your troubles: The Infinity-Forum community boasts a wide variety of people in every field. <br>
                      Use our social tools to get into contact with some potential partners and mentors. <br>
                      And Infinity isn't all just business, either! <br>
                      Take advantage of community activities to make real friends who share your interests.
                      <br><br>
                      <!-- <button class="btn btn-success">Learn Something New</button> -->
                    </div>
                </div>
                <br>
                <div id="collaboration"class="panel panel-default">
                    <div class="panel-heading">
                      <span class="panel-title lead blue"><i class="fa fa-users fa-lg blue"></i> Find people to help you do it.</span>
                    </div>
                    <div class="panel-body lead">
                      Now that you have an idea and the knowledge to pursue it, your going to need some help. <br>
                      Time to start networking and getting your idea out there. <br>
                      Start a project and invite people, public or private. <br>
                      Use the Infinity Workspace to keep track of what needs to get done. <br>
                      And pay attention to rankings and statistics to keep an eye out for interesting people.
                      <br><br>
                      <!-- <button class="btn btn-primary">Find Awesome People</button> -->
                    </div>
                </div>
                <br>
                <div id="freedom"class="panel panel-default">
                    <div class="panel-heading">
                      <span class="panel-title lead"><i class="fa fa-flag fa-lg red"></i> Take advantage of the freedom Infinity-Forum offers.</span>
                    </div>
                    <div class="panel-body lead">
                      Freedom of knowledge and the power to use it is the defining concept here. <br>
                      We actually make it a priority to work with our fellow community members. <br>
                      We provide free plans for groups that require it. <br>
                      We support open source. <br>
                      Infinity-Forum was designed to be a pathway to success, for anyone. <br>
                      The last thing we will do is get in the way.
                      <br><br>
                      <!-- <button class="btn btn-danger">Contribute</button> -->
                    </div>
                </div>
                <br>
                <i id="amazing"class="fa fa-check fa-4x orange"></i>
                <p class="lead">
                    <h2>
                        In just one place, make your dreams come to fruition. <br>
                        What will you create?
                        <br><br>
                      <!-- <button class="btn btn-warning">Get Started</button> -->
                    </h2>
                    <br>
                    <br>
                    <br>
                </p>
            </div>
            <script type="text/javascript">
                var specials = ['#idea', '#information', '#collaboration', '#freedom', '#amazing'];
                $('a[href*=#]').click(function() {
                if($.inArray($(this).attr('href'), specials) !== -1){
                    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                      var target = $(this.hash);
                      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                      if (target.length) {
                        $('html,body').animate({
                          scrollTop: target.offset().top
                        }, 1000);
                        return false;
                      }
                    }
                }
            });
            </script>
<?php
 include_once(PATH ."core/main_end_foot.php");
?>