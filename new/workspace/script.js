(function($) {
	//MODEL
	var model = {
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
		numResults: 0 //how many results do I currently have?
	};
	//CONTROLLER
	$(function() {
		//auto start loading before we add in content
		Workspace.loading();
		$(document).on('focus', '#workspace-search', function() {
			$(this).select();
		});
		$(document).on('mouseup', '#workspace-search', function(e) {
			e.preventDefault();
		});
		$('#workspace-ctx').dropDown();
		$('#workspace-discover-category').dropDown();
		$('#workspace-discover-by').dropDown();
	});
	//ROUTER
	Router.create(function(hash, count) {
		var hash = hash.split('/'); //split hash into seperate components
		if (hash[0] === 'discover' || hash[0] == false) {
			//see projects
			var category = $('#workspace-discover-category').data('val');
			var by = $('#workspace-discover-by').data('val');
			Workspace.showProjects(category, by);
		}
		
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
		return {
			//show load screen for ajax
			loading: function() {
				$('#workspace-main').html('<div id="workspace-loading"> <br><br><br><br><br> <i class="fa fa-spinner fa-spin"style="font-size:15em;color:grey"></i> <br><br> <span style="font-size:2em">Loading...</span> </div>');
			},
			showProjects: function(category, by){
				ajax('GET', {
					signal: 'showProjects',
					category: category,
					by: by
				}, function(res){
					$('#workspace-main').html(res);
				});
			}
		}
	})();
})(jQuery);