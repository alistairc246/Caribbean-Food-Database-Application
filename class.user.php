<?php

include "../config/db_config.php";

	class User{

		public $db;
		public $pass;

		public function __construct(){
			
			$this->db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
			
			// If database connection fails, display error and close connection..
			
			if(mysqli_connect_errno()) {
				
				echo "Error: Could not connect to database.";
			    exit;
			}
		}
		
		
		/*
			TimeStamp Generator Function
		*/
		
		public function timeStamp() {
		
			// Returns the current timestamp
			
			$timer = time();
			
			// Generates todays date based on the current timestamp
			
			$timestamp = date("Y-m-d", $timer);
			
			return $timestamp;
		
		}
		

		/* 
			Registration Function: enables users to register 
			
		*/
		
		public function reg_user($fname, $lname, $email, $password){
			
			$reg_time = $this->timeStamp();
			
			// Encrypt user passwords, for security and integrity purposes..
			
			$format_password = password_hash($password, PASSWORD_BCRYPT, array(
			
					'cost' => 10
				));
				
			$pass = $format_password;
				
				
			$sql = "SELECT * FROM fc_users WHERE first_name = '$fname' AND email = '$email'";

			//checking if the user is in database
			
			$check =  $this->db->query($sql) ;
			$count_row = $check->num_rows;

			// If the user is not in database, then insert add them to the fc_users table
			
			if ($count_row == 0){
				
				$sql1 = "INSERT INTO fc_users SET first_name = '$fname', last_name= '$lname', email = '$email', password = '$format_password', reg_date = '$reg_time'";
				
				$result = mysqli_query($this->db,$sql1) or die(mysqli_connect_errno()."Data cannot be inserted!");
				
				if($result) {
					
					$sql2 = "SELECT * from fc_users WHERE email = '$email'";

					// Checking if the user is in the database
					
					$result = mysqli_query($this->db, $sql2);
					
					$user_data = mysqli_fetch_array($result);
					$count_row = $result->num_rows;
					
					if($count_row == 1) {
						
						$_SESSION['login'] = true;
						$_SESSION['uid'] = $user_data['user_id'];
						
						// Registration Success
						header("location: ./dashboard.php");
					
					} else {
						
						header("location: ./login.php");
					}
					
				}					
        		
				
			} else { 
				
				echo "User Already Registered!";
			
			}
		}

		/* 
			Login Function: enables users to log in 
		*/
		
		public function check_login($email, $password){
			
			$sql2 = "SELECT * from fc_users WHERE email = '$email'";

			// Checking if the user is in the database
			
        	$result = mysqli_query($this->db, $sql2);
			
        	$user_data = mysqli_fetch_array($result);
        	$count_row = $result->num_rows;
			
			$uid = $user_data['user_id'];
			
			if(password_verify($password, $user_data['password'])) {
				
				$_SESSION['login'] = true;

                $_SESSION['uid'] = $user_data['uid'];

                header("location: ./dashboard.php");
				
			} else {
				
			    return false; // Display User Not Present in the database
			}

    	}
		

    	/* 		
			Display Logged in user: getName Function
		*/
		
    	public function getName($uid) {
			
    		$sql3 = "SELECT * FROM fc_users WHERE user_id = $uid";
			
	        $result = mysqli_query($this->db,$sql3);
	        $user_data = mysqli_fetch_array($result);
			
	        echo $user_data['first_name'];
    	}

    	/*
			Start Session Function			
		*/
			
		
	    public function get_session(){
			
	        return $_SESSION['login'];
	    }

	    public function user_logout() {
			
	        $_SESSION['login'] = FALSE;
			
			// remove all session variables
			
			session_unset(); 
			
	        session_destroy();
			
			header('location: ./index.php');
	    }

	}

?>