//Infinity-forum.org: 2013
/*
	Im going to stick some stuff in here that allows the below
	code to run without support from certain external scripts
	so just ignore for now, will include said scripts later
	Will all be deleted soon...
*/
var Status = {};
Status.isIdle = false;
/*
	Okay now for the real stuff :P
*/
var cFirst = cFirst || function(str, what) {
		return str.charAt(0)[(what === 'u') ? 'toUpperCase' : 'toLowerCase']() + str.slice(1); //lowercase or cap first letter
	}
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
	Element.prototype.generic = function(type, name, creator) { //common way to start element extension
		++Model['num_' + type + 's'];
		Element.call(this, type, name, creator);
		console.log("This element is a " + cFirst(type, 'u') + " named " + this.name + ", created by " + this.creator);
		console.log('---------------------------------------------------------------------------------------------');
	};
	return Element;
})();
var Document = (function() { //extends Element
	"use strict";
	var Document = function(name, creator) {
		this.generic.call(this, 'document', name, creator);
	};
	Document.prototype = Object.create(Element.prototype);
	Document.prototype.constructor = Document;
	return Document;
})();
var Task = (function() {
	"use strict";
	var Task = function(name, creator) {
		this.generic.call(this, 'task', name, creator);
	};
	Task.prototype = Object.create(Element.prototype);
	Task.prototype.constructor = Task;
	return Task;
})();
var Table = (function() {
	"use strict";
	var Table = function(name, creator) {
		this.generic.call(this, 'table', name, creator);
	};
	Table.prototype = Object.create(Element.prototype);
	Table.prototype.constructor = Table;
	return Table;
})();
var Note = (function() {
	"use strict";
	var Note = function(name, creator) {
		this.generic.call(this, 'note', name, creator);
	};
	Note.prototype = Object.create(Element.prototype);
	Note.prototype.constructor = Note;
	return Note;
})();
var Event = (function() {
	"use strict";
	var Event = function(name, creator) {
		this.generic.call(this, 'event', name, creator);
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
	Public.implement = function(path) { //do ajax depending on URL
		//do a lot of annyoing parsing to modify Model data depnding on URL
	};
	return Public;
})();
//END
//FUNCTIONS
var Workspace = (function($) {
	"use strict";
	//define functions for use in View
	var Public = {}, Private = {};
	var self = this;
	Public.ajax = function(query, after, obj) { //data to send; what to do after; special args;
		//standard function for server communication
		obj = obj || {};
		after = after || 2;
		obj.datatype = obj.datatype || '';
		$.ajax({
			url: obj.url || Model.scriptFile,
			async: obj.async || true,
			cache: obj.cache || false,
			type: obj.type || 'GET',
			datatype: obj.datatype,
			data: obj.query || query,
			success: function(data) {
				console.log("AJAX run successful.");
				switch (after) {
					//if int do a standard function, else call after()
					case 0: //reload page
						location.reload(obj.reload || false);
						break;
					case 1: //refresh page (ajax)
						Model.modify(['page'], Model.page);
						break;
					case 2: //return response
						return (obj.datatype === 'json') ? jQuery.parseJSON(data) : data;
						break;
					case 3:
						//do nothing
						break;
					default: //call given function with data
						after(data);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log("(AJAX): (\nError: " + thrownError);
				console.log("More information on error:\nQuery: " + query + ";\nAfter: " + after + "\n)");
				if (obj.err) obj.err(); //throw custom error as well
			}
		});
	};
	//return all essential data from the Model as a query string
	Private.getEssentialData = function() {
		var queryString;
		var essentials = ['page', 'project', 'branch', 'filter', 'numResults', 'limiter', 'current'];
		for (var i = 0; i <= essentials.length; ++i) {
			queryString += essentials[i] + '=' + Model[essentials[i]] + '&';
		}
		return queryString;
	};
	//do all the starting stuff
	Public.init = function() {
		Workspace.ajax('signal=init', function(data) {
			Model.modify(['firstTime'], data);
		});
		Workspace.graphs.contributions();
		//$('#entries').css('height', $('#workspace-info').css('height')); //info height is dynamic but entires still needs to match it
		if (Router.isURLDefault()) { // URL is standard
			console.log('The workspace has been initiated.');
			console.log("Initial functions starting...");
			$('#tiny-page-' + cFirst(Model['page'], 'l')).css('display', 'none'); //fade out "Stream" link
			Router.goTo(Model['page']);
			console.log("Finished.");
		} else { //URL has special path
			var paths;
			console.log("This workspace has been linked to. URL:" + location);
			paths = location.split('/workspace/'); //everything after this is the path
			Router.implement(paths[1]); //do ajax functions for this URL
		}
		//a long polling loop to get ALL information needed with one ajax call
		window.setTimeout(Public.updateEverything, 60000); //wait 1 minute before calling
	};
	Public.updateEverything = function() {
		//if the user isnt even here, why the FUCK would we just keep updating shit
		if (Status.isIdle === false) {
			Public.ajax(Private.getEssentialData(), function(data) {
				//parse response to see what needs to be done
				var res = jQuery.parseJSON(data);
				//do any general stuff here

				//END
				for (var i = 0; i <= res.signal.length; ++i) {
					switch (res.signal[i]) {
						//this will allow us to react to multiple signals
					}
				}
				console.log("(AJAX): Everything was just updated; Restarting loop");
				window.setTimeout(Public.updateEverything, 60000); //wait one minute
			}, {
				cache: false,
				datatype: 'json',
				err: function() {
					window.setTimeout(Public.updateEverything, 60000);
					console.log('Encountered an error while attempting to update everything...\nResuming loop now.');
				}
			});
		}
	};
	//let's add an object to Public for each major feature
	Public.gen = {
		//if they havent created any projects yet, throw a big-ass screen in their face
		welcome: function() {
			console.log("You havent created any projects yet.");
			var welcome = [
				'<div id="welcome">',
				'<br /><br /><br /><br /><br /><span id="page-title">Welcome to the Workspace</span>',
				'<hr class="hr-fancy"/><br /><span>You don\'t have a workspace yet.</span>',
				'<br /><span class="b i">You should.</span>',
				'<br /><br /><br />',
				'<a id="cat"class="ctx-head b i">General</a><div id="cat-ctx"style="left:47.5%"class="ctx">',
				'<a class="entry-cat">General</a><hr class="hr-fancy" /><a class="entry-cat">cat 2</a><hr class="hr-fancy" /><a class="entry-cat">cat 3</a>',
				'</div><br />',
				'<input type="text"placeholder="Name" /><br />',
				'<textarea name="" id="" cols="50" rows="12"placeholder="Description (optional)"></textarea><br />',
				'<button>Let\'s do this</button>',
				'</div>'
			].join('');
			//$('body').append(welcome);
		},
		changePage: function(page) {
			$('#page-title').text(cFirst(Model['page'], 'u')); //change title
			$('span[id^="tiny-page-"]').show(); //show all links
			$('#tiny-page-' + Model['page']).hide(); //hide link that we just clicked
			Router.goTo(Model['page']);
			//do ajax request
			Public.ajax('signal=changePage&page=' + page, function(data) {
				$('#unique_content').html(data);
			});
		},
		//introduce to page
		tour: function() {

		},
		//search with no filter
		searchAll: function(val) {

		},
		//stick a loading symbol in a place
		loading: function(id) {

		},
		//get popup info from server
		popup: function(type) {
			Public.ajax('signal=popup&type=' + type, function(data) {
				$(document.body).append(data);
				$('.dim').fadeIn();
				$('.cms_popup').fadeIn();
			});
		}
	};
	Public.graphs = {
		contributions: function() {
			//linear graph listing contributions
			Public.gen.loading('#workspace-graphs'); //may take a while, so start loading screen
			$('#workspace-graphs').graphify({
				obj: {
					id: 'contributionsGraph',
					attachTo: 'workspace-info',
					width: '100%',
					height: 350,
					mainOffset: 45,
					xOffset: 35,
					legend: true,
					pieSize: 175,
					legendX: 350,
					shadow: true,
					xDist: 65,
					example: true,
					xName: 'Dates',
					yName: 'Amount',
					colors: ['grey', 'red', 'blue', 'green', 'yellow', 'orange', 'brown'],
					byCSS: {
						'#contributionsGraph .SVG-tooltip-box': {
							fill: 'darkgrey',
							opacity: 0.7,
							display: 'none'
						},
						'#contributionsGraph .rect': {
							fill: 'grey',
							opacity: 0.7,
							stroke: 'black'
						}
					}
				}
			});
		}
	};
	return Public;
})(jQuery);
//END
//MVC
var Model = (function() {
	"use strict";
	var Private = {};
	//change a property from array
	Private.recursive = function(props, to, obj, i) {
		obj = obj || Model; //initial obj
		i = i || 0;
		if (i < props.length - 1) { //skip final dimension (property of obj) so we can work with object
			this.recursive(props, to, obj[props[i]], i+1); //new obj = Model['data'], then Model['data']['data2'] ---> so on
		}else {
			obj[props[props.length - 1]] = to; //its an object so pass by reference and change
		}
	};
	var Public = {
		//DEV
		scriptFile: 'script.php',
		test: false,
		//defaults
		page: 'Stream',
		firstTime: null,
		mainEvent: 'click', //main event to use for controller
		current: null, //#id of whatever user has open
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
		popup: null, //is there a popup box open? What is it?
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
	//change some data
	Public.modify = function(what, value) {
		//change data
		Private.recursive(what, value);
		//notify view
		View.changed = what.join('-'); //tell view our most recent change
		View.notify(); //we just pushed
		console.log('(Model): -modified: Model.' + what + ' to: "' + value + '"');
	};
	return Public;
})();
//UI: change interface when model changes (calls, but does not define functions)
var View = (function($) {
	"use strict";
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
			var main = Model[Public.changed]; //current value we are working with
			switch (Public.changed) {
				//main view stuff: depending on what changed, do something
				case 'test':
					console.log('(View): Testing...MVC works! Model.test = ' + Model['test']);
					break;
				case 'page':
					//console.log("(View): Page changed to '" + Model['page'] + "'");
					Workspace.gen.changePage(main);
					break;
				case 'popup':
					Workspace.gen.popup(main);
					break;
				case 'firstTime':
					if (main === 'false') Workspace.gen.welcome();
					break;
			}
		}
	};
	return Public;
})(jQuery);
//Click handlers: modify Model
var Controller = (function($) {
	"use strict";
	console.log("(Controller): Controller now listening for events!");
	Model.modify(['test'], true); //make sure MVC works
	//start listening for changes
	$(function() {
		//tooltips
		$(document).tooltip({
			show: {
				delay: 250
			}
		});
		//change pages
		$(document).on(Model.mainEvent, 'span[id^="tiny-page-"]', function() { //changing pages
			Model.modify(['page'], $(this).attr('id').substring(10));
		});
		//Top context boxes
		$(document).on(Model.mainEvent, 'a[id^="top-bar-option"]', function() {
			var id = '#' + $(this).attr('id').substring(15);
			$('.shown').not(id).slideUp();
			$(id).addClass('shown');
			$(id).slideToggle();
		});
		//other context boxes
		$(document).on(Model.mainEvent, '.ctx-head', function() {
			var id = '#' + $(this).attr('id') + '-ctx';
			$(id).slideToggle();
		});
		$(document).on(Model.mainEvent, 'a[class^="entry-"]', function() {
			$('#' + $(this).attr('class').substring(6)).text($(this).text());
		});
		//side options
		$(document).on(Model.mainEvent, 'li[id^="side-bar-option-"]', function() {
			var id = $(this).attr('id').substring(16);
			if (id !== 'chat' && id !== 'current') {
				Model.modify(['popup'], $(this).attr('id').substring(16));
			}
		});
		//dim screen
		$(document).on(Model.mainEvent, '.dim, .close', function() {
			$('.cms_popup').fadeOut('normal', function() {
				$('.dim').fadeOut('normal', function() {
					$('.dim').remove();
					$('.cms_popup').remove();
				});
			});
		});
		//autocomplete
		$('#search').autocomplete({ //use categories so that they know what they're getting
			source: function(request, response) {
				response(
					Workspace.ajax('signal=search-autocomplete', 2, { //return result
						url: Model.scriptFile,
						datatype: 'json'
					})
				);
			},
			select: function() {
				//search automatically when they choose something
				Workspace.gen.searchAll($(this).val());
			}
		});
	});
})(jQuery);
//END
//START
(function() {
	"use strict";
	//BEGIN
	Workspace.init(); //start everything
	//FOR TESTING IN DEV ONLY:
	// var elDocument = new Document('document', 'uriah');
	// var elTask = new Task('task', 'uriah');
	// var elTable = new Table('table', 'uriah');
	// var elNote = new Note('note', 'uriah');
	// var elEvent = new Event('event', 'uriah');
	// Workspace.init(); //for testing hard coded tests (because it must go after the elements)
})();