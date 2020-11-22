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
</head>
<?php 
  // Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
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
if($_SESSION["usertype"]!="hospital")
{
    header("location: index.php");
    exit;  
}
require_once "DB/connect.php";
$user=$_SESSION['username'];
$email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = "";
$phone = $image =$web= "";
$phone_err = $image_err =$web_err= "";
$image_update=$web_update=$email_update=$password_update=$phone_update='';
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST['submit1']))
    { 
        // Validate Email
        if(empty(trim($_POST["email"]))){
            $email_err = "Please enter a email.";
        } else{
            // Prepare a select statement
            $sql = "SELECT email FROM hospital WHERE email = ?";
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
                        $email = trim($_POST["email"]);
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
                // Close statement
                $stmt->close();
            }
        }
        // Check input errors before inserting in database
        if (empty($email_err)){
            // Prepare an insert statement
            $sql1 = "UPDATE hospital SET Email = ? WHERE Hospital_ID =?";
            if($stmt1 = $conn->prepare($sql1)){
                // Bind variables to the prepared statement as parameters
                $stmt1->bind_param("ss",$param_email_id,$param_username);
                // Set parameters
                $param_username = $user;
                $param_email_id = $email; 
                // Attempt to execute the prepared statement
                if($stmt1->execute()){
                    $email_update="Email Updated Successfully !";
                    // Close statement
                    $stmt1->close();                
                } else{
                    echo "Something went wrong. Please try again later.";
                }
                // Close statement
                #$stmt1->close();
            }
            else{
                echo "not working 2";
            }
        }
    }

    if(isset($_POST['submit2']))
    {
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
    
        
        // Check input errors before inserting in database
        if (empty($password_err) && empty($confirm_password_err)){
            // Prepare an insert statement
            $sql2 = "UPDATE hospital SET password = ? WHERE Hospital_ID =?";
            if($stmt2 = $conn->prepare($sql2)){
                // Bind variables to the prepared statement as parameters
                $stmt2->bind_param("ss",$param_password,$param_username);
                // Set parameters
                $param_username = $user;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                // Attempt to execute the prepared statement
                if($stmt2->execute()){
                    $password_update="Password Updated Successfully !";
                    // Close statement
                    $stmt2->close();                
                } else{
                    echo "Something went wrong. Please try again later.";
                }
                // Close statement
                #$stmt1->close();
            }
            else{
                echo "not working 2";
            }
        }
    }


    if(isset($_POST['submit3']))
    {
        // Validate Phone
        if(empty(trim($_POST["Phone"]))){
            $phone_err = "Please Enter a Phone Number"; 
        }
        elseif(strlen($_POST["Phone"])<10){
            $phone_err = "Phone Number Must be Atleast 10 digits"; 
        }
        else{
            $phone=$_POST["Phone"];
        }


        // Check input errors before inserting in database
        if (empty($phone_err)){
            // Prepare an insert statement
            $sql1 = "UPDATE hospital SET Phone = ? WHERE Hospital_ID =?";
            if($stmt1 = $conn->prepare($sql1)){
                // Bind variables to the prepared statement as parameters
                $stmt1->bind_param("ss",$param_email_id,$param_username);
                // Set parameters
                $param_username = $user;
                $param_email_id = $phone; 
                // Attempt to execute the prepared statement
                if($stmt1->execute()){
                    $phone_update="Phone Updated Successfully !";
                    // Close statement
                    $stmt1->close();                
                } else{
                    echo "Something went wrong. Please try again later.";
                }
                // Close statement
                #$stmt1->close();
            }
            else{
                echo "not working 2";
            }
        }


    }


    if(isset($_POST['submit4']))
    {
        // Validate Website Url
        if(empty(trim($_POST["Web"]))){
            $web_err = "Please Enter Website URL."; 
        }
        else{
            $web=$_POST["Web"];
        }


        // Check input errors before inserting in database
        if (empty($web_err)){
            // Prepare an insert statement
            $sql1 = "UPDATE hospital SET Website = ? WHERE Hospital_ID =?";
            if($stmt1 = $conn->prepare($sql1)){
                // Bind variables to the prepared statement as parameters
                $stmt1->bind_param("ss",$param_email_id,$param_username);
                // Set parameters
                $param_username = $user;
                $param_email_id = $web; 
                // Attempt to execute the prepared statement
                if($stmt1->execute()){
                    $web_update="Website Updated Successfully !";
                    // Close statement
                    $stmt1->close();                
                } else{
                    echo "Something went wrong. Please try again later.";
                }
                // Close statement
                #$stmt1->close();
            }
            else{
                echo "not working 2";
            }
        }



    }

    if(isset($_POST['submit5']))
    {
        // Validate Image Url
        if(empty(trim($_POST["Image"]))){
            $image_err = "Please Enter Image URL"; 
        }
        else{
            $image=$_POST["Image"];
        }

        // Check input errors before inserting in database
        if (empty($image_err)){
            // Prepare an insert statement
            $sql1 = "UPDATE hospital SET Image = ? WHERE Hospital_ID =?";
            if($stmt1 = $conn->prepare($sql1)){
                // Bind variables to the prepared statement as parameters
                $stmt1->bind_param("ss",$param_email_id,$param_username);
                // Set parameters
                $param_username = $user;
                $param_email_id = $image; 
                // Attempt to execute the prepared statement
                if($stmt1->execute()){
                    $image_update="Image Updated Successfully !"; 
                    // Close statement
                    $stmt1->close();                
                } else{
                    echo "Something went wrong. Please try again later.";
                }
                // Close statement
                #$stmt1->close();
            }
            else{
                echo "not working 2";
            }
        }

    }

}

