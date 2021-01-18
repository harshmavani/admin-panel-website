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

	$sql = "SELECT * FROM affiliate_data_table WHERE id ='".$_GET['dataid']."'";
	$query = mysqli_query($link,$sql);

	if (!$query){
   die('Invalid query: '.mysqli_error($link));
}
	$row=mysqli_fetch_assoc($query);	
	$Image_Path = $row['ImagePath']; 
	$Product_Name = $row['ProductName'];
	$Product_Price = $row['ProductPrice']; 
	$Product_Link = $row['ProductLink']; 
	

	if(isset($_POST['edit_data'])) 	{	
		$edit_Product_Name = $_POST['edit_Product_Name'];
		$edit_Product_Price = $_POST['edit_Product_Price'];
		$edit_Product_Link = $_POST['edit_Product_Link'];
		
		if ($_FILES['edit_Product_Image']['size'] == 0){
					$destfile = $Image_Path;

		}else{
		$edit_Product_Image = $_FILES['edit_Product_Image'];
		
    	$num_gr = (rand(0,10000));
		$filename = $num_gr.$edit_Product_Image['name'];
		$filepath = $edit_Product_Image['tmp_name'];
		$fileerror = $edit_Product_Image['error'];
		
		$destfile ='affiliate_photos/'.$filename;
			move_uploaded_file($filepath, $destfile);

			}
			$updat_query = "UPDATE affiliate_data_table SET ImagePath = '$destfile', ProductName = '$edit_Product_Name', ProductPrice = '$edit_Product_Price', ProductLink = '$edit_Product_Link' WHERE affiliate_data_table . id='".$_GET['dataid']."'" ;

			$edit_data_query = mysqli_query($link,$updat_query);

			if (mysqli_query($link,$updat_query)) {
				$_SESSION['edit_message'] = "Saved Successfully.";
				header('Location:affiliate_add_data.php');
				exit();		
			}else {
	            $_SESSION['edit_message_error'] = mysqli_error($link);
	    		header("Location:affiliate_add_data.php");
	            exit();
        	}
		
}
?>

<form method="POST" action="affiliate_edit_data.php?dataid=<?php echo $_GET['dataid'] ?>" enctype="multipart/form-data">
    	<div class="form-group">
		<label>Product Image:</label>
		<div style="display: inline-flex;height: 40px">
			<input type="file" class="form-control inslsi" name="edit_Product_Image" accept="image/png, image/jpeg" onchange="readURL(this);">
				<!-- <input type="file" class="form-control" name="banner-Image" onchange="readURL(this);"> -->
			<img src="<?php echo $Image_Path;?>" class="blah" style="margin-left: 10px;top: -30px;position: relative;width: 70px;height: 100px;">

		</div>
	</div>

	<div class="form-group">	

		<label>Product Name:</label>
		<input type="text" class="form-control" name="edit_Product_Name" value="<?php echo $Product_Name ; ?>">
	</div>
	<div class="form-group">

		<label>Product Price:</label>
		<input type="text" class="form-control" name="edit_Product_Price" value="<?php echo $Product_Price ; ?>">
	</div>
	<div class="form-group">
		<label>Product Link:</label>
		<input type="text" class="form-control" name="edit_Product_Link" value="<?php echo $Product_Link ; ?>">
	</div>
	<div class="modal-footer">
		<button type="submit" id="edit_data" name="edit_data" class="btn btn-default">Save</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
</form>

<script>

	
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

		$(".inslsi").select(function() {
		  alert( "Handler for .select() called." );
	  	$(".blah").show();
		});


</script>