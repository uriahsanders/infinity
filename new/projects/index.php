<?php 
    define("INFINITY", true); // this is so the includes can't get directly accessed
    define("PAGE", "projects"); // this is what page it is, for the links at the top
    include_once("../libs/relax.php"); // use PATH from now on
	
    Login::checkAuth();
	
    include_once(PATH ."core/top.php");
    if(defined("PAGE") && PAGE == "start") 
    {
        include_once(PATH ."core/slide.php");
    }
    include_once(PATH ."core/bar_main_start.php");
    $_SESSION['token'] = base64_encode(time() . sha1( $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] ) .uniqid(rand(), TRUE));
?>
<br>
    <div class="nav"style="margin:auto;width:100%;margin-left:1%">
      <button id="new-project"class="btn btn-success">New Project</button>&nbsp;
      <button class="btn btn-success">Technology</button>&nbsp;
      <button class="btn btn-success">All</button>
      <br><br>
      <input placeholder="Search..."/>
    </div>
    <br>
    <form style="display:none;"id="project-form">
      <select name="category">
        <option>Technology<option>
      </select>
      <br><br>
      <input name="projectName"placeholder="projectname"/>
      <br><br>
      <textarea name="short"></textarea>
      <br><br>
      <textarea name="description"></textarea>
      <br><br>
      <input type="hidden"name="video"value="temporary"/>
      <input type="hidden"name="image"value="temporary"/>
      <input id="token"type="hidden"value=<?php echo '"'.$_SESSION['token'].'"'; ?>/>
      <button>Create</button>
    </form>
    <div id="meat">
      <br>
      <!--  -->
      <a>
        <div class="project">
          <div class="lead project-title">Project Title</div>
          <div class="project-img">
            <br>
            <i class="fa fa-star gold"style="font-size:9em"></i>
          </div>
          <div class="project-info">
            By Uriah Sanders <br>
            Hello everyone! This is my first project. I want to thank everyone for supporting me in this
            and i think it will be very successful. Did i mention that this is a small project description to get ou curious about whats its about? So go on! Click me! CLICK ME!!!
            <br><br>
          <div class="progress">
            <div class="progress-bar progress-bar-success black" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">
              <span>44,300 Popularity</span>
            </div>
          </div>
          </div>
        </div>
      </a>
      <!--  -->
      <!--  -->
      <a>
        <div class="project">
          <div class="lead project-title">Project Title</div>
          <div class="project-img">
            <br>
            <i class="fa fa-star gold"style="font-size:9em"></i>
          </div>
          <div class="project-info">
            By Uriah Sanders <br>
            Hello everyone! This is my first project. I want to thank everyone for supporting me in this
            and i think it will be very successful. Did i mention that this is a small project description to get ou curious about whats its about? So go on! Click me! CLICK ME!!!
            <br><br>
          <div class="progress">
            <div class="progress-bar progress-bar-success black" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">
              <span>44,300 Popularity</span>
            </div>
          </div>
          </div>
        </div>
      </a>
      <!--  -->
      <!--  -->
      <a>
        <div class="project">
          <div class="lead project-title">Project Title</div>
          <div class="project-img">
            <br>
            <i class="fa fa-star gold"style="font-size:9em"></i>
          </div>
          <div class="project-info">
            By Uriah Sanders <br>
            Hello everyone! This is my first project. I want to thank everyone for supporting me in this
            and i think it will be very successful. Did i mention that this is a small project description to get ou curious about whats its about? So go on! Click me! CLICK ME!!!
            <br><br>
          <div class="progress">
            <div class="progress-bar progress-bar-success black" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">
              <span>44,300 Popularity</span>
            </div>
          </div>
          </div>
        </div>
      </a>
      <!--  -->
      <!--  -->
      <a>
        <div class="project">
          <div class="lead project-title">Project Title</div>
          <div class="project-img">
            <br>
            <i class="fa fa-star gold"style="font-size:9em"></i>
          </div>
          <div class="project-info">
            By Uriah Sanders <br>
            Hello everyone! This is my first project. I want to thank everyone for supporting me in this
            and i think it will be very successful. Did i mention that this is a small project description to get ou curious about whats its about? So go on! Click me! CLICK ME!!!
            <br><br>
          <div class="progress">
            <div class="progress-bar progress-bar-success black" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">
              <span>44,300 Popularity</span>
            </div>
          </div>
          </div>
        </div>
      </a>
      <!--  -->
      <!--  -->
      <a>
        <div class="project">
          <div class="lead project-title">Project Title</div>
          <div class="project-img">
            <br>
            <i class="fa fa-star gold"style="font-size:9em"></i>
          </div>
          <div class="project-info">
            By Uriah Sanders <br>
            Hello everyone! This is my first project. I want to thank everyone for supporting me in this
            and i think it will be very successful. Did i mention that this is a small project description to get ou curious about whats its about? So go on! Click me! CLICK ME!!!
            <br><br>
          <div class="progress">
            <div class="progress-bar progress-bar-success black" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">
              <span>44,300 Popularity</span>
            </div>
          </div>
          </div>
        </div>
      </a>
      <!--  -->
      <!--  -->
      <a>
        <div class="project">
          <div class="lead project-title">Project Title</div>
          <div class="project-img">
            <br>
            <i class="fa fa-star gold"style="font-size:9em"></i>
          </div>
          <div class="project-info">
            By Uriah Sanders <br>
            Hello everyone! This is my first project. I want to thank everyone for supporting me in this
            and i think it will be very successful. Did i mention that this is a small project description to get ou curious about whats its about? So go on! Click me! CLICK ME!!!
            <br><br>
          <div class="progress">
            <div class="progress-bar progress-bar-success black" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">
              <span>44,300 Popularity</span>
            </div>
          </div>
          </div>
        </div>
      </a>
      <!--  -->
      <!--  -->
      <a>
        <div class="project">
          <div class="lead project-title">Project Title</div>
          <div class="project-img">
            <br>
            <i class="fa fa-star gold"style="font-size:9em"></i>
          </div>
          <div class="project-info">
            By Uriah Sanders <br>
            Hello everyone! This is my first project. I want to thank everyone for supporting me in this
            and i think it will be very successful. Did i mention that this is a small project description to get ou curious about whats its about? So go on! Click me! CLICK ME!!!
            <br><br>
          <div class="progress">
            <div class="progress-bar progress-bar-success black" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">
              <span>44,300 Popularity</span>
            </div>
          </div>
          </div>
        </div>
      </a>
      <!--  -->
      <!--  -->
      <a>
        <div class="project">
          <div class="lead project-title">Project Title</div>
          <div class="project-img">
            <br>
            <i class="fa fa-star gold"style="font-size:9em"></i>
          </div>
          <div class="project-info">
            By Uriah Sanders <br>
            Hello everyone! This is my first project. I want to thank everyone for supporting me in this
            and i think it will be very successful. Did i mention that this is a small project description to get ou curious about whats its about? So go on! Click me! CLICK ME!!!
            <br><br>
          <div class="progress">
            <div class="progress-bar progress-bar-success black" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">
              <span>44,300 Popularity</span>
            </div>
          </div>
          </div>
        </div>
      </a>
      <!--  -->
      <!--  -->
      <a>
        <div class="project">
          <div class="lead project-title">Project Title</div>
          <div class="project-img">
            <br>
            <i class="fa fa-star gold"style="font-size:9em"></i>
          </div>
          <div class="project-info">
            By Uriah Sanders <br>
            Hello everyone! This is my first project. I want to thank everyone for supporting me in this
            and i think it will be very successful. Did i mention that this is a small project description to get ou curious about whats its about? So go on! Click me! CLICK ME!!!
            <br><br>
          <div class="progress">
            <div class="progress-bar progress-bar-success black" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">
              <span>44,300 Popularity</span>
            </div>
          </div>
          </div>
        </div>
      </a>
      <!--  -->
      <!--  -->
      <a>
        <div class="project">
          <div class="lead project-title">Project Title</div>
          <div class="project-img">
            <br>
            <i class="fa fa-star gold"style="font-size:9em"></i>
          </div>
          <div class="project-info">
            By Uriah Sanders <br>
            Hello everyone! This is my first project. I want to thank everyone for supporting me in this
            and i think it will be very successful. Did i mention that this is a small project description to get ou curious about whats its about? So go on! Click me! CLICK ME!!!
            <br><br>
          <div class="progress">
            <div class="progress-bar progress-bar-success black" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">
              <span>44,300 Popularity</span>
            </div>
          </div>
          </div>
        </div>
      </a>
      <!--  -->
      <!--  -->
      <a>
        <div class="project">
          <div class="lead project-title">Project Title</div>
          <div class="project-img">
            <br>
            <i class="fa fa-star gold"style="font-size:9em"></i>
          </div>
          <div class="project-info">
            By Uriah Sanders <br>
            Hello everyone! This is my first project. I want to thank everyone for supporting me in this
            and i think it will be very successful. Did i mention that this is a small project description to get ou curious about whats its about? So go on! Click me! CLICK ME!!!
            <br><br>
          <div class="progress">
            <div class="progress-bar progress-bar-success black" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">
              <span>44,300 Popularity</span>
            </div>
          </div>
          </div>
        </div>
      </a>
      <!--  -->
    </div>
    <script type="text/javascript"src="/js/tinymvc.js"></script>
    <script type="text/javascript"src="script.js"></script>