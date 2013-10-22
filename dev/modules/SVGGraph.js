//Module for creating SVG graphs quickly and easily (HIGHLY flexible, everything is optional/changeable)
/*
	Stuff it can do:
	Create graphs of different types,
	store any graph as JSON,
	expand JSON into a graph,
	update a graph,
	style a graph,
	change a graph into a different type,
	create graphs with multiple lines

	Coming soon: (* denotes current focus)
	pie and area graph, *
	legends
*/
var Graph = Graph || (function($) {
	"use strict";
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
			y: 10,
			attachTo: 'body',
			points: [0, 26, 33, 74, 12, 49, 18]
		};
	};
	//important stuff you might want automatically
	Graph.prototype.basics = function(height, width, graphHeight, graphWidth) {
		//basically, if no graph height/width is given we just make it equal the svg height/width
		height = graphHeight || height || 300;
		width = graphWidth || width || 550;
		//make sure we can take substring
		height = height.toString();
		width = width.toString();
		//so we can let them use percentages, we need the CSS of container
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
			scale: 10,
			//leave space for labels:
			xOffset: 25,
			yOffset: 20,
			yStart: 0, // what number do we want to start from for y labels
			mainOffset: 35, //to seperate everything from the ylabels
			padding: 10, //keep labels from touching edges
			//single points
			xOfPoints: [], //get x and y coordinates of points
			yOfPoints: [],
			//multiple points
			mxOfPoints: [],
			myOfPoints: [],
			multiplePoints: false,
			interactive: true,
			grid: true,
			xGrid: true,
			yGrid: true,
			noLines: false,
			//add some html before append
			before: '',
			//after append:
			after: '',
			title: '', //title of graph to be written in SVG
			id: 'SVGGraph' + Private.count
		};
	};
	//create jquery css header
	Graph.prototype.parseS = function(id, then) {
		return 'svg[id="' + id + '"] ' + then;
	};
	//turn an id into jQuery selector format
	Graph.prototype.id2selector = function(id) {
		var stuff = id.split(' '); //split into components
		id = stuff[0]; //only want the first word (id)
		var selector = 'svg[id="';
		if (id.charAt(0) === '#') { //make sure it's an id
			selector += id.substring(1) + '"]';
			//append everything else to the end
			for (var i = 1; i < stuff.length; ++i) {
				selector += ' ' + stuff[i];
			}
		} else {
			return id;
		}
		return selector;
	};
	Graph.prototype.styles = function(obj) {
		//first way to style is by creating an object representing the CSS
		obj.byCSS = obj.byCSS || {};
		//second way to style something is by modifying default styles
		obj.styles = obj.styles || {};
		var xAnchor = (obj.type === 'bar') ? 'start' : 'middle';
		//which replaces defaults below
		var height = obj.height || '100%';
		var width = obj.width || '100%';
		var styling = {};
		styling.style = {};
		styling.style[this.parseS(obj.id, '')] = {
			"height": height,
			"width": width
		};
		styling.style[this.parseS(obj.id, '.grid')] = {
			"stroke": obj.styles.gridStroke || "#000",
			"stroke-width": obj.styles.gridStrokeWidth || "1"
		};
		styling.style[this.parseS(obj.id, '.points')] = {
			"stroke": obj.styles.pointStroke || "grey",
			"stroke-width": obj.styles.strokeWidth || "4",
			"cursor": 'pointer'
		};
		styling.style[this.parseS(obj.id, '.inset')] = {
			"fill": obj.styles.pointFill || "lightblue"
		};
		styling.style[this.parseS(obj.id, '.labels')] = {
			"fill": obj.styles.labelFill || "#000",
			"stroke": obj.styles.labelStroke || "none",
			"font-family": obj.styles.labelFont || "Arial",
			"font-size": obj.styles.labelFontSize || "12px",
			"kerning": obj.styles.labelKerning || "2"
		};
		styling.style[this.parseS(obj.id, '.lines')] = {
			"stroke": obj.styles.lineStroke || "darkgrey",
			"stroke-width": obj.styles.lineStokeWidth || "2"
		};
		styling.style[this.parseS(obj.id, '.line-of-1')] = {
			"stroke": obj.styles.lineStroke || "green",
			"stroke-width": obj.styles.lineStokeWidth || "2"
		};
		//when using multiple lines make them different colors automatically
		var colors = ['red', 'blue', 'green', 'orange'];
		for (var i = 1; i < colors.length; ++i) {
			styling.style[this.parseS(obj.id, '.line-of-' + i)] = {
				"stroke": obj.styles.lineStroke || colors[i],
				"stroke-width": obj.styles.lineStokeWidth || "2"
			};
		}
		styling.style[this.parseS(obj.id, '.rects')] = {
			"stroke": obj.styles.lineStroke || "grey",
			"stroke-width": obj.styles.lineStokeWidth || "2",
			'fill': 'blue',
			'opacity': 0.7
		};
		styling.style[this.parseS(obj.id, '.SVG-tooltip')] = {
			"fill": obj.styles.tooltipFill || "#000",
			"stroke": obj.styles.tooltipStroke || "none",
			"font-family": obj.styles.tooltipFont || "Arial",
			"font-size": obj.styles.tooltipFontSize || "12px",
			"display": 'none',
			"opacity": '1'
		};
		styling.style[this.parseS(obj.id, '.SVG-tooltip-box')] = {
			"display": 'none',
			"opacity": "0.5"
		};
		styling.style[this.parseS(obj.id, '.labels.x-labels')] = {
			"text-anchor": obj.styles.xLabelAnchor || xAnchor
		};
		styling.style[this.parseS(obj.id, '.labels.y-labels')] = {
			"text-anchor": obj.styles.yLabelAnchor || "end"
		};
		styling.style['table[id="' + obj.id + '"]'] = {
			"height": height,
			"width": width,
			"border-collapse": 'collapse',
			"text-align": 'center'
		};
		//for styling completely with your own object
		for (var name in obj.byCSS) {
			//make sure id is in proper form
			styling.style[this.id2selector(name)] = obj.byCSS[name]; //make styling = users object
		}
		return styling;
	};
	//handle this.obj
	Graph.prototype.setOptions = function(obj) {
		obj = obj || {};
		if (obj.attachTo) {
			obj.attachTo = (obj.attachTo.charAt(0) === '#') ? obj.attachTo : '#' + obj.attachTo; //make hash optional (attchTo)
			Private.attachTo = obj.attachTo; //for basics(), which cant access this.obj.attachTo in time
		}
		if (obj.id) obj.id = (obj.id.charAt(0) === '#') ? obj.id.substring(1) : obj.id; //make hash optional (id)
		//do basic setup automatically
		if (obj.basic === true || typeof obj.basic === 'undefined') {
			this.obj = this.basics(obj.height, obj.width, obj.graphHeight, obj.graphWidth);
		}
		//merge with defaults
		if ((obj && obj.example === true) || !$.isEmptyObject(obj)) { //if example chosen or no options given
			obj.id = obj.id || this.obj.id;
			//everything user did not specify is filled with defaults + basics + style
			//style needs id passed in so it can be replaced from basics().id
			$.extend(this.obj, this.defaults(), obj, this.styles(obj)); //ORDER MATTERS WITH $.EXTEND
			this.obj.addStyle = true;
		} else if (obj && obj.addStyle === true) { //only add styling
			$.extend(this.obj, this.styles(obj), obj);
		} else if (obj) {
			this.obj = obj; //only use given args
		}
		console.log('(SVGGraph): this.obj = \n' + JSON.stringify(this.obj) + '\n'); //output JSON
	};
	Graph.prototype.save = function() { //save a graph as stringified JSON (can expand later)
		return JSON.stringify(this.obj);
	};
	Graph.prototype.expand = function(obj, thing) { //expand JSON into a graph (requires 'type' property of 'obj')
		var obj = (typeof obj === 'string') ? jQuery.parseJSON(obj) : obj; //if in string form parse it
		var graph;
		switch (this.obj.type) {
			case 'linear':
				graph = new GraphLinear(obj);
				break;
			case 'bar':
				graph = new GraphBar(obj);
				break;
			case 'pie':
				graph = new GraphPie(obj);
				break;
			case 'area':
				graph = new GraphArea(obj);
				break;
			default:
				console.log("(SVGGraph): Error, no graph type given; expansion could not complete.");
		}
		thing = thing || '';
		graph.init(thing);
	};
	Graph.prototype.update = function(obj) { //recall script file to update graph with new obj
		obj = obj || {};
		//reset options with new stuff
		this.expand(obj, 'update'); //recreate graph
	};
	//turn one type of graph into another  (can also make changes with obj)
	Graph.prototype.to = function(what) {
		//update graph as a new type
		this.obj.type = what;
		this.expand(this.obj, 'update');
	};
	Graph.prototype.createGrid = function(xLines, yLines) {
		var self = this.obj;
		var xGrid = '',
			yGrid = '';
		//make sure they want the grid
		if (self.grid === true && self.noLines === false) {
			//save final x of xlines so ylines dont pass that boundary
			var finalY = (self.height) - yLines * (self.yDist);
			var nxt;
			//X-GRID LINES
			if (self.xGrid) {
				for (var i = 0; i < xLines; ++i) {
					//x1 and x2 must be the same (dist. from left), 
					//start at very top (y1 = 0), all the way to the bottom (y = height)
					nxt = i * self.xDist + self.mainOffset;
					xGrid += '<line x1="' + nxt + '" x2="' + nxt + '" y1="' + (self.height - self.yOffset - self.padding) +
						'" y2="' + (finalY) + '"></line>';
				}
			}
			var finalX = (xLines - 1) * self.xDist + self.mainOffset;
			//Y-GRID LINES
			if (self.yGrid) {
				for (var i = 1; i <= yLines; ++i) {
					//y1 and y2 must be the same (dist. from top),
					//ALL x1's & x2's must be the same so we start at same dist. from left & right
					nxt = (self.height) - i * (self.yDist);
					//finalX need not be added to mainoffset because nxt already accounts for it mathematically
					yGrid += '<line x1="' + self.mainOffset + '" x2="' + (finalX) + '" y1="' + nxt + '" y2="' + nxt + '"></line>';
				}
			}
		} else {
			//leave the first vert. and horiz. line for them for obvious styling purposes
			//they still have the option to remove this with noLines
			if (self.noLines === false) {
				xGrid += '<line x1="' + self.mainOffset + '" x2="' + self.mainOffset +
					'" y1="' + (self.height - self.yOffset - self.padding) + '" y2="' + ((self.height) - yLines * (self.yDist)) + '"></line>';
				yGrid += '<line x1="' + self.mainOffset + '" x2="' + ((xLines - 1) * self.xDist + self.mainOffset) +
					'" y1="' + (self.height - self.yDist) + '" y2="' + (self.height - self.yDist) + '"></line>';
			}
		}
		return {
			xGrid: xGrid,
			yGrid: yGrid
		};
	};
	Graph.prototype.applyStyling = function() {
		//Add CSS as value for every key in style
		if (this.obj.addStyle === true) {
			for (var i in this.obj.style) {
				$(i).css(this.obj.style[i]);
			}
		}
	};
	//initialize global tags
	Graph.prototype.openTags = function() {
		return {
			SVG: '<svg id="' + this.obj.id + '"class="graph">', //begin all groups
			xGrid: '<g class="grid x-grid" id="xGrid">',
			yGrid: '<g class="grid y-grid" id="yGrid">',
			xLabels: '<g class="labels x-labels">',
			yLabels: '<g class="labels y-labels">',
			title: '<g class="labels title">'
		};
	};
	//add X and Y labels to graph
	Graph.prototype.addLabels = function() {
		var self = this.obj;
		var xLabels = '',
			yLabels = '';
		//xLABELS
		for (var i = 0; i < self.x.length; ++i) {
			xLabels += '<text x="' + (i * self.xDist + self.mainOffset) + '" y="' +
				(self.height - self.padding) + '">' + self.x[i] + '</text>';
		}
		//yLABELS
		for (var i = 1; i <= self.y + 1; ++i) {
			var digit = (i * self.scale - self.scale + self.yStart); //get multiple of scale as number displayed
			var x = (digit >= 10) ? self.xOffset : self.xOffset - 10; //clean it up: move 1 digit numbers 1 place to the left
			//y subtracted from height to invert graph
			yLabels += '<text x="' + x + '" y="' + ((self.height - (self.yDist * i - self.padding)) - 5) +
				'">' + digit + '</text>';
		}
		return {
			xLabels: xLabels,
			yLabels: yLabels
		};
	};
	Graph.prototype.addTitle = function(yLines) {
		return '<text x="' + (this.obj.mainOffset) + '" y="' +
			((this.obj.height) - yLines * (this.obj.yDist) - this.obj.yOffset) +
			'">' + this.obj.title + '</text>';
	};
	//close all tags, append to DOM, and add styling
	Graph.prototype.finishGraph = function(xLines, yLines, E, thing) {
		//build grid
		E.xGrid += this.createGrid(xLines, yLines).xGrid;
		E.yGrid += this.createGrid(xLines, yLines).yGrid;
		//LABELS
		E.xLabels += this.addLabels().xLabels;
		E.yLabels += this.addLabels().yLabels;
		E.title += this.addTitle(yLines); //build grid
		//COMBINING DYNAMICALLY
		for (var i in E) {
			if (i !== 'SVG') E.SVG += E[i] + '</g>';
		}
		//"thing" will determine where to put the new graph
		var finish = this.obj.before + E.SVG + '</svg>' + this.obj.after;
		switch (thing) {
			case 'update':
				$(this.parseS(this.obj.id, '')).replaceWith(finish); //replace old graph with this one
				break;
			default:
				$(this.obj.attachTo).append(finish);
		}
		//STYLING
		this.applyStyling();
	};
	Graph.prototype.help = function() { // show a popup with help information
		alert("Someday this will actually be helpful.");
	};
	return Graph;
})(jQuery);
var GraphLinear = GraphLinear || (function($) {
	"use strict";
	var GraphLinear = function(obj) { //extends "Graph"
		obj = obj || {};
		obj.type = 'linear';
		Graph.call(this, obj);

		var pointHandle = function(action) {
			var $nat = $(this).attr('id');
			var matcher = $nat.split('-');
			var id = matcher[0];
			var num = matcher[1];
			var thiz = this;
			$('svg line[id^="' + id + '"]').each(function() {
				if ($(this).attr('id').split('-')[1] === num) {
					var tooltip = '#' + $(thiz).attr('class') + '-tooltip';
					var tooltipRect = '#' + $(thiz).attr('class') + '-tooltip-rect';
					if (action === 'add') {
						$(this).css('stroke-width', parseFloat($(this).css('stroke-width')) + .5);
						$(tooltip).show();
						$(tooltipRect).show();
					} else {
						$(this).css('stroke-width', parseFloat($(this).css('stroke-width')) - .5);
						$(tooltip).hide();
						$(tooltipRect).hide();
					}
				}
			});
		}
		//set click handlers for tooltips
		if(this.obj.interactive === true){
			$(document).ready(function() {
				$(document).on('mouseover', 'svg circle[id$="point"]', function(e) {
					pointHandle.call(this, 'add');
				});
				$(document).on('mouseleave', 'svg circle[id$="point"]', function(e) {
					pointHandle.call(this, 'sub');
				});
			});
		}
	};
	GraphLinear.prototype = Object.create(Graph.prototype);
	GraphLinear.prototype.constructor = GraphLinear;
	GraphLinear.prototype.init = function(thing) {
		console.log("Linear graph initialized.");
		var self = this.obj; //shorthand from here on...
		//correct values (atm has user inputed version, whereas G... is clean)
		self.width = self.Gwidth;
		self.height = self.Gheight;
		var E = this.openTags(); //elements
		E.lines = '<g class="lines">'; //connecting points
		E.points = '<g class="inset points">';
		//*remember: xLines are vertical, yLines are horizontal
		var xLines = self.x.length;
		var yLines = self.y + 1; //+1 because line 1 is at origin
		var r = 5; //radius of circle
		if (self.multiplePoints === false) { //single line graph
			//POINTS (INDIVIDUAL)
			var inc, x, j, tooltipOffset = 0;
			for (var i = 0; i < xLines; ++i) {
				inc = self.height - ((self.points[i] + self.scale) * (self.yDist / self.scale)); //subtract from height to invert graph
				//set our x coor depending on i due to offset (first and last are special) :/;
				x = i * self.xDist + self.mainOffset;
				E.points += '<circle id="' + self.id + '-0-point"class="' + self.id + '-point' + i +
					'"cx="' + x + '" cy="' + inc + '" r="' + r + '"></circle>'; //cx is always on a vert. line
				//TOOLTIPS
				E.points += '<g><rect class="SVG-tooltip-box"id="' + self.id + '-point' +
					i + '-tooltip-rect"x="' + (x - self.padding * 2) + '"y="' + (inc - self.yDist - self.padding * 2) +
					'"height="' + (self.yDist + self.padding / 2) + '"width="' + (50) + '"/>';
				E.points += '<text class="SVG-tooltip"id="' + self.id + '-point' + i + '-tooltip" x="' +
					(x - self.padding) + '" y="' + (inc - self.yDist) + '">' + self.points[i] + '</text></g>';
				//store coordinates so we can easily connect them with lines
				self.xOfPoints.push(x);
				self.yOfPoints.push(inc);
			}
			//LINES
			for (var i = 0; i < self.points.length - 1; ++i) {
				j = i + 1; //get next point coordinate
				//to connect two points: x1 = (x of first point), x2 = (x of second point),
				//y1 = (y of first point), y2 = (y of second point)
				E.lines += '<line id="' + self.id + '-0-line" x1="' + self.xOfPoints[i] + '" x2="' +
					self.xOfPoints[j] + '" y1="' + self.yOfPoints[i] + '" y2="' + self.yOfPoints[j] + '"></line>';
			}
		} else {
			var inc, x, j;
			//we need to push the right # of empty arrays into the multi arrays for points
			for (var i = 0; i < self.points.length; ++i) {
				self.mxOfPoints.push([]);
				self.myOfPoints.push([]);
			}
			//multiple points are in a multi-dimensional array, so treat it as such with double loops
			for (var i = 0; i < self.points.length; ++i) {
				//chain of index vars: i -> t
				//POINTS (INDIVIDUAL)
				for (var t = 0; t < self.points[i].length; ++t) {
					inc = self.height - ((self.points[i][t] + self.scale) * (self.yDist / self.scale));
					//set our x coor depending on i due to offset (first and last are special) :/;
					x = t * self.xDist + self.mainOffset;
					E.points += '<circle id="' + self.id + '-' + i + '-point" class="' + self.id +
						'-point' + i + t + '" cx="' + x + '" cy="' + inc + '" r="' + r + '"></circle>';
					//TOOLTIPS
					E.points += '<g><rect class="SVG-tooltip-box"id="' + self.id + '-point' +
						i + t + '-tooltip-rect"x="' + (x - self.padding * 2) + '"y="' +
						(inc - self.yDist - self.padding * 2) +
						'"height="' + (self.yDist + self.padding / 2) + '"width="' + (50) + '"/>';
					E.points += '<text class="SVG-tooltip"id="' + self.id + '-point' + i + t +
						'-tooltip" x="' + (x - self.padding) + '" y="' + (inc - self.yDist) + '">' + self.points[i][t] + '</text>';
					//store coordinates so we can easily connect them with lines
					self.mxOfPoints[i].push(x);
					self.myOfPoints[i].push(inc);
				}
				//LINES
				for (var t = 0; t < self.points[i].length - 1; ++t) {
					j = t + 1; //get next point coordinate
					//number class name for different colors
					E.lines += '<line id="' + self.id + '-' + i + '-line" class="line-of-' + i +
						'" x1="' + self.mxOfPoints[i][t] + '" x2="' + self.mxOfPoints[i][j] +
						'" y1="' + self.myOfPoints[i][t] + '" y2="' + self.myOfPoints[i][j] + '"></line>';
				}
			}
		}
		this.finishGraph(xLines, yLines, E, thing); //close tags, style, and append
	};
	return GraphLinear;
})(jQuery);
var GraphBar = GraphBar || (function($) {
	"use strict";
	var GraphBar = function(obj) {
		obj = obj || {};
		obj.type = 'bar';
		Graph.call(this, obj);
		//set click handlers for tooltips
		if(this.obj.interactive === true){
			$(document).ready(function() {
				$(document).on('mouseover', 'svg rect', function(e) {
					$('#' + $(this).attr('id') + '-tooltip').show();
					$('#' + $(this).attr('id') + '-tooltip-rect').show();
				});
				$(document).on('mouseleave', 'svg rect', function(e) {
					$('#' + $(this).attr('id') + '-tooltip').hide();
					$('#' + $(this).attr('id') + '-tooltip-rect').hide();
				});
			});
		}
	};
	GraphBar.prototype = Object.create(Graph.prototype);
	GraphBar.prototype.constructor = GraphBar;
	GraphBar.prototype.init = function(thing) {
		console.log("Bar graph initialized.");
		var self = this.obj;
		self.width = self.Gwidth;
		self.height = self.Gheight;
		var xLines = self.x.length + 1; //needs one more because each x label takes entire column
		var yLines = self.y + 1;
		var E = this.openTags();
		E.rects = '<g class="rects">';
		var inc, x, y; //increment
		//more unique stuff for bar graph now:
		//RECTS
		for (var i = 0; i < xLines - 1; ++i) {
			//height must = last section of "y"
			//if i = 0, let inc = 1 so we can at least see at line at origin
			inc = (i !== 0) ? ((self.points[i] + self.scale) * (self.yDist / self.scale)) - self.yDist : 1;
			x = (i * self.xDist + self.mainOffset);
			y = (self.height - self.padding - self.yOffset - (inc));
			E.rects += '<rect id="' + self.id + '-point-' + i + '" x="' + x +
				'" y="' + y +
				'" width="' + self.xDist + '" height="' + (inc) + '"/>';
			//tooltip box
			E.rects += '<g><rect class="SVG-tooltip-box"id="' + self.id + '-point-' +
				i + '-tooltip-rect"x="' + (x + self.padding / 2) + '"y="' + (y - self.yDist - self.padding * 2) +
				'"height="' + (self.yDist + self.padding / 2) + '"width="' + (self.xDist - self.padding) + '"/>';
			//tooltip text
			E.rects += '<text class="SVG-tooltip"id="' + self.id + '-point-' + i +
				'-tooltip" x="' + (x + (self.xDist) / 2 - self.padding) + '" y="' +
				(y - self.yDist / 2 - self.padding) + '">' + self.points[i] + '</text></g>';
		}
		this.finishGraph(xLines, yLines, E, thing);
	};
	return GraphBar;
})(jQuery);
var GraphTable = GraphTable || (function($) {
	"use strict";
	var GraphTable = function(obj) {
		obj = obj || {};
		obj.type = 'table';
		Graph.call(this, obj);
	};
	GraphTable.prototype = Object.create(Graph.prototype);
	GraphTable.prototype.constructor = GraphTable;
	GraphTable.prototype.init = function(thing) {
		console.log("Table graph initialized.");
		var self = this.obj;
		var table = '<table class="SVG-table"id="' + self.id + '" border="1"cellpadding="5"><tr><th>#</th><th>' +
			(self.xName || 'X') + '</th><th>' + (self.yName || 'Y') + '</th></tr>';
		//within each row is [num | x | y] <td>'s
		var row = '<tr>';
		for (var i = 0; i < self.x.length; ++i) {
			row += '<td>' + i + '</td><td>' + self.x[i] + '</td><td>' + self.points[i] + '</td></tr><tr>';
		}
		table += row + '</tr>';
		$(this.obj.attachTo).append(table);
		this.applyStyling();
	};
	return GraphTable;
})(jQuery);
var GraphPie = GraphPie || (function($) {
	"use strict";
	var GraphPie = function(obj) {
		obj = obj || {};
		obj.type = 'pie';
		Graph.call(this, obj);
	};
	GraphPie.prototype = Object.create(Graph.prototype);
	GraphPie.prototype.constructor = GraphPie;
	GraphPie.prototype.init = function(thing) {

	};
	return GraphPie;
})(jQuery);
var GraphArea = GraphArea || (function($) {
	"use strict";
	var GraphArea = function(obj) {
		obj = obj || {};
		obj.type = 'area';
		Graph.call(this, obj);
	};
	GraphArea.prototype = Object.create(Graph.prototype);
	GraphArea.prototype.constructor = GraphArea;
	GraphArea.prototype.init = function(thing) {

	};
	return GraphArea;
})(jQuery);