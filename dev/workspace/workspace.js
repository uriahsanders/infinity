//ELEMENTS
var Element = (function(){
	var Element = function(){
		console.log('I am an element');
	};
	Element.prototype.hi = function(){
		console.log('Hi from JUST an element');
	};
	return Element;
})();
var Document = (function(){ //extends Element
	var Document = function(){
		Element.call(this);
		console.log("I am also a document");
	};
	Document.prototype = Object.create(Element.prototype);
	Document.prototype.constructor = Document;
	Document.prototype.hi = function(){
		console.log('Hi from document');
	};
	return Document;
})();
//continue for each type of element...
//END
//FUNCTIONS
var Workspace = (function(){
	//define functions for use in View
	var Public, Private = {};
	Private.ajax = {
		//standard functions for server communication
	};
	//let's make add an object to Public for each major feature
	Public.boards = { //EX:
		create: function(){

		}
	};
	return Public;
})();
//END
//MVC
var Model = (function(){
	//all data: notify view when stuff changes
	return {
		//everything is public

	};
})();
var View = (function(){
	//UI: change interface when model changes (calls, but does not define functions)
	var Public, Private = {};
	Public.changed = null;
	Public.notify = function(){
		switch(Public.changed){
			//main view stuff: depending on what changed, do something
		}
	};
	return Public;
})();
var Controller = (function(){
	//click handlers: Modify Model
	return {
		//everything is public
		init: function(){
			//start listening for changes
		},
		modify: function(what, value){
			//change data
			Model[what] = value;
			//notify view
			View.changed = what; //tell view our most recent change
			View.notify(); //we just pushed
		}
	};
})();
//END
//START
Controller.init();