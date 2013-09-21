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
Planner.maxStates = 10; //How many states will we save?
Planner.pointer = null; //which state are we on?
Planner.planType = 'Tree'; //what type of Plan is this?
/*NOTE: undo/redo is extremely verbose, minimalize ASAP*/
//stick this into the undo array (recentStates)
Planner.prototype.addState = function(){
	//only save max states
	if(Planner.recentStates.length >= Planner.maxStates) Planner.recentStates.shift(); //remove oldest state
	Planner.recentStates.push($('#Planner_planner-id').html()); //save html of current state
	if(Planner.pointer === null) Planner.pointer = 0; //set pointer to first element
	else ++Planner.pointer; //move pointer forward
}
//restoring other states
Planner.prototype.undo = function(){
	//make sure we arent on the first element
	if(Planner.pointer != Planner.recentStates[0]){
		$('#Planner_planner-id').html(Planner.recentStates[Planner.pointer - 1]); //get the html of the most recent state
		--Planner.pointer; //move pointer to new state
	}
}
Planner.prototype.redo = function(){
	//make sure there we are not already on the last element
	if(Planner.pointer != Planner.recentStates[Planner.recentStates.length - 1]){
		$('#Planner_planner-id').html(Planner.recentStates[Planner.pointer + 1]); //get the html of the state after the current one
		++Planner.pointer; 
	}
}
//END
//Create a new Planner element
Planner.prototype.createElement = function(){

}
//Join two Elements together
Planner.prototype.joinElements = function(){

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