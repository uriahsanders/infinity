//Module for creating SVG graphs quickly and easily (HIGHLY flexible, everything is optional/changeable)
/*
	Stuff it can do:
	Create graphs of different types,
	store any graph as JSON,
	expand JSON into a graph,
	update a graph

	Coming soon:
	being able to define styles in object,
	bar graph, pie graph, and area graph,
	animations on hover (show data under mouse),
	have the graph draw itself into existence with animation at desired speed
*/
var Graph = Graph || (function($) {
	var Private = {};
	Private.count = 0;
	var Graph = function(obj) {
		this.setOptions(obj);
		++Private.count;
	};
	Graph.prototype.defaults = function() {
		return {
			//default options
			x: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
			y: [10, 20, 30, 40, 50, 60, 70, 80],
			attachTo: 'body',
			points: [0, 26, 33, 74, 12, 49, 18]
		}
	};
	//important stuff you might want automatically
	Graph.prototype.basics = function(height, width, graphHeight, graphWidth) {
		//basically, if no graph height/width is given we just make it equal the svg height/width
		height = graphHeight || height || 300;
		width = graphWidth || width || 550;
		//make sure we can take substring
		height = height.toString();
		width = width.toString();
		//so we can let them use percentages
		Private.attachTo = Private.attachTo || 'body';
		var containerHeight = $(Private.attachTo).css('height');
		var containerWidth = $(Private.attachTo).css('width');
		//if its a percentage they probably mean fill the graph, so use it
		height = (height.substring(height.length - 1) === '%') ? containerHeight : height;
		width = (width.substring(width.length - 1) === '%') ? containerWidth : width;
		return {
			//if user inputed a % or px, chop it off with parseFloat
			Gheight: parseFloat(height),
			Gwidth: parseFloat(width),
			//Distances between lines
			xDist: 60,
			yDist: 30,
			//leave space for labels:
			xOffset: 25,
			yOffset: 20,
			mainOffset: 35, //to seperate everything from the ylabels
			padding: 10, //keep labels from touching edges
			//points
			xOfPoints: [], //get x and y coordinates of points
			yOfPoints: [],
			grid: true,
			noLines: false,
			id: 'SVGGraph' + Private.count
		}
	};
	//create jquery css header
	Graph.prototype.parseS = function(id, then) {
		return 'svg[id="' + id + '"] ' + then;
	};
	Graph.prototype.styles = function(height, width, id) {
		height = height || 300;
		width = width || 550;
		var styling = {};
		styling.style = {};
		styling.style[this.parseS(id, '')] = {
			"height": height,
			"width": width,
			"background": "url('/infinity/dev/images/broken_noise.png')"
		};
		styling.style[this.parseS(id, '.grid')] = {
			"stroke": "grey",
			"stroke-width": "1"
		};
		styling.style[this.parseS(id, '.points')] = {
			"stroke": "grey",
			"stroke-width": "4"
		};
		styling.style[this.parseS(id, '.inset')] = {
			"fill": "lightblue"
		};
		styling.style[this.parseS(id, '.labels')] = {
			"fill": "darkgrey",
			"stroke": "none",
			"font-family": "Arial",
			"font-size": "12px",
			"kerning": "2"
		};
		styling.style[this.parseS(id, '.lines')] = {
			"stroke": "lightblue",
			"stroke-width": "2"
		};
		styling.style[this.parseS(id, '.labels.x-labels')] = {
			"text-anchor": "middle"
		};
		styling.style[this.parseS(id, '.labels.y-labels')] = {
			"text-anchor": "end"
		};
		return styling;
	};
	//handle this.obj
	Graph.prototype.setOptions = function(obj) {
		obj = obj || {};
		if (obj.attachTo) {
			obj.attachTo = (obj.attachTo.charAt(0) === '#') ? obj.attachTo : '#' + obj.attachTo; //make hash optional
			Private.attachTo = obj.attachTo; //for basics(), which cant access this.obj.attachTo in time
		}
		if (obj.id) obj.id = (obj.id.charAt(0) === '#') ? obj.id.substring(1) : obj.id; //make hash optional
		//do basic setup automatically
		if (obj.basic === true || typeof obj.basic === 'undefined') {
			this.obj = this.basics(obj.height, obj.width, obj.graphHeight, obj.graphWidth);
		}
		//merge with defaults
		if ((obj && obj.example === true) || $.isEmptyObject(obj)) { //if example chosen or no options given
			obj.id = obj.id || this.obj.id;
			//everything user did not specify is filled with defaults + basics + style
			//style needs id passed in so it can be replaced from basics().id
			$.extend(this.obj, this.defaults(), this.styles(obj.height, obj.width, obj.id), obj);
			this.obj.addStyle = true;
		} else if (obj && obj.addStyle === true) { //only add styling
			$.extend(this.obj, this.styles(obj.height, obj.width), obj);
		} else if (obj) {
			this.obj = obj; //only use given args
		}
		console.log('this.obj = \n' + JSON.stringify(this.obj) + '\n'); //output JSON
	};
	Graph.prototype.save = function() { //save a graph as stringified JSON (can expand later)
		return JSON.stringify(this.obj);
	};
	Graph.prototype.expand = function(obj) { //expand JSON into a graph (requires 'type' property of 'obj')
		var obj = (typeof obj === 'string') ? jQuery.parseJSON(obj) : obj; //if in string form parse it
		var graph;
		switch (obj.type) {
			case 'linear':
				graph = new GraphLinear(obj);
				graph.init();
				break;
			default:
				console.log("(SVGGraph): Error, no graph type given; expansion could not complete.");
		}
	};
	Graph.prototype.update = function(obj) { //recall script file to update graph with new obj
		//reset options with new stuff
		this.setOptions(obj);
		//this.obj is now updated
		this.expand(this.obj); //recreate graph
	};
	Graph.prototype.help = function() { // show a popup with help information
		alert("Someday this will actually be helpful.");
	};
	return Graph;
})(jQuery);
var GraphLinear = GraphLinear || (function($) {
	var GraphLinear = function(obj) { //extends "Graph"
		Graph.call(this, obj);
		this.obj.type = 'linear';
	};
	GraphLinear.prototype = Object.create(Graph.prototype);
	GraphLinear.prototype.constructor = GraphLinear;
	GraphLinear.prototype.init = function(obj) {
		console.log("Linear graph initialized.");
		var self = this.obj; //shorthand from here on...
		//correct values (atm has user inputed version, whereas G... is clean)
		self.width = self.Gwidth;
		self.height = self.Gheight;
		var SVG = '<svg id="' + this.obj.id + '"class="graph">', //begin all groups
			xGrid = '<g class="grid x-grid" id="xGrid">',
			yGrid = '<g class="grid y-grid" id="yGrid">',
			points = '<g class="inset points">',
			xLabels = '<g class="labels x-labels">',
			yLabels = '<g class="labels y-labels">',
			lines = '<g class="lines">'; //connecting points
		//*remember: xLines are vertical, yLines are horizontal
		var xLines = self.x.length;
		var yLines = self.y.length + 1; //+1 because line 1 is at origin
		//make sure they want the grid
		if (self.grid === true && self.noLines === false) {
			//save final x of xlines so ylines dont pass that boundary
			//X-GRID LINES
			for (var i = 0; i < xLines; ++i) {
				//x1 and x2 must be the same (dist. from left), 
				//start at very top (y1 = 0), all the way to the bottom (y = height)
				var nxt = i * self.xDist + self.mainOffset;
				xGrid += '<line x1="' + nxt + '" x2="' + nxt + '" y1="' + (self.yOffset + self.padding) + '" y2="' + (self.height - self.yOffset - self.padding) + '"></line>';
				if (i === xLines - 1) var finalX = nxt;
			}
			//Y-GRID LINES
			for (var i = 1; i <= yLines; ++i) {
				//y1 and y2 must be the same (dist. from top),
				//ALL x1's & x2's must be the same so we start at same dist. from left & right
				var nxt = (self.height) - i * (self.yDist); 
				//finalX need not be added to mainoffset because nxt already accounts for it mathematically
				yGrid += '<line x1="' + self.mainOffset + '" x2="' + (finalX) + '" y1="' + nxt + '" y2="' + nxt + '"></line>';
			}
		}else{
			//leave the first vert. and horiz. line for them for obvious styling purposes
			//they still have the option to remove this with noLines
			if(self.noLines === false){
				xGrid += '<line x1="' + self.mainOffset + '" x2="' + self.mainOffset + '" y1="' + (self.yOffset + self.padding) + '" y2="' + (self.height - self.yOffset - self.padding) + '"></line>';
				yGrid += '<line x1="' + self.mainOffset + '" x2="' + ((xLines - 1) * self.xDist + self.mainOffset) + '" y1="' + (self.height - self.yDist) + '" y2="' + (self.height - self.yDist) + '"></line>';
			}
		}
		//POINTS (INDIVIDUAL)
		for (var i = 0; i < self.x.length; ++i) { //7 for days in week
			//scale: every actual 30 should equal 10 in points (use yDist for if this changes)
			//so cy should = 30 when point = 10 and so on... (points[i]+10 just fixes the points to match the scale... 
			//i fucked up and everything is 10 off)
			var inc = self.height - ((self.points[i] + 10) * (self.yDist / 10)); //subtract from height to invert graph
			//set our x coor depending on i due to offset (first and last are special) :/;
			var x = i * self.xDist + self.mainOffset;
			points += '<circle cx="' + x + '" cy="' + inc + '" r="5"></circle>'; //cx is always on a vert. line
			//store coordinates so we can easily connect them with lines
			self.xOfPoints.push(x);
			self.yOfPoints.push(inc);
			//xLABELS
			xLabels += '<text x="' + x + '" y="' + (self.height - self.padding) + '">' + self.x[i] + '</text>';
		}
		//yLABELS
		for (var i = 1; i <= yLines; ++i) {
			var x = (i != 1) ? self.xOffset : self.xOffset - 10; //clean it up: move 1 digit numbers 1 place to the left
			//y subtracted from height to invert graph
			yLabels += '<text x="' + x + '" y="' + ((self.height - (self.yDist * i - self.padding)) - 5) + '">' + (i * 10 - 10) + '</text>';
		}
		//LINES
		for (var i = 0; i < self.points.length - 1; ++i) {
			var j = i + 1; //get next point coordinate
			//to connect two points: x1 = (x of first point), x2 = (x of second point),
			//y1 = (y of first point), y2 = (y of second point)
			lines += '<line x1="' + self.xOfPoints[i] + '" x2="' + self.xOfPoints[j] + '" y1="' + self.yOfPoints[i] + '" y2="' + self.yOfPoints[j] + '"></line>';
		}
		//COMBINING
		xGrid += '</g>', yGrid += '</g>', points += '</g>', lines += '</g>', xLabels += '</g>', yLabels += '</g>'; //close all tags
		SVG += xGrid + yGrid + points + lines + xLabels + yLabels + '</svg>'; //build html
		//build with strings 'cause DselfM is sooooo slow
		$(self.attachTo).append(SVG);
		//STYLING
		if (self.addStyle === true) {
			for (var i in self.style) {
				$(i).css(self.style[i]);
			}
		}
	};
	return GraphLinear;
})(jQuery);