(function() {
	//MODEL
	var model = {
		r: 0, //count router calls
		scriptFile: 'script.php', //server communication script
		query: null, //are we searching for anything?
		branch: 'Master', //current branch
		project: 'No Project Selected',
		/*
			Privilege Breakdown:
			Observers can make suggestions, view content
			Members can create and edit everything except for tasks and events, and can post to Stream
			Supervisors can create and edit tasks and events, and delete anything but tasks and events
			Managers can add members, create branches, change project information (but not the name), delete tasks and events
			Admins can remove members and assign privileges (not other admins or the creator), delete/edit branches and project info, launch project
			The Creator can pass lead, remove any member change any privilege, change project name
			And, of course, all privileges can also do all of the things that their inferiors can
		*/
		privileges: ['Observer', 'Member', 'Supervisor', 'Manager', 'Admin', 'Creator'], //0 - 5
		apps: ['stream', 'control', 'members', 'documents', 'tasks', 'events', 'graphs', 'sketches', 'files', 'notes', 'suggestions'],
		numResults: 0 //how many results do I currently have?
	};
	//CONTROLLER
	$(function() {
		$(document).on('click', '.workspace-main-li', function() {
			window.location.hash = '#' + $(this).data('ref');
			$('.workspace-main-li').removeClass('active');
			$(this).addClass('active');
		});
		$(document).on('focus', '#workspace-search', function() {
			$(this).select();
		});
		$(document).on('mouseup', '#workspace-search', function(e) {
			e.preventDefault();
		});
		$('#workspace-ctx').dropDown();
		$('#workspace-discover-category').dropDown('w-disc-cat-change');
		$(document).on('w-disc-cat-change', function(e) {
			window.location.hash = '#discover/' + e.val.toLowerCase() + '/' + $('#workspace-discover-by').data('val').toLowerCase();
		});
		$('#workspace-discover-by').dropDown('w-disc-by-change');
		$(document).on('w-disc-by-change', function(e) {
			window.location.hash = '#discover/' + $('#workspace-discover-category').data('val').toLowerCase() + '/' + e.val.toLowerCase();
		});
		$('#main-body').css({
			margin: 0
		});
		var sidebar = $('#workspace-sidebar').offset().top;
		//manage sidebar when you scroll
		$(window).scroll(function() {
			if (sidebar < $(window).scrollTop()) {
				$("#workspace-sidebar").css({
					position: "fixed",
					top: 0,
					left: 0,
					"margin-top": "0px"
				});
			} else {
				$("#workspace-sidebar").css({
					"position": "absolute",
					"float": "left",
					"margin-top": "-30px"
				});
			}
		});
	});
	var Workspace = (function() {
		//shorthand ajax so we can bulk handle errors and successes
		function ajax(type, request, callback) {
			//check token with every POST request
			//also stick projectname and branch in with every request
			if (type === 'POST') {
				if (typeof request === 'string')
					request += '&token=' + $('#token').val() + '&projectID=' + model.projectID + '&branch=' + model.branch;
				else {
					request.token = $('#token').val();
				}
			}
			var desired_delay = 2000;
			var message_timer = false;
			$.ajax({
				type: type,
				data: request,
				url: model.scriptFile,
				success: function(res) {
					callback(res);
				},
				error: function() {
					console.log("AJAX error.");
				},
				//handle load timing
				beforeSend: function() {
					message_timer = setTimeout(function() {
						Workspace.loading();
						message_timer = false;
					}, desired_delay);
				},
				complete: function() {
					if (message_timer)
						clearTimeout(message_timer);
					message_timer = false;
				}
			});
		}
		return {
			//get all projects user is a part of as array
			getProjects: function(){
				ajax('GET', 'signal=getProjects', function(res){
					res = $.parseJSON(res);
					alert(res['projects']);
				});
			},
			//show load screen for ajax
			loading: function() {
				$('#workspace-main').html('<div id="workspace-loading"> <br><br><br><br><br> <i class="fa fa-spinner fa-spin"style="font-size:15em;color:grey"></i> <br><br> <span style="font-size:2em">Loading...</span> </div>');
			},
			showProjects: function(category, by) {
				ajax('GET', {
					signal: 'showProjects',
					category: category,
					by: by
				}, function(res) {
					$('#workspace-main').html(res);
				});
			},
			err: function(e) {
				$('#workspace-main').html([
					'<br><div style="background:url(\'/images/broken_noise.png\');padding:100px;',
					'border:1px solid #000;width: 60%;margin:auto;font-size:2em">',
					e,
					'</div>'
				].join(''));
			},
			changeHeaders: function(ico, cat, after) {
				$('#workspace-place').html('<i class="fa fa-' + ico + '"></i> ' + ucfirst(cat));
				after();
			},
			stream: function() {

			}
		}
	})();
	//ROUTING
	var route = function() {
		++model.r;
		//only get all data on first load
		if(model.r === 1) Workspace.getProjects();
		var hash = window.location.hash.split('/'); //split hash into seperate components
		if (typeof hash[1] === 'undefined' && (hash[0] === '#discover' || hash[0] == false)) {
			if (hash[0] !== '#discover') window.location.hash = '#discover';
			Workspace.changeHeaders('star', 'discover', function(){
				Workspace.showProjects('all', 'date');
			});
		} else if (hash[0] === '#discover' && typeof hash[1] !== 'undefined' && typeof hash[2] === 'undefined') {
			Workspace.showProjects(hash[1], 'date');
			if (model.r === 1) $('#workspace-discover-category').html(ucfirst(hash[1]) + ' <i class="fa fa-caret-down"></i>');
		} else if (hash[0] === '#discover' && typeof hash[1] !== 'undefined' && typeof hash[2] !== 'undefined') {
			if (model.r === 1) {
				$('#workspace-discover-category').html(ucfirst(hash[1]) + ' <i class="fa fa-caret-down"></i>');
				$('#workspace-discover-by').html(ucfirst(hash[2]) + ' <i class="fa fa-caret-down"></i>');
			}
			Workspace.showProjects(hash[1], hash[2]);
		} else if (hash[0] === 'project') {
			Workspace.getProject(hash[1], hash[2]); //creator, title
		} else if (hash[0] === 'element') {
			Workspace.getElement(hash[1], hash[2]); //title, ID
			//if we're working with a cat
		} else if ($.inArray(hash[0].substring(1), model.apps) !== -1) {
			$('#discover-id').removeClass('active');
			$(hash[0] + '-id').addClass('active');
			//change title and add in select boxes, update model accordingly, then GET content
			var cat = hash[0].substring(1);
			var ico;
			switch(cat){
				case 'stream':
					ico = 'comments';
					break;
			}
			Workspace.changeHeaders(ico, cat, Workspace[cat]); //call method from cat
		} else {
			Workspace.err("Nothing to see here...");
		}
	};
	window.onhashchange = route;
	route();
})();