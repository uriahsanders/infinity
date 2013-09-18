<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/top.php'); //DO NOT REMOVE OR CHANGE 
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/links.php'); // DO NOT REMOVE OR CHANGE

listlinks("???"); // CHANGE TO THE ACTIVE LINK

include_once($_SERVER['DOCUMENT_ROOT'].'/libs/middle.php'); //DO NOT REMOVE OR CHANGE
// UNDER HERE THE DIV content
// REMEMBER DIV ID=MAIN
// REMEMBER DIV ID=NEWS or LINKS
?>
        
            <!--<script>
            function changeStyle()
            {
            x=document.getElementById("html") 
            html.style=          
            }
            </script>   
            
                Sry have to coment this out lol btw what do you want to do?
                To change template start off by making a copy of the css and change the color values
                after that make php script that setts a cookie 
                load the css depending of the value of the cookie if set
                for security use validation my reqomendation is to set the cookie value to 0-9
                and to a regex with numbers max 1char in length somthing like
                /^[0-9]*.{1}$/
                no javascript with include files thats not safe
                
                also start using div or span i preffer div but thats what your used to
                dont think the difference is to big
                code like <h1><font> ect will not be accepted when we get our html and css certificate
                -->

            

            </p>
        <br /><br /><br /><br /><br /><br />
        </div>

       
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/bottom.php'); // DO NOT REMOVE OR CHANGE
?>