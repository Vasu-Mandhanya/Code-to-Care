<!doctype html>
<html>
<head>
<link rel="icon" href="Assets/logo.png" type="image/icon type">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CoVITal</title>
 <!-- Latest compiled and minified CSS -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
<link href="css/styles.css" rel="stylesheet" type="text/css">
<style>
body {
  background-image: url('Assets/GettyImages-1200706447-crop.jpg');
  background-size: cover;
}
</style>
</head>
<?php 
  // Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]))
{
    header("location: index.php");
    exit;  
}
elseif(!$_SESSION["usertype"]=="hospital")
{
    header("location: index.php");
    exit; 
}
?>
<body>
<?php
// Include config file
require_once "DB/connect.php";
// Define variables and initialize with empty values
$username=$_SESSION["username"];
$normal = $icu = $ventilator = "";
$normal_err = $icu_err = $ventilator_err =  "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
//Validate Normal Bed Count
    if(empty(trim($_POST["normal"])))
    {
        $normal_err="Please Enter General Ward Bed Count.";
    }
    else
    {
        $normal=$_POST["normal"];
    }

    //Validate ICU Bed Count
    if(empty(trim($_POST["icu"])))
    {
        $icu_err="Please Enter ICU Bed Count.";
    }
    else
    {
        $icu=$_POST["icu"];
    }

    //Validate Ventilator Bed Count
    if(empty(trim($_POST["ventilator"])))
    {
        $ventilator_err="Please Enter Ventilator Bed Count.";
    }
    else
    {
        $ventilator=$_POST["ventilator"];
    }

    // Check input errors before inserting in database
    if(empty($icu_err) && empty($normal_err) && empty($ventilator_err))
    {
        // Prepare an insert statement
        $sql = "INSERT INTO beds(hospital_id,ICU,Normal,Ventilators) VALUES (?,?,?,?)
        ON DUPLICATE KEY UPDATE 
        ICU=$icu,
        Normal=$normal,
        Ventilators=$ventilator;";
        echo $sql;
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("siii", $param_username,$param_icu,$param_normal,$param_ventilator);
            // Set parameters
			$param_username = $username;
			$param_icu= $icu;
            $param_ventilator = $ventilator;
            $param_normal =$normal;
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Close statement
                $stmt->close();               
                 // Close connection
                $conn->close();   
                header("location: hospitalProfile.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
            // Close statement
            $stmt->close();
		}
		else{
			echo "not working 2";
		}
	}
    // Close connection
    $conn->close();
}
?>
<header>
  <nav class="navbar navbar-expand-lg navbar-purple">
  <a class="navbar-brand" href="index.php">CoVITal</a>
  <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
          <li>
          <a class="nav-link" href="info.php"> Info  <span class="sr-only">(current)</span></a>
          </li>
          <li><a class="nav-link" href="about.php"> About Us  </a></li>
          <li><a class="nav-link" href="hospitals.php"> Hospitals  </a></li>
          <li><a class="nav-link" href="advice.php"> Seek Advice  </a></li>
          <li><a class="nav-link" href="cases.php"> Track Cases  </a></li>
        </ul>
        <ul class="navbar-nav ml-auto">
        <?php 
  // Initialize the session
#session_start();
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
        {
            if($_SESSION["usertype"]=="user")
            {
        echo "
        <li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
            Hi ".$_SESSION['username'].'
        </a>
        <div class="dropdown-menu" style="background-color: #663399 ;" aria-labelledby="navbarDropdown">
          <a class="nav-link" href="user.php">Profile</a>
          <div class="dropdown-divider"></div>
          <a class="nav-link" href="logout.php">Sign Out</a>
        </div>
      </li>';
      }
      elseif ($_SESSION["usertype"]=="hospital") {
        echo "
        <li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle active' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
        ".$_SESSION['username'].'
        </a>
        <div class="dropdown-menu" style="background-color: #663399 ;" aria-labelledby="navbarDropdown">
          <a class="nav-link" href="hospitalProfile.php">Patients</a>
          <a class="nav-link" href="HospitalUpdateInfo.php">Profile</a>
          <div class="dropdown-divider"></div>
          <a class="nav-link" href="logout.php">Sign Out</a>
        </div>
      </li>';
      }
    }
      else
      {
          echo '<li><a class="nav-link" href="login.php">Login</a></li>';
      }
      ?>
    </ul>
    </div>
</nav>
</header>
<div class="wrapper" style="
    display: inline-block;
    position: fixed;
    top: 80px;
    bottom: 0;
    left: 0;
    right: 0;
    width: 500px;
    height: 700px;
    margin: auto;
    background-color: #f3f3f3;">
        <h2 style="text-align:center">Update Bed Count</h2>
        <p>Please Enter the Updated Bed Count</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class="form-group <?php echo (!empty($normal_err)) ? 'has-error' : ''; ?>">
                <label>General Ward</label>
                <input type="text" name="normal" class="form-control" value="<?php echo $normal; ?>">
				<span class="help-block"><?php echo $normal_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($icu_err)) ? 'has-error' : ''; ?>">
                <label>ICU</label>
                <input type="text" name="icu" class="form-control" value="<?php echo $icu; ?>">
                <span class="help-block"><?php echo $icu_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($ventilator_err)) ? 'has-error' : ''; ?>">
                <label>Ventilator</label>
                <input type="text" name="ventilator" class="form-control" value="<?php echo $ventilator; ?>">
                <span class="help-block"><?php echo $ventilator_err; ?></span>
            </div> 
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>   
</body>
</html>