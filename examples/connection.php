<?php 

require "SQLi/autoload.php";
use SQLi\SQLi as sqli;


// min config database
sqli::setDB('
{
    "mydb1":{
        "driver":"mysql",
        "host":"localhost",
        "dbname":"mydb",
        "user":"root",
        "pass":""
    }
}');


// full config database
sqli::setDB('
{
    "mydb":{
        "driver":"mysql",
        "host":"localhost",
        "dbname":"mydb",
        "user":"root",
        "pass":"",
		
		"charset":"utf8", <-- optional (utf8 is default)
		"port":"9999"     <-- maybe is necessary
    }
}');


// multiple databases
sqli::setDB('
{
    "mydb1":{
        "driver":"mysql",
        "host":"localhost",
        "dbname":"mydb1",
        "user":"root",
        "pass":""
    },
	"mydb2":{
        "driver":"mysql",
        "host":"localhost",
        "dbname":"mydb2",
        "user":"root",
        "pass":""
    },
	"mydb3":{
        "driver":"mysql",
        "host":"localhost",
        "dbname":"mydb3",
        "user":"root",
        "pass":""
    }
}');


// using files json
sqli::setDB(file_get_contents("myfile.json"));


// using callback function when an error connection occurs 
sqli::setDB(file_get_contents("myfile.json"), function($error, $database){
	// do something
});


// using callback function when an error connection occurs 
// in one or more databases 
sqli::setDB('
{
    "mydb1":{
        "driver":"mysql",
        "host":"localhost",
        "dbname":"mydb",
        "user":"root",
        "pass":""
    },
	"mydb2":{
        "driver":"mysql",
        "host":"localhost",
        "dbname":"mydb2",
        "user":"root",
        "pass":""
    }
}', 
function($error, $database){
	
	if($database->alias() == "mydb1"){
		// do something
	} else if ($database->alias() == "mydb2"){
		// do something
	}
	sqli::closeAll(); // close all connections
	
});




