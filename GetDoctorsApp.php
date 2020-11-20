<?php
require('connection.php');

$makeQuery= "SELECT d.First_Name,d.Last_Name,d.Specialization,d.Qualification,p.Phone_No from doctors d, doc_phone p where d.Doc_ID = p.Doc_ID";

$statement = $connection->prepare($makeQuery);

$statement->execute();

$myarray = array();

while($resultsFrom = $statement->fetch()){
    array_push(
        $myarray,array(
            "First_Name"=>$resultsFrom['First_Name'],
            "Last_Name"=>$resultsFrom['Last_Name'],
            "Specialization"=>$resultsFrom['Specialization'],
            "Qualification"=>$resultsFrom['Qualification'],
            "Phone"=>$resultsFrom['Phone_No'],
            
        )
    );
}

echo json_encode($myarray);



?>