 <?php
$servernamedb = "localhost";
$usernamedb = "root";
$passworddb = "mysql";
$dbname="id15223135_covital";

// Create connection
$conn = new mysqli($servernamedb, $usernamedb, $passworddb,$dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
else{
    //echo "successful";
}

?>