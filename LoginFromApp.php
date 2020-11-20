<?php

require("connection.php");


$email = $_POST["email"];
$password = $_POST["password"];
//$password = password_hash($password, PASSWORD_DEFAULT); 

$querySt = "Select User_Id,Password from user_email where Email_Id = '$email'  "; // and Password = '$password'

$statement = $connection->prepare($querySt);

$statement->execute();

$myarray = array();

while($resultsFrom = $statement->fetch()){
    if(password_verify($password, $resultsFrom['Password'])){
    array_push(
        $myarray,array(
            
            "UserName"=>$resultsFrom['User_Id'], //User_Id code is column name
            
        )
    );
    }
}




echo json_encode($myarray);






?>