<?php

require("connection.php");

//$userId = $_POST["UserId"];


$querySt = "SELECT h.Image,h.Name 'Hname',h.Email,h.Phone,l.Address,l.Pincode,d.Name 'Dname',b.Normal,b.ICU,b.Ventilators FROM hospital h INNER JOIN beds b ON h.Hospital_ID=b.Hospital_ID INNER JOIN location l ON h.Location_ID=l.Location_ID INNER JOIN district d ON l.District_Code =d.District_Code WHERE d.District_Code= 'D549'";



$statement = $connection->prepare($querySt);

$statement->execute();

$myarray = array();

while($resultsFrom = $statement->fetch()){
    array_push(
        $myarray,array(
            "image"=>$resultsFrom['Image'],
            "name"=>$resultsFrom['Hname'],
            "email"=>$resultsFrom['Email'],
            "phone"=>$resultsFrom['Phone'],
            "address"=>$resultsFrom['Address'],
            "normal"=>$resultsFrom['Normal'],
            "icu"=>$resultsFrom['ICU'],
            "ventilators"=>$resultsFrom['Ventilators'],
            
            
            
            
        )
    );
}

echo json_encode($myarray);




?>