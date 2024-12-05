<?php
$serverName = "PINED"; 
$connectionOptions = array(
    "Database" => "DBEthicX",
    "Uid" => "sa", 
    "PWD" => "nopakepin21" 
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}   