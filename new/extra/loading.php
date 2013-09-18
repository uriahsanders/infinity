<?php
if (!defined("INFINITY"))
	die("");
echo ('<link rel="stylesheet" type="text/css" href="/extra/loading/loading.css" />'.
     '<div id="loading" class="loading-invisible"><br /><br /><br />'.
     '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />'.
     '<div class="circle"></div>'.
     '<div class="circle1"></div>'.
     '<div style=" color:rgba(0,183,229,0.9);'.
     'text-shadow:0 0 15px #2187e7; margin-top:-28px; margin-left:10px; font-weight:bolder">Loading...</div>'.
     '</div>'.
     '<script src="/extra/loading/loading.js" type="text/javascript"></script>');
?>