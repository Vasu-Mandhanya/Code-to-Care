<?php

require("connection.php");


$stateName = $_POST["Name"];


$querySt = "Select dist.name,dist.district_code from district dist,state st where dist.state_code = st.state_code and st.name = '$stateName'";

$statement = $connection->prepare($querySt);

$statement->execute();

$myarray = array();

while($resultsFrom = $statement->fetch()){
    array_push(
        $myarray,array(
            
            "Dist_Name"=>$resultsFrom['name'], //name code is column name
            "Dist_Code"=>$resultsFrom['district_code'],
            
        )
    );
}



echo json_encode($myarray);






?>