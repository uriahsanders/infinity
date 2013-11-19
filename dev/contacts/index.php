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
	<script src="../modules/tinymvc.js"></script>
	<script src="script.js"></script>
	<link rel="stylesheet" href="contacts.css">
	<script>
		$(document).ready(function(){

		});
	</script>
</head>
<body>
	<div id="toolbar">
		<input type="text"placeholder="Search Groups" /> &emsp; <input type="text" placeholder="Search Contacts"> &emsp; <a id="all"class="link">View All</a>
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
					<span class="member link"><input type="checkbox">Person 1</span>
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
				<span class="name link"id="group1">Group Name</span>
				<span class="group-toolbar"><a class="link">Edit</a> | <a class="link">Delete</a></span>
				<br><br>
				<div class="members">
					<span class="member"id="contact1"><input type="checkbox">Person 1</span>
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