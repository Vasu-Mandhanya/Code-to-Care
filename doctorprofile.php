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
require_once "DB/connect.php";
$user=$_SESSION['username'];
$email = $password = $confirm_password = $state = $sch = "";
$email_err = $password_err = $confirm_password_err = $state_err = $sch_err = "";
$sch_update=$email_update=$password_update='';

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{

    if(isset($_POST['submit0']))
    {
        // Validate Email
        if(empty(trim($_POST["sch"]))){
            $sch_err = "Please enter a schedule.";
        } else{
            // Prepare a select statement
            $sch = $_POST["sch"];
        }
        // Check input errors before inserting in database
        if (empty($sch_err)){
            // Prepare an insert statement
            $sql1 = "UPDATE doctors SET Schedule = ? WHERE Doc_ID =?";
            if($stmt1 = $conn->prepare($sql1)){
                // Bind variables to the prepared statement as parameters
                $stmt1->bind_param("ss",$param_sch,$param_username);
                // Set parameters
                $param_username = $user;
                $param_sch = $sch; 
                // Attempt to execute the prepared statement
                if($stmt1->execute()){
                    $sch_update="Schedule Updated Successfully !";
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

    if(isset($_POST['submit1']))
    {
        // Validate Email
        if(empty(trim($_POST["email"]))){
            $email_err = "Please enter a email.";
        } else{
            // Prepare a select statement
            $sql = "SELECT Doc_ID FROM doc_mail WHERE Email = ?";
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
            $sql1 = "UPDATE doc_mail SET Email = ? WHERE Doc_ID =?";
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
            $sql2 = "UPDATE doctors SET password = ? WHERE Doc_ID =?";
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

    
    //Validate State
    if(empty(trim($_POST["State"]))||$_POST["State"]=="#"){
        $state_err = "Please Choose a State"; 
        #$popmessage ="Invalid Data Recieved. Page will be reloaded.";
        #echo "<script> alert('$popmessage');</script>"; 
        #header("Refresh: 0");
        #exit(0);
    }
        // Check input errors before inserting in database
        if (empty($state_err)){
            // Close connection
            $conn->close();  
            $state=$_POST["State"];
            $_SESSION["State"]=$state;
            $_SESSION["Location_set"]=false;
            // Redirect to location page
            header("location: ChangeLocation.php");
            exit;
        }
        else{
            echo "Something went wrong. Please try again later.";
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
        <a class='nav-link dropdown-toggle active' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
            Hi ".$_SESSION['username'].'
        </a>
        <div class="dropdown-menu" style="background-color: #663399 ;" aria-labelledby="navbarDropdown">
          <a class="nav-link active" href="user.php">Profile</a>
          <div class="dropdown-divider"></div>
          <a class="nav-link" href="logout.php">Sign Out</a>
        </div>
      </li>';
      }
      elseif($_SESSION["usertype"]=="doctor")
      {
        echo "
        <li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle active' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
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
      echo "
      <li class='nav-item dropdown'>
      <a class='nav-link dropdown-toggle' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
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
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSppkoKsaYMuIoNLDH7O8ePOacLPG1mKXtEng&usqp=CAU" class="mx-auto img-fluid img-circle d-block" alt="avatar">
       </div>
        <div class="col-lg-8 order-lg-2">
            <ul class="nav nav-tabs">
            <li class="nav-item">
                    <a href="" data-target="#dashboard" data-toggle="tab" class="nav-link active" style="color: black">Dashboard</a>
            </li>
                <li class="nav-item">
                    <a href="" data-target="#profile" data-toggle="tab" class="nav-link" style="color: black">Profile</a>
                </li>
                <li class="nav-item">
                    <a href="" data-target="#edit" data-toggle="tab" class="nav-link" style="color: black">Edit</a>
                </li>
            </ul>
           

            <div class="tab-content py-4">
            <div class="tab-pane active" id="dashboard">
            
            <h2>My Schedule: </h2>
           
            <?php
             $query_2="SELECT Schedule FROM doctors WHERE Doc_ID='$user';";
             $result_2=mysqli_query($conn,$query_2);
             if (mysqli_num_rows($result_2) > 0) {
                while($row1 = mysqli_fetch_assoc($result_2))
                 {
                   echo '<br>'.'<p style="color: blue">  '. $row1["Schedule"].'</p>'.'<br>';
                 }
             } else {
                echo "ERROR! NO NAME FOUND";
             }
            

            ?>

            <div class="card">
            
							<div class="card-header">
								<h4 class="card-title d-inline-block">Upcoming Appointments</h4> <a href="appointments.html" class="btn btn-primary float-right">View all</a>
							</div>
							<div class="card-body p-0">
								<div class="table-responsive">
									<table class="table mb-0">
										<thead class="d-none">
											<tr>
												<th>Patient Name</th>
												<th>Email</th>
												<th>Date and Time</th>
												<th class="text-right">Status</th>
											</tr>
										</thead>
										<tbody>
                                        <?php
                                        $docid=$_SESSION['username'];
                                        $query1 = "SELECT ue.user_id AS user,ue.email_id AS email, d.name AS dist, s.name AS state, a.datetime as time FROM appointments a INNER JOIN user_email ue ON a.User_ID=ue.User_ID INNER JOIN user_location ul ON ul.User_ID=ue.User_ID INNER JOIN location l ON ul.Location_ID=l.Location_ID INNER JOIN district d ON d.District_Code=l.District_Code INNER JOIN state s ON s.State_Code=d.State_Code WHERE Doc_ID='$docid';";
                                        $results1=mysqli_query($conn, $query1);
                                        //loop
                                        $sno=1;
                                        foreach ($results1 as $d)
                                        {
											echo '<tr>
												<td style="min-width: 200px;">
													<h4><a href="patient_profile.php">'.$d['user'].'</h4><br><span>'.$d['dist'].', '.$d['state'].'</span></a>
												</td>                 
												<td>
													<h5 class="time-title p-0">Email</h5>
													<p>'.$d['email'].'</p>
												</td>
												<td>
													<h5 class="time-title p-0">Timing</h5>
													<p>'.$d['time'].'</p>
												</td>
												<td class="text-right">
													<a href="https://pacific-brushlands-06281.herokuapp.com/" class="btn btn-outline-primary take-btn">Take up</a>
												</td>
                                            </tr>';
                                        }
											?>											
										</tbody>
									</table>
                                </div>
</div>
</div>




            </div>
                <div class="tab-pane" id="profile">
                    <h1 class="mb-3 textCenter" style="color: black; text-transform : uppercase; "><?php 
                    $query0="SELECT First_Name FROM doctors WHERE Doc_ID='$user';";
                    $result0=mysqli_query($conn,$query0);
                    $query_1="SELECT Last_Name FROM doctors WHERE Doc_ID='$user';";
                    $result_1=mysqli_query($conn,$query_1);

                    
                    if (mysqli_num_rows($result0) > 0) {
                        while($row1 = mysqli_fetch_assoc($result0))
                         {
                           echo 'Dr.  '. $row1["First_Name"];
                         }
                     } else {
                        echo "ERROR! NO NAME FOUND";
                     }

                     if (mysqli_num_rows($result_1) > 0) {
                        while($row1 = mysqli_fetch_assoc($result_1))
                         {
                           echo '  '. $row1["Last_Name"];
                         }
                     } else {
                        echo "ERROR! NO NAME FOUND";
                     }



                    ?>
                    </h1>

                    <div class="row">
                        <div class="col-md-6">
                        <h5 style="color: black">Email: </h5>
                            <p>
                                <?php
                                    $query1="SELECT Email FROM doc_mail WHERE Doc_ID='$user';";
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
                            
                            <h5 style="color: black">Mobile No.: </h5>
                            <p>
                                <?php
                                    $query1="SELECT Phone_No FROM doc_phone WHERE Doc_ID='$user';";
                                    $result1=mysqli_query($conn,$query1);
                                    if (mysqli_num_rows($result1) > 0) {
                                        while($row1 = mysqli_fetch_assoc($result1))
                                         {
                                           echo $row1["Phone_No"];
                                         }
                                     } else {
                                        echo "ERROR! NO PHONE FOUND";
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
            <h4 style="color: black">Update Schedule: </h4>
            <div class="row">
    <div class="col-md-4 mb-3">
        <div class="form-group <?php echo (!empty($sch_err)) ? 'has-error' : ''; ?>">
                <label>Schedule</label>
                <input type="text" name="sch" class="form-control" value="<?php echo $sch; ?>">
                <span class="help-block"><?php echo $sch_err; ?></span>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <hr style="height:0px; visibility:hidden;"/>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="submit0" value="Save">
        </div>
    </div>
    <div class="col-md-5 mb-3">
        
    </div>
</div>
<h6 style="color : green; "><?php echo $sch_update ?></h6>
                    </form>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h4 style="color: black">Change Email: </h4>
            <div class="row">
    <div class="col-md-4 mb-3">
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
     