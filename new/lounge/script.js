(function() {
	window.onhashchange = hash_ajax;
	hash_ajax();
	function hash_ajax() {
		var hash = window.location.hash;
		switch (hash) {
			case '#!/pm':
				$.ajax({
					type: 'GET',
					url: 'pm.php',
					data: {
						signal: 'list',
						sent: false,
					},
					success: function(res) {
						$('#lounge-main').html(res);
					}
				});
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
})();