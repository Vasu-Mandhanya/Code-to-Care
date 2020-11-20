<?php

require("connection.php");

$userId = $_POST["UserId"];


$querySt = "select name from district where district_code = (select district_code from location where location_id = (select location_id from user_location where user_id = '$userId'));";

//select name from district where district_code = (select district_code from location where location_id = (select location_id from user_location where user_id = '$userid'))

$statement = $connection->prepare($querySt);

$statement->execute();

$myarray = array();

while($resultsFrom = $statement->fetch()){
    array_push(
        $myarray,array(
            "District"=>$resultsFrom['name'],
            
        )
    );
}

echo json_encode($myarray);




?>