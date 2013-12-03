// //page transitions
// (function() {
// 	$("body").css("display", "none");
// 	$("body").fadeIn('slow');
// 	$("a").click(function(e) {
// 		if ($(this).attr('href').length > 0) {
// 			e.preventDefault();
// 			var ref = this.href;
// 			$("body").fadeOut('slow', function() {
// 				window.location = ref;
// 			});
// 		}
// 	});
// })();
//modals
$(document).on('click', '#login', function(){
				$('#login-modal').modal('show');
			});
			$(document).on('click', '#register', function(){
				$('#register-modal').modal('show');
			});
			$(document).on('click', '#recover', function(){
				$('#recover-modal').modal('show');
			});
			$(document).on('click', '#contact', function(){
				$('#contact-modal').modal('show');
			});