(function() {
	var old = [],
		old_data = [], DIR = 'l', REFER = 0;
	$(document).ready(function(e) {
		window.onhashchange = hash_ajax;
		$(document).on("click", ".cat_title", function() { //if you click on a forum 
			var ele = $(this).parents(".forum").children(".subcat"); //find the subcat for that forum
			if (ele.is(":hidden"))
				ele.slideDown(500); //show if hidden
			else
				ele.slideUp(500); //else hide
		});
		$(document).on("click", "a", function() {
			setTimeout(function() {
				hash_ajax();
			}, 200)
		}); //small hash hack
		//changing pages
		$(document).on('click', 'a[id^="change-pg-"]', function() {
			var hash = window.location.hash;
			//add a slash if we need to for a proper split
			var pg = hash.slice(-1);
			var nxt = $(this).attr('id').substring(10);
			if(pg > nxt) DIR = 'r';
			else DIR = 'l';
			if (pg != '/' && isNaN(pg)){
				hash += '/';
				DIR = 'l';
			}
			hash = hash.split('/');
			//change page part of URL
			hash[hash.length - 1] = nxt;
			window.location.hash = hash.join('/');
			$('html, body').animate({
				scrollTop: $("body").offset().top
			}, 1000);
		});
		//////////////////////////////////////////////////////
		// clicking on a category will be handled with ajax..
		//////////////////////////////////////////////////////
		var current = 0;
		var first = false,
			block = false;
		if (window.location.hash.length !== 0) //check if theres a hashtag
		{
			first = true;
			hash_ajax(); //get that page 

		} else {
			window.location = "#";
		}

		function hash_ajax() {
			if (block)
				return;
			var pages = ["forum", "cat", "thread"];
			var pg = 1;
			var hash = window.location.hash.substring(1); //get the hashtag
			if (hash.indexOf("f=") != -1)
				var cat = hash.substr(hash.indexOf("f=") + 2, hash.indexOf("/") - 2); //get the ID of the category
			if (hash.indexOf("s=") != -1)
				var subcat = hash.substr(hash.indexOf("s=") + 2, hash.indexOf("/") - 2); //get the ID of the subcat
			if (hash.indexOf("t=") != -1) {
				var thread = hash.substr(hash.indexOf("t=") + 2, hash.indexOf("/") - 2); //get the ID of the thread
				pg = hash.split('/')[hash.split('/').length - 1]; //get last part of url for page number
				if (pg == false || isNaN(pg)) pg = 1; //fail safe
			}
			if (hash.indexOf("p=") != -1)
				var post = hash.substr(hash.indexOf("p=") + 2); //get the ID of the post
			if (hash.length <= 0)
				var forum = true;

			var page, data, id = "l";
			if (cat !== undefined) //check if cat is set
			{
				page = pages[1]; //then its to forum or subforum
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
				page = pages[2]; //thread view
				if (post !== undefined) //specific post
					data = {
						"t": thread,
						"p": post,
						"pg": pg
					} //^^
				else //seriusly...
					data = {
						"t": thread,
						"pg": pg
					} //yeah okay...
			} else {
				page = pages[0];
				old = [];
				data = {
					"f": "infinity"
				};
				id = "r";
			}
			id = DIR;
			var time = first === true ? 0 : 1000;
			$.ajax({ // send it with ajax
				url: page + ".php", //to the right file depending on the previus code
				type: "POST",
				beforeSend: function() {
					block = true;
				},
				data: data, //data depending on previus code

				success: function(res) { //when done
					$("#main").prepend("<div class=\"forum_2\">" + res + "</div>"); //add the feteched data to a div
					$(".forum_1").hide("slide", {
							direction: ((id === "l") ? "left" : "right")
						}, time, //slide the old one away 
						function() {
							//$("body").append("<div class=\"arrow_l\"></div>") //show back arrow
							//$(".arrow_l").show(500);

							while ($(".forum_1").length > 0) {
								$(".forum_1").remove(); //REMOVE OLD ONE
							}
							$(".forum_2").attr("class", "forum_1"); //change new to active so we can keep this going
							current = old.length;
							save(newID());
							//console.log("length: " +old.length + "\nCurrent: " + current + "\nData: " + old);
							block = false;
							nav();
							if (cat !== undefined || thread !== undefined) {
								if (cat !== undefined) $('#forum-pages').html('<button id="forum-post">New Post</button>');
								else if (thread !== undefined) {
									$.ajax({
										url: '/forum/handle.php',
										type: 'GET',
										data: data,
										success: function(res2) {
											$('#forum-pages').html('<button id="forum-post">New Post</button>' + res2);
											//run epic-edit function for each post
											$('div[id^="epicedit-"]').each(function() {
												var id = $(this).attr('id').substring(9);
												epicDisplay('epicedit-' + id, 'epic-' + id);
												$(this).hide().fadeIn();
											});
										}
									});
								}
							} else {
								$('#forum-pages').html('');
							}
						});
					$(".forum_2").show("slide", {
						direction: ((id !== "l") ? "left" : "right")
					}, time); //slide the new one in

					first = false;
				}
			});
		}

		function newID() {
			var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"; //avalible chars for the random generated string name
			var newID = ""; //string ID
			for (var i = 0; i < 32; i++)
				newID += chars.charAt(Math.floor(Math.random() * chars.length)) //loop to add the random char	
			return newID;
		}

		function save(newID) {
			var hash = window.location.hash;
			if (hash.length === 0) {
				//$("div[class^='arrow_']").remove();
				old = [];
				current = 0;
				window.location.hash = "#";
				hash = "#";
				//return;
			}
			if (typeof(Storage) !== "undefined") //check of html5 support (storrge)
				sessionStorage.setItem(newID, $(".forum_1").html()); //supported, add the old data in the storrage
			else
				old_data[newID] = $(".forum_1").html(); //not supported add it to a normal variable 
			old.splice(current);
			old.push([hash, newID]); //push the id to history array

			arrows();
		}

		function arrows() {
			$("body").append("<div class=\"arrow_l\"></div><div class=\"arrow_r\"></div>") //show arrows
			// if (current === 0)
			// 	$(".arrow_l").remove();
			// if (current == old.length - 1)
			// 	$(".arrow_r").remove();
			// $(".arrow_l, .arrow_r").show(500);
		}

		function nav() {
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
				nav.children("span:first-child").html(((index + 1 == arr2.length) ? name : "<a href=\"#f=" + id + "/" + name.replace(/ /g, '_') + "\">" + name + "</a>") + ((index == 0) ? " <b>&#171;</b>" : "")); //set the html with the decoded name
				$("div[id^='forum_nav_']").removeClass("forum_nav_active"); //remove active from all of them
				if (index + 1 == arr2.length) //if the last
					nav.addClass("forum_nav_active"); //active
				nav.show(); // guess :O
				nav.css("display", "inline-block"); // jquery puts as block always, so....
				$("#forum_nav i:nth-child(" + (index * 2 + 2) + ")").show(); // show the -----------
			});

		}
		////////////////////////////////////////////////////
		// history buttons :]
		////////////////////////////////////////////////////
		$(document).on("click", "div[class^='arrow_']", function() {
			// if (block) //check so its not blocked
			// 	return;
			// block = true; //its not blocked, we will continue but block from now on
			// var id = $(this).attr("class").substr(-1); //get the direction, left or right (l or r)
			// $("#main").prepend("<div class=\"forum_2\">" + //add a hidden div with the data
			// 	((typeof(Storage) !== "undefined") ? //check for ls support
			// 		sessionStorage.getItem(old[((id === "l") ? --current : ++current)][1]) //get the data depending on left or righ from sessionStorage
			// 		:
			// 		old_data[old[current][1]] //get data from variables when session is not supported
			// 	) + "</div>"); //add the feteched data to a div


			// window.location.hash = old[current][0]; //set the right hash in the url bar
			// $(".forum_1").hide("slide", {
			// 		direction: ((id !== "l") ? "left" : "right")
			// 	}, 1000, //slide in the dirrection depending on l/r
			// 	function() {
			// 		while ($(".forum_1").length > 0) //remove all the old divs, this is a dummy proof way of it
			// 		{
			// 			$(".forum_1").remove(); //REMOVE OLD ONE
			// 		}
			// 		$(".forum_2").attr("class", "forum_1"); //change new to active so we can keep this going
			// 		block = false; //unblock as we are done
			// 		setTimeout(nav, 200); //recalculate nevigation with an extra small delay...
			// 	}
			// );
			// nav();
			// $(".forum_2").show("slide", {
			// 	direction: ((id === "l") ? "left" : "right")
			// }, 1000); //slide the new one simultaniasly with the old
			// arrows(); //recalculate arrows
			var id = $(this).attr("class").substr(-1); //get the direction, left or right (l or r)
			DIR = id === 'l' ? 'r' : 'l';
			REFER = 1;
			if(id === 'l') window.history.back();
			else window.history.forward();
		});
		$(document).on('click', '.forum', function(){
			DIR = 'l';
		});
		/////////////////////////
		// clear session storage
		/////////////////////////
		if (typeof(Storage) !== "undefined")
			sessionStorage.clear();
		save(newID());


		///////////////////////////////////////
		//	nav cat dropdown
		///////////////////////////////////////
		$(document).on("click", "#forum_nav_2 span:nth-child(2) a, #forum_nav_2 span:first-child b", function() {
			$("#forum_nav_2 span:nth-child(2)").slideToggle(300);
		});
		//new post form
		$(document).on('click', '#forum-post', function() {
			var hash = window.location.hash;
			if (hash.indexOf("f=") != -1)
				var cat = hash.substr(hash.indexOf("f=") + 2, hash.indexOf("/") - 2); //get the ID of the category
			if (hash.indexOf("t=") != -1)
				var thread = hash.substr(hash.indexOf("t=") + 2, hash.indexOf("/") - 2); //get the ID of the thread
			popup("New Post", '<form id="new-forum-post"><input type="hidden"name="signal"value="post"/><input type="hidden"name="' +
				(thread ? 't' : 'f') + '"value="' + (thread || cat) + '"/><br>' +
				(cat ? '<input style="padding:10px;width:75%"name="subject"placeholder="Subject"/>' : '') +
				'<br><br><div id="epicedit-body"><textarea id="epic-body"name="body"class="epic-text form-control"></textarea></div><br><button class="pr-btn">Post</button></form>');
			epicEdit('epicedit-body', 'epic-body');
		});
		//deleting
		$(document).on('click', '[id^="forum-remove-"]', function() {
			var id = $(this).attr('id').split('-');
			var ID = id[3];
			var obj = {
				id: ID,
				signal: 'delete'
			};
			var isTopic = id[2] == 'topics';
			obj[isTopic ? 'f' : 't'] = ID;
			$.ajax({
				url: '/forum/handle.php',
				data: obj,
				type: 'POST',
				success: function(data) {
					if (isTopic) {
						$('.arrow_l').click();
					}
					$(window).trigger('hashchange');
				}
			});
		});
		//modifiying
		$(document).on('click', '[id^="forum-modify-"]', function() {

		});
		//new post creation
		$(document).on('submit', '#new-forum-post', function(e) {
			e.preventDefault();
			var formData = $(this).serialize();
			$.ajax({
				url: '/forum/handle.php',
				data: formData,
				type: 'POST',
				success: function(data) {
					//dealing with category
					var hash = window.location.hash;
					var cat = hash.indexOf("f=") != -1 ? true : false;
					if (cat) {
						window.location.reload(true);
					} else {
						//change to last page to see post
						//add a slash if we need to for a proper split
						if (hash.slice(-1) != '/' && isNaN(hash.slice(-1))) hash += '/';
						hash = hash.split('/');
						//change page part of URL
						hash[hash.length - 1] = $('#last-page').val();
						if (window.location.hash === hash.join('/')) $(window).trigger('hashchange');
						else window.location.hash = hash.join('/');
						$('#msgbox_close').click(); //close popup and dim
						$('html, body').animate({
							scrollTop: $(document).height()
						}, 3000);
					}
				}
			});
		});
	});
})();