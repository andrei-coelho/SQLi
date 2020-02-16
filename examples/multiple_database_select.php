<?php 

require "SQLi/autoload.php";
use SQLi\SQLi as sqli;

// conn
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
    }
}');

// 'mydb1' is the default database, bacause is the first database registered

$query1 = sqli::query("SELECT * FROM user"); // 'mydb1'
$query2 = sqli::query("SELECT * FROM clients", [], "mydb2"); // 'mydb2'
$query3 = sqli::query("SELECT * FROM employe"); // 'mydb1' 

// show results from table 'user' from database 'mydb1'
while($row = $query1-> fetchAssoc()) print_r($row); 

// show results from table 'clients' from database 'mydb2'
while($row = $query2-> fetchAssoc()) print_r($row);

// show results from table 'employe' from database 'mydb1'
while($row = $query3-> fetchAssoc()) print_r($row);



