if (propFromArray) console.log("tinymvc requesting 'modifyPropFromArray' variable to be cleared for its use.");
else {
	var propFromArray = function(props, to) {
		var obj = Model.data;
		for (var i = 0; i < props.length - 1; ++i) {
			obj = obj[props[i]];
		}
		if (to === false) return obj[props[props.length - 1]]; //jsut return property
		obj[props[props.length - 1]] = to; //its an object so pass by reference and change
	}
}
var Model = (function() {
	"use strict";
	return {
		//initialize Model
		create: function(data) {
			//add Model data
			this.data = data;
		},
		//add an element to the Model wihout calling view
		add: function(what, value) {
			propFromArray(what, value);
		},
		lastChanged: null,
		//change an element in the Model (add and call view if non-existant)
		modify: function(what, value) {
			propFromArray(what, value);
			//notify view
			Model.lastChanged = what.join('-'); //tell view our most recent change
			View.notify(); //we just pushed
		},
		//get the Model as stringified JSON
		retrieve: function() {
			return this.data;
		}
	};
})();
var View = (function() {
	"use strict";
	return {
		//call user defined func with changed in Model and value of changed
		create: function(func) {
			this.func = func;
		},
		//call user defined func with changed in Model and value of changed
		notify: function() {
			var c = Model.lastChanged;
			//parse last changed to get value from -'s
			var value = c.split('-');
			value = propFromArray(value, false);
			this.func(c, value);
		}
	};
})();
var Controller = (function($) {
	"use strict";
	return {
		create: function(func) {
			$(function() {
				//one day this will actually be useful :P
				func();
			});
		}
	};
})(jQuery);