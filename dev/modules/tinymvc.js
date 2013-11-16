"use strict";
var propFromArray = function(props, to) {
	var obj = Model.data;
	for (var i = 0; i < props.length - 1; ++i) { //minus one so we work with property alone
		obj = obj[props[i]];
	}
	if (to === false) return obj[props[props.length - 1]]; //just return property
	obj[props[props.length - 1]] = to; //change by reference
}
var Model = (function() {
	return {
		lastChanged: null,
		//initialize Model
		create: function(data) {
			this.data = data;
		},
		get: function(what) { //get something from Model, use of '-' for next obj allowed
			return propFromArray(what.split('-'), false);
		},
		//add an element to the Model wihout calling view
		add: function(what, value) {
			propFromArray(what, value);
		},
		//change an element in the Model (add and call view if non-existant)
		modify: function(what, value) {
			propFromArray(what, value);
			Model.lastChanged = what.join('-');
			View.notify();
		},
		//get the Model obj
		retrieve: function() {
			return this.data;
		}
	};
})();
var View = (function() {
	return {
		create: function(func, max) {
			this.func = func;
			this.max = max || 20; //amount of states to store
		},
		states: {},
		//call user defined func with changed in Model and value of changed
		notify: function() {
			var c = Model.lastChanged;
			//parse last changed to get true value from -'s
			var value = c.split('-');
			value = propFromArray(value, false);
			//save the states key to value
			if (this.states[c]) this.states[c].push(value);
			else this.states[c] = [value];
			//dont save too many states
			if (this.states[c].length > this.max) this.states[c].shift();
			//call user supplied function
			var thiz = this;
			this.func(c, value, function(index) {
				//get recent states with +|- index
				if (typeof index === 'undefined') return thiz.states[c];
				if (index < 0) index += thiz.states[c].length;
				return thiz.states[c][index];
			}, Model.data);
		}
	};
})();
var Controller = (function() {
	return {
		create: function(func) {
			func(Model.data);
		}
	};
})();
var Router = (function() {
	return {
		//define object with key for path and value for function
		create: function(paths) {
			this.paths = paths;
		},
		//change URL and do something after
		goTo: function(param) {
			window.history.pushState({state: param}, param, param);
			if (this.paths && this.paths[param]) {
				//run user defined function for this path
				this.paths[param]();
			}
		}
	};
})();