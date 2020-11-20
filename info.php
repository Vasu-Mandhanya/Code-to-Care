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
          <a class="nav-link active" href="info.php"> Info  <span class="sr-only">(current)</span></a>
          </li>
          <li><a class="nav-link" href="about.php"> About Us  </a></li>
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

<br>
<br>

<div class="row featurette">
        <div class="col-md-6 order-md-2">
            <h1 class="featurette-heading textCenter">SARS-CoV2</h1><br>
            <h3 class="text-center" style="color: #8e090c;">Most common Symptons:</h3>
            <div class="text-center">
   <li class="text-gray-900">Fever</li>
   <li class="text-gray-900">Dry Cough</li>
   <li class="text-gray-900">Tiredness</li><br>
   <h3 style="color: #8e090c;">Less common Symptons:</h3>
   <li class="text-gray-900">Aches and Pains</li>
   <li class="text-gray-900">Sore Throat</li>
   <li class="text-gray-900">Diarrhoea</li>
   <li class="text-gray-900">Conjunctivitis</li>
   <li class="text-gray-900">Headache</li>
   <li class="text-gray-900">Loss of taste or smell</li>
   <li class="text-gray-900">A rash on skin, or discolouration of fingers or toes</li><br>
</div>
        </div>
        <div class="col-md-5 order-md-1">
            <img class="featurette-image img-fluid" src="Assets/real_v.jpeg" data-holder-rendered="true" style="width: 570px; height: 450px; padding-left : 19%">
        </div>
    </div>

	<br>
    <br>
	<br>

<hr class="featurette-divider">
    <div class="row featurette">
        <div class="col-md-6" style="padding-left : 5%">
            <h2 class="featurette-heading">If You are sick!</h2>
            <p class="lead">If you have a fever, cough or other symptoms, you might have COVID-19. Most people have mild illness and are able to recover at home. If you think you may have been exposed to COVID-19, contact a doctor.Keep track of your symptoms and if any warning signs(including troubled breathing) seek medical care.</p>
          <a href="https://www.who.int/emergencies/diseases/novel-coronavirus-2019/advice-for-public" class="btn btn-primary text-red-600">Know More</a>
        </div>
        <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" style="width: 500px; height: 500px;" src="Assets/man_sick_with_the_flu-removebg-preview.png" data-holder-rendered="true">
        </div>
    </div>
    <br>
    <br>
	<br>
	
<hr class="featurette-divider">

<div class="row featurette">
        <div class="col-md-6 order-md-2">
            <h2 class="featurette-heading">Fact Check</h2>
            <p class="lead">Most people infected with COVID-19 will only have mild symptoms and fully recover. Yet, some people are more at risk.We all have a role to play in protecting ourselves and others. Know the facts about COVID-19 and help stop the spread of rumours and the disease.</p>
            <a href="https://www.covid-19facts.com/?page_id=82920" class="btn btn-primary text-red-600">Know More</a>
        </div>
        <div class="col-md-5 order-md-1">
            <img class="featurette-image img-fluid" src="Assets/fact.png" data-holder-rendered="true" style="width: 550px; height: 450px; padding-left : 5%">
        </div>
    </div>

	<br>
    <br>
	<br>
<hr class="featurette-divider">
<div class="row featurette">
        <div class="col-md-6" style="padding-left : 5%">
            <h2 class="featurette-heading">How to travel?</h2>
            <p class="lead">Travel increases your chance of getting and spreading COVID-19. Staying home is the best way to protect yourself and others from COVID-19. You can get COVID-19 during your travels. You may feel well and not have any symptoms, but you can still spread COVID-19 to others. You and your travel companions (including children) may spread COVID-19 to other people including your family, friends, and community for 14 days after you were exposed to the virus.But if it is highly necessary for you to travel, the guidlines for travelling are given below.</p>
          <a href="https://www.cdc.gov/coronavirus/2019-ncov/travelers/index.html" class="btn btn-primary text-red-600">Know More</a>
        </div>
        <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" style="width: 480px; height: 400px;" src="Assets/rsz_travel-1594126875884.png" data-holder-rendered="true">
        </div>
	</div>

	<br>
    <br>
	<br>
<hr class="featurette-divider">

<div class="row featurette">
        <div class="col-md-6 order-md-2">
            <h2 class="featurette-heading">Stress Coping</h2>
            <p class="lead">The coronavirus disease 2019 (COVID-19) pandemic may be stressful for people. Fear and anxiety about a new disease and what could happen can be overwhelming and cause strong emotions in adults and children. Public health actions, such as social distancing, can make people feel isolated and lonely and can increase stress and anxiety. However, these actions are necessary to reduce the spread of COVID-19. Coping with stress in a healthy way will make you, the people you care about, and your community stronger.</p>
            <a href="https://www.cdc.gov/coronavirus/2019-ncov/daily-life-coping/stress-coping/index.html" class="btn btn-primary text-red-600">Know More</a>
        </div>
        <div class="col-md-5 order-md-1">
            <img class="featurette-image img-fluid" src="https://sm.mashable.com/t/mashable_in/photo/default/workf-rom-home_wjz2.960.jpg" data-holder-rendered="true" style="width: 550px; height: 450px; padding-left : 5%">
        </div>
    </div>
	<br>
    <br>
	<br>
	<footer>
        <p class="float-right" style="padding-right : 50%"><a href="#">Back to top</a></p>
    </footer>
</body>
</html>