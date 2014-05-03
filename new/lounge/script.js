(function() {
	window.onhashchange = hash_ajax;
	hash_ajax();

	function listPms(sent, callback) {
		$.ajax({
			type: 'GET',
			url: 'script.php',
			data: {
				signal: 'list-pms',
				sent: sent,
			},
			success: function(res) {
				$('#lounge-main').html(res);
				$("#pm-to").tagit({
					autocomplete: {
						source: 'auto.php',
						minLength: 1
					}
				});
				callback();
			}
		});
	}

	function hash_ajax() {
		var hash = window.location.hash;
		switch (hash) {
			case '#!/pm':
				listPms(false);
				break;
			case '#!/settings':
				$.ajax({
					type: 'GET',
					url: 'settings.php',
					success: function(res) {
						$('#lounge-main').html(res);
					}
				});
				break;
			case '#!/suggestions':
				$.ajax({
					type: 'GET',
					url: 'suggestions.php',
					success: function(res) {
						$('#lounge-main').html(res);
					}
				});
				break;
			case '#!/members':
				$.ajax({
					type: 'GET',
					url: 'members.php',
					success: function(res) {
						$('#lounge-main').html(res);
					}
				});
				break;
			default:
				$.ajax({
					type: 'GET',
					url: 'main.php',
					success: function(res) {
						$('#lounge-main').html(res);
					}
				});
		}
	}
	$(function() {
		$(document).on('click', '[id^="action-dismiss-"]', function() {
			var id = $(this).attr('id').substring(15);
			$.ajax({
				type: 'POST',
				url: 'script.php',
				data: {
					id: id,
					signal: 'dismiss-action'
				},
				success: function(res) {
					$('#action-panel-' + id).fadeOut();
				}
			});
		});
		$(document).on('click', '#pm-init-send', function() {
			if (!$('#epicedit-pm-body iframe').length) epicEdit('epicedit-pm-body', 'epic-pm-body');
			$('#pm-form').slideToggle('slow');
		});
		$(document).on('click', '#pm-recieved', function(){
			$('#lounge-main').fadeOut('normal', function(){
				listPms(false, function(){
					$('#lounge-main').fadeIn();
				});
			});
		});
		$(document).on('click', '#pm-sent', function(){
			$('#lounge-main').fadeOut('normal', function(){
				listPms(true, function(){
					$('#lounge-main').fadeIn();
				});
			});
		});
	});
})();