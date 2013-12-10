// Persistent form.js
var PersistentForm = PersistentForm || (function() {
	sessionStorage.psCount = sessionStorage.psCount || 0;
	//set instance data
	var PersistentForm = function(name, data) {
		this.name = name;
		this.data = data;
		++sessionStorage.psCount;
		this.num = sessionStorage.psCount;
		var mark = 'ps-' + this.num;
		this.id = mark;
		var thiz = this;
		var classes = 'tab-pane fade'; //first tab is special
		if (this.num === 1) classes += ' in active';
		$('#ps-tabs').append('<li><a href="#' + mark + '"data-toggle="tab">' + name + '&nbsp;<button id="ps-close-' + mark + '"class="close fa fa-lg">×</button></a></li>');
		$('#ps-content').append('<div class="' + classes + '"id="' + mark + '">' + data + '</div>');
		$('#ps-tabs a:first').tab('show') //Select first tab
		//now save everything in session
		sessionStorage.psForm = $('#ps-formholder').html();
	};
	//create form container
	PersistentForm.create = function() { //static
		var thiz = this;
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
			$(document.body).prepend(formHolder);
		} else {
			$(document.body).prepend('<div id="ps-formholder">' + psForm + '</div>');
		}
		//click handling
		//top resizable
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
				dragger.css('height', startHeight - (me.pageY - py));
			});
		});
		//button for opening form
		$(document).on('click', '#psform-btn', function() {
			PersistentForm.toggle();
		});
		//close the formholder
		$(document).on('click', '#ps-close', function() {
			thiz.toggle();
		});
		//close the tab and its content
		$(document).on('click', '[id^="ps-close-ps-"]', function() {
			var id = $(this).attr('id').substring(9);
			$('a[href="#' + id + '"]').parent().fadeOut();
			$('#' + id).fadeOut();
		});
	};
	//handle visibility
	PersistentForm.toggle = function() { //static
		$('#ps-formholder').toggle(0, function() {
			if ($(this).is(':visible')) sessionStorage.psVisible = true;
			else sessionStorage.psVisible = false;
		});
	};
	//manually remove form
	PersistentForm.prototype.remove = function() {
		$('a[href="#' + this.id + '"]').parent().fadeOut();
		$('#' + this.id).fadeOut();
	};
	//manually select form
	PersistentForm.prototype.select = function() {
		$('#ps-tabs a[href="#' + this.id + '"]').tab('show') //Select first tab
	};
	return PersistentForm;
})();
$(function() {
	//DO NOT REMOVE ////////////////////////////////////////////////////
	PersistentForm.create(); //create form holder
	//make sure form stays visible or not on load
	if (sessionStorage.psVisible === 'true') PersistentForm.toggle();
	////////////////////////////////////////////////////////////////////
	//example:
	if (!sessionStorage.psForm) {
		var form1 = new PersistentForm('Workspace Document', 'workspace form content'); //add a new tab, (title, content)
		var form2 = new PersistentForm('Something', 'my html content');
		var form3 = new PersistentForm('Another', 'some other html content');
		// form2.select(); //works
		// form3.remove(); //works
		//PersistentForm.toggle(); //show the formholder
	}
});