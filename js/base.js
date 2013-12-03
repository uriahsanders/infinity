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