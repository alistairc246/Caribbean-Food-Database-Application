<?php 

	/* Include header data: meta data, js scripts and css styles */
	
	include_once('../templates/header.php');
	
	/* Include navigation option data */
	
	include_once('../templates/nav.php');
	
	session_start();
	
	/* Include User.class.php */
	
	include_once('../models/class.user.php');
	
	// Create new object of User class
	
	$user = new User();
	
	// Check if user submission form was submitted.
	
	if (isset($_REQUEST['signin'])) {
		
		extract($_REQUEST);	
				
	    $login = $user->check_login($email, $password);
		
	}
	
	if (isset($_REQUEST['register'])) {
		
		extract($_REQUEST);			
		
		if($password === $passwordRepeat) {
				
			$register = $user->reg_user($firstname, $lastname, $email, $password);
			
			
		} else {
			
			echo "Password didn't match";
		}
		
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
											<form action="login.php" method="post" name="register">
												<div class="row form-group">
													<div class="col-md-6">
														<label for="firstname">First Name</label>
														<input type="text" class="form-control" id="firstname" name="firstname">
													</div>
													<div class="col-md-6">
														<label for="lastname">Last Name</label>
														<input type="text" class="form-control" id="lastname" name="lastname">
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<label for="email">Email</label>
														<input type="email" class="form-control" id="email" name="email">
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
														<label for="password2">Repeat Password</label>
														<input type="password" class="form-control" id="passwordRepeat" name="passwordRepeat">
													</div>
												</div>

												<div class="row form-group">
													<div class="col-md-12">
														<input type="submit" class="btn btn-primary" name="register" value="Register" onclick="return(submitreg());">
													</div>
												</div>
											</form>	
										</div>

										<div class="tab-content-inner" data-content="login">
											<form action="login.php" method="post" name="login">
												<div class="row form-group">
													<div class="col-md-12">
														<label for="username">Email</label>
														<input type="text" class="form-control" id="email" name="email">
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
														<input type="submit" class="btn btn-primary" name="signin" value="Sign In" onclick="return(submitlogin());">
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
	
	<script type="text/javascript" language="javascript">

				function submitlogin() {
					
					var form = document.login;
					
					if(form.email.value == "") {
						
						alert( "Enter Your Email." );
						return false;
						
					} else if(form.password.value == "") {
						
						alert( "Enter Your Password." );
						return false;
					}
				}
				
				function submitreg() {
					
					 var form = document.register;
					 
					 if(form.firstname.value == ""){
						 
						alert( "Enter Your First Name." );
						return false;
						
					 } else if(form.lastname.value == ""){
						 
						 alert( "Enter Your Last Name." );
						 return false;
						 
					 } else if(form.email.value == ""){
						 
						 alert( "Enter Your Email." );
						 return false;
						 
					 } else if(form.password.value == ""){
						 
						 alert( "Enter Your Password." );
						 return false;
					 
					 } else if(form.passwordRepeat.value == ""){
						 
						 alert( "Confirm Your Password." );
						 return false;
					 }
				}

	</script>


<?php 

	/* Include footer data: js scripts */
	
	include('../templates/footer.php');

?>