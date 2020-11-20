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
?>
<body>
<?php
// Include config file
require_once "DB/connect.php";
 
// Define variables and initialize with empty values
$fname = $mname = $sname = $email = $phone = $email = $state = $qual = $spec = "";
$fname_err = $mname_err = $sname_err = $phone_err = $email_err = $state_err = $qual_err = $spec_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate email
    if(empty(trim($_POST["Email"]))){
        $email_err = "Please enter an email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT email FROM doc_mail WHERE email = ?";
        
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["Email"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $email_err = "You have already registered.";
                } else{
                    $email = trim($_POST["Email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    //Validate First Name
    if(empty(trim($_POST["Fname"]))){
        $fname_err = "Please enter your name.";
    }else{
        $fname = trim($_POST["Fname"]);
    }
    //Validate qualifiaction
    if(empty(trim($_POST["Qual"]))){
        $qual_err = "Please enter your qualification.";
    }else{
        $qual = trim($_POST["Qual"]);
    }
    //validate specialization
    if(empty(trim($_POST["Spec"]))){
        $spec_err = "Please enter your specialization.";
    }else{
        $spec = trim($_POST["Spec"]);
    }

     //Validate State
     if(empty(trim($_POST["State"]))||$_POST["State"]=="#"){
        $state_err = "Please Choose a State"; 
        #$popmessage ="Invalid Data Recieved. Page will be reloaded.";
        #echo "<script> alert('$popmessage');</script>"; 
        #header("Refresh: 0");
        #exit(0);
    }
	
    // Validate Phone
    if(empty(trim($_POST["Phone"]))){
        $phone_err = "Please enter a phone number.";
    }elseif(strlen(trim($_POST["Phone"]))<10){
        $phone_err = "Phone number must be of atleast 10 digits.";
    }
     else{
        // Prepare a select statement
        $sql = "SELECT Phone_No FROM doc_phone WHERE Phone_No = ?";
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_phone);
            // Set parameters
            $param_phone = trim($_POST["Phone"]);
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $phone_err = "You have already registered.";
                } else{
                    $phone = trim($_POST["Phone"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
    $mname=$_POST["Mname"];
    $sname=$_POST["Sname"];

        // Check input errors before inserting in database
        if(empty($fname_err) && empty($email_err) && empty($phone_err) && empty($qual_err) && empty($state_err) &&  empty($spec_err)){
                    $state=$_POST["State"];
                    $_SESSION["Fname"]=$fname;
                    $_SESSION["Mname"]=$mname;
                    $_SESSION["Sname"]=$sname;
                    $_SESSION["Phone"]=$phone;
                    $_SESSION["Email"]=$email;
                    $_SESSION["Qual"]=$qual;
                    $_SESSION["Spec"]=$spec;
                    $_SESSION["State"]=$state;
                    $_SESSION["Location_set"]=false;
                    // Redirect to location page
                    header("location: DoctorLocation.php");
                } else{
                    echo "Something went wrong. Please try again later.";
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
          <li><a class="nav-link active" href="advice.php"> Seek Advice  </a></li>
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
          echo '<li><a class="nav-link" href="login.php">Login</a></li>';
      }
      ?>
    </ul>
    </div>
</nav>
</header>
<div class="wrapper" style="
    overflow-y: scroll;
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
        <h2 style="text-align:center">Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($fname_err)) ? 'has-error' : ''; ?>">
                <label>First Name</label>
                <input type="text" name="Fname" class="form-control" value="<?php echo $fname; ?>">
				<span class="help-block"><?php echo $fname_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($mname_err)) ? 'has-error' : ''; ?>">
                <label>Middle Name</label>
                <input type="text" name="Mname" class="form-control" value="<?php echo $mname; ?>">
				<span class="help-block"><?php echo $mname_err; ?></span>
            </div> 
			<div class="form-group <?php echo (!empty($sname_err)) ? 'has-error' : ''; ?>">
                <label>Surname</label>
                <input type="text" name="Sname" class="form-control" value="<?php echo $sname; ?>">
				<span class="help-block"><?php echo $sname_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                <label>Phone No.</label>
                <input type="text" name="Phone" class="form-control" value="<?php echo $phone; ?>">
                <span class="help-block"><?php echo $phone_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email IDs</label>
                <input type="text" name="Email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>  
            <div class="form-group <?php echo (!empty($spec_err)) ? 'has-error' : ''; ?>">
                <label>Specialization</label>
                <input type="text" name="Spec" class="form-control" value="<?php echo $spec; ?>">
                <span class="help-block"><?php echo $spec_err; ?></span>
            </div>  
            <div class="form-group <?php echo (!empty($qual_err)) ? 'has-error' : ''; ?>">
                <label>Qualification</label>
                <input type="text" name="Qual" class="form-control" value="<?php echo $qual; ?>">
                <span class="help-block"><?php echo $qual_err; ?></span>
            </div>     
            <div class="form-group <?php echo (!empty($state_err)) ? 'has-error' : ''; ?>">
                <label>State</label>
                <select class="form-control" name="State" onchange="getId(this.value);">
                <option value="#">Select State</option>
                    <?php
                    $query = "SELECT * FROM state;";
                    $results=mysqli_query($conn, $query);
                    //loop
                    foreach ($results as $states){
                       echo "<option value=";
                        echo $states["State_Code"];
                       echo ">";
                       echo $states["Name"];
                       echo "</option>";
                    }
                ?>
                </select>
                <span class="help-block"><?php echo $state_err; ?></span>
            </div>    
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
        </form>
    </div>   
</body>
</html>		