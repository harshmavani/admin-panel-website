<?php 
session_start();
include "check_login_sesstion.php";
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'admin_panel');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){	
	die("ERROR: Could not connect. " . mysqli_connect_error());
}

$success_message = "";	
$error_message = "";


if(isset($_POST['Add_data'])){
	$Product_Image = $_FILES['Product_Image'];
	$Product_Name = $_POST['Product_Name'];
	$Product_Price = $_POST['Product_Price'].$_POST['Money_Type'];
	$menu_Link = $_POST['Product_Link'];

	$num_gr = (rand(0,10000));
	$filename = $num_gr.$Product_Image['name'];
	$filepath = $Product_Image['tmp_name'];
	$fileerror = $Product_Image['error'];

	$destfile = 'affiliate_photos/'.$filename;
	move_uploaded_file($filepath, $destfile);

	$insertqurey =" INSERT INTO affiliate_data_table (ImagePath, ProductName, ProductPrice, ProductLink) VALUES ('$destfile', '$Product_Name', '$Product_Price', '$menu_Link') ";
	
	
    	if (mysqli_query($link, $insertqurey)) {
           $_SESSION['message'] = "Added Successfully";
    		header("Location:affiliate_add_data.php");
    		exit(); 
        } else {
            $_SESSION['message_error'] = mysqli_error($link);
    		header("Location:affiliate_add_data.php");
            exit();
        }

    }
$show_error = "Please fill all field to enable <b style='color:black';>Add</b> button.";
?>		


<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>database data</title>

	<!-- Custom fonts for this template -->
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="css/sb-admin-2.min.css" rel="stylesheet">

	<!-- Custom styles for this page -->
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<style type="text/css">  

	select{
		border: 1px solid #d1d3e2;
	    border-radius: 5px;
	}
	select:focus{
		outline: none;
	}
	.modal input{
	    height: 43px;
	}
	

	#snackbar {
	  visibility: hidden;
	  min-width: 250px;
	  margin-left: -125px;
	  background-color: #333;
	  color: #fff;
	  text-align: center;
	  border-radius: 2px;
	  padding: 16px;
	  position: fixed;
	  z-index: 1;
	  left: 50%;
	  bottom: 30px;
	  font-size: 17px;
	}

	#snackbar.show {
	  visibility: visible;
	  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
	  animation: fadein 0.5s, fadeout 0.5s 2.5s;
	}

	@-webkit-keyframes fadein {
	  from {bottom: 0; opacity: 0;} 
	  to {bottom: 30px; opacity: 1;}
	}

	@keyframes fadein {
	  from {bottom: 0; opacity: 0;}
	  to {bottom: 30px; opacity: 1;}
	}

	@-webkit-keyframes fadeout {
	  from {bottom: 30px; opacity: 1;} 
	  to {bottom: 0; opacity: 0;}
	}

	@keyframes fadeout {
	  from {bottom: 30px; opacity: 1;}
	  to {bottom: 0; opacity: 0;}
	}
</style>
</head>

<body id="page-top" onload="myFunction();">
    <?php
