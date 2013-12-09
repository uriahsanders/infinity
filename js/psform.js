// Persistent form.js
var PersistentForm = PersistentForm || (function() {
	sessionStorage.psCount = sessionStorage.psCount || 0;
	//set instance data
	var PersistentForm = function(name, data) {
		console.log("Persistent form created.");
		this.name = name;
		this.data = data;
		++sessionStorage.psCount;
		this.num = sessionStorage.psCount;
		console.log("Connecting new form to container.");
		var mark = 'ps-' + this.num;
		var thiz = this;
		var classes = 'tab-pane fade'; //first tab is special
		if (this.num === 1) classes += ' in active';
		$(function() {
			$('#ps-tabs').append('<li><a href="#' + mark + '"data-toggle="tab">' + name + '</a></li>');
			$('#ps-content').append('<div class="' + classes + '"id="' + mark + '">' + data + '</div>');
			$('#ps-tabs a:first').tab('show') //Select first tab
			//now save everything in session
			sessionStorage.psForm = $('#ps-formholder').html();
		});
	};
	//create form container
	PersistentForm.create = function() { //static
		console.log("Creating PersistentForm container.");
		var psForm = sessionStorage.psForm || false;
		if (!psForm) {
			//lets create the form, but dont display it
			var formHolder = [
				'<div id="ps-formholder">',
				'<br />',
				'<div id="ps-drag"><button id="ps-close"type="button" class="close"style="color:red;font-size:3em;">×</button></div><br>',
				'<div id="ps-main">',
				'<ul id="ps-tabs"class="nav nav-tabs"></ul>',
				'<div id="ps-content"class="tab-content"></div>',
				'</div>',
				'</div>'
			].join('');
		} else {
			$(document.body).prepend('<div id="ps-formholder">' + psForm + '</div>');
			$('#ps-tabs a:first').tab('show') //Select first tab
		}
		//click handling
		$(function() {
			$(document.body).prepend(formHolder);
			//top resizable: thanks to Martijn Hols for intial help
			//http://stackoverflow.com/a/14002818/2822051
			$('#ps-drag').on('mousedown', function(e) {
				//make text nonselectable to prevent annoyances
				$(document.body).attr('unselectable', 'on').css('user-select', 'none').on('selectstart', false);
				var dragger = $(this).parent(),
					startHeight = dragger.height(),
					py = e.pageY;
				$(document).on('mouseup', function(e) {
					$(document).off('mouseup').off('mousemove');
					//do something here to enable selection again :P
					//...
				});
				$(document).on('mousemove', function(me) {
					var my = (me.pageY - py);
					dragger.css({
						height: startHeight - my
					});
				});
			});
			//close the formholder
			$(document).on('click', '#ps-close', function() {
				$('#ps-formholder').fadeOut();
			});
		});
	};
	//common enough for func i guess
	PersistentForm.toggle = function() { //static
		console.log("Showing PersistentForm container.");
		$(function() {
			$('#ps-formholder').toggle();
		});
	};
	return PersistentForm;
})();
//example:
// PersistentForm.create(); //create form holder
// var form = new PersistentForm('Workspace Document', 'my html content'); //add a new tab, (title, content)
// var form = new PersistentForm('Something', 'my html content');
// var form = new PersistentForm('Another', 'my html content');
// PersistentForm.toggle(); //show the formholder