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
if(isset($_SESSION['Location_set']))
{
    if($_SESSION['Location_set']==true)
    {
        header("location: index.php");
        exit;
    }
}
else
{
    header("location: index.php");
    exit;
}
if(!isset($_SESSION["loggedin"]))
{
    header("location: login.php");
    exit;  
}
if(!isset($_SESSION["username"]))
{
    header("location: login.php");
    exit;  
}
?>
<body>
<?php
// Include config file
require_once "DB/connect.php";
// Define variables and initialize with empty values
$state=$_SESSION['State'];
$district = $address = $pincode = "";
$state_err = $district_err = $address_err = $pincode_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
 
    // Validate District
    if(empty(trim($_POST["District"]))||$_POST["District"]=="#"){
        $district_err = "Please Choose a District"; 
    }
    else{
        $district=$_POST["District"];
    }
	
    // Validate Address
    if(empty(trim($_POST["Address"]))){
        $address_err = "Please enter address.";
    } 
    else{
        $address=$_POST["Address"];
    }
    
    // Validate Pincode
    if(empty(trim($_POST["Pincode"]))){
        $pincode_err = "Please enter pincode";     
    } elseif(strlen(trim($_POST["Pincode"])) !=6){
        $pincode_err = "Pincode must have 6 digits.";
    } else{
        $pincode = trim($_POST["Pincode"]);
    }
    
    // Check input errors before inserting in database
    if(empty($district_err) && empty($address_err) && empty($pincode_err))
	{
        // Prepare an insert statement
        $sql1 = "INSERT INTO location (pincode,address,district_code) VALUES (?,?,?)";
        if($stmt1 = $conn->prepare($sql1))
		{
            // Bind variables to the prepared statement as parameters
            $stmt1->bind_param("sss", $param_pincode,$param_address,$param_district_code);
            // Set parameters
			$param_pincode= $pincode;
			$param_address= $address;
            $param_district_code = $district; 
            // Attempt to execute the prepared statement
            if($stmt1 ->execute())
            {
                $query = "SELECT location_id FROM location WHERE pincode='$pincode' and address='$address' and district_code='$district';";
                $res=mysqli_query($conn, $query);
				foreach ($res as $loc)
					{
						$location_id=$loc['location_id'];
                    }
                $user_id=$_SESSION['username'];
                #$location_id=$res['location_id'];
                $sql2 = "UPDATE user_location SET location_id=?  WHERE user_id=?;";
                if($stmt2 = $conn->prepare($sql2))
				{
                    // Bind variables to the prepared statement as parameters
                    $stmt2->bind_param("ss",$param_location_id,$param_user_id);
                    // Set parameters
                    $param_location_id=$location_id;
                    $param_user_id=$user_id;
                    // Attempt to execute the prepared statement
                    if($stmt2 ->execute())
                    {
                        // Close statement
                         $stmt1->close();
                        // Close connection
                        $conn->close();
                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        #$_SESSION["username"] = $user_id;  
                        $_SESSION["usertype"] = "user";    
                        // Redirect to user profile
                        header("location: user.php");
                    }
                    {
                        echo "NOT WORKING 2";
                    }
					$res->close();
                }
                {
					echo "NOT WORKING 1";
				}
			}
			else
				{
					echo "Something went wrong. Please try again later.";
				}
            // Close statement
            $stmt1->close();
		}
    // Close connection
    $conn->close();
	}
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
        <a class='nav-link dropdown-toggle' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
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
          echo '<li><a class="nav-link active" href="login.php">Login</a></li>';
      }
      ?>
    </ul>
    </div>
</nav>
</header>
<div class="wrapper" style="
    display: inline-block;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    width: 500px;
    height: 600px;
    margin: auto;
    background-color: #f3f3f3;">
        <h2>Location Details</h2>
        <p>Please tell us where you live.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($district_err)) ? 'has-error' : ''; ?>">
                <label>District</label>
                <select class="form-control" name="District" onchange="getId(this.value);">
                <option value="#">Select District</option>
                <?php
                    $query = "SELECT * FROM district WHERE State_Code='$state';";
                    $results=mysqli_query($conn, $query);
                    //loop
                    foreach ($results as $districts)
					{
                       echo "<option value=";
                       echo $districts["District_Code"];
                       echo ">";
                       echo $districts["Name"];
                       echo "</option>";
                    }
					$results->close();
                ?>
                </select>
                <span class="help-block"><?php echo $district_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                <label>Address</label>
                <input type="text" name="Address" class="form-control" value="<?php echo $address; ?>">
                <span class="help-block"><?php echo $address_err; ?></span>
            </div>    
			<div class="form-group <?php echo (!empty($pincode_err)) ? 'has-error' : ''; ?>">
                <label>Pincode</label>
                <input type="text" name="Pincode" class="form-control" value="<?php echo $pincode; ?>">
				<span class="help-block"><?php echo $pincode_err; ?></span>
            </div>    
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
        </form>
    </div>   
</body>
</html>