?>
<body>
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
      elseif($_SESSION["usertype"]=="doctor")
      {
        echo "
        <li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
            Hi ".$_SESSION['username'].'
        </a>
        <div class="dropdown-menu" style="background-color: #663399 ;" aria-labelledby="navbarDropdown">
            <a class="nav-link" href="doctorprofile.php">Profile</a>
            <a class="nav-link" href="viewpatients.php">Patients</a>
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
          <a class="nav-link" href="Doctor_Login.php">Doctor</a>
          <a class="nav-link" href="HospitalUpdateInfo.php">Profile</a>
          <div class="dropdown-divider"></div>
          <a class="nav-link" href="logout.php">Sign Out</a>
        </div>
      </li>';
      }
    }
    else
    {
      echo "
      <li class='nav-item dropdown'>
      <a class='nav-link dropdown-toggle active' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
      ".'Login'.'
      </a>
      <div class="dropdown-menu" style="background-color: #663399 ;" aria-labelledby="navbarDropdown">
        <a class="nav-link" href="login.php">User</a>
        <a class="nav-link" href="Doctor_Login.php">Doctor</a>
        <a class="nav-link" href="HospitalLogin.php">Hospital</a>
    </li>';
       // echo '<li><a class="nav-link" href="login.php">Login</a></li>';
    }
      ?>
    </ul>
    </div>
</nav>
</header>

