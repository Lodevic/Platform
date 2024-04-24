<?php

$hostname = "localhost";
$username =  "root";
$password = "";
$database_name = "platform";

$db = mysqli_connect($hostname, $username, $password, $database_name);

if ($db->connect_error) {
    echo "Connect ERROR";
    die("ERROR");
}else{
    echo "Connect OK";
}

?>