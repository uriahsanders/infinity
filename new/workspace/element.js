$(function() {
	var hash = location.hash.split('/');
	var project = hash[0] + '/' + hash[1];
	var branch = hash[2];
	var elementID = hash[4];
	//let server know this element is being actively edited
	//and check for it as well
	$.ajax({
		type: 'POST',
		url: 'script.php',
		data: {
			signal: 'activeEdit',
			project: project,
			branch: branch,
			elementID: elementID
		},
		success: function(res) {
			if (res.length > 0) { //res is array of people editing element atm
				//show edit warning message:
				//user should either create a new version or
				//join team member's session to avoid conflicts
			}
		}
	});
	//load element from URL
	$.ajax({
		type: 'GET',
		url: 'script.php',
		data: {
			signal: 'editOne',
			project: project,
			branch: branch,
			elementID: elementID
		},
		success: function(res) { //res is element as html

		}
	});
	//update onclick
	$(document).on('click', '#update', function() {
		$.ajax({
			type: 'POST',
			url: 'script.php',
			data: {
				signal: 'update',
				form: $('#form').serialize(),
				project: project,
				branch: branch,
				elementID: elementID
			}
		});
	});
	window.onbeforeunload = function(e) {
		//remove user from edit list
		$.ajax({
			type: 'POST',
			url: 'script.php',
			data: {
				signal: 'leaveEdit',
				project: project,
				branch: branch,
				elementID: elementID
			}
		});
	};
});