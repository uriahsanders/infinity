<!doctype html>
<!-- 
	Hai Jeremy, here's whats what:
	The contact list on the side are your main contacts,
	where people go after you add them normally.

	The red X there deletes all selected contacts in the sidebar,
	it deletes them from every group including the main list.

	When you search, listen for the enter event, and replace main
	area with relevant groups. 

	If they search for a contact, give a list of contacts
	that takes you to their contact page on click (more on that later).

	Whenevr you double click a contact, it should also take you to 
	that contacts page. the page should have general information,
	as well as a unique area for you to write information about them,
	this are should have edit/save/etc. Basic stuff

	Contacts should be draggable into any group box.
	Originally, you can drag contacts from main list
	into a group. When you drop it in, it should add to that group,
	but also stay in the last area as well. So just duplicate it.

	When you click edit on a group div it should let you change the
	name and description of the group at that groups page. Same as when you click
	on group name.

	When you click a group name,
	it should take you to that groups page where it only shows that group
	and its members. Should have description and name editing and stuff. like edit
	button.

	When you click delete on a group div, it will delete all selected 
	contacts within that group from only that group (NOT THE MAIN LIST)

	When you click "View All" it should show you the original list
	of groups ordered by date again. So its also technically a back button.

	Dont worry about the add friend button for now.

	When you type a name into add group and press enter, add the group
	and take user to that groups page.

	NO POPUPS, NO SLIDE DOWNS, OOP

	Thats, it, should be easy tbh. The interface is there, now just make it interactive :)
	I will help as much as possible, throughout the entire thing,
	but this really shouldnt take very long at all.
	2 weeks max. If not ill just finish it myself by that time :P
 -->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Contact List</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<style>
		html, body{
			margin:0;
		    padding:0;
		    width:100%;
		    min-width:1000px;
		    height: 100%;
		}
		/*SCROLLBARS*/
		::-webkit-scrollbar              { width:10px; height:10px; background:rgba(27,27,27,1);}
		::-webkit-scrollbar-button       { 
		  background: -webkit-gradient(linear, left top, right top, color-stop(0%, #4d4d4d), color-stop(100%, #333333));
		  border: 1px solid #0d0d0d;
		  height: 10px;
		  width: 10px;
		  border-top: 1px solid #666666;
		  border-left: 1px solid #666666; }
		::-webkit-scrollbar-button:vertical:increment {background: rgb(27,27,27); background:url(/infinity/dev/images/down.png) no-repeat; background-size:6px; background-position:center} 
		::-webkit-scrollbar-button:vertical:increment:active, ::-webkit-scrollbar-button:vertical:increment:hover { background:url(/infinity/dev/images/down2.png) no-repeat; background-size:6px; background-position:center} 
		::-webkit-scrollbar-button:vertical:decrement {background: rgb(27,27,27);background:url(/infinity/dev/images/up.png) no-repeat; background-size:6px; background-position:center} 
		::-webkit-scrollbar-button:vertical:decrement:active, ::-webkit-scrollbar-button:vertical:decrement:hover { background:url(/infinity/dev/images/up2.png) no-repeat; background-size:6px; background-position:center} 
		::-webkit-scrollbar-button:horizontal:increment { background:url(/infinity/dev/images/right.png) no-repeat; background-size:6px; background-position:center} 
		::-webkit-scrollbar-button:horizontal:increment:active, ::-webkit-scrollbar-button:horizontal:increment:hover { background:url(/infinity/dev/images/right2.png) no-repeat; background-size:6px; background-position:center} 
		::-webkit-scrollbar-button:horizontal:decrement { background:url(/infinity/dev/images/left.png) no-repeat; background-size:6px; background-position:center} 
		::-webkit-scrollbar-button:horizontal:decrement:active, ::-webkit-scrollbar-button:horizontal:decrement:hover { background:url(/infinity/dev/images/left2.png) no-repeat; background-size:6px; background-position:center} 

		::-webkit-scrollbar-track        { }
		::-webkit-scrollbar-track-piece  {background:rgba(79,79,79,1);}
		::-webkit-resizer                {  }
		::-webkit-scrollbar-thumb { 
		  background: rgba(27,27,27,1);
		  opacity: 0.5;
		  border: 1px solid #0d0d0d;
		  border-top: 1px solid #666666;
		  border-left: 1px solid #666666;}
		::-webkit-scrollbar-thumb:hover  { background:rgba(27,27,27,.6)}
		::-webkit-scrollbar-corner       {  }
		input{
			border-radius: 3px;
			border: 1px solid #000;
			padding: 5px;
		}
		#toolbar{
			border-bottom: 1px solid black;
			padding: 5px;
			text-align: center;
		}
		#control{
			float: left;
			width: 16%;
			padding: 5px;
			text-align: center;
		}
		.group-toolbar{
			
		}
		.group{
			display: inline-block;
			border: 1px solid black;
			margin: 5px;
			padding: 10px;
			text-align: center;
			width: 25%;
			height: 250px;
			overflow-y: auto;
		}
		.name{
			font-size: 2em;
			display: block;
		}
		.member{
			display: block;
			padding: 5px;
			cursor: pointer;
		}
		.link{
			opacity: .7;
			-webkit-transition: all linear 0.2s;
		    -moz-transition: all linear 0.2s;
		    -ms-transition: all linear 0.2s;
		    -o-transition: all linear 0.2s;
		    transition: all linear 0.2s;
		    cursor: pointer;
		}
		.link:hover{
			opacity: 1;
		}
		#contacts{
			text-align: center;
		}
		.i{
			font-style: italic;
		}
		.b{
			font-weight: bold;
		}
		.opts{
			text-align: left;
		}
	</style>
	<script>
		$(document).ready(function(){

		});
	</script>
</head>
<body>
	<div id="toolbar">
		<input type="text"placeholder="Search Groups" /> &emsp; <input type="text" placeholder="Search Contacts"> &emsp; <a class="link">View All</a>
	</div>
	<div id="control">
		<span class="i">Create Group:</span> <br>
		<input type="text" placeholder="Group Name"> 
		<span class="i">Add Friend:</span> <br>
		<input type="text" placeholder="Find by Name"> 
		<hr>
		<span class="i">Contacts:</span> <a class="link i"style="color: red"title="Delete selected">X</a>
		<div id="contacts">
			<div class="members">
					<span class="member"><input type="checkbox">Person 1</span>
					<span class="member"><input type="checkbox">Person 2</span>
					<span class="member"><input type="checkbox">Person 3</span>
					<span class="member"><input type="checkbox">Person 4</span>
					<span class="member"><input type="checkbox">Person 5</span>
					<span class="member"><input type="checkbox">Person 1</span>
					<span class="member"><input type="checkbox">Person 2</span>
					<span class="member"><input type="checkbox">Person 3</span>
					<span class="member"><input type="checkbox">Person 4</span>
					<span class="member"><input type="checkbox">Person 5</span>
					<span class="member"><input type="checkbox">Person 1</span>
					<span class="member"><input type="checkbox">Person 2</span>
					<span class="member"><input type="checkbox">Person 3</span>
					<span class="member"><input type="checkbox">Person 4</span>
					<span class="member"><input type="checkbox">Person 5</span>
					<span class="member"><input type="checkbox">Person 1</span>
					<span class="member"><input type="checkbox">Person 2</span>
					<span class="member"><input type="checkbox">Person 3</span>
					<span class="member"><input type="checkbox">Person 4</span>
					<span class="member"><input type="checkbox">Person 5</span>
				</div>
			</div>
	</div>
	<div id="main">
		<div class="group">
				<span class="name">Group Name</span>
				<span class="group-toolbar"><a class="link">Edit</a> | <a class="link">Delete</a></span>
				<br><br>
				<div class="members">
					<span class="member"><input type="checkbox">Person 1</span>
					<span class="member"><input type="checkbox">Person 2</span>
					<span class="member"><input type="checkbox">Person 3</span>
					<span class="member"><input type="checkbox">Person 4</span>
					<span class="member"><input type="checkbox">Person 5</span>
				</div>
		</div><div class="group">
				<span class="name">Group Name</span>
				<span class="group-toolbar"><a class="link">Edit</a> | <a class="link">Delete</a></span>
				<br><br>
				<div class="members">
					<span class="member"><input type="checkbox">Person 1</span>
					<span class="member"><input type="checkbox">Person 2</span>
					<span class="member"><input type="checkbox">Person 3</span>
					<span class="member"><input type="checkbox">Person 4</span>
					<span class="member"><input type="checkbox">Person 5</span>
				</div>
		</div>
		<div class="group">
				<span class="name">Group Name</span>
				<span class="group-toolbar"><a class="link">Edit</a> | <a class="link">Delete</a></span>
				<br><br>
				<div class="members">
					<span class="member"><input type="checkbox">Person 1</span>
					<span class="member"><input type="checkbox">Person 2</span>
					<span class="member"><input type="checkbox">Person 3</span>
					<span class="member"><input type="checkbox">Person 4</span>
					<span class="member"><input type="checkbox">Person 5</span>
				</div>
		</div>
		<div class="group">
				<span class="name">Group Name</span>
				<span class="group-toolbar"><a class="link">Edit</a> | <a class="link">Delete</a></span>
				<br><br>
				<div class="members">
					<span class="member"><input type="checkbox">Person 1</span>
					<span class="member"><input type="checkbox">Person 2</span>
					<span class="member"><input type="checkbox">Person 3</span>
					<span class="member"><input type="checkbox">Person 4</span>
					<span class="member"><input type="checkbox">Person 5</span>
				</div>
		</div>
		<div class="group">
				<span class="name">Group Name</span>
				<span class="group-toolbar"><a class="link">Edit</a> | <a class="link">Delete</a></span>
				<br><br>
				<div class="members">
					<span class="member"><input type="checkbox">Person 1</span>
					<span class="member"><input type="checkbox">Person 2</span>
					<span class="member"><input type="checkbox">Person 3</span>
					<span class="member"><input type="checkbox">Person 4</span>
					<span class="member"><input type="checkbox">Person 5</span>
				</div>
		</div>
		<div class="group">
				<span class="name">Group Name</span>
				<span class="group-toolbar"><a class="link">Edit</a> | <a class="link">Delete</a></span>
				<br><br>
				<div class="members">
					<span class="member"><input type="checkbox">Person 1</span>
					<span class="member"><input type="checkbox">Person 2</span>
					<span class="member"><input type="checkbox">Person 3</span>
					<span class="member"><input type="checkbox">Person 4</span>
					<span class="member"><input type="checkbox">Person 5</span>
				</div>
		</div>
		<div class="group">
				<span class="name">Group Name</span>
				<span class="group-toolbar"><a class="link">Edit</a> | <a class="link">Delete</a></span>
				<br><br>
				<div class="members">
					<span class="member"><input type="checkbox">Person 1</span>
					<span class="member"><input type="checkbox">Person 2</span>
					<span class="member"><input type="checkbox">Person 3</span>
					<span class="member"><input type="checkbox">Person 4</span>
					<span class="member"><input type="checkbox">Person 5</span>
				</div>
		</div>
		<div class="group">
				<span class="name">Group Name</span>
				<span class="group-toolbar"><a class="link">Edit</a> | <a class="link">Delete</a></span>
				<br><br>
				<div class="members">
					<span class="member"><input type="checkbox">Person 1</span>
					<span class="member"><input type="checkbox">Person 2</span>
					<span class="member"><input type="checkbox">Person 3</span>
					<span class="member"><input type="checkbox">Person 4</span>
					<span class="member"><input type="checkbox">Person 5</span>
				</div>
		</div>
		<div class="group">
				<span class="name">Group Name</span>
				<span class="group-toolbar"><a class="link">Edit</a> | <a class="link">Delete</a></span>
				<br><br>
				<div class="members">
					<span class="member"><input type="checkbox">Person 1</span>
					<span class="member"><input type="checkbox">Person 2</span>
					<span class="member"><input type="checkbox">Person 3</span>
					<span class="member"><input type="checkbox">Person 4</span>
					<span class="member"><input type="checkbox">Person 5</span>
				</div>
		</div>
	</div>
</body>
</html>