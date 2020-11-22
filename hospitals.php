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
session_start();
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
<section class="jumbotron text-center">
                <div class="container">
                    <h1 class="jumbotron-heading">Hospital Bed Status for your State/City!</h1>
                    <p class="lead text-muted">In these troubled times there is no need to call places for finding a spot in hospitals.The bed availablity staus of your district is just a click away!</p>
                    <p class="lead text-muted">If you are from hospital administration and wish to join the cause, help us by signing up and we will display your hospital here!</p>
					<p> <a href="HospitalLogin.php" class="btn btn-primary my-2">Login</a> <a href="hospitalSignUp.php" class="btn btn-secondary my-2">SignUp</a> </p>
                    <p> If you wish to see the availablity status, please select the state and district from the drop down menu given below.
                </div>	
</section>
<div class="row justify-content-center">
<?php
 require_once "DB/connect.php";
 $district =$state = "";
 $district_err =$state_err = "";
 $statename=$districtname="";
 if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
 {
     if($_SESSION["usertype"]=="user")
     {
         $user=$_SESSION["username"];
        $query11 = "SELECT * FROM user_location u INNER JOIN location l On u.location_id=l.location_id WHERE User_ID='$user';";
        $results11=mysqli_query($conn, $query11);
        //loop
        foreach ($results11 as $dnames)
        {
            $district=$dnames["District_Code"];
            $query9 = "SELECT * FROM district WHERE District_Code='$district';";
            $results9=mysqli_query($conn, $query9);
            //loop
            foreach ($results9 as $districtnames)
            {

                $districtname=$districtnames["Name"];
            }
        }
       # echo $district;
     }
 }




// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST['submit1']))
    {
    //Validate State
    if(empty(trim($_POST["State"]))||$_POST["State"]=="#"){
        $state_err = "Please Choose a State"; 
        #$popmessage ="Invalid Data Recieved. Page will be reloaded.";
        #echo "<script> alert('$popmessage');</script>"; 
        #header("Refresh: 0");
        #exit(0);
    }else{
        $state=$_POST["State"];
        $district=$district_err=""; 
        $query9 = "SELECT * FROM state WHERE State_Code='$state';";
        $results9=mysqli_query($conn, $query9);
        //loop
        foreach ($results9 as $statenames)
        {
            $statename=$statenames["Name"];
        }
        $districtname="";
    }
        // Check input errors
        if (empty($state_err)){
           # echo "Working";
        }
        else{
           # echo "Something went wrong. Please try again later.";
        }
    }
    if(isset($_POST['submit2']))
    {
            // Validate District
            if(empty(trim($_POST["District"]))||$_POST["District"]=="#"){
                $district_err = "Please Choose a District"; 
            }
            else{
                $district=$_POST["District"];
                $query9 = "SELECT * FROM district WHERE District_Code='$district';";
                $results9=mysqli_query($conn, $query9);
                //loop
                foreach ($results9 as $districtnames)
                {

                    $districtname=$districtnames["Name"];
                }
                #echo $district;
            }
            if(empty($district_err))
            {
                #echo "working";
            }
            else{
                echo "nah!";
            }
            #echo "Working";
    }
}

//State dropdown
echo '<div class="col-md-5 mb-3">';
echo '<form action="';
echo htmlspecialchars($_SERVER["PHP_SELF"]);
echo '" method="post">';
echo '<div class="row justify-content-center">';
echo '<div class="col-md-5 mb-3">
    <div class="form-group"';
    echo (!empty($state_err)) ? "has-error" : '';
    echo '">
                <label>State:</label>
                <select class="form-control" name="State" onchange="getId(this.value);">
                <option value="#">Select State</option>';
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
            echo '
                </select>
                <span class="help-block">';
                echo $state_err;
                echo '</span>
            </div>   
    </div>
    <div class="col-md-1 mb-3">
        <hr style="height:0px; visibility:hidden;"/>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="submit1" value="Change State">
        </div>
    </div>
