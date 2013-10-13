//changeStatus, getStatus, pollStatus
var Status = Status || (function($) { //thanks for this, did not know you could do else statements this easy in js ^_^
	//Just run: Status.init() to do everything
	var Public = {}, Private = {};
	Private.StatusCodes = [ // the different types, just did this an object so we know what everything means, will be using the keys only here
			0,//: "Offline", //changed to array, better suited for this
			1,//: "Online",
			2,//: "Away",
			3 //: "Busy"
		];
	Private.idleTime = 0;
	Private.timer;
	Private.url = '/libs/status.php'; //changed to the right path		
	Public.changeStatus = function(id, forced, after) { //now has optional third param to do function afterwards
		$(".status_icon").attr("src", "/images/status/"+id+".png");
		$.ajax({
			url: Private.url,
			type: 'POST',
			data: 'signal=change-status&status=' + id,
			success: function() {
				Private.setForced(forced || false); //they chose to change their status, or a manual param
				if(after) after();
			},
			error: function(){
				if(after) after();
			}
		});
	};
	Public.getStatus = function() {
		var status = $.ajax({
			url: Private.url,
			type: 'GET',
			data: 'signal=get-status',
			async: false,
			success: function(res) {
				if (res == "error!")
				{
					MsgBox("Error", "There was an error, please reload the page and try again!", 3);
					return;	
				}
				$(".status_icon").attr("src", "/images/status/"+res+".png");
				return res;
			}
		}).responseText;
		return status;
	};
	
	Private.setForced = function(force)
	{
		if(typeof(Storage)!=="undefined")
			sessionStorage.force = force;
		else
			Private.forced = force;
	}
	Private.getForced = function()
	{
		if(typeof(Storage)!=="undefined")
			return sessionStorage.force;
		else
			return Private.forced;
	}
	
	
	//Poll server every minute to see if away or now available
	Private.pollStatus = function() {
		++Private.idleTime; //they have been idle for one more minute
		//if they chose to go away, dont make them available
		if (Private.idleTime >= 1 && Public.getIcon() == 1) { //10 minutes
			Public.changeStatus(2, true, function(){
				window.setTimeout(Private.pollStatus(), 60000); //tell changeStatus to recall us afterwards
			});
		}
	};
	Public.getIcon = function()
	{
		var icon =$(".status_icon").attr("src"); //== eg "/images/status/2.png";
		return icon.substr(icon.lastIndexOf("/")+1,1);
	}
	Public.init = function() {
		$(document).ready(function() {
			if (typeof(Private.getForced()) === "undefined")
				Private.setForced(false);
				
			Public.getStatus(); 
			//reset idle time with any movements
			$(this).on('mousemove keypress', function() {
				Private.idleTime = 0;
				Private.timer = setTimeout(function()
					{
						clearInterval(Private.timer);
						if (Private.getForced() === true && Public.getIcon() == 2)
							Public.changeStatus(1, false);
							//if they dont have another status already (only make them go away if they are "Available")
					},2500); //a delay so the vForced value can be set before this runs
			});
			//change status on element click
			$(document).on('click', '#status_icon label', function() {
				//you may want to change some of this depending on the DOM
				var new_status = $(this).children("img").attr('alt');
				Public.changeStatus(new_status, false);
			});
			//keep polling server every minute
			Private.pollStatus();
		});
	};
	return Public;
})(jQuery); //include jQuery before this

Status.init();
$(document).ready(function(e) {
    $(document).on("click", "#status_icon", function()
		{
			var icon = $(this).children("img");
			var mnu =  $(this).children("span");
			mnu.slideToggle(300);
			if (typeof(time) !== "undefined")
				clearInterval(time);
			var time = setTimeout(function(){mnu.slideUp(300);}, 60000);
		}
	);
});