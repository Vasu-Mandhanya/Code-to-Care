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

<script>
(function ($) {
	$.fn.countTo = function (options) {
		options = options || {};
		
		return $(this).each(function () {
			// set options for current element
			var settings = $.extend({}, $.fn.countTo.defaults, {
				from:            $(this).data('from'),
				to:              $(this).data('to'),
				speed:           $(this).data('speed'),
				refreshInterval: $(this).data('refresh-interval'),
				decimals:        $(this).data('decimals')
			}, options);
			
			// how many times to update the value, and how much to increment the value on each update
			var loops = Math.ceil(settings.speed / settings.refreshInterval),
				increment = (settings.to - settings.from) / loops;
			
			// references & variables that will change with each update
			var self = this,
				$self = $(this),
				loopCount = 0,
				value = settings.from,
				data = $self.data('countTo') || {};
			
			$self.data('countTo', data);
			
			// if an existing interval can be found, clear it first
			if (data.interval) {
				clearInterval(data.interval);
			}
			data.interval = setInterval(updateTimer, settings.refreshInterval);
			
			// initialize the element with the starting value
			render(value);
			
			function updateTimer() {
				value += increment;
				loopCount++;
				
				render(value);
				
				if (typeof(settings.onUpdate) == 'function') {
					settings.onUpdate.call(self, value);
				}
				
				if (loopCount >= loops) {
					// remove the interval
					$self.removeData('countTo');
					clearInterval(data.interval);
					value = settings.to;
					
					if (typeof(settings.onComplete) == 'function') {
						settings.onComplete.call(self, value);
					}
				}
			}
			
			function render(value) {
				var formattedValue = settings.formatter.call(self, value, settings);
				$self.html(formattedValue);
			}
		});
	};
	
	$.fn.countTo.defaults = {
		from: 0,               // the number the element should start at
		to: 0,                 // the number the element should end at
		speed: 1000,           // how long it should take to count between the target numbers
		refreshInterval: 100,  // how often the element should be updated
		decimals: 0,           // the number of decimal places to show
		formatter: formatter,  // handler for formatting the value before rendering
		onUpdate: null,        // callback method for every time the element is updated
		onComplete: null       // callback method for when the element finishes updating
	};
	
	function formatter(value, settings) {
		return value.toFixed(settings.decimals);
	}
}(jQuery));

jQuery(function ($) {
  // custom formatting example
  $('.count-number').data('countToOptions', {
	formatter: function (value, options) {
	  return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
	}
  });
  
  // start all the timers
  $('.timer').each(count);  
  
  function count(options) {
	var $this = $(this);
	options = $.extend({}, options || {}, $this.data('countToOptions') || {});
	$this.countTo(options);
  }
});
</script>



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

  <section class="jumbotron text-center">
    <div class="container">
        <h2 class="jumbotron-heading">Let's Fight COVID-19 together</h2>
        <br>
        <p class="lead text-muted" style="color: #565050;">Coronavirus disease (COVID-19) is an infectious disease caused by a newly discovered coronavirus.Most people infected with the COVID-19 virus will experience mild to moderate respiratory illness and recover without requiring special treatment. Older people, and those with underlying medical problems like cardiovascular disease, diabetes, chronic respiratory disease, and cancer are more likely to develop serious illness.The best way to prevent and slow down transmission is to be well informed about the COVID-19 virus, the disease it causes and how it spreads. Protect yourself and others from infection by washing your hands or using an alcohol based rub frequently and not touching your face.</p>
    </div>
</section>
<h2 class="text-center" style="color: #663399">#  Follow the rules......</h2>
<div class="row">
    <div class="col-md-10 offset-md-2">
        <div class="row poem-row">
            <div class="col-md-4"> 
                <h3>Wear Mask!</h3> 
            </div>
            <div class="col-md-4"> 
                <h3>Wash Hands!</h3> 
            </div>
            <div class="col-md-4"> 
            <h3>Follow Social Distancing!</h3> 
            </div>
        </div>         
    </div>
</div>

