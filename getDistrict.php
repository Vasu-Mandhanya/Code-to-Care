<?php
require('connection.php');

$makeQuery= "SELECT Name FROM district WHERE State_Code='ST003'";

$statement = $connection->prepare($makeQuery);

$statement->execute();

$myarray = array();

while($resultsFrom = $statement->fetch()){
    array_push(
        $myarray,array(
            "Name"=>$resultsFrom['Name'],
            
        )
    );
}

echo json_encode($myarray);



?>