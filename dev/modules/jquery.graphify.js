//UI for displaying SVGGraph.js graphs with all their functionality
(function($) {
	$.fn.graphify = $.fn.graphify || function(options, obj) { //extend jQuery
		options = options || {};
		obj = obj || {};
		//SETUP
		var opts = $.extend({
			height: this.css('height'),
			width: this.css('width'),
			start: 'GraphLinear', //type of graph to start with
			pos: 'top'
		}, options);
		var data = {
			types: ['linear', 'bar', 'table', 'area']
		};
		obj.height = opts.height;
		obj.width = opts.width;
		obj.attachTo = this.attr('id');
		//UI
		var buttons = (function() {
			var btns = '';
			for (var i = 0; i < data.types.length; ++i) {
				btns += '<button id="' + this.id + '-graphify-button-' + i + '" class="' + data.types[i] + '">' +
					data.types[i].charAt(0).toUpperCase() + data.types[i].substring(1) +
					'</button>&emsp;';
			}
			return btns;
		})();
		if (opts.pos === 'top') this.append(buttons + '<br/><br />');
		//Initiation
		var graph = new window[opts.start](obj);
		graph.init();
		if (opts.pos === 'bottom') this.append(buttons);
		//click handlers
		$(document).ready(function() {
			$(document).on('click', 'button[id^="' + this.id + '-graphify-button-"]', function() {
				var type = $(this).attr('class');
				if(obj.type !== type){ //dont repeat a chosen type
					if (type !== 'area') graph.to($(this).attr('class'));
					else { //area graphs are a subset of linear graphs...
						obj.special = 'area';
						graph.to('linear');
						graph.update(obj);
					}
				}
				obj.type = type;
			});
		});
	};
})(jQuery);