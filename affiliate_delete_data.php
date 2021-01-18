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

	$sql = "SELECT * FROM affiliate_data_table WHERE id ='".$_POST['dataid']."'";
	$query = mysqli_query($link,$sql);
	$row = mysqli_fetch_assoc($query);	
	$Image_Path = $row['ImagePath']; 
 		
 ?>	

<form method="POST">
	<div class="form-group">
		<div class="">Are You Sure You Want To Delete This Product<img src="<?php echo $Image_Path; ?>" alt="image" width="40" height="60" style="margin-left:10px; margin-right:10px;"></div>
	</div>
	<div class="modal-footer">
		<a href=affiliate_inner_delete_data.php?dataid=<?php echo $_POST['dataid'] ?>><button type="button" class="btn btn-default">Yes (Delete) </button></a>
		<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
	</div>
</form>