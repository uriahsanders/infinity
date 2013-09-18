<?php
    /*
    REPLACE SPECIFIED TEXT WITH EMOTICONS:
    Modify this code to work for whatver $_POST you are calling to take user input from the rich text editor.
    Then paste it onto the page where it is needed. All it does is replace certain characters with emoticons.
    As we make new emotes, this will need to be added to as well.
    */
    include_once($_SERVER['DOCUMENT_ROOT'].'/libs/phpfunctions.php');
    $user_input = cleanQuery($_POST['user_input']); //The original post (Remember to Cleanse this.)
    $scan = array(':)', ':/', ':(', ':P', ':*', ':D', ':O'); //What characters we need to replace.
    $emote_replace = array('<img src="/images/smile.gif" title="Smile">', '<img src="/images/sserious.png" title="Serious">', '<img src="/images/sad.gif" title="Sad">', '<img src="/images/toungue.png" title="Toungue">', '<img src="/images/cuss.png" title="Cuss">'); //Once we actually have all these emotes, the array will continue like so. Just the values to replace the above with in that order.
    $actual_post = str_replace($scan, $emote_replace, $user_input); //Replace what's in $scan with whats in $emote_replace, based off of what's found in $user_input
    echo $actual_post; //Instead of echoing the actual post, echo the post with replaced characters
    //If you would also like the same action for the post title, repeat the code, but for that input value instead.

?>