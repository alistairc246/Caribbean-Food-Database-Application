<?php

	/* Start user's session */
	
	session_start();	

	/* Include User.class.php */
	
	include_once('../models/class.user.php');
	
	$user = new User(); 
	
	$uid = $_SESSION['uid'];
	
	if (!$user->get_session()){
		
		header("location:login.php");
	}

?>

<html>
	<head>
		<title>Caribbean Food Database</title>
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />  
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
	
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
		<script src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
	
	</head>
	
	<body>
		<div class="container box">
			<h1 align="center">Caribbean Food Database</h1>
			<br />
			<div class="table-responsive">
			<br />
			<div align="right">
				<button type="button" name="add" id="add" class="btn btn-info">Add</button>
			</div>
			<br />
			<div id="alert_message"></div>
				<table id="user_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Category</th>
							<th>Food Code </th>
							<th>Description</th>
							<th>Water</th>
							<th></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</body>
</html>

<script type="text/javascript" language="javascript" >

	$(document).ready(function(){
	  
		// Call Fetch_Data Function: fetches data from the database and displays in a datatables
		
		fetch_data();
		
		// Fetch_Data Function...
		
		function fetch_data() {
			
		   var dataTable = $('#user_data').DataTable({
			"processing" : true,
			"serverSide" : true,
			"order" : [],
			"ajax" : {
			 url:"fetch.php",
			 type:"POST"
			}
			
		   });
		}
		
		// Update Data Function: enables users to edit database data within the table
		
		function update_data(id, column_name, value) {
  
		   $.ajax({
			url:"update.php",
			method:"POST",
			data:{id:id, column_name:column_name, value:value},
			success:function(data)
			{
				$('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
				$('#user_data').DataTable().destroy();
				fetch_data();
			}
		   });
		   
		   setInterval(function(){
				$('#alert_message').html('');
		   }, 5000);
		}
		
		// On blur or field change, updates the database data based on data entered in a particular column
		
		$(document).on('blur', '.update', function(){
		   var id = $(this).data("id");
		   var column_name = $(this).data("column");
		   var value = $(this).text();
		   update_data(id, column_name, value);
		});
		
		// Enables user to add new rows to the existing datatable, with editable fields
		
		$('#add').click(function(){
		   var html = '<tr>';
		   html += '<td contenteditable id="data1"></td>';
		   html += '<td contenteditable id="data2"></td>';
		   html += '<td contenteditable id="data3"></td>';
		   html += '<td contenteditable id="data4"></td>';
		  
		   
		   html += '<td><button type="button" name="insert" id="insert" class="btn btn-success btn-xs">Insert</button></td>';
		   html += '</tr>';
		   $('#user_data tbody').prepend(html);
		});
		
		  
		// Retrieves data entered within the editable fields. Using Ajax sends data to server files which is written to the database.
		
		$(document).on('click', '#insert', function(){
	  
		   var id = $('#data1').text();
		   var code = $('#data2').text();
		   var desc = $('#data3').text();
		   var water = $('#data4').text();
	   

			// If id, code and description fields aren't fulled in, display error message requesting user to enter all table fields
			
			if (id != '' && code != '' && desc != '') {
				
				$.ajax({
					
					url:"insert.php",
					method:"POST",
					data:{id:id, code:code, desc:desc, water:water},
					success:function(data) {
						
						$('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
						$('#user_data').DataTable().destroy();
						fetch_data();
					}
				});
				
				// Display alert message (error or success) for 5 secs
				
				setInterval(function() {
					$('#alert_message').html('');
				}, 5000);
			
			} else {
				
				alert("All Fields Are Required!!!");
			}
		});
  
  
		// Deletes row items based on food_id of the particular row.
		
		$(document).on('click', '.delete', function(){
			
			// Retrieve and store row id
			
			var id = $(this).attr("id");
   
			// Ask for user deletion confirmation
			
			if (confirm("Are you sure you want to remove this?")) {				
				
				$.ajax({
					url:"delete.php",
					method:"POST",
					data:{id:id},
					success:function(data){
						$('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
						$('#user_data').DataTable().destroy();
						fetch_data();
					}
				});
				
				setInterval(function(){
					$('#alert_message').html('');
				}, 5000);
			}
		});
	});
</script>