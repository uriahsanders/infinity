// Persistent form.js
var PersistentForm = PersistentForm || (function() {
	//set instance data
	var PersistentForm = function(id, name, data) {
		console.log("Persistent form created.");
		this.id = id;
		this.name = name;
		this.data = data;
		++PersistentForm.count;
		this.num = PersistentForm.count;
	};
	PersistentForm.count = 0;
	//create form container
	PersistentForm.create = function() { //static
		console.log("Creating PersistentForm container.");
		//lets create the form, but dont display it
		var formHolder = [
			'<div id="ps-formholder">',
			'<br />',
			'<div id="ps-drag"><button type="button" class="close"style="color:red;font-size:3em;">×</button></div><br>',
			'<ul id="ps-tabs"class="nav nav-tabs"></ul>',
			'<div id="ps-content"class="tab-content"></div>',
			'</div>'
		].join('');
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
		});
	};
	//add form to formholder
	PersistentForm.prototype.connect = function() {
		console.log("Connected new form to container.");
		var mark = 'ps-'+this.num;
		var thiz = this;
		var classes = 'tab-pane fade'; //first tab is special
		if(this.num === 1) classes += ' in active';
		$(function(){
			$('#ps-tabs').append('<li><a href="#'+mark+'"data-toggle="tab">'+thiz.name+'</a></li>');
			$('#ps-content').append('<div class="'+classes+'"id="'+mark+'">'+thiz.data+'</div>');
			$('#ps-tabs a:first').tab('show') //Select first tab
			//now save everything in session
			sessionStorage.setItem('ps-form', $('#ps-formholder').html());
		});
	};
	//common enough for func i guess
	PersistentForm.show = function() { //static
		console.log("Showing PersistentForm container.");
		$(function() {
			$('#ps-formholder').fadeIn();
		});
	};
	return PersistentForm;
})();
//test (temp)
PersistentForm.create();
var test = [
	'<br /><div class="lead">Create New Document</div><input type="text"placeholder="Title"class="form-control" /><br />',
	'<textarea name="" id="" cols="30" rows="10"class="form-control"placeholder="Body"></textarea>'
].join('');
var form = new PersistentForm('testps', 'test', test);
form.connect();
var form = new PersistentForm('testps', 'test', 'lorem');
form.connect();
var form = new PersistentForm('testps', 'test', 'lorem');
form.connect();
var form = new PersistentForm('testps', 'test', 'lorem');
form.connect();
PersistentForm.show();