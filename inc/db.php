<?php
/*
$db = array(
	'host' => 'localhost',
	'user' => 'root',
	'pass' => 'root',
	'name' => 'vh-grand-opening'
);
*/

$db = array(
	'host' => 'dbmaster',
	'user' => 'cerise-rsvp',
	'pass' => 'nMpQXdzq4xq4vxbB',
	'name' => 'cerise_beta'
);

$mysqli = new mysqli($db['host'], $db['user'], $db['pass'], $db['name']);

?>