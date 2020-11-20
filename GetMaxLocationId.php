<?php

require("connection.php");



$querySt = "Select Max(Location_Id) from location";

$statement = $connection->prepare($querySt);

$statement->execute();

$myarray = array();

while($resultsFrom = $statement->fetch()){
    array_push(
        $myarray,array(
            "id"=>$resultsFrom['Max(Location_Id)'],

        )
    );
}

echo json_encode($myarray);



?>