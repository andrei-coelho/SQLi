<?php

use SQLi\SQLi as sqli;

$toInsert = ['ss', 'User Smith', 'usmith@email.com'];

$status = sqli::insert("user(nome, email)", $toInsert);

# important : this is sensitivity for boolean
if($status === true) echo "success!";