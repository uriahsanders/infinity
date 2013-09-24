//infinity-forum.org 2013
/*
    Style: modified singleton module pattern
    Ensures you dont overwrite variables, saves the namespace, and allows for public/private
    I always stick the public stuff in an object with the same name as the function
    Return only the public object for public use, all else is private
*/
/*
    -Tiny script to produce a simple page introduction
    Example:
    Tour.createElement({
        attachTo: '#main',
        txt: 'My first tour!',
        arrowDir: 'left',
        style: 'color:red'
    });
    Tour.init({
        page: 'workspace',
        localstorage: true
    });
*/
"use strict"; //lets not be evil, eh?
//dont overwrite if Tour variable already exists
var Tour = Tour || (function($){
    //CLICK-HANDLERS
    $(document).ready(function() {
        //finish the tour (all elements can be revover with resumeTour())
        $(document).on('mousedown', '.finish-tour', function() {
            Private.endTour();
        });
        //next element button
        $(document).on('mousedown', '.next-tour-element', function() {
            Private.goTo('next');
        });
        //last element button
        $(document).on('mousedown', '.previous-tour-element', function() {
            Private.goTo('previous');
        });
    });
    //END CLICK-HANDLERS
    //i like declaring the object name explicitly for less brace tracking
    var Tour = {}; //main object, public data
    var Private = {}; //stuff i only want access in here; will not return
    //PROPERTIES
    //private:
    Private.button_nextElement = '&nbsp; <button class="next-tour-element">Next</button>';
    Private.button_previousElement  = '&nbsp; <button class="previous-tour-element">Previous</button>';
    Private.count = 0; //number of tour elements
    Private.selector = 0; //the number of the tour element that is currently being displayed
    //END PROPERTIES
    //METHODS
    //public:
    Tour.init = function(options){ //actually start the tour
        var options = options || {};
        var pageSet = (typeof options.page === 'undefined') ? false : true; //is the page var defined?
        if(pageSet) var pageVisited = options.page + 'HasBeenVisited'; //create a unique localstorage variable for this page
        //start tour if page has not been visited/set or if localStorage is being ignored
        if(typeof localStorage[pageVisited] === 'undefined' || options.localstorage !== true || !pageSet){
            Private.fadeRelevant(); //fade in the first element
            //do some cleaning up:
            $('.tour_div0 .previous-tour-element').remove(); //remove the "previous" button from the first element
            $('.tour_div' + (Tour.count - 1) + ' .next-tour-element').remove(); //remove the "next" button from the last element
        }
        //set page visited to true if we are not ignoring localStorage and the page hasnt been visited
        if(options.localstorage === true && typeof localStorage[pageVisited] === 'undefined'){
            localStorage[pageVisited] = true;
        }
    };
    Tour.createElement = function(options){ //add a new hidden element to the DOM
        //all options are...well...optional
        var element = options.attachTo || document.body; //use document body if attach is not set 
        //...and so on:
        var txt = options.txt || '';
        var arrow = options.arrowDir || 'none';
        var style = options.style || '';
        //specifically: 1.Number the element, 2.Set arrow direction, 3.Add styling, 4.Input the text, 5.Add the buttons
        $(element).after('<div class="tour_div' + Private.count + ' tour_arrow-' + arrow + '" style="' + style + '">' + txt + '<br /><br />' +
            Private.button_nextElement + Private.button_previousElement  +
            '&nbsp; <button class="finish-tour">Finish</button></div>');
        ++Private.count; //up the count so we know we just added one more element
    };
    Tour.resumeTour = function(){ //restart a tour
        Private.selector = 0;
        $('#tour_dim_screen').fadeIn();
        Private.fadeRelevant(); //fade in first element
    };
    Tour.removeAllElements = function(){ //actually remove all elements from the DOM for good
        $('div[class^=tour_div], #tour_dim_screen').remove();
    };
    //private:
    Private.fadeRelevant = function(){ //only what matters :)
        $('div[class^=tour_div]').fadeOut(); //fade out all tour elements if any are displayed
        $('.tour_div' + Private.selector).fadeIn(); //fade in the selected element
    };
    Private.goTo = function(dir){ //go to next or previous element
        if(dir === 'previous') --Private.selector; //move selector to appropriate position
        else ++Private.selector;
        Private.fadeRelevant(); //fade in proper items
    }
    Private.endTour = function(){ //fade out but dont remove all Tour stuff
        $('div[class^=tour_div], #tour_dim_screen').fadeOut();
    };
    //END METHODS
    return Tour; //make the main object public
}).call(this, jQuery); //allow $ use within function