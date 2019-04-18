<?php
$db = mysqli_connect("localhost", "food_manager", "gjVi5bGHKmdLeBMW", "food_composition");
if(isset($_POST["id"]))
{
 $value = mysqli_real_escape_string($db, $_POST["value"]);
 $query = "UPDATE fc_food_properties SET ".$_POST["column_name"]."='".$value."' WHERE food_id = '".$_POST["id"]."'";
 if(mysqli_query($db, $query))
 {
  echo 'Data Updated';
 }
}
?>