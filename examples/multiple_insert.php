<?php

use SQLi\SQLi as sqli;

$toInsert = [
	'ss', 
	['Peter Parker', 'spider@marvel.com'],
	['Bruce Wayne', 'batman@dc.com']
];

$status = sqli::multiInsert("user(nome, email)", $toInsert);

if($status) echo "success!";