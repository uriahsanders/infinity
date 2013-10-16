//Module for creating SVG graphs quickly and easily
/*
	Example:
	var graph = new GraphLinear({ //all parameters are optional, will merge with defaults
		attachTo: '#wrapper',
		classes: ['graph', 'forum', 'SVG', ...],
		url: 'script.php',
		data: 'graph=forum&type=linear', //can also be an object
		lineColor: 'blue',
		interactive: true,
		pan: true,
		x: ['Mon', 'Tue', 'Wed', 'Thu', ...],
		y: [10, 20, 30, 40, ...],
		length: '400px',
		width: '500px'
	});
	var graph2 = new GraphLinear(); //no parameters so makes an example graph
	if(page === 'forum'){
		graph.init();
		setInterval(graph.update, 60000); //update graph every minute
	}else{
		graph2.init();
	}
	var object = graph2.save(); //store condensed form of graph that can be expanded
	//to expand an old graph:
	var graph3 = new Graph();
	graph3.expand({
		src: mySavedJSON,
		//other options
	});
	//for help:
	graph.help();
	//functions constructor, expand, and update can all be called with object for arguments (all the same)
*/
var Graph = Graph || (function($) {
	var Private = {};
	Private.defaults = function(height, width, graphHeight, graphWidth) { //used in multiple places so needs external ref.
		height = height || 300;
		width = width || 550;
		return {
			//default options
			x: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
			y: [10, 20, 30, 40, 50, 60, 70, 80],
			height: graphHeight || height, //if graph height is sepcified go with that, else fill container
			width:  graphWidth || width,
			attachTo: 'body',
			points: [2, 54, 12, 8, 5, 45, 32],
			defaultStyle: true, //add at least basic styling
			//Distances between lines
			xDist: 90,
			yDist: 30,
			//leave space for labels:
			xOffset: 25,
			yOffset: 20,
			padding: 7, //keep labels from touching edges
			//points
			xOfPoints: [], //get x and y coordinates of points
			yOfPoints: [],
			style: { //default styling
				"svg.graph": {
					"height": height + "px",
					"width": width + "px",
					"background": "url('/infinity/dev/images/broken_noise.png')"
				},
				"svg.graph .grid": {
					"stroke": "grey",
					"stroke-width": "1"
				},
				"svg.graph .points": {
					"stroke": "grey",
					"stroke-width": "4"
				},
				"svg.graph .inset": {
					"fill": "lightblue"
				},
				"svg.graph .labels": {
					"fill": "darkgrey",
					"stroke": "none",
					"font-family": "Arial",
					"font-size": "12px",
					"kerning": "2"
				},
				"svg.graph .lines": {
					"stroke": "lightblue",
					"stroke-width": "2"
				},
				"svg.graph .labels.x-labels": {
					"text-anchor": "middle"
				},
				"svg.graph .labels.y-labels": {
					"text-anchor": "end"
				}
			}
		}
	};
	var Graph = function(obj) {
		this.setOptions(obj);
	};
	//handle this.obj
	Graph.prototype.setOptions = function(obj) {
		//merge with defaults
		if (obj) this.obj = $.extend({}, Private.defaults(obj.height, obj.width, obj.graphHeight, obj.graphWidth), obj);
		else this.obj = Private.defaults(); //just use defaults
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
		this.setOptions(obj);
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
		var SVG = '<svg class="graph">', //begin all groups
			xGrid = '<g class="grid x-grid" id="xGrid">',
			yGrid = '<g class="grid y-grid" id="yGrid">',
			points = '<g class="inset points">',
			xLabels = '<g class="labels x-labels">',
			yLabels = '<g class="labels y-labels">',
			lines = '<g class="lines">'; //connecting points
		//*remember: xLines are vertical, yLines are horizontal
		var xLines = self.x.length - 1;
		var yLines = self.y.length + 1; //+1 because line 1 is at origin
		//(Throughout the following I subtract and add 5 where needed, idk why, but it just works...)
		//X-GRID LINES
		for (var i = 1; i <= xLines; ++i) {
			//x1 and x2 must be the same (dist. from left), 
			//start at very top (y1 = 0), all the way to the bottom (y = height)
			var nxt = i * self.xDist;
			xGrid += '<line x1="' + nxt + '" x2="' + nxt + '" y1="' + self.yOffset + '" y2="' + (self.height - self.yOffset) + '"></line>';
		}
		//Y-GRID LINES
		for (var i = 1; i <= yLines; ++i) {
			//y1 and y2 must be the same (dist. from top),
			//ALL x1's & x2's must be the same so we start at same dist. from left & right
			var nxt = (self.height) - i * (self.yDist);
			yGrid += '<line x1="' + (self.xOffset + 5) + '" x2="' + (self.width - self.xOffset + 15) + '" y1="' + nxt + '" y2="' + nxt + '"></line>';
		}
		//POINTS (INDIVIDUAL)
		for (var i = 0; i < self.x.length; ++i) { //7 for days in week
			//scale: every actual 30 should equal 10 in points (use yDist for if this changes)
			//so cy should = 30 when point = 10 and so on... (points[i]+10 just fixes the points to match the scale... 
			//i fucked up and everything is 10 off)
			var inc = self.height - ((self.points[i] + 10) * (self.yDist / 10)); //subtract from height to invert graph
			//set our x coor depending on i due to offset (first and last are special) :/;
			var x = (i === 0) ? i * self.xDist + self.xOffset + 5 : (i === 6 ? i * self.xDist : i * self.xDist);
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
		xGrid, yGrid, points, lines, xLabels, yLabels += '</g>'; //close all tags
		SVG += xGrid + yGrid + points + lines + xLabels + yLabels + '</svg>'; //build html
		//build with strings 'cause DselfM is sooooo slow
		if (self.attachTo !== 'body') self.attachTo = '#' + self.attachTo;
		$(self.attachTo).append(SVG);
		//STYLING
		if (self.defaultStyle === true) {
			for (var i in self.style) {
				$(i).css(self.style[i]);
			}
		}
	};
	return GraphLinear;
})(jQuery);