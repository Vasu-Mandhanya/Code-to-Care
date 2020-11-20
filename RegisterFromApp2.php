<?php

require("connection.php");

$userId = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$password = password_hash($password, PASSWORD_DEFAULT); 

$querySt = "INSERT INTO user_email VALUES('$userId','$email','$password')";

$statement = $connection->prepare($querySt);

$statement->execute();



echo json_encode("INSERTED DATA");




?>

