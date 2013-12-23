/////////////////////////////////////////
// By: relax for Infinity-forum.org
// relax@infinity-forum.org
// protected by Swedish copyright laws
/////////////////////////////////////////

(function() {
	//uses my tinyMVC framework :D
	Model.create({
		old: [],
		old_data: [],
		first: false,
		block: false,
		current: 0,
		pages: ["forum", "cat", "thread"],
		chars: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"
	});
	var model = Model.data;
	//you dont need this yet, but you will once you get to posts and stuff
	//talk to me so i can explain it to you :)
	View.create(function(name, value) {

	});
	Controller.create(function() {
		$(document).ready(function(e) {
			$(document).on("click", ".cat_title", function() {
				Forum.handle_forumSlide.call(this);
			});
			$(document).on("click", "a", function() {
				Forum.handle_aClick();
			});
			$(document).on("click", "div[class^='arrow_']", function() {
				Forum.handle_arrowClick.call(this);
			});
			$(document).on("click", "#forum_nav_2 span:nth-child(2) a, #forum_nav_2 span:first-child b", function() {
				Forum.handle_navCatDropDown();
			});
		});
	});
	Router.create(function(hash, count) {
		if (location.hash.length >= 3) //check for hash start
		{
			if (count === 0) model.first = true; //do once
			Forum.hash_ajax();
		} else //start hash
			Router.goTo('');
	});
	//all actual functions for this page
	var Forum = (function() {
		var Public = {}, Private = {};
		//i made everything public to match what you had but
		//consider making some stuff private if you can
		Public.hash_ajax = function() {
			if (model.block)
				return;
			var hash = Router.hash(); //get the hashtag
			if (hash.indexOf("f=") != -1)
				var cat = hash.substr(hash.indexOf("f=") + 2, hash.indexOf("/") - 2); //get the ID of the category
			if (hash.indexOf("s=") != -1)
				var subcat = hash.substr(hash.indexOf("s=") + 2, hash.indexOf("/") - 2); //get the ID of the subcat
			if (hash.indexOf("t=") != -1)
				var thread = hash.substr(hash.indexOf("t=") + 2, hash.indexOf("/") - 2); //get the ID of the thread
			if (hash.indexOf("p=") != -1)
				var post = hash.substr(hash.indexOf("p=") + 2); //get the ID of the post
			if (hash.length <= 0)
				var forum = true;
			var page, data, id = "l";
			if (cat !== undefined) //check if cat is set
			{
				page = model.pages[1]; //then its to forum or subforum
				if (subcat !== undefined) //is a subforum set?
					data = {
						"f": cat,
						"s": subcat
					} // set data to show the subforum
				else
					data = {
						"f": cat
					} //only forum
			} else if (thread !== undefined) //else its a thread view
			{
				page = model.pages[2]; //thread view
				if (post !== undefined) //specific post
					data = {
						"t": thread,
						"p": post
					} //^^
				else //seriusly...
					data = {
						"t": thread
					} //yeah okay...
			} else {
				page = model.pages[0];
				model.old = [];
				data = {
					"f": "infinity"
				};
				id = "r";
			}
			$.ajax({ // send it with ajax
				url: page + ".php", //to the right file depending on the previus code
				type: "POST",
				beforeSend: function() {
					model.block = true;
				},
				data: data, //data depending on previus code

				success: function(data) { //when done
					$("#main").prepend("<div class=\"forum_2\">" + data + "</div>"); //add the feteched data to a div
					$(".forum_1").hide("slide", {
							direction: ((id === "l") ? "left" : "right")
						}, ((model.first) ? 0 : 1000), //slide the old one away 
						function() {
							$("body").append("<div class=\"arrow_l\"></div>") //show back arrow
							$(".arrow_l").show(500);

							while ($(".forum_1").length > 0) {
								$(".forum_1").remove(); //REMOVE OLD ONE
							}
							$(".forum_2").attr("class", "forum_1"); //change new to active so we can keep this going
							model.current = model.old.length;
							Public.save(Public.newID());
							//console.log("length: " +old.length + "\nCurrent: " + current + "\nData: " + old);
							model.block = false;
							Public.nav();
						});
					$(".forum_2").show("slide", {
						direction: ((id !== "l") ? "left" : "right")
					}, ((model.first) ? 0 : 1000)); //slide the new one in
					model.first = false;
				}
			});
		};
		Public.newID = function() {
			var newID = ""; //string ID
			for (var i = 0; i < 32; i++)
				newID += model.chars.charAt(Math.floor(Math.random() * model.chars.length)) //loop to add the random char	
			return newID;
		};
		Public.save = function(newID) {
			var hash = Router.hash();
			if (hash.length === 0) {
				$("div[class^='arrow_']").remove();
				model.old = [];
				model.current = 0;
				Router.goTo('')
				hash = Router.hash();
				//return;
			}
			if (typeof(Storage) !== "undefined") //check of html5 support (storrge)
				sessionStorage.setItem(newID, $(".forum_1").html()); //supported, add the old data in the storrage
			else
				model.old_data[newID] = $(".forum_1").html(); //not supported add it to a normal variable 
			model.old.splice(model.current);
			model.old.push([hash, newID]); //push the id to history array

			this.arrows();
		};
		Public.arrows = function() {
			$("body").append("<div class=\"arrow_l\"></div><div class=\"arrow_r\"></div>") //show arrows
			if (model.current === 0)
				$(".arrow_l").remove();
			if (model.current == model.old.length - 1)
				$(".arrow_r").remove();
			$(".arrow_l, .arrow_r").show(500);
		};
		Public.manageStorage = function() {
			if (typeof(Storage) !== "undefined")
				sessionStorage.clear();
			this.save(this.newID());
		};
		Public.nav = function() {
			$("div[id^='forum_nav_']:not('#forum_nav_1')").hide();
			$("#forum_nav i").hide();
			var arr = ["hdn_cat", "hdn_thr"]; //the different classes
			var arr2 = []; //checked array
			arr.forEach(function(entry) {
				if ($("." + entry).length > 0) //check if exists
					arr2.push(entry); //then add if it does
			});
			arr2.forEach(function(entry, index) {
				var nav = $("#forum_nav_" + (index + 2)); //easier to write
				var txt = $("." + entry).val(); // the text
				var name = window.atob(txt.substring(0, txt.indexOf("|"))); //decoded name
				var id = txt.substr(txt.indexOf("|") + 1); //the ID
				nav.children("span:first-child").html(((index + 1 == arr2.length) ? name : "<a href=\"#!f=" + id + "/" + name.replace(/ /g, '_') + "\">" + name + "</a>") + ((index == 0) ? " <b>&#171;</b>" : "")); //set the html with the decoded name
				$("div[id^='forum_nav_']").removeClass("forum_nav_active"); //remove active from all of them
				if (index + 1 == arr2.length) //if the last
					nav.addClass("forum_nav_active"); //active
				nav.show(); // guess :O
				nav.css("display", "inline-block"); // jquery puts as block always, so....
				$("#forum_nav i:nth-child(" + (index * 2 + 2) + ")").show(); // show the -----------
			});
		};
		//click handler functions:
		Public.handle_forumSlide = function() {
			var ele = $(this).parents(".forum").children(".subcat"); //find the subcat for that forum
			if (ele.is(":hidden"))
				ele.slideDown(500); //show if hidden
			else
				ele.slideUp(500); //else hide
		};
		//small hash hack
		Public.handle_aClick = function() {
			setTimeout(function() {
				Public.hash_ajax();
			}, 200);
		};
		Public.handle_arrowClick = function() {
			if (model.block) //check so its not blocked
				return;
			model.block = true; //its not blocked, we will continue but block from now on
			var id = $(this).attr("class").substr(-1); //get the direction, left or right (l or r)

			$("#main").prepend("<div class=\"forum_2\">" + //add a hidden div with the data
				((typeof(Storage) !== "undefined") ? //check for ls support
					sessionStorage.getItem(model.old[((id === "l") ? --model.current : ++model.current)][1]) //get the data depending on left or righ from sessionStorage
					:
					model.old_data[model.old[model.current][1]] //get data from variables when session is not supported
				) + "</div>"); //add the feteched data to a div
			//window.location.hash = model.old[model.current][0]; //set the right hash in the url bar
			Router.goTo(model.old[model.current][0]);
			$(".forum_1").hide("slide", {
					direction: ((id !== "l") ? "left" : "right")
				}, 1000, //slide in the dirrection depending on l/r
				function() {
					while ($(".forum_1").length > 0) //remove all the old divs, this is a dummy proof way of it
					{
						$(".forum_1").remove(); //REMOVE OLD ONE
					}
					$(".forum_2").attr("class", "forum_1"); //change new to active so we can keep this going
					model.block = false; //unblock as we are done
					setTimeout(Public.nav, 200); //recalculate nevigation with an extra small delay...
				}
			);
			$(".forum_2").show("slide", {
				direction: ((id === "l") ? "left" : "right")
			}, 1000); //slide the new one simultaniasly with the old
			Public.arrows(); //recalculate arrows
		};
		Public.handle_navCatDropDown = function() {
			$("#forum_nav_2 span:nth-child(2)").slideToggle(300);
		};
		return Public;
	})();
	Forum.manageStorage();
	Router.run(); //make absolutely sure we run the URL
})();