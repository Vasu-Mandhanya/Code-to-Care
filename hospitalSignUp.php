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
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
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
$name=$phone=$web=$img=$username = $email = $password = $confirm_password = $state = "";
$name_err=$phone_err=$web_err=$img_err=$username_err = $email_err = $password_err = $confirm_password_err = $state_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    //Validate Name
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter a name.";
    } else{
        $name=trim($_POST["name"]);
    }
    //Validate Phone Number
    if(empty(trim($_POST["phone"]))){
        $phone_err = "Please enter phone number.";
    } elseif(strlen(trim($_POST["phone"])) < 10){
        $phone_err = "Phone Number must have atleast 10 digits.";
    } else{
        $phone=trim($_POST["phone"]);
    }
    // Validate Website
    if(empty(trim($_POST["web"]))){
        $web_err = "Please enter webiste url.";
    } else{
        $web=trim($_POST["web"]);
    }
    //Validate Image url
    if(empty(trim($_POST["img"]))){
        $img_err = "Please enter url for the image.";
    } else{
        $img=trim($_POST["img"]);
    }
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT * FROM hospital WHERE hospital_id = ?";
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $user_id = trim($_POST["username"]);
                    echo $user_id;
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
	}
	
    // Validate Email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT * FROM hospital WHERE email = ?";
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            // Set parameters
            $param_email = trim($_POST["email"]);
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                if($stmt->num_rows == 1){
                    $email_err = "This email has already been used.";
                } else{
                    $emailid = trim($_POST["email"]);
                    echo $emailid;
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            $stmt->close();
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 8){
        $password_err = "Password must have atleast 8 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    //Validate State
    if(empty(trim($_POST["State"]))||$_POST["State"]=="#"){
        $state_err = "Please Choose a State"; 
        #$popmessage ="Invalid Data Recieved. Page will be reloaded.";
        #echo "<script> alert('$popmessage');</script>"; 
        #header("Refresh: 0");
        #exit(0);
    }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($phone_err) && empty($web_err) && empty($img_err) && empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($state_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO hospital(Hospital_ID,Name,Phone,Email,Website,Password,Image) VALUES (?,?,?,?,?,?,?);";
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssssss",$param_username,$param_name,$param_phone,$param_email,$param_web,$param_password,$param_img);
            // Set parameters
            $param_name=$name;
            $param_username = $user_id;
            $param_email = $emailid;
            $param_phone = $phone;
            $param_web = $web;
            $param_img = $img;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            echo $param_name;
            echo $param_username;
            echo $param_email;
            echo $param_phone;
            echo $param_web;
            echo $param_img;
            echo "  ".$param_password;
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Close statement
                $stmt->close();               
                 // Close connection
                $conn->close();   
                $state=$_POST["State"];
                #session_start();
                $_SESSION["State"]=$state;
                $_SESSION["username"]=$user_id;
                $_SESSION["usertype"]="hospital";
                $_SESSION["Location_set"]=false;
                // Redirect to location page
                header("location: HospitalRegisterLocation.php");
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
          <li><a class="nav-link active" href="hospitals.php"> Hospitals  </a></li>
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
          echo '<li><a class="nav-link" href="login.php">Login</a></li>';
      }
      ?>
    </ul>
    </div>
</nav>
</header>
<div class="wrapper " style="
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
        <div class="container vertical-scrollable">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Name of the Hospital:</label> 
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
				<span class="help-block"><?php echo $name_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                <label>Phone Number:</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
				<span class="help-block"><?php echo $phone_err; ?></span>
            </div>  
            <div class="form-group <?php echo (!empty($web_err)) ? 'has-error' : ''; ?>">
                <label>Website:</label>
                <input type="text" name="web" class="form-control" value="<?php echo $web; ?>">
				<span class="help-block"><?php echo $web_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($img_err)) ? 'has-error' : ''; ?>">
                <label>Image URl:</label>
                <p> Please give the url for the image to be displayed on our site.</p>
                <input type="text" name="img" class="form-control" value="<?php echo $img; ?>">
				<span class="help-block"><?php echo $img_err; ?></span>
            </div> 
			<div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email ID:</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
				<span class="help-block"><?php echo $email_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username:</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password:</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password:</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
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
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
    </div>   
</body>
</html>