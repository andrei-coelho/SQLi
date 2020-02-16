<?php 


require __dir__.DIRECTORY_SEPARATOR."../autoload.php";

use SQLi\SQLi as sqli;

sqli::setDB(file_get_contents('db.json'), function($error, $db){
	if($db->alias() === "mydb1"){
		echo "mydb1 está fora do ar mas não tem problema. "; 
	} else {
		echo "Erro crítico! mydb2 parou!";
		sqli::closeAll();
		exit;
	}
});

$query1 = sqli::query("SELECT * FROM sessions WHERE nome LIKE ?", ['s', '%a%']);
$query2 = sqli::query("SELECT * FROM sessions WHERE nome LIKE ?", ['s', '%a%'], "mydb2");

if($query1)
	var_dump($query1->fetchAllAssoc());


$query2 = sqli::multiInsert(
    "sessions (nome, value)",
	['ss', ['test1A', 'test2A'], ['test1B', 'test2B']]);
	
