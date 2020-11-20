<?php
//index.php
//Change hospital id to varchar 
session_start();
require_once "DB/connect.php";
$message = '';
// Hospital ID 
$Hospital_ID=$_SESSION["username"];
if(isset($_POST["upload"]))
{
    
 if($_FILES['product_file']['name'])
 {
    
  $filename = explode(".", $_FILES['product_file']['name']);
  if(end($filename) == "csv")
  {
    
   $handle = fopen($_FILES['product_file']['tmp_name'], "r");
   while($data = fgetcsv($handle))
   {
    
    $Patient_ID = mysqli_real_escape_string($conn, $data[0]);
    $First_Name = mysqli_real_escape_string($conn, $data[1]);  
    $Middle_Name = mysqli_real_escape_string($conn, $data[2]);
    $Last_Name	= mysqli_real_escape_string($conn, $data[3]);
    $Gender = mysqli_real_escape_string($conn, $data[4]);
    $Age	= mysqli_real_escape_string($conn, $data[5]);
    $Email = mysqli_real_escape_string($conn, $data[6]);
    $Mobile_No = mysqli_real_escape_string($conn, $data[7]);
    $District = mysqli_real_escape_string($conn, $data[8]);
    $Street = mysqli_real_escape_string($conn, $data[9]);
    $Flat_Building_No = mysqli_real_escape_string($conn, $data[10]);
    $Pincode = mysqli_real_escape_string($conn, $data[11]);
    $Admit_Date = mysqli_real_escape_string($conn, $data[12]);
    $Discharge_Date = mysqli_real_escape_string($conn, $data[13]);
    $DOB = mysqli_real_escape_string($conn, $data[14]);
    
    
    $query="
    INSERT INTO patient (`Patient_ID`, `First_Name`, `Middle_Name`, `Last_Name`, `Gender`, `Age`, `Email`, `Mobile_No`, `District`, `Street`, `Flat_Building_No`, `Pincode`, `Admit_Date`, `Discharge_Date`, `DOB`, `Hospital_ID`) 
    VALUES($Patient_ID,'$First_Name','$Middle_Name','$Last_Name','$Gender',$Age,'$Email',$Mobile_No,'$District','$Street',$Flat_Building_No,$Pincode,'$Admit_Date','$Discharge_Date','$DOB','$Hospital_ID') 
    ON DUPLICATE KEY UPDATE 
    First_Name = '$First_Name', 
    Middle_Name = '$Middle_Name',
    Last_Name = '$Last_Name',
    Gender = '$Gender',
    Age = $Age,
    Email = '$Email',
    Mobile_No = $Mobile_No,
    District = '$District',
    Street = '$Street',
    Flat_Building_No = $Flat_Building_No,
    Pincode = $Pincode,
    Admit_Date = '$Admit_Date',
    Discharge_Date = '$Discharge_Date',
    DOB = '$DOB';";
    mysqli_query($conn,$query);
   }
   fclose($handle);
   
   //header("location: index.php?updation=1");
  }
  else
  {
   $message = '<label class="text-danger">Please Select CSV File only</label>';
  }
 }
 else
 {
  $message = '<label class="text-danger">Please Select File</label>';
 }
}

if(isset($_GET["updation"]))
{
 $message = '<label class="text-success">Product Updation Done</label>';
}

$query = "SELECT * FROM patient Where Hospital_ID = '$Hospital_ID';"; 
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="Assets/logo.png" type="image/icon type">
<link rel="icon" href="Assets/logo.jpeg" type="image/icon type">
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
<div class="carousel-inner">
    <div class="carousel-item active">
        <img class="first-slide" src="Assets/docQuote.png" alt="First slide">
    </div>
</div>


<section class="jumbotron text-center">
    <div class="container">
        <h2 class="jumbotron-heading">Let's Fight COVID-19 together</h2>
        <br>
        <p class="lead text-muted" style="color: #565050;">Needless to say, doctors, nurses and people working in health-care sectors are particularly vulnerable to the highly infectious disease. In response to the global pandemic, the under-resourced doctors are facing unprecedented challenges. The list of the sleep-deprived heroes includes doctors, nurses, medical cleaners, pathologists, paramedics, ambulance drivers, and health-care administrators. In the fight against coronavirus, the brave medical army stands strong with thermometers, stethoscopes, and ventilators as their weapons. Not to forget, medical researchers are working day in and night out against all odds, hoping to find the antidote to the disease.We are with all of you.Let's stand united against COVID19 pandemic.</p>
    </div>
</section>
<br>
<!--bed count-->

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

<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
<div class="container">
	<div class="row">
	    <br/>
	   <div class="col text-center">
		<h2>Bed Count</h2>
        <br><br>
		</div>
			
	</div>
		<div class="row text-center">
	        <div class="col">
	        <div class="counter" style="border:5px;border-style:outset; border-color:#663399;">
      <h2 class="timer count-title count-number" 
      data-to="
      <?php
                                    $query1="SELECT Normal FROM beds WHERE Hospital_ID='$Hospital_ID';";
                                    $result1=mysqli_query($conn,$query1);
                                    if (mysqli_num_rows($result1) > 0) {
                                        while($row1 = mysqli_fetch_assoc($result1))
                                         {
                                           echo $row1["Normal"];
                                         }
                                     } else {
                                        echo "ERROR! NO DATA FOUND";
                                     }
        ?>
