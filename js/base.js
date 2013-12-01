//page transitions
$("body").css("display", "none");
$("body").fadeIn('slow');
$("a.truelink").click(function(e) {
	e.preventDefault();
	var ref = this.href;
	$("body").fadeOut('slow', function(){
		window.location = ref;
	});
});