</div></form></div>';


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if($state!="")
    {
            echo '
            <div class="col-md-5 mb-3">';
            echo'
            <form action="';
            echo htmlspecialchars($_SERVER["PHP_SELF"]);
            echo
            '" method="post">
            <div class="row justify-content-center">
            <div class="col-md-5 mb-3">
            <div class="form-group ';
            echo (!empty($district_err)) ? 'has-error' : '';
            echo '">
                    <label>District:</label>
                    <select class="form-control" name="District" onchange="getId(this.value);">
                    <option value="#">Select District</option>';
                        $query1 = "SELECT * FROM district WHERE State_Code='$state';";
                        $results1=mysqli_query($conn, $query1);
                        //loop
                        foreach ($results1 as $districts)
                        {
                           echo "<option value=";
                           echo $districts["District_Code"];
                           echo ">";
                           echo $districts["Name"];
                           echo "</option>";
                        }
                        $results1->close();
                    echo '
                    </select>
                    <span class="help-block">';
                    echo $district_err;
                    echo '</span>
                </div> 
                </div>
                <div class="col-md-1 mb-3">
                <div class="form-group">
                <hr style="height:0px; visibility:hidden;"/>
                <input type="submit" class="btn btn-primary" name= "submit2" value="Change District">
            </div>
        </div>
        </form></div></div>';
        }
        else{
            #echo "Something went wrong. Please try again later.";
        }
    }
   # echo $district;
?>
</div>
<div>
<h1 class="text-center" style="color: rebeccapurple" >
 <?php
 if($districtname!="")
 {
 echo 'Hospitals in '.$districtname;
 }
 elseif($statename!="")
 {
 echo 'Hospitals in '.$statename;
 }
 #echo $district;
?>
</h1>
</div>


<div class="album py-5 bg-light">
    <div class="container">
        <div class="row">
        <!--
            <div class="col-md-4">
                <div class="card mb-4 box-shadow">
                    <img class="card-img-top" src="https://www.eternalhospital.com/uploads/pages/who-we-are_1505734484_who-we.jpg"/>
                    <div class="card-body">
					    <h3 class="card-text textCenter"> Name: </h3>
                        <p class="card-text">Total: </p>
						<p class="card-text">General: </p>
						<p class="card-text">ICU: </p>
						<p class="card-text">Ventilator:</p>
						<p class="card-text">Address:</p>
						<h6 class="card-text textCenter"> <a href="https://www.eternalhospital.com/" style="ext-align: center";>Visit Website</a> </h6>
                    </div>
                </div>
			</div>
            -->
			
