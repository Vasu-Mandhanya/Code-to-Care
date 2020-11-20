<?php

require("connection.php");


$pincode = (int) $_POST["pincode"];
$address = $_POST["address"];
$districtCode = $_POST["districtCode"];

$querySt = "INSERT INTO location(Pincode,Address,District_Code) VALUES('$pincode','$address','$districtCode')";

$statement = $connection->prepare($querySt);

$statement->execute();



echo json_encode("INSERTED DATA");




?>