"
       data-speed="1500"></h2>
       <p class="count-text " style="color: red; font-size: 30px">General Ward</p>
    </div>
	        </div>
              <div class="col">
               <div class="counter" style="border:5px;border-style:inset; border-color:#663399;">
      <h2 class="timer count-title count-number" data-to="      
      <?php
                                    $query2="SELECT Ventilators FROM beds WHERE Hospital_ID='$Hospital_ID';";
                                    $result2=mysqli_query($conn,$query2);
                                    if (mysqli_num_rows($result2) > 0) {
                                        while($row2 = mysqli_fetch_assoc($result2))
                                         {
                                           echo $row2["Ventilators"];
                                         }
                                     } else {
                                        echo "ERROR! NO DATA FOUND";
                                     }
        ?>
        " data-speed="1000"></h2>
      <p class="count-text " style="color: red; font-size: 30px">Ventilators</p>
    </div>
              </div>
              <div class="col">
                  <div class="counter" style="border:5px;border-style:outset; border-color:#663399;">
      <h2 class="timer count-title count-number" data-to="
      
      <?php
                                    $query3="SELECT ICU FROM beds WHERE Hospital_ID='$Hospital_ID';";
                                    $result3=mysqli_query($conn,$query3);
                                    if (mysqli_num_rows($result3) > 0) {
                                        while($row3 = mysqli_fetch_assoc($result3))
                                         {
                                           echo $row3["ICU"];
                                         }
                                     } else {
                                        echo "ERROR! NO DATA FOUND";
                                     }
        ?>
      
      " data-speed="1000"></h2>
      <p class="count-text " style="color: red; font-size: 30px">I.C.U</p>
    </div></div>
              <div class="col">
              <div class="counter" style="border:5px;border-style:inset; border-color:#663399;">
      <h2 class="timer count-title count-number" data-to="
      
            
      <?php
                                    $query4="SELECT Normal+ICU+Ventilators AS 'Total' FROM beds WHERE Hospital_ID='$Hospital_ID';";
                                    $result4=mysqli_query($conn,$query4);
                                    if (mysqli_num_rows($result4) > 0) {
                                        while($row4 = mysqli_fetch_assoc($result4))
                                         {
                                           echo $row4["Total"];
                                         }
                                     } else {
                                        echo "ERROR! NO DATA FOUND";
                                     }
        ?>

      " data-speed="1000"></h2>
      <p class="count-text " style="color: red; font-size: 30px">Total</p>
    </div>
              </div>
         </div>
         <br>
         <div class="col text-center">
         <p><a class="btn btn-lg btn-primary" href="UpdateBeds.php" role="button">Update</a></p>
        <br><br>
		</div>
         <hr class="featurette-divider">
</div>

 
 <!--Php csv file upload and table-->
  <br><br>
  <div class="container">
   <h2 align="center">Update  Database  </a></h2>
   <br />
   <form method="post" enctype='multipart/form-data'>
    <p><label>Please Select File(Only CSV Format)</label><br>
    <input type="file" name="product_file" style="color: red"/></p>
    <br />
    <input type="submit" name="upload" class="btn btn-lg btn-primary" value="Upload" />
   </form>
   <br />
   <?php echo $message; ?>
   <h3 align="center">Covid Patients</h3>
   <br />
   <div class="table-responsive">
    <table class="table table-bordered table-striped">
     <tr>
      <th>Patient_ID</th>
      <th>First_Name</th>
      <th>Middle_Name</th>
      <th>Last_Name</th>
      <th>Gender</th>
      <th>Age</th>
      <th>Email</th>
      <th>Mobile_No</th>
      <th>District</th>
      <th>Street</th>
      <th>Flat_Building_No</th>
      <th>Pincode</th>
      <th>Admit_Date</th>
      <th>Discharge_Date</th>
      <th>DOB</th>
     </tr>
     <?php
     while($row = mysqli_fetch_array($result))
     {
      echo '
      <tr>
       <td>'.$row["Patient_ID"].'</td>
       <td>'.$row["First_Name"].'</td>
       <td>'.$row["Middle_Name"].'</td>
       <td>'.$row["Last_Name"].'</td>
       <td>'.$row["Gender"].'</td>
       <td>'.$row["Age"].'</td>
       <td>'.$row["Email"].'</td>
       <td>'.$row["Mobile_No"].'</td>
       <td>'.$row["District"].'</td>
       <td>'.$row["Street"].'</td>
       <td>'.$row["Flat_Building_No"].'</td>
       <td>'.$row["Pincode"].'</td>
       <td>'.$row["Admit_Date"].'</td>
       <td>'.$row["Discharge_Date"].'</td>
       <td>'.$row["DOB"].'</td>
      </tr>
      ';
     }
     ?>
    </table>
   </div>
  </div>
 </body>
</html>