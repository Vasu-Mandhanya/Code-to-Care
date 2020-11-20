<?php
require('connection.php');

$makeQuery= "SELECT * FROM test_table";

$statement = $connection->prepare($makeQuery);

$statement->execute();

$myarray = array();

while($resultsFrom = $statement->fetch()){
    array_push(
        $myarray,array(
            "id"=>$resultsFrom['id'],
            "Name"=>$resultsFrom['Name'],
            "City"=>$resultsFrom['City'],
            "Contact"=>$resultsFrom['Contact']
        )
    );
}

echo json_encode($myarray);



?>