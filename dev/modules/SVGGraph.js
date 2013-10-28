//Module for creating SVG graphs quickly and easily (HIGHLY flexible, everything is optional/changeable)
/*
	Stuff it can do:
	Create graphs of different types,
	store any graph as JSON,
	expand JSON into a graph,
	update a graph,
	style a graph,
	change a graph into a different type,
	create graphs with multiple entries,
	create graphs of any scale,
	add interactivity,
	extremely versatile: everything is optional/changeable

	Coming soon: (* denotes current focus)
	pie graphs, scatter graphs, *
	legends,
	average lines for bar and scatter graphs,
	jquery plugin for UI
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
			legend: false,
			interactive: true,
			grid: true,
			xGrid: true,
			yGrid: true,
			xName: null,
			yName: null,
			special: null,
			showPoints: true,
			noLines: false,
			pointRadius: 5,
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
		styling.style[this.parseS(obj.id, 'circle')] = {
			"opacity": 0.7
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
		styling.style[this.parseS(obj.id, '.rect')] = {
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
			"opacity": "0.7",
			"fill": 'blue',
			"stroke": obj.styles.lineStroke || "grey",
			"stroke-width": obj.styles.lineStokeWidth || "2"
		};
		styling.style[this.parseS(obj.id, '.area')] = {
			"opacity": "0.5",
			"fill": 'blue'
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
		//when using multiple lines make them different colors automatically
		var colors = ['red', 'blue', 'green', 'orange'];
		for (var i = 0; i < colors.length; ++i) {
			styling.style[this.parseS(obj.id, '.line-of-' + i)] = {
				"stroke": obj.styles.lineStroke || colors[i],
				"stroke-width": obj.styles.lineStokeWidth || "2"
			};
			styling.style[this.parseS(obj.id, '.path-of-' + i)] = {
				"fill": colors[i]
			};
			styling.style[this.parseS(obj.id, '.rect-of-' + i)] = {
				"fill": colors[i],
				"opacity": 0.7
			};
		}
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
		//console.log('(SVGGraph): this.obj = \n' + JSON.stringify(this.obj) + '\n'); //output JSON
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
			case 'table':
				graph = new GraphTable(obj);
				break;
			default:
				console.log("(SVGGraph): Error, no graph type given; expansion could not complete.");
		}
		thing = thing || '';
		graph.init(thing);
	};
	Graph.prototype.update = function(obj) { //recall script file to update graph with new obj
		obj = obj || {};
		obj.byCSS = this.obj.byCSS;
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
			yGrid = '',
			weird = self.yDist - 30;
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
					xGrid += '<line x1="' + nxt + '" x2="' + nxt + '" y1="' + (self.height - self.yOffset - self.padding - weird) +
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
					'" y1="' + (self.height - self.yOffset - self.padding - weird) + '" y2="' + ((self.height) - yLines * (self.yDist)) + '"></line>';
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
		//name of X-Axis:
		// if (self.xName !== null) {
		// 	xLabels += '<text x="' + (self.width/2 - self.mainOffset - self.padding - self.yOffset) + '" y="' +
		// 		(self.height) + '">' + self.xName + '</text>';
		// }
		//yLABELS
		for (var i = 1; i <= self.y + 1; ++i) {
			var digit = (i * self.scale - self.scale + self.yStart); //get multiple of scale as number displayed
			var x = (digit >= 10) ? self.xOffset : self.xOffset - 10; //clean it up: move 1 digit numbers 1 place to the left
			//y subtracted from height to invert graph
			yLabels += '<text x="' + x + '" y="' + ((self.height - (self.yDist * i - self.padding)) - 5) +
				'">' + digit + '</text>';
		}
		//name of Y-Axis:
		// if (self.yName !== null) {
		// 	yLabels += '<text transform="rotate(-90)"x="' + (-self.height/2) + '" y="' + (self.yDist - self.padding) +
		// 		'">' + self.yName + '</text>';
		// }
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
		E.points = E.points || '';
		for (var i in E) {
			if (E[i] !== E.points) { //so we can add last to increase z-index
				if (i !== 'SVG') E.SVG += E[i] + '</g>';
			}
		}
		E.SVG += E.points;
		//"thing" will determine where to put the new graph
		var finish = this.obj.before + E.SVG + '</svg>' + this.obj.after;
		this.handleAppend(thing, finish);
		//STYLING
		this.applyStyling();
	};
	Graph.prototype.handleAppend = function(thing, finish) {
		switch (thing) {
			case 'update':
				$('#' + this.obj.id).replaceWith(finish); //replace old graph with this one
				break;
			default:
				$(this.obj.attachTo).append(finish);
		}
	};
	Graph.prototype.addLegend = function(thing) {
		var self = this.obj;
		//HACK!!!!!!!!!!!!!!!!!!1
		//hack for to(), must change later:
		var xDist = (thing === 'update') ? self.xDist / self.points.length : self.xDist;
		if(thing === 'update' && this.obj.special === 'area') xDist *= self.points.length;
		var legend = '<g class="legend">';
		var x = (self.Gwidth - self.mainOffset - xDist * 2 + self.padding * 2);
		var width = 30; //width of rect
		var height = 30;
		self.dataNames = self.dataNames || [];
		legend += '<g class="legend-pair">';
		if (self.multiplePoints === false) {
			legend += '<g class="legend-pair">';
			legend += '<rect x="' + (x) +
				'" y="' + (self.yOffset) + '"width="' + width + '"height="' + height + '"></rect>';
			legend += '<text x="' + (x + width + 5) +
				'"y="' + (self.yOffset + height / 2) + '">' + (self.dataNames[0] || 'Data') + '</text>';
			legend += '</g>';
		} else {
			var y = self.yOffset;
			for (var i = 0; i < self.points.length; ++i) {
				legend += '<g class="legend-pair">';
				//RECT
				legend += '<rect class="rect-of-' + i + '"x="' + (x) +
					'" y="' + (y) + '"width="' + width + '"height="' + height + '"></rect>';
				//TEXT
				legend += '<text x="' + (x + width + 5) +
					'"y="' + (y + height / 2) + '">' + (self.dataNames[i] || 'Data' + (i === 0 ? '' : ' ' + i)) + '</text>';
				legend += '</g>';
				y += self.yDist + self.padding;
			}
		}
		return legend + '</g>';
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
			var thiz = this; //reference the point that called us
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
		if (this.obj.interactive === true) {
			var thiz = this;
			$(document).ready(function() {
				$(document).on('mouseover', 'svg circle[id$="point"]', function(e) {
					pointHandle.call(this, 'add');
					$(this).css('opacity', 1);
				});
				$(document).on('mouseleave', 'svg circle[id$="point"]', function(e) {
					pointHandle.call(this, 'sub');
					$(this).css('opacity', thiz.obj.style[thiz.parseS(obj.id, 'circle')].opacity || 0.7);
				});
			});
		}
	};
	GraphLinear.prototype = Object.create(Graph.prototype);
	GraphLinear.prototype.constructor = GraphLinear;
	GraphLinear.prototype.buildPoints = function(arr) {
		var inc, x, j, points, str, html, mult, num, i, r = this.obj.pointRadius,
			self = this.obj;
		//stuff that changes based on multiple points:
		if (arr.length === 1) {
			//only have "i" var
			points = self.points[arr[0]];
			str = arr[0];
			i = arr[0];
			mult = false;
		} else if (arr.length === 2) {
			//have "i" and then "t" var
			points = self.points[arr[0]][arr[1]];
			str = '' + arr[0] + arr[1]; //to get proper identifier
			i = arr[1];
			mult = true;
		}
		inc = self.height - ((points + self.scale) * (self.yDist / self.scale)); //subtract from height to invert graph
		x = i * self.xDist + self.mainOffset;
		num = (mult === false) ? 0 : arr[0];
		//circles
		html = '<circle id="' + self.id + '-' + num + '-point"class="' + self.id + '-point' + str +
			'"cx="' + x + '" cy="' + inc + '" r="' + r + '"></circle>'; //cx is always on a vert. line
		//TOOLTIPS
		//rectangle
		html += '<g><rect class="SVG-tooltip-box"id="' + self.id + '-point' +
			str + '-tooltip-rect"rx="10"x="' + (x - self.padding * 2) + '"y="' + (inc - self.yDist - self.padding * 2) +
			'"height="' + (self.yDist + self.padding / 2) + '"width="' + (50) + '"/>';
		//text
		html += '<text class="SVG-tooltip"id="' + self.id + '-point' + str + '-tooltip" x="' +
			(x - self.padding) + '" y="' + (inc - self.yDist) + '">' + points + '</text></g>';
		return html;
	};
	GraphLinear.prototype.init = function(thing) {
		console.log("Linear graph initialized.");
		var self = this.obj; //shorthand from here on...
		//correct values (atm has user inputed version, whereas G... is clean)
		self.width = self.Gwidth;
		self.height = self.Gheight;
		var E = this.openTags(); //elements
		E.lines = '<g class="lines">'; //connecting points
		E.points = '<g class="inset points">';
		if (self.legend === true) E.legend = this.addLegend(thing);
		var area = self.special === 'area';
		if (area && self.multiplePoints === false) E.path = '<g class="area"><path d="';
		//*remember: xLines are vertical, yLines are horizontal
		var xLines = self.x.length;
		var yLines = self.y + 1; //+1 because line 1 is at origin
		var r = 5; //radius of circle
		var hmdist = self.height - self.yDist;
		if (self.multiplePoints === false) { //single line graph
			//POINTS (INDIVIDUAL)
			var inc, x, j;
			for (var i = 0; i < xLines; ++i) {
				inc = self.height - ((self.points[i] + self.scale) * (self.yDist / self.scale)); //subtract from height to invert graph
				//set our x coor depending on i due to offset (first and last are special) :/;
				x = i * self.xDist + self.mainOffset;
				if (self.showPoints === true) {
					E.points += this.buildPoints([i]);
				}
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
			if (area) {
				//PATHS 
				//building SVG path params
				//handling seprately because Moveto is important
				E.path += 'M' + self.xOfPoints[0] + ',' + (hmdist) + ' '; //make sure origin is included
				E.path += 'L' + self.xOfPoints[0] + ',' + self.yOfPoints[0] + ' '; //draw from origin to first point
				for (var i = 1; i < self.xOfPoints.length; ++i) {
					E.path += 'L' + self.xOfPoints[i] + ',' + self.yOfPoints[i] + ' '; //draw line to next point
				}
				E.path += 'L' + self.xOfPoints[self.xOfPoints.length - 1] + ',' + (hmdist) + ' Z"></path>';
			}
		} else {
			var inc, x, j;
			if(thing === 'update' && area) self.xDist *= self.points.length;
			//we need to push the right # of empty arrays into the multi arrays for points
			for (var i = 0; i < self.points.length; ++i) {
				self.mxOfPoints.push([]);
				self.myOfPoints.push([]);
			}
			if (area) {
				E.path = '<g class="area">';
				var paths = [];
			}
			//multiple points are in a multi-dimensional array, so treat it as such with double loops
			for (var i = 0; i < self.points.length; ++i) {
				//chain of index vars: i -> t
				//POINTS (INDIVIDUAL)
				for (var t = 0; t < self.points[i].length; ++t) {
					inc = self.height - ((self.points[i][t] + self.scale) * (self.yDist / self.scale));
					x = t * self.xDist + self.mainOffset;
					if (self.showPoints === true) {
						E.points += this.buildPoints([i, t]);
					}
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
				if (area) {
					//PATHS
					paths.push('<path class="path-of-' + i + '" d="');
					paths[i] += 'M' + self.mxOfPoints[i][0] + ',' + (hmdist) + ' ';
					paths[i] += 'L' + self.mxOfPoints[i][0] + ',' + self.myOfPoints[i][0] + ' ';
					for (var t = 0; t < self.points[i].length; ++t) {
						paths[i] += 'L' + self.mxOfPoints[i][t] + ',' + self.myOfPoints[i][t] + ' ';
					}
					paths[i] += 'L' + self.mxOfPoints[i][self.mxOfPoints[i].length - 1] + ',' + (hmdist) + ' Z"></path>';
				}
			}
			if (area) {
				E.path += paths.join('');
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
		if (this.obj.interactive === true) {
			var thiz = this;
			$(document).ready(function() {
				$(document).on('mouseover', 'svg rect', function(e) {
					$('#' + $(this).attr('id') + '-tooltip').show();
					$('#' + $(this).attr('id') + '-tooltip-rect').show();
					$(this).css('opacity', 0.8);
				});
				$(document).on('mouseleave', 'svg rect', function(e) {
					$('#' + $(this).attr('id') + '-tooltip').hide();
					$('#' + $(this).attr('id') + '-tooltip-rect').hide();
					$(this).css('opacity', thiz.obj.style[thiz.parseS(obj.id, '.rect')].opacity || 0.7);
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
		if (self.legend === true) E.legend = this.addLegend(thing);
		var inc, x, y, weird; //increment
		weird = self.yDist - 30;
		if (self.multiplePoints === false) {
			for (var i = 0; i < xLines - 1; ++i) {
				//height must = last section of "y"
				//if i = 0, let inc = 1 so we can at least see at line at origin
				inc = (i !== 0) ? ((self.points[i] + self.scale) * (self.yDist / self.scale)) - self.yDist : 2;
				x = (i * self.xDist + self.mainOffset);
				y = (self.height - self.padding - self.yOffset - (inc));
				//bars
				E.rects += '<rect class="rect"id="' + self.id + '-point-' + i + '" x="' + x +
					'" y="' + (y - weird) +
					'" width="' + self.xDist + '" height="' + (inc) + '"/>';
				//tooltip box
				E.rects += '<g><rect class="SVG-tooltip-box"id="' + self.id + '-point-' +
					i + '-tooltip-rect"rx="1"x="' + (x + self.padding / 2) + '"y="' + (y - weird - self.yDist - self.padding * 2) +
					'"height="' + (self.yDist + self.padding / 2) + '"width="' + (self.xDist - self.padding) + '"/>';
				//tooltip text
				E.rects += '<text class="SVG-tooltip"id="' + self.id + '-point-' + i +
					'-tooltip" x="' + (x + (self.xDist) / 2 - self.padding) + '" y="' +
					(y - weird - self.yDist / 2 - self.padding) + '">' + self.points[i] + '</text></g>';
			}
		} else {
			E.points += '<g class="lines">';
			//HACK!!!!!!!!!!!!!!
			//hack for to(), must change later
			if(thing !== 'update'){
				var xDist = self.xDist;
				self.xDist = self.xDist * self.points.length; //add more dist so we can fit more bars
			}else{
				var xDist = self.xDist / self.points.length;
			}
			//okay, so we need to get the first point of each array
			//then display them side by side and so on
			//get longest array:
			var max = 0;
			for (var i = 0; i < self.points.length; ++i) {
				if (max < self.points[i].length) max = self.points[i].length;
			}
			var j = 0;
			var all;
			var avgs = []; //to store averages for average line
			for (var i = 0; i < max; ++i) { //so we get throguh the length of every array
				for (var t = 0; t < self.points.length; ++t) { //this lets us loop array td instead of lr with j
					all = t + j + i + i; //lol wut?
					inc = (self.points[t][j] !== 0) ? ((self.points[t][j] + self.scale) * (self.yDist / self.scale)) - self.yDist : 2;
					x = ((all) * (xDist) + self.mainOffset);
					self.xOfPoints.push(x);
					y = (self.height - self.padding - self.yOffset - (inc));
					//bars
					E.rects += '<rect class="rect-of-' + t + '"id="' + self.id + '-point-' + (all) + '" x="' + x +
						'" y="' + (y - weird) +
						'" width="' + xDist + '" height="' + (inc) + '"/>';
					//tooltip box
					E.rects += '<g><rect class="rect-of-' + t + ' SVG-tooltip-box "id="' + self.id + '-point-' +
						(all) + '-tooltip-rect"rx="1"x="' + (x) + '"y="' + (y - weird - self.yDist - self.padding * 2) +
						'"height="' + (self.yDist + self.padding / 2) + '"width="' + (xDist) + '"/>';
					//tooltip text
					E.rects += '<text class="SVG-tooltip"id="' + self.id + '-point-' + (all) +
						'-tooltip" x="' + (x + (xDist) / 2 - self.padding) + '" y="' +
						(y - weird - self.yDist / 2 - self.padding) + '">' + self.points[t][j] + '</text></g>';
					if (j === i) {
						//grouping each X value
						avgs.push(y - inc);
					}
				}
				++j;
			}
			//AVERAGE LINES
			/*var avgPts = [];
			for (var i = 0; i < avgs.length; i += self.points.length) {
				avgPts.push((function() {
					var sums = 0;
					//add up points tb then return avg.
					for (var t = 0; t < self.points.length; ++t) {
						sums += avgs[i + t];
					}
					return sums / self.points.length;
				})());
			}
			//so now avgPts holds our avg points for every nth bar; lets draw line to each one from loop
			console.log(avgPts);
			for (var i = 0; i < avgPts.length; ++i) {
				var j = i + 1;
				E.points += '<line id="' + self.id + '-0-line" x1="' + (self.xOfPoints[i] + xDist + xDist/self.points.length) + '" x2="' +
					(self.xOfPoints[j] + xDist) + '" y1="' + avgPts[i] + '" y2="' + avgPts[j] + '"></line>';
			}*/
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
		var headers = '<th>' + (self.yName || 'Y') + '</th>'; //first header will always just be name of y
		//within each row is [num | x | y] <td>'s
		var row = '<tr>';
		if (self.multiplePoints !== true) {
			for (var i = 0; i < self.x.length; ++i) {
				row += '<td>' + i + '</td><td>' + self.x[i] + '</td><td>' + self.points[i] + '</td></tr><tr>';
			}
		} else {
			var data = [];
			for (var i = 0; i < self.points.length; ++i) {
				for (var t = 0; t < self.points[i].length; ++t) {
					data.push('<td>' + self.points[i][t] + '</td>'); //stick every single point into data[]
				}
				data.push('|'); //seperate each entry
			}
			var all = {}; //to hold formatted data
			//now split array with '|'
			var tick = 0;
			for (var i = 0; i < data.length; ++i) { //add entries to all{} numerically
				if (!all[tick]) all[tick] = []; //if arr hasnt been set set it
				if (data[i] !== '|') all[tick].push(data[i]); //add next entry
				else ++tick; //we are now in a new data layer
			}
			var tds; //build with 
			for (var i = 0; i < self.x.length; ++i) {
				if (i < self.points.length - 1) headers += '<th>' + (self.yName || 'Data') + ' ' + (i + 1) + '</th>'; //add headers numerically
				tds = '';
				for (var t = 0; t < self.points.length; ++t) {
					tds += all[t][i];
				}
				row += '<td>' + i + '</td><td>' + self.x[i] + '</td>' + tds + '</tr><tr>';
			}
		}
		var table = '<table class="SVG-table"id="' + self.id + '" border="1"cellpadding="5"><tr><th>#</th><th>' +
			(self.xName || 'X') + '</th>' + headers + '</tr>';
		table += row + '</tr>';
		this.handleAppend(thing, table);
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
		console.log("Pie graph initialized.");
		var self = this.obj;
		var pie = '<svg>';
		//constants
		var START = 'M340,251';
		var ARC = 'A154,154,0,0,1,';
		var lineFrom = false;
		var lineTo;
		pie += '<g class="paths">';
		// pie += '<path d="M340,251 L191,290 A154,154,0,0,1,340,97 Z"' +
		// 	'stroke="#ffffff" stroke-width="1" fill="#990099"></path>' +
		// 	'<path d="M340,251 L340,97 A154,154,0,0,1,379,399 Z"' +
		// 	'stroke="#ffffff" stroke-width="1" fill="#3366cc"></path>' +
		// 	'<path d="M340,251 L379,399 A154,154,0,0,1,300,400 Z"' +
		// 	'stroke="#ffffff" stroke-width="1" fill="#000"></path>' +
		// 	'<path d="M340,251 L300,399 A154,154,0,0,1,231,359 Z"' +
		// 	'stroke="#ffffff" stroke-width="1" fill="#ff9900"></path>' +
		// 	'<path d="M340,251 L231,359 A154,154,0,0,1,191,290 Z"' +
		// 	' stroke="#ffffff" stroke-width="1" fill="#109618"></path>' +
		// 	'';
		for (var i = 0; i < self.points.length; ++i) {
			if (!lineFrom) lineFrom = 191 + ',' + 290;
			lineTo = 340 + ',' + 97;
			pie += '<path d="' + START + ' L' + lineFrom + ' ' + ARC + lineTo + ' Z"></path>';
			lineFrom = lineTo; //set so next path starts where this one left off
		}
		pie += '</g></svg>';
		console.log(pie);
		this.handleAppend('', pie);
	};
	return GraphPie;
})(jQuery);