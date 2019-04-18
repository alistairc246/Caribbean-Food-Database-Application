<?php 
	
	/* Include header data: meta data, js scripts and css styles */
	
	include_once('../templates/header.php');
	
	/* Include navigation option data */
	
	include_once('../templates/nav.php');
		
	/* Start user's session */
	
	session_start();	

	/* Include User.class.php */
	
	include_once('../models/class.data.php');
	
	$data = new Data(); 
	
	$uid = $_SESSION['uid'];
	
	if (!$data->get_session()){
		
		header("location:login.php");
	}

	if (isset($_POST['logout_btn'])){
		
		$data->user_logout();
		
	}
	
	if (isset($_POST['upload'])) {
				
		// Checks if any file was selected..
		
		if($_FILES['food_file']['name']) {
				
			  $filename = explode(".", $_FILES['food_file']['name']);	
			  
				// If file extension is of type csv...
				
				if(end($filename) == "csv") { 
				
					// Read file contents
				  
					$handle = fopen($_FILES['food_file']['tmp_name'], "r");
								   
					while($datas = fgetcsv($handle)) {
						
						$group_id = mysqli_real_escape_string($data->db, $datas[0]);
						$food_code = mysqli_real_escape_string($data->db, $datas[1]);  
						$food_desc = mysqli_real_escape_string($data->db, $datas[2]);
						$water_amt = mysqli_real_escape_string($data->db, $datas[3]);
						$energy_kcal_amt = mysqli_real_escape_string($data->db, $datas[4]);
						$energy_kj_amt = mysqli_real_escape_string($data->db, $datas[5]);
						$protein_amt = mysqli_real_escape_string($data->db, $datas[6]);
						$total_fat_amt = mysqli_real_escape_string($data->db, $datas[7]);
						$saturated_fat_amt = mysqli_real_escape_string($data->db, $datas[8]);
						$cholesterol_amt= mysqli_real_escape_string($data->db, $datas[9]);
						$carbohydrate_amt = mysqli_real_escape_string($data->db, $datas[10]);
						$ash_amt = mysqli_real_escape_string($data->db, $datas[11]);
						$dietary_fibre_amt = mysqli_real_escape_string($data->db, $datas[12]);
						$calcium_amt = mysqli_real_escape_string($data->db, $datas[13]);
						$potassium_amt = mysqli_real_escape_string($data->db, $datas[14]);
						$iron_amt = mysqli_real_escape_string($data->db, $datas[15]);
						$magnesium_amt = mysqli_real_escape_string($data->db, $datas[16]);
						$phosphorus_amt = mysqli_real_escape_string($data->db, $datas[17]);
						$sodium_amt = mysqli_real_escape_string($data->db, $datas[18]);
						$zinc_amt = mysqli_real_escape_string($data->db, $datas[18]);
						$copper_amt = mysqli_real_escape_string($data->db, $datas[19]);
						$manganese_amt = mysqli_real_escape_string($data->db, $datas[20]);
						$vit_a_amt = mysqli_real_escape_string($data->db, $datas[21]);
						$thiamin_amt = mysqli_real_escape_string($data->db, $datas[22]);
						$riboflavin_amt = mysqli_real_escape_string($data->db, $datas[23]);
						$niacin_amt = mysqli_real_escape_string($data->db, $datas[24]);
						$total_folacin_amt = mysqli_real_escape_string($data->db, $datas[25]);
						$cyano_cobalamin_amt = mysqli_real_escape_string($data->db, $datas[26]);
						$vit_c_amt = mysqli_real_escape_string($data->db, $datas[27]);
						
						
						$chk_code = "SELECT * FROM fc_food_properties WHERE food_code = '$food_code'";

						//checking if the data is already in database
						
						$check =  $data->db->query($chk_code) ;
						$count_row = $check->num_rows;
						
						if($count_row == 0) {
							
							// Insert new data into the table..
							
							$query = "
								 INSERT INTO `fc_food_properties`(`group_id`, `food_code`, `food_desc`, `water_amt`, `energy_kcal_amt`, `energy_kj_amt`, `protein_amt`, `total_fat_amt`, `saturated_fat_amt`, `cholesterol_amt`, `carbohydrate_amt`, `ash_amt`, `dietary_fibre_amt`, `calcium_amt`, `potassium_amt`, `iron_amt`, `magnesium_amt`, `phosphorus_amt`, `sodium_amt`, `zinc_amt`, `copper_amt`, `manganese_amt`, `vit_a_amt`, `thiamin_amt`, `riboflavin_amt`, `niacin_amt`, `total_folacin_amt`, `cyano_cobalamin_amt`, `vit_c_amt`) VALUES ('$group_id','$food_code','$food_desc','$water_amt','$energy_kcal_amt',
									'$energy_kj_amt','$protein_amt','$total_fat_amt','$saturated_fat_amt','$cholesterol_amt','$carbohydrate_amt','$ash_amt','$dietary_fibre_amt',
									'$calcium_amt','$potassium_amt','$iron_amt','$magnesium_amt','$phosphorus_amt','$sodium_amt','$zinc_amt','$copper_amt',
									'$manganese_amt','$vit_a_amt','$thiamin_amt','$riboflavin_amt','$niacin_amt','$total_folacin_amt','$cyano_cobalamin_amt',
									'$vit_c_amt')";
								 
							// Execute the query..
								 
							$result = mysqli_query($data->db,$query) or die(mysqli_connect_errno()."Data cannot be inserted!");
									
						} else {
							
							// Update table data...	
						
							$query = "
								 UPDATE fc_food_properties
								 SET group_id = '$group_id', 
								 food_code = '$food_code', 
								 food_desc = '$food_desc', 
								 water_amt = '$water_amt', 
								 energy_kcal_amt = '$energy_kcal_amt',
								 energy_kj_amt = '$energy_kj_amt', 
								 protein_amt = '$protein_amt', 
								 total_fat_amt = '$total_fat_amt',
								 saturated_fat_amt = '$saturated_fat_amt',
								 cholesterol_amt = '$cholesterol_amt',
								 carbohydrate_amt = '$carbohydrate_amt',
								 ash_amt = '$ash_amt',
								 dietary_fibre_amt = '$dietary_fibre_amt',
								 calcium_amt = '$calcium_amt',
								 potassium_amt = '$potassium_amt',
								 iron_amt = '$iron_amt',
								 magnesium_amt = '$magnesium_amt',
								 phosphorus_amt = '$phosphorus_amt',
								 sodium_amt = '$sodium_amt',
								 zinc_amt = '$zinc_amt',
								 copper_amt = '$copper_amt',
								 manganese_amt = '$manganese_amt',
								 vit_a_amt = '$vit_a_amt',
								 thiamin_amt = '$thiamin_amt',
								 riboflavin_amt = '$riboflavin_amt',
								 niacin_amt = '$niacin_amt',
								 total_folacin_amt = '$total_folacin_amt',
								 cyano_cobalamin_amt = '$cyano_cobalamin_amt',
								 vit_c_amt = '$vit_c_amt'
								 WHERE food_code = '$food_code'";
								 
							// Execute the query..
								 
							$result = mysqli_query($data->db,$query) or die(mysqli_connect_errno()."Data cannot be inserted!");
							
						}
						
						
					}
					
					// Closes file after fetching all of that file data..
					
					fclose($handle);
					
					// Refresh page..
					header("location: dashboard.php");
				   
				} else {
					
					$data->message = '<label class="text-danger">Please Select CSV File Only</label>';
				
				}
  						
			}
	
	} else {
		
		$data->message = '<label class="text-danger">Please Select File</label>';
	}
	
	if(isset($_GET['updation'])) {
		
		$data->message = '<label class="text-danger">Food Item Updation Done!!</label>';
	
	}
	
	
	$query = "SELECT * FROM fc_food_properties";
								
	$result = mysqli_query($data->db, $query) or die(mysqli_connect_errno()."Data cannot be inserted!");
	
