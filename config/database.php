<?php
$serverName = "pop-os"; 
$connectionOptions = array(
    "Database" => "DBEthicX",
    "Uid" => "sa", 
    "PWD" => "Igaramadana123#" 
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}