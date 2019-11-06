<?php
if (!defined("INFINITY"))
	die("");
echo '<link rel="stylesheet" type="text/css" href="/extra/loading/loading.css" />'."\n".
     '<div id="loading" class="loading-invisible"><br /><br /><br />'."\n".
     '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />'."\n".
     '<div class="circle"></div>'."\n".
     '<div class="circle1"></div>'."\n".
     '<div style=" color:rgba(0,183,229,0.9);'."\n".
     'text-shadow:0 0 15px #2187e7; margin-top:-28px; margin-left:10px; font-weight:bolder">Loading...</div>'."\n".
     '</div>'."\n".
     '<script src="/extra/loading/loading.js" type="text/javascript"></script>'."\n";
?>