
//////////////////////////////////////
// Loading Screen
///////////////////////////////////////
var quotes = [
			["If everyone is moving forward together, then success takes care of itself.","Henry Ford"],
			["Many ideas grow better when transplanted into another mind than the one where they sprang up.","Oliver Wendell Holmes"],
			["If I have seen further it is by standing on the shoulders of giants.","Isaac Newton"],
			["Politeness is the poison of collaboration.","Edwin Land"],
			["I never did anything alone. Whatever was accomplished in this country was accomplished collectively.","Golda Meir"],
			["It is literally true that you can succeed best and quickest by helping others to succeed.","Napoleon Hill"],
			["The secret is to gang up on the problem, rather than each other.","Thomas Stallkamp"],
			["Individually, we are one drop. Together, we are an ocean.","Ryunosuke Satoro"],
			["Few things in life are less efficient than a group of people trying to write a sentence. The advantage of this method is that you end up with something for which you will not be personally blamed.","Scott Adams, creator of Dilbert"],
			["No matter what accomplishments you make, somebody helped you.","Althea Gibson"],
			["The strength of the team is each individual member. The strength of each member is the team.","Phil Jackson"],
			["Coming together is a beginning, staying together is progress, and working together is success.","Henry Ford"],
			["The lightning spark of thought generated in the solitary mind awakens its likeness in another mind.","Thomas Carlyle"],
			["Gettin' good players is easy. Gettin' 'em to play together is the hard part.","Casey Stengel"],
			["We're in this together, and if we united and we inter-culturally cooperated, then that might be the key to humanity's survival.","Jeremy Gilley, TEDTalks lecture"],
			["Your corn is ripe today; mine will be so tomorrow. 'Tis profitable for us both, that I should labour with you today, and that you should aid me tomorrow.","David Hume"],
			["Individual commitment to a group effort—that is what makes a team work, a company work, a society work, a civilization work.","Vince Lombardi"],
			["No one can whistle a symphony. It takes a whole orchestra to play it.","H.E. Luccock"],
			["Teamwork is the ability to work together toward a common vision. The ability to direct individual accomplishments toward organizational objectives. It is the fuel that allows common people to attain uncommon results.","Andrew Carnegie"]
	];
var rnd = Math.floor(Math.random() * (quotes.length));
$("body").before('<div class="loader"><img src="/images/logo_big2.png" /><br /><br /><span id="quote"></span><br /><span id="by"></span><br /><span class="dott_1"> . </span><span class="dott_2"> . </span><span class="dott_3"> . </span></div>');
$("#quote").html("\""+quotes[rnd][0]+"\"");
$("#by").html("--"+quotes[rnd][1]);
var time = setInterval(function(){
		var id = $(".loader-cont span[class^='dott_'][active]");
		if (id.length == 0)
			id = 0
		else
			id = id.attr("class").substr(5);
		if (id >= 3)
			id = 0;
		else
			id++;
		$("span[class^='dott_']").removeAttr("active");
		$(".dott_"+id).attr("active", "1");
},800)
