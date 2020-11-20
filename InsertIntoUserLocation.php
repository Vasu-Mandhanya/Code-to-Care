<?php

require("connection.php");

$userId = $_POST["Id"];
$locationId = (int) $_POST["LocationId"];

$querySt = "INSERT INTO user_location(User_ID,Location_ID) VALUES('$userId','$locationId')";

$statement = $connection->prepare($querySt);

$statement->execute();

echo json_encode("INSERTED DATA");




?>