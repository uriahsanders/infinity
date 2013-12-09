$(function() {
	//page transitions
	// $("body").css("display", "none");
	// $("body").fadeIn('slow');
	// $("a").click(function(e) {
	// 	if ($(this).attr('href').length > 0) {
	// 		e.preventDefault();
	// 		var ref = this.href;
	// 		$("body").fadeOut('slow', function() {
	// 			window.location = ref;
	// 		});
	// 	}
	// });
	//use proper stylesheet and css option
	if(localStorage.css){
		$('link[href^="css/"]').attr('href', 'css/'+localStorage.css+'.css');
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
	$(document).on('click', '#darkcss', function(){
		$('link[href="css/white.css"]').attr('href', 'css/dark.css');
		localStorage.css = 'dark';
		handle_cssModify();
	});
	$(document).on('click', '#whitecss', function(){
		$('link[href="css/dark.css"]').attr('href', 'css/white.css');
		localStorage.css = 'white';
		handle_cssModify();
	});
	function handle_cssModify(){
		$('#orgcss').removeClass(localStorage.css === 'white' ? 'black' : 'white');
		$('#orgcss').addClass(localStorage.css === 'dark' ? 'black' : 'white');
	}
	/*
	Okay, now for persistent forms
	which will show an unobtrusive form for chosen content
	at the bottom of the page,
	with data stored on session (JS)
	so the form stays up when you switch pages.
	Multiple forms can be active at once
	*/
	$(document).on('click', '.psform-btn', function(){
		var form = new PersistentForm($(this).data('psform-html'));
		form.connect();
		PersistentForm.show();
	});
});