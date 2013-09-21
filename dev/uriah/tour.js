//Infinity-forum.org 2013
/*
 *USAGE (new tour boxes appear in the order they are listed):
 *var myTour = new Tour();
 *myTour.newTourElement('#main', 'click here to get help with something', 'right', 'color:red;'); //thats (idOrClass, message, arrowPosition, styling)
 *myTour.init();
 *
 *wrap in ajax function to determine whether its the users first time on the page.
 *"elements" are what i will call each tour div
 */
//begin by dimming the screen and initiating vars
"use strict"; //lets not be evil, eh?
function Tour(construct) {
    construct = (typeof(construct) === 'undefined') ? 1 : 0;
    //if Tour is being called to do more than just access properties/methods: 
    if (construct != 0) {
        $('<div id="tour_dim_screen"></div>').appendTo(document.body).hide().fadeIn(); //dim the screen
        //next and previous buttons
        this.buttonNextTour = '&nbsp; <button class="next-tour-element">Next</button>'; 
        this.buttonPreviousTour = '&nbsp; <button class="previous-tour-element">Previous</button>';
    }
}
Tour.count = 0; //number of tour elements
Tour.selector = 0; //the number of the tour element that is currently being displayed
//start the tour (will use the last elements provided to Tour instance)
Tour.prototype.init = function() {
    this.fadeRelevant(); //fade in the first div
    //doing some cleaning up:
    $('.tour_div0 .previous-tour-element').remove(); //remove the "previous" button from the first element
    $('.tour_div' + (Tour.count - 1) + ' .next-tour-element').remove(); //remove the "next" button from the last element
}
//fade out everything but what is being requested
Tour.prototype.fadeRelevant = function() {
    $('div[class^=tour_div]').fadeOut(); //fade out all tour elements if any are displayed
    $('.tour_div' + Tour.selector).fadeIn(); //fade in the selected element
}
//fade out everything (elements are recoverable)
Tour.prototype.endTour = function() {
    $('div[class^=tour_div], #tour_dim_screen').fadeOut();
}
//reset the selected element and restart the tour
Tour.prototype.resumeTour = function() {
    Tour.selector = 0;
    $('#tour_dim_screen').fadeIn();
    this.fadeRelevant(); //fade in first element
}
//remove all the tour data from the DOM (irrecoverable)
Tour.prototype.removeAllElements = function() {
    $('div[class^=tour_div], #tour_dim_screen').remove();
}
//create a new element and append it to the DOM, after the chosed id
Tour.prototype.newTourElement = function(element, txt, arrow, style) {
    arrow = (arrow === 'undefined') ? 'none' : arrow; //if an arrow arg isnt supplied dont add one
    style = (style === 'undefined') ? '' : style; //if a style isnt defined leave style="" alone
    //add a tour div with the correct data directly after the id or class given as an argument
    //specifically: 1.Number the element, 2.Set arrow direction, 3.Add styling, 4.Input the text, 5.Add the buttons
    $(element).after('<div class="tour_div' + Tour.count + ' tour_arrow-' + arrow + '" style="' + style + '">' + txt + '<br /><br />' +
        this.buttonNextTour + this.buttonPreviousTour +
        '&nbsp; <button class="finish-tour">Finish</button></div>');
    Tour.count += 1; //up the count so we know we just added one more element
}
//go to the next tour element
Tour.prototype.nextTourElement = function() {
    Tour.selector +=1; //select the next element
    this.fadeRelevant(); //fade out everything but the newly selected tour element
}
//go to previous tour element
Tour.prototype.previousTourElement = function() {
    Tour.selector -= 1; //select the previous element
    this.fadeRelevant(); //fade out everything but the newly selected tour element
}
//adding some click handlers for the tour buttons
$(document).ready(function() {
    var myTour = new Tour(0); //0 as argument so we can use functions without starting anything
    //finish the tour (all elements can be revover with resumeTour())
    $(document).on('mousedown', '.finish-tour', function() {
        myTour.endTour();
    });
    //next element button
    $(document).on('mousedown', '.next-tour-element', function() {
        myTour.nextTourElement();
    });
    //last element button
    $(document).on('mousedown', '.previous-tour-element', function() {
        myTour.previousTourElement();
    });
});