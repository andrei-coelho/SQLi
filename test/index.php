﻿<?php 


require "../autoload.php";

use SQLi\SQLi as sqli;

sqli::setDB('
{
    "mydb1":{
        "driver":"mysql",
        "host":"localhost",
        "dbname":"webbot",
        "user":"root",
        "pass":""
    },
    "mydb2":{
        "driver":"pgsql",
        "host":"127.0.0.1",
        "dbname":"other",
        "user":"username",
        "pass":"passuser",
        "port":"10004"
    }
}');

$query1 = sqli::query(
    "SELECT * FROM sessions");

$query2 = sqli::multiInsert(
    "sessions (nome, value)",
	['ss', ['test1A', 'test2A'], ['test1B', 'test2B']]);

while($val = $query1->fetchAll()){
    print_r($val);
    echo "<br>";
}