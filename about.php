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
          <li><a class="nav-link active" href="about.php"> About Us  </a></li>
          <li><a class="nav-link" href="hospitals.php"> Hospitals  </a></li>
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
          <a class="nav-link" href="hospital_doctors.php">Doctors</a>
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
<div id="myCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="first-slide" src="Assets/covidGraph.png" style="height: 700px; width :1640px"; alt="First slide">
                    <div class="container">
                        <div class="carousel-caption d-none d-md-block text-left">
                            <h1>Keep Track.</h1>
                            <p>CoVITal will help you to keep track on the pandemic situation.We provide you with the number of cases in your area. Also we show the bed availablity status fot your city hospitals.Hence giving you a one stop solution in case of an emergency. </p>
                            <p><a class="btn btn-lg btn-primary" href="register.php" role="button">Sign up today</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="second-slide" src="Assets/hopitalBedNew.png" style="height: 700px; width :1640px"; alt="Second slide">
                    <div class="container">
                        <div class="carousel-caption d-none d-md-block text-left">
                            <h1>Check Availablity in Hospitals.</h1>
                            <p>CoVITal will show you the availablity of hospital beds in your city.The Covid19 pandemic has caused a serious scarcity of beds and ventilators in hospitals, and when an emergency comes it is hard to find a spot in hospitals. We will be there for you in case of any health emergncy! </p>
                            <p><a class="btn btn-lg btn-primary" href="hospitals.php" role="button">View</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="third-slide" src="Assets/TalkDoc.png" style="height: 700px; width :1640px"; alt="Third slide">
                    <div class="container">
                        <div class="carousel-caption d-none d-md-block text-left">
                            <h1>Talk to a professional.</h1>
                            <p>Are you having a thousand doubts about your health? Are you ill and hesitating to go to a hospital? We provide you with the contact list of good hearted medical professionals who are always there to help you.  </p>
                            <p><a class="btn btn-lg btn-primary" href="advice.php" role="button">Seek Advice</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
        </div>


<br>
<br>
<br>


<div class="container marketing">

<h1 style="text-align: center";>Meet the Team</h1>
<br><br>
<div class="row">
    <div class="col-lg-4" style="text-align: center";>
        <img class="rounded-circle" src="http://pinegrow.com/placeholders/img1.jpg" alt="Generic placeholder image" width="140" height="140">
        <h2>Siddharth Dinkar</h2>
        <p>Web Developer</p>
        <p><a class="btn btn-lg btn-primary" href="https://www.linkedin.com/in/siddharth-dinkar-3896b81b4" role="button">LinkedIn</a></p>
    </div>
    <!-- /.col-lg-4 -->
    <div class="col-lg-4" style="text-align: center";>
        <img class="rounded-circle" src="http://pinegrow.com/placeholders/img2.jpg" alt="Generic placeholder image" width="140" height="140">
        <h2>Vasu Mandhanya</h2>
        <p class="text-center">Backend Developer</p>
        <p><a class="btn btn-lg btn-primary" href="https://www.linkedin.com/in/vasu-mandhanya-3b50661a0/" role="button">LinkedIn</a></p>
    </div>
    <!-- /.col-lg-4 -->
    <div class="col-lg-4" style="text-align: center";>
        <img class="rounded-circle" src="http://pinegrow.com/placeholders/img3.jpg" alt="Generic placeholder image" width="140" height="140">
        <h2>Syed Shahbaz Husain</h2>
        <p>App Developer</p>
        <p><a class="btn btn-lg btn-primary" href="https://www.linkedin.com/in/shahbaz-husain-3155b21b9" role="button">LinkedIn</a></p>
    </div>
    <!-- /.col-lg-4 -->
</div>



</body>
</html>