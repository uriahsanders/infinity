//changeStatus, getStatus, pollStatus
var Status = Status || (function($) {
	//Just run: Status.init() to do everything
	var Public = {}, Private = {};
	Private.url = 'status.php';
	Private.idleTime = 0;
	Private.forced = false; //is their current status voluntary?
	Public.changeStatus = function(id, forced) {
		$.ajax({
			url: Private.url,
			type: 'POST',
			data: 'signal=change-status&status=' + id,
			success: function() {
				Private.forced = forced || false; //they chose to change their status, or a manual param
			}
		});
	};
	Public.getStatus = function() {
		var status;
		$.ajax({
			url: Private.url,
			type: 'GET',
			data: 'signal=get-status'
			success: function(res) {
				status = res;
			}
		});
		return status;
	};
	//Poll server every minute to see if away or now available
	Private.pollStatus = function() {
		//if they chose to go away, dont make them available
		if (Private.idleTime === 0 && Private.forced === true) {
			Public.changeStatus('Available');
			//if they dont have another status already (only make them go away if they are "Available")
		} else if (Private.idleTime > 4 && Public.getStatus() === 'Available') { //5 minutes
			Public.changeStatus('Away');
			Private.forced = true; //they didnt choose this :P
		}
		++Private.idleTime; //they have been idle for one more minute
	};
	Public.init = function() {
		$(document).ready(function() {
			//reset idle time with any movements
			$(this).on('mousemove keypress', function() {
				Private.idleTime = 0;
			});
			//change status on element click
			$(document).on('.some-status-class', 'click', function() {
				//you may want to change some of this depending on the DOM
				Public.changeStatus($(this).attr('id'));
			});
			//keep polling server every minute
			window.setInterval(function() {
				Private.pollStatus();
			}, 60000); //every minute
		});
	};
	return Public;
})(jQuery); //include jQuery before this