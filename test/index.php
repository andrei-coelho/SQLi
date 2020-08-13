<?php 


require __dir__.DIRECTORY_SEPARATOR."../autoload.php";

use SQLi\SQLi as sqli;

sqli::setDB(file_get_contents('db.json'), function($error, $db){
	if($db->alias() === "mydb2"){
		echo "mydb2 está fora do ar mas não tem problema. "; 
	} else {
		echo "Erro crítico! mydb1 parou!";
		sqli::closeAll();
		exit;
	}
});

$toInsert = ['sss', 'Gustavo', 'gustavo@gmail.com', 'senha1'];
$id       = sqli::lastInsert('tabela_test(nome,email,senha)', $toInsert);

if($id) {
	echo "Foi inserido um usuário. Seu id é: ".$id;
} else {
	echo "Já existe um usuário com este e-mail: erro:".sqli::getLastError();
}

$query = sqli::query("SELECT * FROM tabela_test");
if($query)
	print_r($query->fetchAllAssoc());
else  echo "<br>\n".sqli::getLastError();	

	
