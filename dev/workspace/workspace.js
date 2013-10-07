//Infinity-forum.org: 2013
//ELEMENTS
var Element = (function() {
	"use strict";
	var Element = function(type, name, creator) {
		console.log('New element created:');
		//we want to be able to edit this's from both Element and sub-class
		this.name = name;
		this.creator = creator;
		//the number of this type of element so far (index)
		this.num = Model['num_' + type + 's'];
		//create an object for this new element using its num as a unique key
		Model[type + 's'][type + this.num] = {
			name: name,
			creator: creator,
			num: this.num
		};
	};
	return Element;
})();
var Document = (function() { //extends Element
	"use strict";
	var Document = function(name, creator) {
		++Model.num_documents;
		Element.call(this, 'document', name, creator);
		console.log("This element is a Document named " + this.name + ", created by " + this.creator);
	};
	Document.prototype = Object.create(Element.prototype);
	Document.prototype.constructor = Document;
	return Document;
})();
var Task = (function() {
	"use strict";
	var Task = function(name, creator) {
		++Model.num_tasks;
		Element.call(this, 'task', name, creator);
		console.log("This element is a Task named " + this.name + ", created by " + this.creator);
	};
	Task.prototype = Object.create(Element.prototype);
	Task.prototype.constructor = Task;
	return Task;
})();
var Table = (function() {
	"use strict";
	var Table = function(name, creator) {
		++Model.num_tables;
		Element.call(this, 'table', name, creator);
		console.log("This element is a Table named " + this.name + ", created by " + this.creator);
	};
	Table.prototype = Object.create(Element.prototype);
	Table.prototype.constructor = Table;
	return Table;
})();
var Note = (function() {
	"use strict";
	var Note = function(name, creator) {
		++Model.num_notes;
		Element.call(this, 'note', name, creator);
		console.log("This element is a Note named " + this.name + ", created by " + this.creator);
	};
	Note.prototype = Object.create(Element.prototype);
	Note.prototype.constructor = Note;
	return Note;
})();
var Event = (function() {
	"use strict";
	var Event = function(name, creator) {
		++Model.num_events;
		Element.call(this, 'event', name, creator);
		console.log("This element is a Event named " + this.name + ", created by " + this.creator);
	};
	Event.prototype = Object.create(Element.prototype);
	Event.prototype.constructor = Event;
	return Event;
})();
//END
//URL HANDLING (PUSHSTATE)
var Router = (function() {
	"use strict";
	var Public = {}, Private = {};
	Public.goTo = function(param, second) {
		//history.pushState('', '', param);
	};
	Public.isURLDefault = function() {
		var paths = location.href.split('/');
		if (paths[paths.length - 2] === 'workspace') return true;
		return false
	};
	Public.implement = function(path){ //do ajax depending on URL
		//do a lot of annyoing parsing to modify Model data depnding on URL
	};
	return Public;
})();
//END
//FUNCTIONS
var Workspace = (function($, _, T) {
	"use strict";
	//define functions for use in View
	var Public = {}, Private = {};
	Private.ajax = function(query, after, obj) { //data to send; what to do after; special args;
		//standard function for server communication
		after = after || 2;
		$.ajax({
			url: Model.scriptFile,
			async: obj.async || true,
			cache: obj.cache || false,
			type: 'POST',
			datatype: obj.datatype || '',
			data: query,
			success: function(data) {
				switch (after) {
					//if int do a standard function, else call after()
					case 0: //reload page
						location.reload(obj.reload || false);
						break;
					case 1: //refresh page (ajax)
						Model.modify('page', Model.page);
						break;
					case 2:
						//do nothing
						break;
					default: //call given function with data
						after(data);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.err.log("AJAX error: " + thrownError);
				console.err.log("More information on error: Query: " + query + "; After: " + after);
			}
		});
	};
	//get initial view
	Public.init = function() {
		if (Router.isURLDefault()) { // URL is standard
			console.log('The workspace has been initiated.');
			console.log("Initial functions starting...");
			$('#tiny-page-' + Model['page'].lcfirst()).css('display', 'none'); //fade out "Stream" link
			Router.goTo(Model['page']);
			console.log("Finished.");
		} else { //URL has special path
			var paths;
			console.log("This workspace has been linked to. URL:" + location);
			paths = location.split('/workspace/'); //everything after this is the path
			Router.implement(paths[1]); //do ajax functions for this URL
		}
	};
	//let's add an object to Public for each major feature
	Public.gen = { //EX:
		welcome: function() {

		},
		changePage: function() {
			$('#page-title').text(Model['page'].ucfirst()); //change title
			$('span[id^="tiny-page-"]').show(); //show all links
			$('#tiny-page-' + Model['page']).hide(); //hide link that we just clicked
			Router.goTo(Model['page']);
			//do ajax request
		},
		tour: function() {

		}
	};
	return Public;
})(jQuery, NOHTML, Tour);
//END
//MVC
var Model = (function() {
	"use strict";
	//all data: notify view when stuff changes (All Public)
	return {
		//DEV
		scriptFile: 'workspace_script.php',
		test: false,
		//defaults
		page: 'Stream',
		project: null,
		branch: 'Master',
		filter: [], //are we filtering anything?
		num_results: null, //how many results are currently displayed?
		limiter: 20, //how many results to get at once
		tour: false, //has a Tour been called yet?
		//general data
		privileges: ['Observer', 'Contributor', 'Supervisor', 'Manager', 'Creator'],
		elements: ['Document', 'Task', 'Event', 'Table', 'Note'],
		pages: ['Stream', 'Control', 'Members', 'Documents', 'Tasks', 'Events', 'Tables', 'Files', 'Notes', 'Suggested'],
		//buttons for controlling content
		CMS: [

		],
		//How many of each element we have OPEN
		num_documents: 0,
		num_tasks: 0,
		num_tables: 0,
		num_notes: 0,
		num_events: 0,
		//store entries of each element
		documents: {},
		tasks: {},
		tables: {},
		notes: {},
		events: {},
		//functions for modifications:
		modify: function(what, value) { //change a constant Model property
			//change data
			this[what] = value;
			//notify view
			View.changed = what; //tell view our most recent change
			View.notify(); //we just pushed
			console.log('(Model): -modified: Model.' + what);
		},
		//change a dynamically added Model property
		tickle: function(cat, thing, what, newValue) {
			this[cat][thing][what] = newValue;
			// * astrid to tell view it is dynamic
			View.changed = '*' + cat + '-' + thing + '-' + what;
			View.notify();
			console.log('(Model): -tickled: Model.' + cat + '.' + thing + '.' + what);
		}
	};
})();
var View = (function($) {
	"use strict";
	//UI: change interface when model changes (calls, but does not define functions)
	var Public = {};
	Public.changed = null;
	Public.notify = function() {
		//work with a dynamically added element in the Model
		if (Public.changed.charAt(0) === '*') {
			//do lots of hard stuff in here to parse Public.changed
			//to do the appropriate action
			var changed = Public.changed.substring(1).split('-'); //remove astrid and get pieces
			var type = changed[0]; //type of element, eg: documents, tasks, etc.
			var num = changed[1].substring(changed[0].length - 1); //get the index #
			var what = changed[2]; //exactly what was changed?
			switch (type) { //we need to do something different depending on the element
				//then, do something for each one depending on the actual property changed (var what)
				case 'documents':

					break;
				case 'tasks':

					break;
				case 'tables':

					break;
				case 'notes':

					break;
				case 'events':

					break;
				default:
					console.err.log("(View): There is no such element: " + type);
			}
		} else {
			//work with constant Model variables
			switch (Public.changed) {
				//main view stuff: depending on what changed, do something
				case 'test':
					console.log('(View): Testing...MVC works! Model.test = ' + Model['test']);
					break;
				case 'page':
					console.log("(View): Page changed to '" + Model['page'] + "'");
					Workspace.gen.changePage();
					break;
			}
		}
	};
	return Public;
})(jQuery);
var Controller = (function($) {
	"use strict";
	//click handlers: Modify Model
	console.log("(Controller): Controller now listening for events!");
	Model.modify('test', true); //make sure MVC works
	//start listening for changes
	$(document).ready(function() {
		$(document).on('click', 'span[id^="tiny-page-"]', function() {
			Model.modify('page', $(this).attr('id').substring(10));
		});
	});
})(jQuery);
//END
//START
(function() {
	"use strict";
	//JS additions
	String.prototype.ucfirst = String.prototype.ucfirst || function() {
		return this.charAt(0).toUpperCase() + this.slice(1);
	}
	String.prototype.lcfirst = String.prototype.lcfirst || function() {
		return this.charAt(0).toLowerCase() + this.slice(1);
	}
	//BEGIN
	Workspace.init(); //start everything
	//FOR TESTING IN DEV ONLY:
	// var elDocument = new Document('task', 'uriah');
	// var elTask = new Task('task', 'uriah');
	// var elTable = new Table('table', 'uriah');
	// var elNote = new Note('note', 'uriah');
	// var elEvent = new Event('event', 'uriah');
	// Workspace.init(); //for testing hard coded tests (because it must go after the elements)
})();