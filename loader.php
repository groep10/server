<?php

error_reporting(E_ALL);

require('db.php');
require('error.php');

$error = new error(true);
$db = new db(Array( 
	'host' => "localhost", 
	'username' => "**", 
	'password' => "**", 
	'database' => "**"
));

