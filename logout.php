<?php
// Initialize the session
session_start();
/*if(!isset($_SESSION["loggedin"]))
{
    header("location : index.php");
}*/
// Unset all of the session variables
$_SESSION = array();
// Destroy the session.
session_destroy();
#echo "<script> alert('You Have Been Logged Out. You we will be redirected home page'); </script>";
// Redirect to home page
header("location: index.php");
#exit;
?>