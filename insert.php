<?php

	$db = mysqli_connect("localhost", "food_manager", "gjVi5bGHKmdLeBMW", "food_composition");

	if(isset($_POST["id"], $_POST["code"], $_POST["desc"], $_POST["water"]))
	{
	 $id = mysqli_real_escape_string($db, $_POST["id"]);
	 $code = mysqli_real_escape_string($db, $_POST["code"]);
	 $desc = mysqli_real_escape_string($db, $_POST["desc"]);
	 $water = mysqli_real_escape_string($db, $_POST["water"]);
	 //$energy_kcal = mysqli_real_escape_string($db, $_POST["energy_kcal"]);
	 
	 
	 $query = "INSERT INTO fc_food_properties(group_id, food_code, food_desc, water_amt) VALUES('$id', '$code', '$desc', '$water')";
	 if(mysqli_query($db, $query))
	 {
	  echo 'Data Inserted';
	 }
	}
?>
