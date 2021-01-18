<?php
/* Attempt to connect to MySQL database */
$link = mysqli_connect('localhost', 'root', '', 'admin_panel');

// Check connection
if($link === false){	
	die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql = "SELECT link FROM shortaner_data WHERE id ='".$_GET['id']."'";
$query = mysqli_query($link,$sql);

if (!$query){
	die('Invalid query: '.mysqli_error($link));
}
$row=mysqli_fetch_assoc($query);
$getlink = $row['link'];
?>

<!DOCTYPE>
<html>
<head>
	<title>download-page</title>
	<meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>
	<div class="container" style="text-align: center;">
		<center>
			<div class="card" style="height: 90px; width:728px;border: 1px solid;"></div>
		</center>

		<p style="text-align: center;">following button to download</p>


		<div class="row"  style="display:inline-flex;text-align: center;">
			<div class="col-md-3 col-sm-12">
 <div style="text-align: center;">
				<div class="card" style="height: 600px; width:160px;border: 1px solid;"></div>
</div>
			</div>
			<div class="col-md-6 col-sm-12" style="text-align:center">
				<div class="row">
					<span class="col-md-12 col-sm-12">
						<div class="card" style="height: 60px; width:468px;border: 1px solid;"></div>
					</span>

					<span class="col-md-12 col-sm-12">
						<p style="text-align: center;"><a href="<?php echo $getlink;?>"><button style="width:auto;border-radius:30px;background-color:black;">Download</button></a></p>
					</span>
					<span class="col-md-12 col-sm-12">
						<div class="card" style="height: 60px; width:468px;border: 1px solid;"></div>
					</span>
					<span class="col-md-12 col-sm-12">
						<p style="text-align: center;"><a href="#" target="_blank"><button style="width:auto;border-radius:30px;background-color:black">Fast Download</button></a></p>
					</span>
					<span class="col-md-12 col-sm-12">
						<div class="card" style="height: 60px; width:468px;border: 1px solid;"></div>
					</span>
				</div>
		</div>
		<div class="col-md-3 col-sm-12">

			<div class="card" style="height: 600px; width:160px;border: 1px solid;"></div>

		</div>
	</div>

	<div class="row">
		<div class="col-md-4 col-sm-12">
			<div class="card" style="height: 250px; width:300px;border: 1px solid;"></div>
		</div>
		<div class="col-md-4 col-sm-12">
			<div class="card" style="height: 250px; width:300px;border: 1px solid;"></div>
		</div>		
		<div class="col-md-4 col-sm-12">
			<div class="card" style="height: 250px; width:300px;border: 1px solid;"></div>
		</div>
	</div>
</div>
</body>	
</html>

