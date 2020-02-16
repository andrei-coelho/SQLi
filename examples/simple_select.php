<?php 

use SQLi\SQLi as sqli;

if($res = sqli::query("SELECT * FROM user")){
	// values
	$arrayValues = $res ->fetchAllAssoc();
}
