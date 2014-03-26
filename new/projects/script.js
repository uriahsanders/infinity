(function($) {
	"use strict";
	//functions found in MVC are defined in var Projects = (function(){ ... })(); //(Below MVC)
	Model.create({ //global data
		scriptFile: 'script.php',
		category: null, //what category are we on
		getOne: false, //are we looking at one project?
		creator: null, //creator of current project
		projectName: null, //name of current project
		limit: 10, //how many results to add on loadMore
		joined: null, //have we joined the current project?
		query: null, //what are we searching?
		action: null, //what are we doing right now? (category, searching, project)
		id: null, //current project id
		//all different categories
		categories: ['all', 'technology', 'music', 'art', 'literature', 'language', 'science', 'mathematics', 'education', 'history'],
		DL: 'all', //Default Location should show everything
		results: 0 //how many results are being shown atm?
	});
	var model = Model.data; //shorthand alias for Model
	View.create(function(name, value, states) { //function will run each time Model.modify() is called
		var changed = Model.changed; //array of changed names
		switch (name) {
			case 'category':
				Projects.retrieve(value);
				break;
			case 'query':
				Projects.search(value);
				break;
			case 'joined':
				Projects.joinProject(value);
				break;
		}
		//getOne if projectname has changed
		if (name === 'projectName') {
			//get id from DOM
			Projects.getOne();
		}
	});
	Controller.create(function() { //click handlers
		$(function() {
			//changing categories
			$(document).on('change', '#category_select', function() {
				Projects.handle_categoryChange($(this).val());
			});
			//viewing a project
			$(document).on('click', '.project', function() { //id is #projectname-creator-uniqueId
				Projects.handle_projectClick($(this).attr('id').split('-'));
			});
			//prevent default on clicking project links so whole page
			//doesnt need to be refreshed since we handle with js & ajax
			//but they still have the option to open in a new tab if they want
			$(document).on('click', 'a.projectLink', function(e) {
				e.preventDefault();
			});
			//actually creating a new project
			$(document).on('submit', '#project-form', function(e) {
				e.preventDefault();
				Projects.handle_createProject($(this).serialize());
			});
			$(document).on('click', '#new-project', function(){
				$('#project-form').fadeToggle();
			});
			//entering a search request
			$(document).on('submit', '#search-form', function() {
				Projects.handle_searchEnter($('#search').val());
			});
			//allow editing on a project one owns
			$(document).on('click', '#edit', function() {
				Projects.handle_editProject();
			});
			//updating a project one owns
			$(document).on('click', '#update', function() {
				Projects.handle_updateProject($('#project-form').serialize());
			});
			//commenting on a project
			$(document).on('click', '#comment', function() {
				Projects.handle_comment($('#comment-textarea').val(), $('#projectID').val());
			});
			//deleting a project
			$(document).on('click', '#delete', function() { // remember id of project is in hidden input
				Projects.handle_delete($('#projectID').val());
			});
			//loading more projects
			$(document).on('click', '#load_more', function() {
				Projects.handle_loadMore();
			});
			//joining a project
			$(document).on('click', '#join', function() {
				Projects.handle_join((model.join === null || model.join === false) ? true : false);
			});
			//going back
			$(document).on('click', '#pr-discover', function(){
				Router.goTo(model.DL);
			});
		});
	});
	Router.create(function(hash, count) { //func will run each popstate and hashchange
		/*
		IMPORTANT:
		because the router runs functions indirectly by modifying Model data
		and these functions also must change the url, and with every url change the Router
		function will run, we have an infinite loop of View calls.
		To prevent this, do not modify Model data that is already correct
		eg if(model.category !== category) Model.modify('category', category); //correct way
		*/
		//clearing projects specific vars because they will be set after function is called
		if (model.joined !== null) model.joined = null;
		if (model.creator !== null) model.creator = null;
		if (model.projectName !== null) model.projectName = null;
		if (model.getOne !== null) model.getOne = null;
		//////////////////////////////////////////
		var hash = hash.split('/');
		var DL = model.DL; //default location
		if (hash[0] && hash[0] === 'project' && hash.length === 3) { //we have one project
			console.log("one project");
			model.action = 'project';
			//parse url
			model.getOne = true; //we are looking at one project
			var creator = hash[1]; //creator of project
			//let the model know project info
			if (model.creator !== creator && model.projectName !== hash[2]) { //if data is not already correct
				Model.cascade({
					creator: creator,
					projectName: hash[2],
					id: hash[3]
				});
			}
			//check that there is a filter and a category, and both are valid
		} else if (hash[0] && $.inArray(hash[0], model.categories) > -1) {
			console.log("A category");
			model.action = 'category';
			//we are looking at a category
			Model.modify('category', hash[0]);
		} else if (hash[0] && hash[0] === 'search') { //there is a search query
			console.log("A search");
			model.action = 'searching';
			Model.modify('query', hash[1]);
		} else if (Router.hash('visible')) { //there's hash content but it wasnt caught above (it's invalid)...
			console.log("Not found");
			//show not found message
		} else { //hash either doesnt exist or is empty eg. #!/
			console.log("Empty hash");
			model.action = 'category';
			//so do default location
			Model.modify('category', DL);
		}
	});
	var Projects = (function() {
		//PRIVATE DATA
		//shorthand ajax so we can bulk handle errors and successes
		function ajax(type, request, callback) {
			//check token with every POST request
			if(type === 'POST'){
				if (typeof request === 'string') request += '&token=' + $('#token').val();
				else request.token = $('#token').val();
			}
			$.ajax({
				type: type,
				data: request,
				url: model.scriptFile,
				cache: false,
				success: function(res) {
					callback(res);
				},
				error: function() {
					console.log("AJAX error.");
				}
			});
		}
		//PUBLIC DATA
		return {
			//meat FUNCS
			//lets make Router calls before ajax calls because Router purifies Model
			search: function(query) {
				Router.goTo('search/' + query);
				ajax('GET', {
					signal: 'search',
					query: query
				}, function(res) {
					//#meat is container for content
					$('#meat').html(res);
				});
			},
			//get one project
			getOne: function() {
				Router.goTo('project/' + model.creator + '/' + model.projectName);
				ajax('GET', {
					signal: 'getOne',
					projectname: model.projectName,
					creator: model.creator,
				}, function(res) {
					$('#meat').html(res);
					$('#pr-navigation').hide();
					//so, whether or not the project has been joined in stored in a hidden input
					//so hide form if it has been joined and show it otherwise
					//required boolean is the value of the hidden input
					this.joinForm($("#projectHasBeenJoined").val());
				});
			},
			//get a category
			retrieve: function(where) {
				Router.goTo(where);
				ajax('GET', {
					signal: 'retrieve',
					category: where
				}, function(res) {
					$('#meat').html(res);
					$('#pr-navigation').show();
				});
			},
			create: function(formData) {
				/*
					Contents of formData:
					projectName, short, description, image, video
				*/
				ajax('POST', 'signal=create&' + formData, function(res) {
					console.log(res);
				});
			},
			deleteOne: function(id) {
				ajax('POST', {
					signal: 'delete',
					id: id
				}, function(res) {
					console.log("Project was deleted.");
				});
			},
			updateOne: function(formData) {
				ajax('POST', 'signal=update&' + formData, function(res) {
					console.log("Project was updated.");
				});
			},
			comment: function(comment, id) {
				ajax('POST', {
					signal: 'comment',
					comment: comment,
					id: id
				}, function(res) {
					this.getComments(); //reload comments
				});
			},
			getComments: function(){
				ajax('GET', {
					signal: 'comments',
					projectID: $('#projectID').val() //hidden input with project ID
				}, function(res) {
					$('#comments').html(res);
				});
			},
			joinProject: function(bool){ //true for joining false for leaving
				//send an ajax call on whether project was joined or unjoined
				//based on the value of model.joined
				//hide join form if project is being joined or
				//show if it being left
				ajax('POST', {
					signal: 'join',
					bool: bool,
					projectID: $('#projectID').val() //hidden input with project ID
				}, function(res){
					console.log("Joining/leaving project has been handled.");
					this.joinForm(bool); //hide or show form depending on bool
				});
			},
			joinForm: function(bool){
				if(bool === true) $('#joinForm').hide();
				else $('#joinForm').show();
			},
			loadMore: function(){
				ajax('GET', {
					signal: 'loadMore',
					results: model.results, //how many results do we have already?
					action: model.action, //what are we doing?
					category: model.category,
					query: model.query,
					projectID: model.getOne === true ? $('#projectID').val() : -1
				}, function(res){
					$('#meat').append(res); //append results
					model.results += model.limit;
				});
			},
			/////////////////////////////////////////////
			//UI FUNCS
			handle_categoryChange: function(category) {
				Model.modify('category', category);
			},
			handle_createProject: function(formData) {
				this.create(formData);
			},
			handle_projectClick: function(id) {
				Model.cascade({
					'creator': id[0],
					'projectName': id[1],
					'id': id[2]
				});
			},
			handle_searchEnter: function(query) {
				Model.modify('query', query);
			},
			//make project editable
			handle_editProject: function() {

			},
			//actually make changes by server
			handle_updateProject: function(formData) {
				this.updateOne(formData);
			},
			handle_comment: function(comment) {
				this.comment(comment);
			},
			handle_delete: function(id) {
				this.deleteOne(id);
				//nothing is here anymore so retrieve category again
				this.retrieve(model.category);
			},
			handle_loadMore: function() {
				this.loadMore();
			},
			handle_join: function(bool){
				Model.modify('joined', bool);
			}
		};
	})();
})(jQuery);