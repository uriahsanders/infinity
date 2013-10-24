<?php
define("INFINITY", true); //to be able to include relax
include_once("libs/relax.php"); //defines and functions 

function PDO() //this will later be in the relax.php
{
	return new PDO("mysql:host=".SQL_SERVER.";dbname=".SQL_DB, SQL_USR, SQL_PWD); //we only have it to make our coding easier with the connection and to use the defines for credentials
}

$pdo = PDO(); //just return a new PDO 
$st = $pdo->prepare('SELECT * FROM memberinfo WHERE ID <= :ID AND LOWER(active_p) = LOWER(:active)'); //prepare the statement
// this is with named args, you can also use unnamed and use the char ?, then you don't use a key in the array below

$args = array(":ID"	=>	3, ":active"	=>	"Infinity-Forum"); //the data, with key names
$st->execute($args); //RUN

foreach($st->fetchAll(PDO::FETCH_NAMED) as $row) //loop, and only fetch names and not array indexes
	echo $row["username"] . " is currently working on " . $args[":active"]. "<br/>\n"; //print

?>