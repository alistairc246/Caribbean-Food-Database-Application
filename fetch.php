<?php
//fetch.php
$db = mysqli_connect("localhost", "food_manager", "gjVi5bGHKmdLeBMW", "food_composition");
$columns = array('id', 'code', 'desc', 'water');

$query = "SELECT * FROM fc_food_properties ";

if(isset($_POST["search"]["value"]))
{
 $query .= '
 WHERE food_code LIKE "%'.$_POST["search"]["value"].'%" 
 OR food_desc LIKE "%'.$_POST["search"]["value"].'%" 
 ';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 ';
}
else
{
 $query .= 'ORDER BY food_id DESC ';
}

$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($db, $query));

$result = mysqli_query($db, $query . $query1);

$data = array();

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["food_id"].'" data-column="group_id">' . $row["group_id"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["food_id"].'" data-column="food_code">' . $row["food_code"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["food_id"].'" data-column="food_desc">' . $row["food_desc"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["food_id"].'" data-column="water_amt">' . $row["water_amt"] . '</div>';
 $sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["food_id"].'">Delete</button>';
 $data[] = $sub_array;
}

function get_all_data($db)
{
 $query = "SELECT * FROM fc_food_properties";
 $result = mysqli_query($db, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($db),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>
