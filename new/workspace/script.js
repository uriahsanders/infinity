(function($) {
	/*
		We will stick some default information into html hidden inputs
		with PHP. The id's of such input start with "hidden_"
	*/
	Model.create({
		scriptFile: 'script.php', //server communication script
		getOne: null, //are we looking at one element alone?
		limit: 10, //number of results to filter out
		query: null, //are we searching for anything?
		action: null, //what are we doing right now? (application, element, search)
		welcome: null, //true if no projects have been created yet
		application: null, //what application are we using atm?
		applications: [
			'Stream', 'Control', 'Members', 'Documents', 'Tasks', 'Events',
			'Tables', 'Graphs', 'Sketches', 'Files', 'Notes', 'Suggestions'
		],
		//elements are what we need to open on edit in a new window with togetherJS
		elements: ['document', 'task', 'event', 'table', 'graph', 'sketch', 'file', 'note'],
		project: $('#hidden_project').val(), //current project (creator/projectname)
		branch: 'Master', //current branch
		elementID: null, //current element ID
		elementType: null,
		/*
			Privilege Breakdown:
			Observers can make suggestions, view content
			Members can create and edit everything except for tasks and events, and can post to Stream
			Supervisors can create and edit tasks and events, and delete anything but tasks and events
			Managers can add members, create branches, change project information (but not the name)
			Admins can remove members and assign privileges (not other admins or the creator), delete/edit branches and project info
			The Creator can pass lead, remove any member change any privilege
			And, of course, all privileges can also do all of the things that their inferiors can
		*/
		privileges: ['Observer', 'Member', 'Supervisor', 'Manager', 'Admin', 'Creator'],
		numResults: 0 //how many results do I currently have?
	});
	var model = Model.data;
	View.create(function(name, value, states, count) {
		var changed = Model.changed;
		if (name === 'application') {
			Workspace.getApp(value);
		} else {
			switch (name) {
				case 'project':
					Workspace.getProject(value);
					break;
				case 'branch':
					Workspace.getBranch(value);
					break;
				case 'welcome':
					Workspace.welcome();
					break;
				case 'elementID':
					Workspace.getElement(value);
					break;
				case 'query':
					Workspace.search(value);
					break;
			}
		}
	});
	Controller.create(function() {
		$(function() {

		});
	});
	Router.create(function(hash, count) {
		/*
		IMPORTANT:
		because the router runs functions indirectly by modifying Model data
		and these functions also must change the url, and with every url change the Router
		function will run, we have an infinite loop of View calls.
		To prevent this, do not modify Model data that is already correct
		eg if(model.creator !== creator) Model.modify('creator', creator); //correct way
		*/
		//URL contains project, branch, application, search, and element information
		var hash = hash.split('/'); //split hash into seperate components
		//hash structure: creator/projectname/branch/(application | search | element)
		if (!Router.hash('visible') || hash.length < 4) { //we dont have a hash or hash doesnt cover needed info
			//if we dont have any projects show welcome screen, else go to a URL we can work with
			if (typeof model.project === 'undefined') Model.modify('welcome', true);
			else Router.goTo(model.project.split('/')[0] + '/' + model.project.split('/')[1] + '/' + model.branch + '/' + model.application);
		} else {
			var projectString = hash[0] + '/' + hash[1]; //creator/project
			if (model.project !== projectString) Model.modify('project', projectString);
			if (model.branch !== hash[2]) Model.modify('branch', hash[2]);
			var type = hash[3]; //application, search, or element
			//if search or element, hash[4] has the data we want (either element ID or query)
			if (type === 'search' && hash[4]) {
				model.action = 'search';
				if (model.query !== hash[4]) Model.modify('query', hash[4]);
			} else if ($.inArray(type, model.elements) > -1 && hash[4]) {
				model.action = 'element';
				model.elementType = hash[3];
				if (model.elementID !== hash[4]) Model.modify('elementID', hash[4]);
			} else if ($.inArray(type, model.applications) > -1) {
				model.action = 'application';
				if (model.application !== type) Model.modify('application', type);
			} else if (Router.hash('visible')) { //not found because crap is in the URL
				console.log('Not found.');
				//show not found message
			} else { //nothing in URL so do basic and just get first application
				console.log("Empty hash");
				model.action = 'application';
				//so do default location
				var dl = model.applications[0];
				if (model.application !== dl) Model.modify('application', dl);
			}
		}
	});
	//all update functions are contained in the JS for editing elements, not here
	//but the are commented out in here for a reminder of potential functions
	var Workspace = (function() {
		//shorthand ajax so we can bulk handle errors and successes
		function ajax(type, request, callback) {
			//check token with every POST request
			//also stick projectname and branch in with every request
			if (type === 'POST') {
				if (typeof request === 'string')
					request += '&token=' + $('#token').val() + '&project=' + model.project + '&branch=' + model.branch;
				else {
					request.token = $('#token').val();
					request.project = model.project;
					request.branch = model.branch;
				}
			}
			$.ajax({
				type: type,
				data: request,
				url: model.scriptFile,
				success: function(res) {
					callback(res);
				},
				error: function() {
					console.log("AJAX error.");
				}
			});
		}
		//return basic URL beginning: creator/project/branch
		var basicPath = function() {
			return model.project + model.branch + '/';
		};
		return {
			//General
			getApp: function(which) {
				Router.goTo(basicPath() + which); //go to basicPath/applicationName
				ajax('GET', {
					signal: 'application',
					application: which
				}, function(res) {

				});
			},
			//model data should have already been modified from initial Router run, Model change,
			//or a handle_ function, so just run inital functions again by going to a blank URL
			//of course, server side will verify project access so all we had to do here is change some data
			//we make functions for this in case of future requirements (which are likely)
			getProject: function() { //basically change current project
				Router.goTo(''); //go to empty URL
			},
			//same thing as getProject
			getBranch: function() {
				Router.goTo(''); //go to empty URL
			},
			welcome: function() {
				console.log("Welcome! Create a new project to get started.");
			},
			getElement: function(id) {
				Router.goTo(basicPath() + model.elementType + '/' + model.elementID);
				ajax('GET', {
					signal: 'getElement',
					elementID: id
				}, function(res) {

				});
			},
			//go to edit url for current element
			startEditing: function(id) {
				location.href = 'edit.php/#!/' + model.project + '/' + model.branch +
					'/' + model.elementType + '/' + model.elementID;
			},
			search: function(query) {
				Router.goTo(basicPath() + 'search/' + query);
				ajax('GET', {
					signal: 'search',
					query: query
				}, function(res) {

				});
			},
			newWorkspace: function(form) {
				ajax('POST', {
					signal: 'newWorkspace',
					form: form
				}, function(res) {

				});
			},
			//delete a singleton element
			deleteElement: function(id, form) {
				ajax('POST', {
					signal: 'deleteElement',
					id: id
				}, function(res) {

				});
			},
			//delete just one version of an element
			deleteElementVersion: function(id, form) {
				ajax('POST', {
					signal: 'deleteElementVersion',
					id: id
				}, function(res) {

				});
			},
			//commenting on elements
			comment: function(form) {
				ajax('POST', {
					signal: 'comment',
					form: form
				}, function(res) {

				});
			},
			//load more of whatever we're looking at, if possible
			loadMore: function() {

			},
			changeStatus: function(form) {
				ajax('POST', {
					signal: 'changeStatus',
					form: form
				}, function(res) {

				});
			},
			//the form required for this is "DELETE" verification
			leaveProject: function(form) {
				ajax('POST', {
					signal: 'leaveProject',
					form: form
				}, function(res) {

					location.reload(true); //refresh page
				});
			},
			passLead: function(form) {
				ajax('POST', {
					signal: 'passLead',
					form: form
				}, function(res) {

					location.reload(true); //refresh page
				});
			},
			//Stream
			//(This should be handled by Wall class, instantiated particularly for the Workspace)
			//Control
			// updateWorkspaceInfo: function() {

			// },
			deleteWorkspace: function(form) {
				ajax('POST', {
					signal: 'deleteWorkspace',
					form: form
				}, function(res) {

					location.reload(true); //refresh page
				});
			},
			createBranch: function(form) {
				ajax('POST', {
					signal: 'createBranch',
					form: form
				}, function(res) {

				});
			},
			editBranch: function(form) {
				ajax('POST', {
					signal: 'editBranch',
					form: form
				}, function(res) {

				});
			},
			deleteBranch: function(form) {
				ajax('POST', {
					signal: 'deleteBranch',
					form: form
				}, function(res) {

				});
			},
			launch: function() {
				ajax('POST', {
					signal: 'launch',
					form: form
				}, function(res) {

				});
			},
			//Members
			changePrivilege: function(form) {
				ajax('POST', {
					signal: 'changePrivilege',
					form: form
				}, function(res) {

				});
			},
			removeMember: function(form) {
				ajax('POST', {
					signal: 'removeMember',
					form: form
				}, function(res) {

				});
			},
			addMember: function(form) {
				ajax('POST', {
					signal: 'addMember',
					form: form
				}, function(res) {

				});
			},
			acceptMember: function() {
				ajax('POST', {
					signal: 'acceptMember',
					form: form
				}, function(res) {

				});
			},
			denyMember: function(form) {
				ajax('POST', {
					signal: 'denyMember',
					form: form
				}, function(res) {

				});
			},
			messageMember: function(form) {
				ajax('POST', {
					signal: 'messageMember',
					form: form
				}, function(res) {

				});
			},
			getAdvancedMemberInfo: function() {
				ajax('POST', {
					signal: 'getAdvancedMemberInfo',
					form: form
				}, function(res) {

				});
			},
			//Documents
			createDocumentVersion: function(form) {
				ajax('POST', {
					signal: 'createDocumentVersion',
					form: form
				}, function(res) {

				});
			},
			// updateDocumentVersion: function() {

			// },
			//Tasks
			createTask: function(form) {
				ajax('POST', {
					signal: 'createTask',
					form: form
				}, function(res) {

				});
			},
			// updateTask: function() {

			// },
			changeTaskStatus: function() {
				ajax('POST', {
					signal: 'changeTaskStatus',
					form: form
				}, function(res) {

				});
			},
			//Events
			addEvent: function(form) {
				ajax('POST', {
					signal: 'addEvent',
					form: form
				}, function(res) {

				});
			},
			goToEvent: function() {
				ajax('POST', {
					signal: 'goToEvent',
					form: form
				}, function(res) {

				});
			},
			// updateEvent: function() {

			// },
			//Tables
			createTableVersion: function(form) {
				ajax('POST', {
					signal: 'createTableVersion',
					form: form
				}, function(res) {

				});
			},
			// updateTable: function() {

			// },
			//Graphs
			createGraph: function(form) {
				ajax('POST', {
					signal: 'createGraph',
					form: form
				}, function(res) {

				});
			},
			// updateGraph: function() {

			// },
			//Sketches
			createSketch: function(form) {
				ajax('POST', {
					signal: 'createSketch',
					form: form
				}, function(res) {

				});
			},
			//can only add to existing sketches because canvas can only save as image
			// addToSketch: function(){

			// },
			//Files
			addFile: function() {

			},
			removeFile: function() {

			}
			//Notes
			createNote: function(form) {
				ajax('POST', {
					signal: 'createNote',
					form: form
				}, function(res) {

				});
			},
			//notes are not a collaborative effort, so update func is here
			updateNote: function(form) {
				ajax('POST', {
					signal: 'updateNote',
					form: form
				}, function(res) {

				});
			},
			//Suggestions
			createSuggestion: function(form) {
				ajax('POST', {
					signal: 'createSuggestion',
					form: form
				}, function(res) {

				});
			},
			dismissSuggestion: function(form) {
				ajax('POST', {
					signal: 'dismissSuggestion',
					form: form
				}, function(res) {

				});
			},
			approveSuggestion: function() {
				ajax('POST', {
					signal: 'approveSuggestion',
					form: form
				}, function(res) {

				});
			},
			//UI funcs (all start with handle_)

		};
	})();
})(jQuery);