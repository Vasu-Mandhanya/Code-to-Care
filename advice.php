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
          <li><a class="nav-link" href="hospitals.php"> Hospitals  </a></li>
          <li><a class="nav-link active" href="advice.php"> Seek Advice  </a></li>
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
				<img src="Assets/doc_team.png"/>
                    <h1 class="jumbotron-heading">Nation wide list of Volunteer Doctors!</h1>
                    <p class="lead text-muted">The pandemic is causing a global helthcare emergency.As the healthcare services are not uniform and everyone can't afford to go an expensicve doctor. We provide you with the contact details of doctors to consult with! </p>
					<a href="doctorSignUp.php">If you are a doctor and wish to volunteer for this nobel cause.Sign Up now.</a>
				</div>	
</section>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Qualification</th>
                                    <th>Specialisation</th>
                                    <th>E-mail</th>
                                    <th>Phone No.</th>
									<th>State</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?php 
                        require_once("DB/connect.php");
                        $query1 = "SELECT * FROM doctors d1 INNER JOIN doc_mail d2 ON d1.Doc_ID=d2.Doc_ID INNER JOIN doc_phone d3 ON d2.Doc_ID=d3.Doc_ID INNER JOIN location l ON d1.Location_ID=l.Location_ID INNER JOIN district d4 ON d4.District_Code=l.District_Code INNER JOIN state s ON s.State_Code=d4.State_Code";
                        $results1=mysqli_query($conn, $query1);
                        //loop
                        $sno=1;
                        foreach ($results1 as $d)
                        {
                            echo '<tr>';
                            echo '<td>'.$sno.'</td>';
                            $sno+=1;
                            echo '<td>'.'Dr. '.$d['First_Name'].' '.$d['Last_Name'].'</td>';
                            echo '<td>'.$d['Qualification'].'</td>';
                            echo '<td>'.$d['Specialization'].'</td>';
                            echo '<td>'.$d['Email'].'</td>';
                            echo '<td>'.$d['Phone_No'].'</td>';
                            echo '<td>'.$d['Name'].'</td>';
                            echo '</tr>';
                        }
                        $results1->close(); 
                        ?>  
                            </tbody>
                        </table>
                    </div>
</body>
</html>