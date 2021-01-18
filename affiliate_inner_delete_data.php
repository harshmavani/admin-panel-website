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

$delete = "DELETE FROM affiliate_data_table WHERE id ='".$_GET['dataid']."'";
	$delete_query = mysqli_query($link,$delete);

			if (mysqli_query($link,$delete)) {
				$_SESSION['delete_message'] = "deleted Successfully.";
				header('Location:affiliate_add_data.php');
				exit();		
			}else {
	            $_SESSION['delete_message_error'] = mysqli_error($link);
	    		header("Location:affiliate_add_data.php");
	            exit();
        	}

?>