//Infinity-forum.org: 2013
(function() {
	"use strict";
	//keep me safe until status script is included
	var Status = {};
	Status.isIdle = false;
	var cFirst = function(str, what) {
		return str.charAt(0)[(what === 'u') ? 'toUpperCase' : 'toLowerCase']() + str.slice(1); //lowercase or cap first letter
	}
	//MVC
	Model.create({
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
	});
	var model = Model.data;
	View.create(function(name, value, states) {
		if (name === 'test') {
			console.log('(View): Testing...MVC works! Model.test = ' + value);
		} else if (name === 'page') {
			//console.log("(View): Page changed to '" + value + "'");
			Workspace.gen.changePage(value);
		} else if (name === 'popup') {
			Workspace.gen.popup(value);
		} else if (name === 'firstTime') {
			if (value === 'false') Workspace.gen.welcome();
		} else {
			//no match... do something
		}
	});
	Controller.create(function() {
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
			$(document).on(model.mainEvent, 'span[id^="tiny-page-"]', function() { //changing pages
				Model.modify(['page'], $(this).attr('id').substring(10));
			});
			//Top context boxes
			$(document).on(model.mainEvent, 'a[id^="top-bar-option"]', function() {
				var id = '#' + $(this).attr('id').substring(15);
				$('.shown').not(id).slideUp();
				$(id).addClass('shown');
				$(id).slideToggle();
			});
			//other context boxes
			$(document).on(model.mainEvent, '.ctx-head', function() {
				var id = '#' + $(this).attr('id') + '-ctx';
				$(id).slideToggle();
			});
			$(document).on(model.mainEvent, 'a[class^="entry-"]', function() {
				$('#' + $(this).attr('class').substring(6)).text($(this).text());
			});
			//side options
			$(document).on(model.mainEvent, 'li[id^="side-bar-option-"]', function() {
				var id = $(this).attr('id').substring(16);
				if (id !== 'chat' && id !== 'current') {
					Model.modify(['popup'], $(this).attr('id').substring(16));
				}
			});
			//dim screen
			$(document).on(model.mainEvent, '.dim, .close', function() {
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
							url: model.scriptFile,
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
	});
	//URL HANDLING (PUSHSTATE)
	var Router = (function() {
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
				url: obj.url || model.scriptFile,
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
							Model.modify(['page'], model.page);
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
				queryString += essentials[i] + '=' + model[essentials[i]];
				if (i !== essentials.length) queryString += '&';
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
				$('#tiny-page-' + cFirst(model['page'], 'l')).css('display', 'none'); //fade out "Stream" link
				Router.goTo(model['page']);
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
				$('#page-title').text(cFirst(model['page'], 'u')); //change title
				$('span[id^="tiny-page-"]').show(); //show all links
				$('#tiny-page-' + model['page']).hide(); //hide link that we just clicked
				Router.goTo(model['page']);
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
	Workspace.init(); //start everything
})();