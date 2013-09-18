  document.getElementById("loading").className = "loading-visible";
  var hideDiv = function(){$('#loading').remove();};
  var oldLoad = window.onload;
  var newLoad = oldLoad ? function(){hideDiv.call(this);oldLoad.call(this);} : hideDiv;
  window.onload = newLoad;
  setTimeout(function(){$('#loading').remove();},8000);