<div class="container">
    <div class="row my-2">
        <div class="col-lg-4 order-lg-1 text-center">
        <hr style="height:0px; visibility:hidden;"/>
        <hr style="height:0px; visibility:hidden;"/>
        <hr style="height:0px; visibility:hidden;"/>
            <img src="
            <?php
                $query8="SELECT Image FROM hospital WHERE Hospital_ID='$user';";
                $result8=mysqli_query($conn,$query8);
                if (mysqli_num_rows($result8) > 0) {
                    while($row8 = mysqli_fetch_assoc($result8))
                        {
                        echo $row8["Image"];
                        }
                    } else {
                    echo "ERROR! NO Image FOUND";
                    }
            ?>
            " class="mx-auto img-fluid img-circle d-block" alt="avatar">
       </div>
        <div class="col-lg-8 order-lg-2">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="" data-target="#profile" data-toggle="tab" class="nav-link active" style="color: black">Profile</a>
                </li>
                <li class="nav-item">
                    <a href="" data-target="#edit" data-toggle="tab" class="nav-link" style="color: black">Edit</a>
                </li>
            </ul>
            <div class="tab-content py-4">
                <div class="tab-pane active" id="profile">
                    <h1 class="mb-3 textCenter" style="color: black; text-transform : uppercase; ">
                    <?php
                                    $query1="SELECT Name FROM hospital WHERE Hospital_ID='$user';";
                                    $result1=mysqli_query($conn,$query1);
                                    if (mysqli_num_rows($result1) > 0) {
                                        while($row1 = mysqli_fetch_assoc($result1))
                                         {
                                           echo $row1["Name"];
                                         }
                                     } else {
                                        echo "ERROR! NO Phone Number FOUND";
                                     }
                    ?>
                </h1>
                    <div class="row">
                        <div class="col-md-6">
                        <h5 style="color: black">Phone Number: </h5>
                        <p>
                                <?php
                                    $query1="SELECT Phone FROM hospital WHERE Hospital_ID='$user';";
                                    $result1=mysqli_query($conn,$query1);
                                    if (mysqli_num_rows($result1) > 0) {
                                        while($row1 = mysqli_fetch_assoc($result1))
                                         {
                                           echo $row1["Phone"];
                                         }
                                     } else {
                                        echo "ERROR! NO Phone Number FOUND";
                                     }
                                ?>
                            </p>
                        <h5 style="color: black">Website url: </h5>
                        <p>
                                <?php
                                    $query1="SELECT Website FROM hospital WHERE Hospital_ID='$user';";
                                    $result1=mysqli_query($conn,$query1);
                                    if (mysqli_num_rows($result1) > 0) {
                                        while($row1 = mysqli_fetch_assoc($result1))
                                         {
                                           echo $row1["Website"];
                                         }
                                     } else {
                                        echo "ERROR! NO Web URL FOUND";
                                     }
                                ?>
                            </p>

                        <h5 style="color: black">Email: </h5>
                            <p>
                                <?php
                                    $query1="SELECT Email FROM hospital WHERE Hospital_ID='$user';";
                                    $result1=mysqli_query($conn,$query1);
                                    if (mysqli_num_rows($result1) > 0) {
                                        while($row1 = mysqli_fetch_assoc($result1))
                                         {
                                           echo $row1["Email"];
                                         }
                                     } else {
                                        echo "ERROR! NO EMAIL FOUND";
                                     }
                                ?>
                            </p>
                            <h5 style="color: black">State: </h5>
                            <p>
                            <?php
                                    $query2="SELECT Name FROM state WHERE State_Code=(SELECT State_Code From district Where District_Code=(SELECT District_Code FROM location WHERE Location_ID = (SELECT Location_ID FROM hospital WHERE Hospital_ID ='$user')));";
                                    $result2=mysqli_query($conn,$query2);
                                    if (mysqli_num_rows($result2) > 0) {
                                        while($row2 = mysqli_fetch_assoc($result2))
                                         {
                                           echo $row2["Name"];
                                         }
                                     } else {
                                        echo "ERROR! NO STATE SET";
                                     }
                                ?>
                            </p>
                            <h5 style="color: black">District: </h5>
                            <p>
                            <?php
                                    $query3="SELECT Name From district Where District_Code=(SELECT District_Code FROM location WHERE Location_ID = (SELECT Location_ID FROM hospital WHERE Hospital_ID ='$user'));";
                                    $result3=mysqli_query($conn,$query3);
                                    if (mysqli_num_rows($result3) > 0) {
                                        while($row3 = mysqli_fetch_assoc($result3))
                                         {
                                           echo $row3["Name"];
                                         }
                                     } else {
                                        echo "ERROR! NO DISTRICT SET";
                                     }
                                ?>
                            </p>
                            <h5 style="color: black">Address: </h5>
                            <p>
                            <?php
                                    $query4="SELECT Address FROM location WHERE Location_ID = (SELECT Location_ID FROM hospital WHERE Hospital_ID ='$user');";
                                    $result4=mysqli_query($conn,$query4);
                                    if (mysqli_num_rows($result4) > 0) {
                                        while($row4 = mysqli_fetch_assoc($result4))
                                         {
                                           echo $row4["Address"];
                                         }
                                     } else {
                                        echo "ERROR! NO Address SET";
                                     }
                                ?>
                            </p>
                            <h5 style="color: black">Pincode: </h5>
                            <p>
                            <?php
                                    $query5="SELECT Pincode FROM location WHERE Location_ID = (SELECT Location_ID FROM hospital WHERE Hospital_ID ='$user');";
                                    $result5=mysqli_query($conn,$query5);
                                    if (mysqli_num_rows($result5) > 0) {
                                        while($row5 = mysqli_fetch_assoc($result5))
                                         {
                                           echo $row5["Pincode"];
                                         }
                                     } else {
                                        echo "ERROR! NO Pincode SET";
                                     }
                                ?>
                            </p> 
                        </div>
                    </div>
                    <!--/row-->
                </div>
                <!--Edit pane-->

            <div class="tab-pane" id="edit">

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h4 style="color: black">Change Phone: </h4>
            <div class="row">
    <div class="col-md-5 mb-3">
        <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                <label>Phone Number</label>
                <input type="text" name="Phone" class="form-control" value="<?php echo $phone; ?>">
                <span class="help-block"><?php echo $phone_err; ?></span>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <hr style="height:0px; visibility:hidden;"/>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="submit3" value="Save">
        </div>
    </div>
    <div class="col-md-5 mb-3">
    </div>
