<?php
if(strlen(session_id()) < 1)
 {
      // session has NOT been started
session_set_cookie_params( 
    '1209600', 
    "/", 
    ".infinity-forum.org",
    false, 
    true 
); 
session_start();
session_regenerate_id(true); 
}
?>