?>
	
	<header id="gtco-header" class="gtco-cover gtco-cover-sm" role="banner" style="background-image: url(images/img_2.jpg)">
		<div class="overlay"></div>
		<div class="gtco-container" style="width: 100% !important;">
			<div class="row">
				<div class="col-md-12 col-md-offset-0 text-left">
					
					<form action="" method="post">
						<div class="row row-mt-15em">

							<div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
								<span class="intro-text-small">View</span>
								<h1>Your Dashboard</h1>
								<input class="btn btn-primary" type="submit" value="Logout" name="logout_btn" />
							</div>
							
						</div>
					</form>		
					
				</div>
			</div>
		</div>
	</header><br/><br/>
	
	<div class="container" style="margin-top: 40%;">
	   <br/><br/>
			<form action="dashboard.php" method="post" enctype='multipart/form-data' style="border: solid; padding: 30px;">
				<p>
					<label>Please Select File (Only CSV Formate)</label>				
					<input type="file" name="food_file" />
				</p><br />
				
					<input type="submit" name="upload" class="btn btn-info" value="Upload" />
				
			   <br />
			   <?php echo $data->message; ?>
			   
			</form>
			
	</div>
	
<?php 

	/* Include footer data: js scripts */
	
	include('../templates/footer.php');

?>