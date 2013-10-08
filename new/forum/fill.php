<?php
define("INFINITY", true);
include_once("../libs/relax.php");
$forum = new forum;
$m = $forum->Query("SELECT * FROM memberinfo");
$mem = array();
while($r = mysql_fetch_array($m))
	array_push($mem,$r['ID']);
var_dump($mem);
$res = $forum->Query("SELECT * FROM subcat WHERE parent_ID <= 1");
$now = strtotime(date("Y-m-d H:i:s"));
$old = strtotime(date("Y-m-d H:i:s", strtotime("2000-01-01 00:00:00")));
while ($row = mysql_fetch_array($res))
{
	$num = mt_rand(5, 10);
	for ($i = 0; $i <= $num;$i++)
	{
		$msg = "";
		for ($j = 0;$j <= mt_rand(10,100);$j++) $msg .= random_pronounceable_word(mt_rand(3,10))." ";
		$title = "";
		for ($k = 0;$k <= mt_rand(2,5);$k++) $title .= random_pronounceable_word(mt_rand(3,9))." ";
		$by = $mem[mt_rand(0,sizeof($mem)-1)];
		$time = date('Y-m-d H:i:s',mt_rand($old,$now));
		$ins = $forum->Query("INSERT INTO topics (msg, title, parent_ID, by_, IP, time_) VALUES (%s,%s,%d,%d,%s,%s)"
					  ,$msg, $title, $row['ID'], $by, "127.0.0.1", $time);
		$id = mysql_insert_id($forum->CON);
		$num2 = mt_rand(2, 8);
		for ($ii = 0; $ii <= $num2;$ii++)
		{
			$msg2 = "";
			$by2 = $mem[mt_rand(0,sizeof($mem)-1)];
			for ($j = 0;$j <= mt_rand(10,100);$j++) $msg2 .= random_pronounceable_word(mt_rand(3,10))." ";
			$forum->Query("INSERT INTO posts (msg, IP, by_, parent_ID, time_) VALUES(%s, %s, %d, %d, %s)"
							,$msg2, "127.0.0.1", $by2, $id, date('Y-m-d H:i:s',mt_rand($time,$now)));
		}
		
	}
}














































/**
 * Generate random pronounceable words
 *
 * @param int $length Word length
 * @return string Random word
 */
function random_pronounceable_word( $length = 6 ) {
    
    // consonant sounds
    $cons = array(
        // single consonants. Beware of Q, it's often awkward in words
        'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm',
        'n', 'p', 'r', 's', 't', 'v', 'w', 'x', 'z',
        // possible combinations excluding those which cannot start a word
        'pt', 'gl', 'gr', 'ch', 'ph', 'ps', 'sh', 'st', 'th', 'wh', 
    );
    
    // consonant combinations that cannot start a word
    $cons_cant_start = array( 
        'ck', 'cm',
        'dr', 'ds',
        'ft',
        'gh', 'gn',
        'kr', 'ks',
        'ls', 'lt', 'lr',
        'mp', 'mt', 'ms',
        'ng', 'ns',
        'rd', 'rg', 'rs', 'rt',
        'ss',
        'ts', 'tch', 
    );
    
    // wovels
    $vows = array(
        // single vowels
        'a', 'e', 'i', 'o', 'u', 'y', 
        // vowel combinations your language allows
        'ee', 'oa', 'oo', 
    );
    
    // start by vowel or consonant ?
    $current = ( mt_rand( 0, 1 ) == '0' ? 'cons' : 'vows' );
    
    $word = '';
        
    while( strlen( $word ) < $length ) {
    
        // After first letter, use all consonant combos
        if( strlen( $word ) == 2 ) 
            $cons = array_merge( $cons, $cons_cant_start );
 
         // random sign from either $cons or $vows
        $rnd = ${$current}[ mt_rand( 0, count( ${$current} ) -1 ) ];
        
        // check if random sign fits in word length
        if( strlen( $word . $rnd ) <= $length ) {
            $word .= $rnd;
            // alternate sounds
            $current = ( $current == 'cons' ? 'vows' : 'cons' );
        }
    }
    
    return $word;
}
?>
