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
?>


 <!DOCTYPE html>  
 <html lang="en">
 <head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin-Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <style type="text/css">

      body {
        font-family: 'Roboto', sans-serif;
        background: #fff;
      }
      p{
        font-weight: 500;
      }
      a{
        color: black;  
      }
      a:link {
        text-decoration: none;
      }

      a:visited {
        text-decoration: none;
      }

      a:hover {
        text-decoration: none;
        color: black;
      }

      a:active {
        text-decoration: none;
      }

      .wrap {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -ms-flex-direction: row;
        flex-direction: row;
      }

      .box {
        margin: 10px;
        width: 280px;
        height: auto;
        min-height: 500px;
        text-align: center;
        padding-top: 1px;
        position: relative;
        border-radius: 3px;
        -webkit-transition: 200ms ease-in-out;
        -o-transition: 200ms ease-in-out;
        transition: 200ms ease-in-out;
        -webkit-box-shadow: 0 0 15px rgba(0,0,0,0.3);
        box-shadow: 0 0 15px rgba(0,0,0,0.3);
      }
      .box:hover {
        margin-bottom: -10px;
        -webkit-box-shadow: 0 0 5px rgba(0,0,0,0.7);
        box-shadow: 0 0 5px rgba(0,0,0,0.7);
      }
      .box h1 {
        color: #fff;
        padding: 30px;
        margin-top: 100px;
        text-align: center;
        font-weight: 100;
        font-size: 25px;
        background: rgba(0,0,0,0.8);
        -webkit-box-shadow: 0 0 30px rgba(0,0,0,0.7);
        box-shadow: 0 0 30px rgba(0,0,0,0.8);
      }
      .box .box_botton{
        background-color: black;
        color: #fff!important;
        position: absolute;
        width: 100%;
        bottom: 0;   
      }
      .card img {
        height: 300px;
      }
      .box .price {
        padding: 15px;
        padding-top: 0px;
        padding-bottom: 0px;
      }
      .box .price p{
        margin: 2px;
      }
      .box .pname {
        padding: 15px;
      }
      .box .card{
        margin: 10px;
        padding-bottom: 0px;
      }

      @-webkit-keyframes rotation {
        from {
          -webkit-transform: rotate(0deg);
        }
        to {
          -webkit-transform: rotate(359deg);
        }
      }
      .pagination {
    display: inline-block;
  }

.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
  border: 1px solid #ddd;
}

.pagination a.active {
background-color: #000000;
    color: white;
    border: 1px solid #ff0000;
}

.pagination a:hover:not(.active) {background-color: #fff;}
.disabled  {
    pointer-events: none;
    opacity: 0.4;
}

      .search-box{
          width: 100%;
          position: relative;
          display: inline-block;
          font-size: 14px;
          padding: 1.5rem;
          padding-top: 0;
      }
      .search-box input{
          display: inline-flex;
          position: absolute;
          max-width: 225px;
      }
      .search-box input[type="text"]{
          height: 32px;
          padding: 5px 10px;
          border: 1px solid #CCCCCC;
          font-size: 14px;
      }
      .result{
          z-index: 999;
          justify-content: center;
          display: flex;
          flex-flow: wrap;
      }
      .search-box input[type="text"], .result{
          width: 100%;
          box-sizing: border-box;
      }
      #hr{
        display: none;
      }

  </style>
</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <?php include "Sidebar.php"?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php include "topbar.php" ?>
        <!-- End of Topbar -->
          <div class="conatiner">
    <div class="search-box">
        <label for="Search_movie" style="margin: 5px;font-weight: bold;">Search:</label>
        <input type="text" id="Search_movie" autocomplete="on" placeholder="Search Product..." />
        <div class="result"></div>
        <div id="hr"><hr></div>
    </div>

    <div class="wrap">
      <?php

      $q1 = mysqli_query($link, "SELECT * FROM affiliate_data_table");
      $count = mysqli_num_rows($q1);
      $prev_page_main = $next_page_main = "";
      $rowsperpage = 1;
      $page = $_REQUEST['page'];  
      $page = $page - 1;

      $p = $page * $rowsperpage;  

      $sql = "SELECT * FROM affiliate_data_table ORDER BY id DESC LIMIT ".$p.", ".$rowsperpage;
      $query = mysqli_query($link,$sql);
      while($row=mysqli_fetch_assoc($query)){
        $id = $row['id']; 
        $Image_Path = $row['ImagePath']; 
        $Product_Name = $row['ProductName'];
        $Product_Price = $row['ProductPrice']; 
        $Product_Link = $row['ProductLink']; 
        echo "

<a href='$Product_Link'>  
        <div class='box'>
          <div class=''>
            <div class='card'>
              <img src='$Image_Path' >
            </div>
            <div class='pname card'>
              <p>$Product_Name...</p>
            </div>
            <div class='price card'>
              <p><strong>Price:</strong>$Product_Price</p>
            </div>
            <div class='box_botton'>
              <button style='color:#fff!important;' class='btn'>Buy Now</button>
            </div>
          </div>
        </div>
      </a>

";
      }
        if($_REQUEST['page'] > 1){
          $prev_page = $_REQUEST['page'] - 1;
          $prev_page_main = '<div class="container"><a href= "card_demo.php?page='.$prev_page.'">Previous</a></div>';   

        }else{
          $prev_page = $_REQUEST['page'] - 1;
          $prev_page_main = '<div class="container disabled"><a href= "card_demo.php?page='.$prev_page.'">Previous</a></div>';   
        }

        $check = $p + $rowsperpage;
              
        if($check < $count){
          $next_page = $_REQUEST['page'] + 1;
          $next_page_main = '<div class="container"><a href= "card_demo.php?page='.$next_page.'">next</a></div>';
        }else{
          $next_page = $_REQUEST['page'] + 1;
          $next_page_main = '<div class="container disabled"><a href= "card_demo.php?page='.$next_page.'">next</a></div>'; 
        }

        $limit = $count / $rowsperpage;
        $limit = ceil($limit);
               
      ?>
      <div class="pagination container" style="margin-top:50px;">
      <?php
      echo $prev_page_main;
      for ($i=1; $i<=$limit; $i++) { 
                if ($i==$_REQUEST['page']) {
                 $page_number = $i;
                 echo'<a href="card_demo.php?page='.$page_number.'" class="active disabled">'.$page_number.'</a>';
                }else{

                  for ($j=1; $j<=7; $j++){
                    
                  echo'<a>...</a>';
                  echo'<a href="card_demo.php?page='.$i.'">'.$i.'</a>';
                }

              }
              }
      echo $next_page_main;
      ?>
      </div>

    </div>
  </div>

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/chart-area-demo.js"></script>
<script src="js/demo/chart-pie-demo.js"></script>

<!-- search script -->

<script type="text/javascript">
$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("backend-search.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
                document.getElementById("hr").style.display = "block";

            });
        } else{
            resultDropdown.empty();
            document.getElementById("hr").style.display = "none";

        }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result", function(){
        // $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        $(this).parent(".result").empty();

    });
});
</script>

</body>

</html>
