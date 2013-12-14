// Holds functions for displaying information in a certain way
var Formjs = Formjs || (function() {
	var Formjs = function(o) {
		this.id = o.id || '';
		this.form = '<div class="text-center"id="' + o.id + '">';
		//icon
		if (o.icon) {
			this.form += '<i class="fa ' + o.icon + ' fa-3x';
			if (o.iconColor) this.form += ' ' + o.iconColor;
			this.form += '"></i><br>';
		}
		//title
		if (o.title) this.form += '<span class="lead">' + o.title + '</span><br>';
		//body
		if (o.body) this.form += '<small>' + o.body + '</small><br><br>';
		//button
		if (o.button) this.form += o.button;
		this.form += '</div>'; //close wrapper
	};
	//get form html
	Formjs.prototype.get = function() {
		return this.form;
	};
	//display inline
	Formjs.prototype.show = function(appendTo) {
		$(appendTo).append(this.form);
	};
	//show in modal
	Formjs.prototype.popup = function() {
		$(['<div id="' + this.id + '-modal"class="modal fade">',
			'<br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <div class="modal-dialog">',
			'<div class="modal-content"><div class="modal-header">',
			'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>',
			'</div><div class="modal-body">',
			this.form
		].join('')).appendTo(document.body);
		$('#' + this.id + '-modal').modal('show');
	};
	return Formjs;
})();
/*
	Example:
	var form = new Formjs({
		title: 'title',
		body: 'body',
		icon: 'fa-play-circle',
		iconColor: 'red',
		button: '<button class="btn btn-primary">Do Something</button>'
	});
	form.popup();
*/