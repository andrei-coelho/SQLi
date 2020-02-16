<?php

use SQLi\SQLi as sqli;

$update = sqli::exec("UPDATE user SET name = ? WHERE id = ?", ['si', 'Bruce', 1]);

$delete = sqli::exec("DELETE FROM logs");

if($update && $delete) echo "success";