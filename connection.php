<?php

try{
    $connection = new PDO('mysql:host=localhost;dbname=id15223135_covital','id15223135_shahbaz','3Y93NjG2XYq5FEx_');
    $connection -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    //echo "yes connected";
}catch(PDOException $exc){
    echo $exc ->getMessage();
    die("could not connect");
}




?>