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
//FUNCTIONS
var Workspace = (function($ /*, _, T*/ ) {
	"use strict";
	//define functions for use in View
	var Public = {}, Private = {};
	Private.ajax = function(query, after) {
		//standard function for server communication
		$.ajax({
			success: function() {
				switch (after) {
					//if int do a standard function, else call do()
				}
			}
		});
	};
	//start Controller, get data from server
	Public.init = function() {
		console.log('The workspace has been initiated.');
		Controller.init();
	};
	//let's add an object to Public for each major feature
	Public.boards = { //EX:
		create: function() {

		}
	};
	return Public;
})(jQuery /*, NOHTML, Tour*/ );
//END
//MVC
var Model = (function() {
	"use strict";
	//all data: notify view when stuff changes
	return {
		//everything is public
		test: false,
		//defaults
		page: 'Start',
		filter: [], //are we filtering anything?
		num_results: null, //how many results are currently displayed?
		limiter: 20, //how many results to get at once
		tour: false, //has a Tour been called yet?
		//general data
		privileges: ['Observer', 'Contributor', 'Supervisor', 'Manager', 'Creator'],
		elements: ['Document', 'Task', 'Event', 'Table', 'Note'],
		pages: ['Start', 'Wall', 'Control', 'Members', 'Documents', 'Tasks', 'Events', 'Tables', 'Files', 'Notes', 'Suggested'],
		//buttons for controlling content
		CMS : [

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
		events: {}
	};
})();
var View = (function() {
	"use strict";
	//UI: change interface when model changes (calls, but does not define functions)
	var Public = {}, Private = {};
	Public.changed = null;
	Public.begin = function() { //function for onload handler
		console.log("(View): initial functions starting...");
		Controller.modify('test', true);
	};
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
					console.err.log("There is no such element: " + type);
			}
		} else {
			//work with constant Model variables
			switch (Public.changed) {
				//main view stuff: depending on what changed, do something
				case 'test':
					console.log('Testing...MVC works! Model.test = ' + Model['test']);
					break;
			}
		}
	};
	return Public;
})();
var Controller = (function() {
	"use strict";
	//click handlers: Modify Model
	return {
		//everything is public
		init: function() {
			console.log("Controller now listening for events!");
			View.begin(); //onload events
			//start listening for changes
		},
		//change a constant Model property
		modify: function(what, value) {
			//change data
			Model[what] = value;
			//notify view
			View.changed = what; //tell view our most recent change
			View.notify(); //we just pushed
			console.log('-modified: Model.' + what);
		},
		//change a dynamically added Model property
		tickle: function(cat, thing, what, newValue) {
			Model[cat][thing][what] = newValue;
			// * astrid to tell view it is dynamic
			View.changed = '*' + cat + '-' + thing + '-' + what;
			View.notify();
			console.log('-tickled: Model.' + cat + '.' + thing + '.' + what);
		}
	};
})();
//END
//START
(function() {
	"use strict";
	Workspace.init();
	//FOR TESTING IN DEV ONLY:
	// var elDocument = new Document('task', 'uriah');
	// var elTask = new Task('task', 'uriah');
	// var elTable = new Table('table', 'uriah');
	// var elNote = new Note('note', 'uriah');
	// var elEvent = new Event('event', 'uriah');
	// Workspace.init(); //for testing hard coded tests (because it must go after the elements)
})();