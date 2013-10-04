//ELEMENTS
var Element = (function() {
	"use strict";
	var Element = function(type, name, creator) {
		console.log('New element created:');
		this.name = name;
		this.creator = creator;
		this.num = Model['num_' + type + 's'];
		Model[type+'s'][type + this.num] = {
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
var Workspace = (function() {
	"use strict";
	//define functions for use in View
	var Public = {}, Private = {};
	Public.init = function() {
		console.log('The workspace has been initiated.');
		Controller.init();
	};
	Private.ajax = {
		//standard functions for server communication
	};
	//let's make add an object to Public for each major feature
	Public.boards = { //EX:
		create: function() {

		}
	};
	return Public;
})();
//END
//MVC
var Model = (function() {
	"use strict";
	//all data: notify view when stuff changes
	return {
		//everything is public
		test: false,
		//How many of each element we have OPEN
		num_documents: 0,
		num_tasks: 0,
		num_tables: 0,
		num_notes: 0,
		num_events: 0,
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
	Public.notify = function() {
		switch (Public.changed) {
			//main view stuff: depending on what changed, do something
			case 'test':
				console.log('Testing...it works! Model.test = ' + Model['test']);
				break;
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
			this.modify('test', true);
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
			View.changed = cat + '-' + thing + '-' + what;
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
	// Workspace.init(); //for testing hard coded tests
})();