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
          <li><a class="nav-link active" href="cases.php"> Track Cases  </a></li>
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

  <section class="jumbotron text-center">
    <div class="container">
        <h2 class="jumbotron-heading">Let's Fight COVID-19 together</h2>
        <br>
    </div>
</section>
<h2 class="text-center" style="color: #663399">#  Follow the rules......</h2>
<br>
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
            <h3> Social Distancing!</h3> 
            </div>
        </div>         
    </div>
</div>
<hr class="featurette-divider">
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
     else{
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
     }
 }
 else{
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
 echo 'Cases in '.$districtname;
 $total=$active=$recovered=$deaths=0;
$query1 = "SELECT Active+Recovered+Deaths 'Total', Active,Recovered,Deaths FROM cases WHERE District_Code='$district';";
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
 }
 elseif($statename!="")
 {
 echo 'Cases in '.$statename;
 $total=$active=$recovered=$deaths=0;
$query1 = "SELECT SUM(Active+Recovered+Deaths) 'Total', SUM(Active) 'Active',SUM(Recovered) 'Recovered',Sum(Deaths) 'Deaths' FROM cases WHERE District_Code IN(SELECT District_Code FROM district WHERE State_Code='$state');";
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
 }
 #echo $district;
?>
</h1>
</div>


<hr class="featurette-divider">
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
</body>
</html>