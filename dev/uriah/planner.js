//Infinity-Forum.org 2013
function Planner(wrapper){
	//call with 0 to avoid constructor
	if(wrapper != 0){
		//setup the environment
		var environment, options, data;
		//main user options
		data = ['New circle', 'New ellipse', 'New rectangle', 'Add level'];
		//create a button for each of the above options
		for(var i = 0; i <= data.length; ++i){
			var this_id = data[i].split(' '); //create an id out of the option name
			//build a list
			options += '<li id="Planner_' + this_id[0].lowerCase() '-' + this_id[1] + '">' + data[i] + '</li>';
		}
		//environment consists of an option bar and main area
		environment = '<div id="Planner_option-bar"><ul>' + options + '</ul></div>';
		environment += '<div id="Planner_stage"></div>';
		$(wrapper).html(environment); //stick the environment into the given area
	}
}
//hold all recent states of the Planner
Planner.recentStates = []; 
Planner.maxStates = 20; //How many states will we save?
Planner.pointer = null; //which state are we on?
Planner.planType = 'Tree'; //what type of Plan is this?
//stick this into the undo array (recentStates)
Planner.prototype.addState = function(id, txt, add){
	//only save max states
	if(Planner.recentStates.length >= Planner.maxStates) Planner.recentStates.shift(); //remove oldest state
	Planner.recentStates.push(Planner.minimalize(id, txt, add)); //save min data of element
	if(Planner.pointer === null) Planner.pointer = 0; //set pointer to first element
	else ++Planner.pointer; //move pointer forward
}
//restoring other states
Planner.prototype.undo = function(){
	//make sure we arent on the first element
	if(Planner.pointer != Planner.recentStates[0]){
		Planner.mergeState(Planner.recentStates[Planner.pointer - 1]); //get the html of the most recent state
		--Planner.pointer; //move pointer to new state, back one
	}
}
Planner.prototype.redo = function(){
	//make sure that we are not already on the last element
	if(Planner.pointer != Planner.recentStates[Planner.recentStates.length - 1]){
		Planner.mergeState(Planner.recentStates[Planner.pointer + 1]); //get the html of the state after the current one
		++Planner.pointer; //we are now one state ahead
	}
}
//split elements into not-redundant component parts and return an object
Planner.prototype.minimalize = function(id, txt, add){
	return {
		id: id,
		txt: txt,
		add: add, //true for adding element, false for removing
		position: Planner.getLevelAndCol(id) //grab data from class name
	};
}
//actually merge the now expanded data into the DOM
Planner.prototype.mergeState = function(min){
	if(min.add === false) $('#' + min.id).remove(); //if we are removing from the planner
	else $('#Planner_planner-id').append(Planner.expand(min)); //append expanded the element. order does not matter
	Planner.cleanUp(); //re-connect everything
}
//expand a minimalized object into html
Planner.prototype.expand = function(min){
	return '<div id="' + min['id'] + '" class="pos_' + min.position[0] + '-' + min.position[1] + '">' + min.txt + '</div>';
}
//END
//what level and column is the element with the given id on?
Planner.prototype.getLevelAndCol = function(id){
	return $(id).attr('class').substring(4).split('-'); //Ex: pos_3-2 (level-column)
}
//Create a new Planner element
Planner.prototype.createElement = function(){

}
//Join two Elements together
Planner.prototype.joinElements = function(){

}
//Clean up things by correctly connecting them
Planner.prototype.cleanUp = function(){

}
//Add another layer to add more room for elements
Planner.prototype.newLevel = function(){

}
//make an element switch places with another element
Planner.prototype.moveElement = function(){

}
//Delete a Planner element
Planner.prototype.deleteElements = function(){

}
//delete a level
Planner.prototype.deleteLevel = function(){

}
//produce the start of that type of plan
Planner.prototype.startPlan = function(){

}
//change the shape of a Planner element
Planner.prototype.changeShape = function(){

}
//resize Planner divs to fit inside of given area
Planner.prototype.resize = function(){

}
//save the planner in ajax exportable format
Planner.prototype.savePlan = function(){

}
//click handlers required
$(document).ready(function(){

});