</div>
<h6 style="color : green; "><?php echo $phone_update ?></h6>
                    </form>
                    <hr class="featurette-divider">



                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h4 style="color: black">Change Website URL: </h4>
            <div class="row">
    <div class="col-md-5 mb-3">
        <div class="form-group <?php echo (!empty($web_err)) ? 'has-error' : ''; ?>">
                <label>Web url</label>
                <input type="text" name="Web" class="form-control" value="<?php echo $web; ?>">
                <span class="help-block"><?php echo $web_err; ?></span>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <hr style="height:0px; visibility:hidden;"/>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="submit4" value="Save">
        </div>
    </div>
    <div class="col-md-5 mb-3">
        
    </div>
</div>
<h6 style="color : green; "><?php echo $web_update ?></h6>
                    </form>
                    <hr class="featurette-divider">

                    

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h4 style="color: black">Change Image URL: </h4>
            <div class="row">
    <div class="col-md-5 mb-3">
        <div class="form-group <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
                <label>Image Url</label>
                <input type="text" name="Image" class="form-control" value="<?php echo $image; ?>">
                <span class="help-block"><?php echo $image_err; ?></span>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <hr style="height:0px; visibility:hidden;"/>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="submit5" value="Save">
        </div>
    </div>
    <div class="col-md-5 mb-3">
        
    </div>
</div>
<h6 style="color : green; "><?php echo $image_update ?></h6>
                    </form>
                    <hr class="featurette-divider">









            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h4 style="color: black">Change Email: </h4>
            <div class="row">
    <div class="col-md-5 mb-3">
        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <hr style="height:0px; visibility:hidden;"/>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="submit1" value="Save">
        </div>
    </div>
    <div class="col-md-5 mb-3">
        
    </div>
</div>
<h6 style="color : green; "><?php echo $email_update ?></h6>
                    </form>
                    <hr class="featurette-divider">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h4 style="color: black">Change Password: </h4>
            <div class="row">

    <div class="col-md-4 mb-3">
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
        </div>
    </div>
    <div class="col-md-4 mb-3">
           <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div> 
    </div>
    <div class="col-md-3 mb-3">
        <hr style="height:0px; visibility:hidden;"/>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="submit2" value="Save">
        </div>
    </div>
</div>
<h6 style="color : green; "><?php echo $password_update ?></h6>
                    </form>
                    <hr class="featurette-divider">



                   
                    
            
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
     