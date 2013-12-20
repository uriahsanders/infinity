<?php
	include_once("server/templates/top.php"); //top bar
?>
<br><br>
<!-- Body/content of page -->
<br>
<?php
	//include_once("server/soon.php"); //modals, footer, and libs
?>
<div style="width:80%;margin:auto;padding:10px;border-radius:5px;"class="text-center">
	<div class="lead i fa-2x"style="margin:auto">Profile Options</div><br>
	<div style="border:2px solid #000;width:75%;margin:auto;background:url('images/gray_sand.png');padding:20px;height:100%;border-radius:5px;">
		<input type="text"class="form-control"style="display:inline;width:80%"placeholder="Current Password...">
		<br><br>
		<div class="lead">Account</div>
		<input type="text"class="form-control"style="display:inline;width:80%"placeholder="Username..."><br><br>
		<input type="text"class="form-control"style="display:inline;width:80%"placeholder="Password..."><br><br>
		<input type="text"class="form-control"style="display:inline;width:80%"placeholder="Verify Password..."><br><br>
		<input type="text"class="form-control"style="display:inline;width:80%"placeholder="Email..."><br><br>
		<div class="lead">Profile</div>
		Choose Avatar: <input type="file"class="form-control"style="display:inline;width:66%">
		<br><br>
		<input type="text"class="form-control"style="display:inline;width:80%"placeholder="Birth Date..."><br><br>
		<input type="text"class="form-control"style="display:inline;width:80%"placeholder="Location..."><br><br>
		Who can send me personal messages: <select class="form-control"style="display:inline;width:45%"name="" id="">
			<option value="">All members not on my ignore list</option>
			<option value="">All members</option>
			<option value="">Only friends</option>
			<option value="">Noone except for Infinity Staff</option>
		</select>
		<br><br>
		<textarea style="display:inline;width:80%"name="" id="" cols="30" rows="10"class="form-control"placeholder="About Me..."></textarea>
		<br><br>
		<input type="text"class="form-control"style="display:inline;width:67%"placeholder="New Skill">&emsp;<button class="btn btn-info">Add Skill</button><br><br>
		<textarea style="display:inline;width:80%"name="" id="" cols="30" rows="5"class="form-control"placeholder="Skills..."disabled></textarea>
		<br><br>
		Gender:&emsp;<input type="radio"> Male&emsp;<input type="radio"> Female&emsp;<input type="radio"> Other&emsp;<input type="radio"> Undisclosed
		<br><br>
		<input type="checkbox"> Allow Infinity to send me emails.
		<br><br>
		<div class="btn-group">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					Dark Theme <span class="caret"></span>
				</button>
				<ul class="dropdown-menu primary-menu" role="menu">
					<li><a href="#">Dark Theme</a></li>
					<li><a href="#">Light Theme</a></li>
				</ul>
			</div>&emsp;<button style="display:inline"class="btn btn-primary">Change</button>
			<br><br>
	</div><br>
		<button class="btn btn-success">Change</button>
		<br><br>
</div>
<br>
<br>
<br>
<?php
	include_once("server/templates/bottom.php"); //modals, footer, and libs
?>
<!-- Link in JS scripts here -->
<?php
	include_once("server/templates/end.php"); //end tags
?>