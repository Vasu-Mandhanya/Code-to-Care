<?php

require("connection.php");

$email = $_POST["Email"];
$userid = $_POST["UserId"];


$querySt = "Select Email_Id,User_Id from user_email where Email_Id = '$email' or User_Id = '$userid' limit 1";

$statement = $connection->prepare($querySt);

$statement->execute();

$myarray = array();

while($resultsFrom = $statement->fetch()){
    array_push(
        $myarray,array(
            "Email"=>$resultsFrom['Email_Id'],
            "UserId"=>$resultsFrom['User_Id'],
            
        )
    );
}

echo json_encode($myarray);




?>