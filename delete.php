<?php
$db = mysqli_connect("localhost", "food_manager", "gjVi5bGHKmdLeBMW", "food_composition");
if(isset($_POST["id"]))
{
 $query = "DELETE FROM fc_food_properties WHERE food_id = '".$_POST["id"]."'";
 if(mysqli_query($db, $query))
 {
  echo 'Data Deleted';
 }
}
?>