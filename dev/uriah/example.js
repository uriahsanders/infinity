/*
	Hi all. Here's a nice little tutorial on how
	I think we should format JS code for infinity
	its not very strict at all or anything, just a general layout
	ensures use of OOP
*/


////////////////////////////////////////////////////////////////////////////////
/*HELPER SCRIPTS*/
//"helper scripts", like Tour, SVGGraph, etc. should follow this format:
//use autorun function for namespacing
var helper = helper || (function($, ...){ // || is so you dont overwrite more important variables on the main page
	"use strict"; //always put use strict within function, so it doesnt fuck up file concatenation
	//here, you have 2 choices
	//If you need to declare multiple instances use prototypes
	//Else just return an object of functions

	//prototype you should already know, just use it like normal but make sure
	//you return your constructor function at the end

	//otherwise have a public and private object, return the public one at the end like:
	var Public = {}; //ofc you can do the same thing in slightly different ways
	var Private = {}; //Dont return this!
	Public.doSomething = function(){

	}; //semicolon always!
	return Public;

})(jQuery, ...); //dont forget your semicolons; if you dont have them file concatenation can break
//pass definite variables in as parameters so you can safely use shorthands
////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////////
/*MVC FOR MAIN PAGES (We'll be using a Forum as an example)*/
//Main application pages (Workspace, Forum, Profile, etc.) should use an MVC format
//MVC stands for Model, View, Controller
//It is useful because it lets you control your application using pure data
//this makes it easy to keep track of the state of your program
//and send information to the server
//and its just easier to use, once you get started

//What I do: (normally you use a framework for this, but i invented my own method :D)
//make a seperate var for each part:
var Model = (function(){
	"use strict"; //please always use strict...
	//so, the model is where your data is all stored
	//whenever something changes here, you let the View know it was changed
	//when the view is notified it changes the UI accordingly
	//changes to the Model are made by the Controller
	return {
		//return all your data along with functions for Controller
		//to modify it. Everything is Public
		modify: function(what, to){
			//modify a Model entry, then tell the View it happened
			//and what was changed
			//ofc there are different ways to do everything
			//this is just a basic skeleton
			this[what] = value; //change data
			//now notify the View
			View.changed = what; //tell view our most recent change
			View.notify(); //we just pushed (see View for function def.)
			console.log('(Model): -modified: Model.' + what); //lots of logging helps me debug :)
		},
		//you might have some more elaborate ways to modify data
		//when your done, continue on to list defaults of your data vars
		//heres some example data since we're using Forum example (NO FUNCTIONS)
		scriptFile: 'forum_script.php',
		page: 'Forum',
		currentThread: null,
		branch: 'Master',
		filter: [],
		num_results: null,
		categories: ['general', 'food', 'fun', 'coding', ...]
	}; //now that its returned every function can use Model data/functions
})();
var View = (function(){
	"use strict";
	//listens for changes in the Model, and changes the UI accordingly
	//only implements functions defined in the main function (see the bottom)
	//DOES NOT DEFINE FUNCTIONS OTHER THAN notify()
	//everything is public:
	return {
		changed: null, //last changed var in Model
		notify: function(){
			var changed = this.changed; //shorthand it
			//tell the View that something was changed
			switch(this.changed){
				//do something different depending on what was changed
				//in the Model. For example:
				case 'thread':
					//since we're going with the Forum example
					//below Forum holds main functions
					Forum.changeThread(Model.changed); //pass in new value
					break;
				//and so on for each possible change you want to account for
			}
		}
	};
})();
var Controller = (function($){
	"use strict";
	//Listens for events in the View (UI), and changes information
	//in the Model whenever it catches something
	$(document).ready(function(){
		//listen for events...
		//example: Modify currentThread var in Model when change thread button is clicked
		$(document).on('click', 'button[id="changeThread"]', function(){
			Model.modify('currentThread', toSomething); //and thats it!
		});
		//continue to listen for events...
	});
})(jQuery);
//now, have a main function that holds functions to use in the View
//so, if this page was the forum:
var Forum = (function(){ //you can do whatever you want in here, prototype or return an object. Just make it OOP
	"use strict";
	//functions for use in View...
	//continuing with forum example from above:
	var Public = {};
	var Private = {};
	Public.changeThread = function(to){
		//do something to change the thread
	};
	//finish defining functions... :)
	return Public;
})();
//And thats all, folks
//////////////////////////////////////////////////////////////////////////////////////////////////