<?php

require("connection.php");

$userId = $_POST["UserId"];


$querySt = "select Active,Recovered,Deaths from cases where district_code = (select District_code from location where Location_ID = ( select Location_ID from user_location where User_ID = '$userId'));";

//select name from district where district_code = (select district_code from location where location_id = (select location_id from user_location where user_id = '$userid'))

$statement = $connection->prepare($querySt);

$statement->execute();

$myarray = array();

while($resultsFrom = $statement->fetch()){
    array_push(
        $myarray,array(
            "Active"=>$resultsFrom['Active'],
            "Recovered"=>$resultsFrom['Recovered'],
            "Deaths"=>$resultsFrom['Deaths'],
            
            
        )
    );
}

echo json_encode($myarray);




?>