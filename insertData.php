<?php

require("connection.php");

$userId = $_POST["Id"];
$userName = $_POST["Name"];
$userCity = $_POST["City"];
$userContact = $_POST["Contact"];

$querySt = "INSERT INTO test_table (id,Name,City,Contact) VALUES('$userId','$userName','$userCity','$userContact')";

$statement = $connection->prepare($querySt);

$statement->execute();

echo json_encode("INSERTED DATA");




?>