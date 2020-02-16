<?php 

use SQLi\SQLi as sqli;

//                                                     BIND PARAMETER          VALUES
//                                                 __________|_________     _____|______
//                                                |             |      |   |            |
$qry = sqli::query("SELECT * FROM user WHERE id = ? AND email = ?", ['is', 1, 'user@email.com']);
//                                                ^             ^
//                                                |___ (i)'1'   |___ (s)'user@email.com'
$arr = $qry ->fetchAllAssoc(); // rows results

