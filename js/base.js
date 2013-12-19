$(function() {
	//use proper stylesheet and css option
	if (localStorage.css) {
		$('link[href^="css/"]').attr('href', 'css/' + localStorage.css + '.css');
		handle_cssModify();
	}
	//modals
	$(document).on('click', '#login', function() {
		$('#login-modal').modal('show');
	});
	$(document).on('click', '#register', function() {
		$('#register-modal').modal('show');
	});
	$(document).on('click', '#recover', function() {
		$('#recover-modal').modal('show');
	});
	$(document).on('click', '#contact', function() {
		$('#contact-modal').modal('show');
	});
	$(document).on('click', '#darkcss', function() {
		$('link[href="css/white.css"]').attr('href', 'css/dark.css');
		localStorage.css = 'dark';
		handle_cssModify();
	});
	$(document).on('click', '#whitecss', function() {
		$('link[href="css/dark.css"]').attr('href', 'css/white.css');
		localStorage.css = 'white';
		handle_cssModify();
	});
	//scroll to top
	$(window).scroll(function() {
		if ($(window).scrollTop() === 0) $('#scrollup').fadeOut();
		else $('#scrollup').fadeIn();
	});
	$('#totop').click(function() {
		$('html,body').animate({
			scrollTop: $(this.hash).offset().top
		}, 1000);
		return false;
	});
	//change search bar criteria on cat click
	$(document).on('click', 'li[id^="search-"]', function(){
		changeSearch(cFirst('u', $(this).attr('id').substring(7)) + '...');
	});
	//stuff that depends on current page
	(function() {
		//what page are we on?
		var page = $('#base_current_page').val() || 'Projects';
		//change search bar criteria based on page
		changeSearch(cFirst('u', page) + '...');
	})();

	function handle_cssModify() {
		$('#orgcss').removeClass(localStorage.css === 'white' ? 'black' : 'white');
		$('#orgcss').addClass(localStorage.css === 'dark' ? 'black' : 'white');
	}
	//modify search criteria
	function changeSearch(change) {
		$('#search').attr('placeholder', change);
	}
	//capitalize or lowercase first letter
	function cFirst(type, str) {
		return str.charAt(0)[(type === 'l') ? 'toLowerCase' : 'toUpperCase']() + str.substring(1);
	}
});