<hr class="featurette-divider">
<div class="bg-light">
<div>
<br>
<h1 class="text-center " style="color: rebeccapurple; text-decoration: underline;" >
Cases in India
</h1>
</div>
<?php
require_once "DB/connect.php";
$total=$active=$recovered=$deaths=0;
$query1 = "SELECT SUM(Active+Recovered+Deaths) 'Total', SUM(Active) 'Active',SUM(Recovered) 'Recovered',Sum(Deaths) 'Deaths' FROM cases;";
$results1=mysqli_query($conn, $query1);
//loop
foreach ($results1 as $cases)
{
    $total=$cases["Total"];
    $active=$cases["Active"];
    $recovered=$cases["Recovered"];
    $deaths=$cases["Deaths"];
}
$results1->close();
?>
<div class="album py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card mb-4 box-shadow">
                    <img class="card-img-top " src="Assets/active.jpg"/>
                    <div class="card-body">
                        <h3 class="textCenter">Active</h3>
                        <h2 class=" textCenter timer count-title count-number" 
                         data-to="<?php echo $active;?> "
                        data-speed="2000"></h2>

                        <!-- <p class="textCenter timer count-title count-number" data-to="-->  <!--" data-speed="15000"></p>-->
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mb-4 box-shadow">
                    <img class="card-img-top" src="Assets/recovered.jpg"/>
                    <div class="card-body">
                        <h3 class="card-text textCenter">Recovered</h3>
                        <h2 class=" textCenter timer count-title count-number" 
                         data-to="<?php echo $recovered;?>"
                        data-speed="3000"></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card mb-4 box-shadow">
                    <img class="card-img-top" src="Assets/deaths.png" style="height: 250px; width :240px";/>
                    <div class="card-body">
                        <h3 class="card-text textCenter">Deaths</h3>
                        <h2 class=" textCenter timer count-title count-number" 
                         data-to="<?php echo $deaths;?>"
                         data-speed="3500"></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card mb-4 box-shadow">
                    <img class="card-img-top" src="Assets/total.png" style="height: 250px; width :240px";/>
                    <div class="card-body">
                        <h3 class="card-text textCenter">Total Cases</h3>
                        <h2 class=" textCenter timer count-title count-number" 
                         data-to="<?php echo $total;?>"
                         data-speed="3000"></h2>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
    </div>


<div class="container marketing">
    <br>
    </div>
    <!-- /.row -->
    <!-- START THE FEATURETTES -->
    <hr class="featurette-divider">
    <div class="row featurette ">
        <div class="col-md-6" style="padding-left: 5%">
            <h2 class="featurette-heading">How to keep safe?</h2>
            <p class="lead">There is currently no vaccine to prevent coronavirus disease 2019 (COVID-19). The best way to prevent illness is to avoid being exposed to this virus.
                The virus is thought to spread mainly from person-to-person:
                <br>
                (i)Between people who are in close contact with one another (within about 6 feet).<br>
                (ii)Through respiratory droplets produced when an infected person coughs, sneezes or talks.<br>
                (iii)These droplets can land in the mouths or noses of people who are nearby or possibly be inhaled into the lungs.<br>
                (iv)Some recent studies have suggested that COVID-19 may be spread by people who are not showing symptoms.<br>
                (A)Wash your hands often.<br>
                (B)Avoid close contact.<br>
                (C)Cover your mouth and nose with a mask when around others.<br>
                (D)Cover while coughing and sneezing.<br>
                (E)Monitor your health on a regular basis.
            </p>
          <a href="https://www.who.int/emergencies/diseases/novel-coronavirus-2019/advice-for-public" class="btn btn-primary text-red-600">Read More....</a>
        </div>
        <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" style="width: 500px; height: 500px;" src="Assets/Boy-scared-of-coronavirus-disease-on-transparent-background-PNG-removebg-preview.png" data-holder-rendered="true">
        </div>
    </div>
    <br>
    <br>
    <br>
    <hr class="featurette-divider">
    <div class="row featurette">
        <div class="col-md-6 order-md-2">
            <h2 class="featurette-heading">COVID Myths</h2>
            <p class="lead">As coronavirus continues to make the news, a host of untruths has surrounded the topic. In this Special Feature, we address some of these myths and conspiracy theories.</p>
            <a href="https://www.who.int/emergencies/diseases/novel-coronavirus-2019/advice-for-public/myth-busters" class="btn btn-primary text-red-600">Read More....</a>
        </div>
        <div class="col-md-5 order-md-1" style="padding-left: 5%">
            <img class="featurette-image img-fluid" src="Assets/myth.png" data-holder-rendered="true" style="width: 500px; height: 500px;">
        </div>
    </div>
    <!-- /END THE FEATURETTES -->
    <!-- FOOTER -->
    <br>
    <br>
    <footer>
        <p class="text-center"><a  href="#">Back to top</a></p>
    </footer>
</div> 

</body>
</html>