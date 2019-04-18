<?php 

	/* Include header data: meta data, js scripts and css styles */
	
	include('../templates/header.php');
	
	/* Include navigation option data */
	
	include('../templates/nav.php');
	
	
	require_once '../model/DB.class.php';

	class User {
		
		protected $firstname = '';
		protected $lastname = '';
		protected $email = '';
		protected $password = '';
		protected $cpassword = '';		
		
		public function timeStamp() {
		
			// Returns the current timestamp
			
			$timer = time();
			
			// Generates todays date based on the current timestamp
			
			$timestamp = date("Y-m-d", $timer);
			
			return $timestamp;
		
		}

		// Log in admin user
		// Check if the username and password match within the database.
		// Set user session, once logged in successfully.
		
		public function login( $username, $password ) {
			
			
			$result = $conn->mysqli_query("SELECT username FROM users WHERE username = '$username' AND password = '$cryptPassword' ");
			
			if ( mysqli_num_rows($result) == 1 ) {
				
				$_SESSION[ "user" ] = serialize( mysqli_fetch_assoc( $result ));
				
				header('location: ../pages/dashboard.php');
				
			} else {
				
				header('location: ../pages/login.php');
			}
		}
		
		public function register( $ufname, $ulname, $uemail, $upassword, $ucpassword ) {	

			$this->firstname = $ufname;
			$this->lastname = $ulname;
			$this->email = $uemail;
			$this->password = $upassword;
			$this->cpassword = $ucpassword;
			
			// Get current timeStamp
			
			$time = timeStamp();
			
			// If passwords match!
			// Store POST data into the database
			
			if($password === $cpassword){
				
				// Encrypt user passwords, for security and integrity purposes..
				
				$format_password = password_hash($password, PASSWORD_BCRYPT, array(
				
						'cost' => 10
					));
					
				// Execute queries to the database..
						
				$insertion = $conn->mysqli_query("INSERT INTO fc_users (first_name, last_name, email, password, reg_date) VALUES ('$firstname','$lastname','$email','$format_password', '$time')");
						
				if ($insertion) {
					
					header("location: ../pages/login.php");
					
				} else {
					
					header("location: ../pages/register.php");
				}
				
			} else {
				
				//array_push($errors, "Passwords did not match!");
			}
		}
	}
	
	$user = new User();
	
	// Check if user submission form was submitted.
	
	if(isset($_POST['signup'])) {
		
		$fname = mysqli_real_escape_string($conn, $_POST['firstname']);
		$lname = mysqli_real_escape_string($conn, $_POST['lastname']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password =  mysqli_real_escape_string($conn, $_POST['password']);	
		$cpassword =  mysqli_real_escape_string($conn, $_POST['repeatPassword']);	
		
		$user->register($fname, $lname ,$email, $password, $cpassword);
	}
	
	// Check if user submission form was submitted.
	
	if(isset($_POST['signin'])) {
		
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password =  mysqli_real_escape_string($conn, $_POST['password']);	
		
		$user->login($email, $password);
	}
	
	
?>

	<header id="gtco-header" class="gtco-cover" role="banner" style="background-image: url(images/img_4.jpg)">
		<div class="overlay"></div>
		<div class="gtco-container">
			<div class="row">
				<div class="col-md-12 col-md-offset-0 text-left">
					

					<div class="row row-mt-15em">
						<div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
							<span class="intro-text-small">Welcome to the Caribbean Food Database</span>
							<h1>Healthier Living.</h1>	
						</div>
						<div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
							<div class="form-wrap">
								<div class="tab">
									<ul class="tab-menu">
										<li class="active gtco-first"><a href="#" data-tab="signup">Sign up</a></li>
										<li class="gtco-second"><a href="#" data-tab="login">Login</a></li>
									</ul>
									<div class="tab-content">
										<div class="tab-content-inner active" data-content="signup">
											<form action="register.php" method="post">
												<div class="row form-group">
													<div class="col-md-6">
														<label for="firstname">First Name</label>
														<input type="text" class="form-control" id="firstname" name="firstname" required>
													</div>
													<div class="col-md-6">
														<label for="lastname">Last Name</label>
														<input type="text" class="form-control" id="lastname" name="lastname" required>
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<label for="email">Email</label>
														<input type="email" class="form-control" id="email" name="email" required>
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-6">
														<label for="password">Password</label>
														<input type="password" class="form-control" id="password" name="password" required>
													</div>
													<div class="col-md-6">
														<label for="password2">Repeat Password</label>
														<input type="password" class="form-control" id="cpassword" name="repeatPassword" required>
													</div>
												</div>
												

												<div class="row form-group">
													<div class="col-md-12">
														<input type="submit" class="btn btn-primary" name="signup" value="Sign In">
													</div>
												</div>
											</form>	
										</div>

										<div class="tab-content-inner" data-content="login">
											<form action="register.php" method="post">
												<div class="row form-group">
													<div class="col-md-12">
														<label for="username">Email</label>
														<input type="text" class="form-control" id="username" name="email">
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<label for="password">Password</label>
														<input type="password" class="form-control" id="password" name="password">
													</div>
												</div>

												<div class="row form-group">
													<div class="col-md-12">
														<input type="submit" class="btn btn-primary" name="signin" value="Login">
													</div>
												</div>
											</form>	
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
							
					
				</div>
			</div>
		</div>
	</header>


<?php 

	/* Include footer data: js scripts */
	
	include('../templates/footer.php');

?>