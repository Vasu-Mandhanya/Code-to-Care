<?php
// Include config file
require_once "connection.php";
 
// Define variables and initialize with empty values
$username = $email = $password = $confirm_password = $state = "";
$username_err = $email_err = $password_err = $confirm_password_err = $state_err = "";
$district = $address = $pincode = "";
$state_err = $district_err = $address_err = $pincode_err = "";
 
    // Validate username
    if(empty(trim($_POST["username"])))
	{
        $username_err = "Please enter a username.";
		echo json_encode("$username_err");
		exit(0);
    } 
	else
	{
        // Prepare a select statement
        $sql = "SELECT user_id FROM user_email WHERE user_id = ?";
        if($stmt = $connection->prepare($sql))
		{
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute())
			{
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1)
				{
                    $username_err = "This username is already taken.";
					echo json_encode("$username_err");
					exit(0);
                } 
				else
				{
                    $username = trim($_POST["username"]);
                }
            } 
			else
			{
                echo json_encode("Oops! Something went wrong. Please try again later.");
				exit(0);
            }
            // Close statement
            $stmt->close();
        }
	}
    // Validate Email
    if(empty(trim($_POST["email"])))
	{
        $email_err = "Please enter a email.";
		echo json_encode("$email_err");
		exit(0);
    } 
	else
	{
        // Prepare a select statement
        $sql = "SELECT email_id FROM user_email WHERE email_id = ?";
        if($stmt = $connection->prepare($sql))
		{
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            // Set parameters
            $param_email = trim($_POST["email"]);
            // Attempt to execute the prepared statement
            if($stmt->execute())
			{
                // store result
                $stmt->store_result();
                if($stmt->num_rows == 1)
				{
                    $email_err = "This email has already been used.";
					echo json_encode("$email_err");
					exit(0);
                } 
				else
				{
                    $email = trim($_POST["email"]);
                }
            } 
			else
			{
                echo json_last_error("Oops! Something went wrong. Please try again later.");
				exit(0);
            }
            // Close statement
            $stmt->close();
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"])))
	{
        $password_err = "Please enter a password."; 
		echo json_encode("$$password_err");
		exit(0);
    } elseif(strlen(trim($_POST["password"])) < 8)
	{
        $password_err = "Password must have atleast 8 characters.";
		echo json_encode("$$password_err");
		exit(0);
    }
	else
	{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"])))
	{
        $confirm_password_err = "Please confirm password.";  
		echo json_encode("$confirm_password_err");
		exit(0);
    }
	else
	{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password))
		{
            $confirm_password_err = "Password did not match.";
			echo json_encode("$confirm_password_err");
			exit(0);
        }
    }
    
    //Validate State
    if(empty(trim($_POST["State"]))||$_POST["State"]=="#")
	{
        $state_err = "Please Choose a State"; 
		echo json_encode("$state_err");
		exit(0);
        #$popmessage ="Invalid Data Recieved. Page will be reloaded.";
        #echo "<script> alert('$popmessage');</script>"; 
        #header("Refresh: 0");
        #exit(0);
    }

    // Validate District
    if(empty(trim($_POST["District"]))||$_POST["District"]=="#")
	{
        $district_err = "Please Choose a District"; 
		echo json_encode("$district_err");
		exit(0);
    }
    else
	{
        $district=$_POST["District"];
    }
	
    // Validate Address
    if(empty(trim($_POST["Address"])))
	{
        $address_err = "Please enter address.";
		echo json_encode("$address_err");
		exit(0);
    } 
    else
	{
        $address=$_POST["Address"];
    }
    
    // Validate Pincode
    if(empty(trim($_POST["Pincode"])))
	{
        $pincode_err = "Please enter pincode"; 
		echo json_encode("$pincode_err");
		exit(0);
    } elseif(strlen(trim($_POST["Pincode"])) !=6)
	{
        $pincode_err = "Pincode must have 6 digits.";
		echo json_encode("$pincode_err");
		exit(0);
    } 
	else
	{
        $pincode = trim($_POST["Pincode"]);
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($state_err))
	{
        // Prepare an insert statement
        $sql = "INSERT INTO user_email (user_id,email_id,password) VALUES (?,?,?)";
        if($stmt = $connection->prepare($sql))
		{
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $param_username,$param_email,$param_password);
            // Set parameters
			$param_username = $username;
			$param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            // Attempt to execute the prepared statement
            if($stmt->execute())
			{
                $state=$_POST["State"];
                session_start();
                $_SESSION["State"]=$state;
                $_SESSION["USERNAME"]=$username;
                // Redirect to location page
                #header("location: registerlocation.php");
            } 
			else
			{
                echo json_encode("Something went wrong. Please try again later.");
				exit(0);
            }
            // Close statement
            $stmt->close();
		}
		else
		{
			echo json_encode("not working 2");
			exit(0);
		}
	}
    
    // Check input errors before inserting in database
    if(empty($district_err) && empty($address_err) && empty($pincode_err))
	{
        // Prepare an insert statement
        $sql1 = "INSERT INTO location (pincode,address,district_code) VALUES (?,?,?)";
        if($stmt1 = $connection->prepare($sql1))
		{
            // Bind variables to the prepared statement as parameters
            $stmt1->bind_param("sss", $param_pincode,$param_address,$param_district_code);
            // Set parameters
			$param_pincode= $pincode;
			$param_address= $address;
            $param_district_code = $district; 
            // Attempt to execute the prepared statement
            if($stmt1 ->execute())
            {
                $query = "SELECT location_id FROM location WHERE pincode='$pincode' and address='$address' and district_code='$district';";
                $res=mysqli_query($connection, $query);
				foreach ($res as $loc)
					{
						$location_id=$loc['location_id'];
                    }
                $user_id=$_SESSION['USERNAME'];
                #$location_id=$res['location_id'];
                $sql2 = "INSERT INTO user_location (user_id,location_id) VALUES (?,?)";
                if($stmt2 = $connection->prepare($sql2))
				{
                    // Bind variables to the prepared statement as parameters
                    $stmt2->bind_param("ss",$param_user_id,$param_location_id);
                    // Set parameters
                    $param_user_id=$user_id;
                    $param_location_id=$location_id;
                    // Attempt to execute the prepared statement
                    if($stmt2 ->execute())
                    {
                        // Redirect to login page
                        #header("location: login.php");
                    }
					$res->close();
				}
			}
			else
				{
					echo json_encode("Something went wrong. Please try again later.");
					exit(0);
				}
            // Close statement
            $stmt1->close();
		}
	}
	echo json_encode("Registration Successful");
?>