if (isset($_SESSION['message'])) {
	echo "<div id='snackbar' style='background-color:green!important'>".$_SESSION['message']."</div>";
	unset($_SESSION['message']);
} 
if (isset($_SESSION['message_error'])) {
	echo "<div id='snackbar' style='background-color:red!important';>".$_SESSION['message_error']."</div>";
	unset($_SESSION['message_error']);
} 
if (isset($_SESSION['edit_message'])) {
	echo "<div id='snackbar' style='background-color:green!important';>".$_SESSION['edit_message']."</div>";
	unset($_SESSION['edit_message']);
} 
if (isset($_SESSION['edit_message_error'])) {
	echo "<div id='snackbar' style='background-color:red!important';>".$_SESSION['edit_message_error']."</div>";
	unset($_SESSION['edit_message_error']);
}
if (isset($_SESSION['delete_message'])) {
	echo "<div id='snackbar' style='background-color:green!important';>".$_SESSION['delete_message']."</div>";
	unset($_SESSION['delete_message']);
} 	
if (isset($_SESSION['delete_message_error'])) {
	echo "<div id='snackbar' style='background-color:red!important';>".$_SESSION['delete_message_error']."</div>";
	unset($_SESSION['delete_message_error']);
}
?>
	<!-- Page Wrapper -->
	<div id="wrapper">

		<!-- Sidebar -->
		<?php include "sidebar.php" ?>

		<!-- End of Sidebar -->

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">

				<!-- Topbar -->
				<?php include "topbar.php" ?>

				<!-- End of Topbar -->
 
				<!-- Begin Page Content -->
				<div class="container-fluid">
					<div style="text-align: right; margin-right: 10px;margin-bottom: 10px;">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#luanch_modal">Add Product</button>
					</div>

					<!-- DataTales Example -->
					<div>
						<div class="card shadow mb-4">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary">Products Data</h6>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" >
										<thead>
											<tr>
												<th>Id</th>
												<th>Image</th>
												<th>Product Name</th>
												<th>Product Price</th>
												<th>Product Link</th>
												<th>Date & Time</th>
												<th>Action</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Id</th>
												<th>Image</th>
												<th>Product Name</th>
												<th>Product Price</th>
												<th>Product Link</th>
												<th>Date & Time</th>
												<th>Action</th>
											</tr>
										</tfoot>
										<tbody>


											<?php

											$sql = "SELECT * FROM affiliate_data_table";
											$query = mysqli_query($link,$sql);
											while($row=mysqli_fetch_assoc($query)){
												$id = $row['id']; 
												$Image_Path = $row['ImagePath']; 
												$Product_Name = $row['ProductName'];
												$Product_Price = $row['ProductPrice']; 
												$Product_Link = $row['ProductLink']; 
												$Date_Time = $row['date_time']; 
												$newDateTime = date('d-m-Y h:i A', strtotime($Date_Time));

												echo "<tr>
												<td>$id</td>	
												<td><img src='$Image_Path'width='70' height='100'></td>
												<td>$Product_Name</td>
												<td>$Product_Price</td>
												<td>$Product_Link</td>
												<td>$newDateTime</td>
												<td>
												<img src='img/edit.png' width='30px' data-id='{$id}' class='getdataid' data-toggle='modal'style='cursor:pointer'>
												<img src='img/delete.png' width='30px'class=' delete_data_id' data-id='{$id}' style='cursor:pointer'></td>
												</tr>";
											}

											?>

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

				</div>
				<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->

		</div>
		<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- modal -->

	<div id="luanch_modal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Prouduct</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form method="POST" enctype="multipart/form-data" id="reset" name="reset" action="affiliate_add_data.php">

						<div class="form-group">
							<label>Product Image</label><br>
							<div style="display: inline-flex;    height: 40px;">
								<input type="file" class="form-control container-fluid" id="Product_Image" name="Product_Image" onchange="readURL(this);">
								<img class="blah" style="margin-left: 10px;top:-30px; position: relative;">
							</div>
						</div>

						<div class="form-group"> 

							<label>Product Name</label>
							<input type="text" class="form-control" id="Product_Name" name="Product_Name" maxlength="50">
						</div>
						<div class="form-group">

							<label>Product Price</label>
							<div style="display: inline-flex;">
								<input type="number" class="form-control" name="Product_Price">
								<select name="Money_Type" style="margin-left: 5px;">
									<option value="₹">₹</option>
									<option value="$">$</option>	
								</select>
							</div>
						</div>
						<div class="form-group">

							<label>Product Link</label>
							<input type="text" class="form-control" name="Product_Link">
						</div>

						<div class="modal-footer">
							<div id="show_error" style="color: red; float: left; "><?php echo $show_error; ?></div>
							<div>
								<button type="submit" id="Add_data" name="Add_data" class="btn btn-default" disabled="disabled">Add</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>

						</div>
					</form>
				</div>

			</div>

		</div>
	</div>

<div id="edit_menu_modal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Edit Menu</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div id="employee_detail" class="modal-body">
					</div>
				</div>

			</div>
		</div>

		<!--modal-->

		<div id="delete_menu_modal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Delete Menu</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div id="delete_data" class="modal-body">
						<div class="modal-footer">
						</div>
					</div>

				</div>
			</div>
		</div>
		<!-- modal -->

	<!-- Bootstrap core JavaScript-->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Core plugin JavaScript-->
	<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

	<!-- Custom scripts for all pages-->
	<script src="js/sb-admin-2.min.js"></script>

	<!-- Page level plugins -->
	<script src="vendor/datatables/jquery.dataTables.min.js"></script>
	<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

	<!-- Page level custom scripts -->
	<script src="js/demo/datatables-demo.js"></script>
	<script type="text/javascript">

		
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					$('.blah')
					.attr('src', e.target.result)
					.width(70)
					.height(100);
				};

				reader.readAsDataURL(input.files[0]);
			}
		}

		required = function(fields) {
			var valid = true;
  fields.each(function() { // iterate all
  	var $this = $(this);
    if ((($this.is(':text') || $this.is(':file') || $this.is('textarea')) && !$this.val()) || // text and file and textarea
      ($this.is(':radio') && !$('input[name=' + $this.attr("name") + ']:checked').length)) { // radio
    	valid = false;
    	
}
});
  return valid;
}

validateRealTime = function() {
	var fields = $("#luanch_modal :input");
	fields.on('keyup change keypress blur', function() {
		if (required(fields)) {
			{
				$("#Add_data").prop('disabled', false);
				$("#show_error").css("display", "none");

			}
		} else {	
			{
				$("#Add_data").prop('disabled', true);
				$("#show_error").css("display", "block");

			}
		}
	});
}

validateRealTime();


				$('.getdataid').click(function(){
					var dataId = $(this).attr("data-id");

					$.ajax({
						method:"GET",
						url: "affiliate_edit_data.php?dataid="+dataId,
						success:function(data){
							$('#employee_detail').html(data);
							$('#edit_menu_modal').modal("show");

						}			
					});
				});


				$('.delete_data_id').click(function(){
					var dataId = $(this).attr("data-id");

					$.ajax({
						method:"POST",
						url: "affiliate_delete_data.php",
						data:{dataid:dataId},
						success:function(data){
							$('#delete_data').html(data);
							$('#delete_menu_modal').modal("show");

						}			
					});
				});
			
function myFunction() {
  var x = document.getElementById("snackbar");
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

</script>
  <script type="text/javascript">

var table = $('#dataTable').DataTable();

// Sort by column 1 and then re-draw
table
    .order( [ 0, 'desc' ] )
    .draw();
 
  </script>

</body>

</html>