<?php
#echo $district;
if($district!="")
{
                        $query2 = "SELECT * FROM hospital INNER JOIN beds ON hospital.Hospital_ID=beds.Hospital_ID INNER JOIN location ON hospital.Location_ID=location.Location_ID WHERE District_Code='$district'";
                        $results2=mysqli_query($conn, $query2);
                        foreach($results2 as $hospitals)
                        {
                            			//Code for a card starts
                                        echo '<div class="col-md-4">
                                        <div class="card mb-4 box-shadow">
                                            <img class="card-img-top" src="';
                                            echo $hospitals["Image"];;
                                            echo '"/>
                                            <div class="card-body">
                                                <h3 class="card-text textCenter">';
                                                echo $hospitals["Name"];
                                                echo ' </h3>';
                                                echo '<p class="card-text"><span style= "font-weight: bolder;"> Email:  </span>';
                                                echo $hospitals["Email"];
                                                echo '</p>';
                                                echo '<p class="card-text"><span style= "font-weight: bolder;"> Phone No.:  </span>';
                                                echo $hospitals["Phone"];
                                                echo '</p>';
                                                echo '<p class="card-text"><span style= "font-weight: bolder;"> Address:  </span>';
                                                echo $hospitals["Address"];
                                                echo '</p>
                                                <p class="card-text"><span style= "font-weight: bolder;">Pincode: </span>';
                                                echo $hospitals["Pincode"];
                                                echo '</p>';
                                                echo '<h4> Available Beds: </h4>
                                                <p class="card-text" style="color:green">
                                                Total:';
                                                echo $hospitals["Normal"]+$hospitals["ICU"]+$hospitals["Ventilators"];
                                                echo '</p>
                                                <p class="card-text" style="color:green">General:';echo $hospitals["Normal"]; 
                                                echo '</p>
                                                <p class="card-text" style="color:green">ICU:';echo $hospitals["ICU"];
                                                echo' </p>
                                                <p class="card-text" style="color:green">Ventilator:';
                                                echo $hospitals["Ventilators"];
                                                echo '</p>';
                                                echo ' <button id="btn1" class="btn btn-primary" name="btn1" onClick="javascript:location.href='."'appointments.php?hospitalid=".$hospitals['Hospital_ID']."'".'">Book Appointment</button>';
                                                echo ' <button id="btn2" class="btn btn-secondary my-2" name="btn2" onClick="javascript:location.href='."'".$hospitals['Website']."'".'"'.'>Visit Website</button>';
                                               
                                                
                                               
                                                echo '
                                            </div>
                                        </div>
                                    </div>';
                                    //Code for a card ends
                         }
}
elseif($state!=""){
    $query2 = "SELECT h.Hospital_ID,h.Image,h.Website,h.Name 'Hname',h.Email,h.Phone,l.Address,l.Pincode,d.Name 'Dname',b.Normal,b.ICU,b.Ventilators FROM hospital h INNER JOIN beds b ON h.Hospital_ID=b.Hospital_ID INNER JOIN location l ON h.Location_ID=l.Location_ID INNER JOIN district d ON l.District_Code =d.District_Code INNER JOIN state s ON d.State_Code =s.State_Code WHERE s.State_Code='$state' ";
    $results2=mysqli_query($conn, $query2);
    foreach($results2 as $hospitals)
    {
                    //Code for a card starts
                    echo '<div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" src="';
                        echo $hospitals["Image"];;
                        echo '"/>
                        <div class="card-body">
                            <h3 class="card-text textCenter">';
                            echo $hospitals["Hname"];
                            echo ' </h3>';
                            echo '<p class="card-text"><span style= "font-weight: bolder;"> Email:  </span>';
                            echo $hospitals["Email"];
                            echo '</p>';
                            echo '<p class="card-text"><span style= "font-weight: bolder;"> Phone No.:  </span>';
                            echo $hospitals["Phone"];
                            echo '</p>';
                            echo '<p class="card-text"><span style= "font-weight: bolder;">Address: </span> ';
                            echo $hospitals["Address"];
                            echo '</p>
                            <p class="card-text"><span style= "font-weight: bolder;">Pincode:</span> ';
                            echo $hospitals["Pincode"];
                            echo '</p>';
                            echo '
                            <p class="card-text"><span style= "font-weight: bolder;">District: </span>';
                            echo $hospitals["Dname"];
                            echo '</p>';
                            echo '<h4> Available Beds: </h4>
                            <p class="card-text" style="color:green">
                            Total:';
                            echo $hospitals["Normal"]+$hospitals["ICU"]+$hospitals["Ventilators"];
                            echo '</p>
                            <p class="card-text" style="color:green">General:';echo $hospitals["Normal"]; 
                            echo '</p>
                            <p class="card-text" style="color:green">ICU:';echo $hospitals["ICU"];
                            echo' </p>
                            <p class="card-text" style="color:green">Ventilator:';
                            echo $hospitals["Ventilators"];
                            echo '</p>';
                            echo ' <button id="btn1" class="btn btn-primary" name="btn1" onClick="javascript:location.href='."'appointments.php?hospitalid=".$hospitals['Hospital_ID']."'".'">Book Appointment</button>';
                            echo ' <button id="btn2" class="btn btn-secondary my-2" name="btn2" onClick="javascript:location.href='."'".$hospitals['Website']."'".'"'.'>Visit Website</button>';
                            echo '
                        </div>
                    </div>
                </div>';
                //Code for a card ends
     }
}
?>
        </div>
    </div>
</div>

</body>
</html>