<?php

use SQLi\SQLi as sqli;

$toInsert = ['ss', 'User Smith', 'usmith@email.com'];

$id = sqli::lastInsert("user(nome, email)", $toInsert);

if($id) echo $id;