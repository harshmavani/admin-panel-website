 <?php
session_start();
include "check_login_sesstion.php";

  include "..\lefpro\admin\config.php";
  if((!empty($_POST['menu-Name']))){

    if(isset($_POST['Add_data'])){
      $menu_Name = $_POST['menu-Name'];
      $menu_Title = $_POST['menu-Title'];
      $menu_Link = $_POST['menu-Link'];
      $banner_Image = $_FILES['banner-Image'];
      $banner_Title = $_POST['banner-Title'];
      $banner_Descriptoin = $_POST['banner-Descriptoin'];

      $filename = $banner_Image['name'];
      $filepath = $banner_Image['tmp_name'];
      $fileerror = $banner_Image['error'];


      $destfile = '../lefpro/admin/upload-images/'.$filename;
      move_uploaded_file($filepath, $destfile);

      $insertqurey =" INSERT INTO add_menu_data (menuname, menutitle, menulink, bannerimage, bannertitle, bannerdescription) VALUES ('$menu_Name', '$menu_Title', '$menu_Link', '$destfile', '$banner_Title', '$banner_Descriptoin') ";

      $query = mysqli_query($link,$insertqurey); 

    //create file
      $myfile = fopen("../lefpro/$menu_Link", "w");
      $txt = file_get_contents('../lefpro/admin/add_menu_fileformat.php', true);
      fwrite($myfile, $txt);
      header('Location: index.php'); 

      $success_message = "Add successfully";  
      echo "<script type='text/javascript'>alert('$success_message');</script>";


    }
  }else{
    $show_error = "Please fill all field to enable <b style='color:black';>Add</b> button.";
    
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
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


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

        <div class="container-fluid">
          <div style="text-align: right; margin-right: 10px;margin-bottom: 10px;">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Menu</button>
          </div>

          <!-- DataTales Example -->
          <div>
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Menu Data</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" >
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Image</th>
                        <th>Menu Name</th>
                        <th>Menu Title</th>
                        <th>Menu Link</th>
                        <th>Banner Tilte</th>
                        <th>Banner Description</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $sql = "SELECT * FROM add_menu_data";
                      $query = mysqli_query($link,$sql);
                      while($row=mysqli_fetch_assoc($query)){
                        $id = $row['id']; 
                        $menuname_fetch = $row['menuname']; 
                        $menutitle_fetch = $row['menutitle'];
                        $menulink_fetch = $row['menulink']; 
                        $bannerimage_fetch = $row['bannerimage']; 
                        $bannertitle_fetch = $row['bannertitle']; 
                        $bannerdescription_fetch = $row['bannerdescription'];

                        echo "<tr>
                        <td>$id</td>  
                        <td><img src='$bannerimage_fetch'width='100' height='60'></td>
                        <td>$menuname_fetch</td>
                        <td>$menutitle_fetch</td>
                        <td>$menulink_fetch</td>
                        <td>$bannertitle_fetch</td>
                        <td>$bannerdescription_fetch</td>
                        <td>
                        <img src='img/edit.png' width='30px' data-id='{$id}' class='getdataid' data-toggle='modal'style='cursor:pointer'>
                        <img src='img/delete.png' width='30px'class=' delete_data_id' data-id='{$id}' style='cursor:pointer'></td>
                        </tr>";
                      }

                      ?>

                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Id</th>
                        <th>Image</th>
                        <th>Menu Name</th>
                        <th>Menu Title</th>
                        <th>Menu Link</th>
                        <th>Banner Tilte</th>
                        <th>Banner Description</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>

        </div>


</div>
<!-- End of Page Wrapper -->

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add Menu</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label>Menu Name:</label>
                <input type="text" class="form-control" name="menu-Name" required="required">
              </div>
              <div class="form-group">

                <label>Menu Title</label>
                <input type="text" class="form-control" name="menu-Title" required="required">
              </div>
              <div class="form-group">

                <label>Menu Link</label>
                <input type="text" class="form-control" name="menu-Link" required="required">
              </div>
              <div class="form-group">

                <label>Banner Image</label>
                <input type="file" class="form-control" name="banner-Image" onchange="readURL(this);" required="required">
                <img class="blah1" />
              </div>
              

              <div class="form-group"> 

                <label>Banner Title</label>
                <input type="text" class="form-control" name="banner-Title" required="required">
              </div>
              <div class="form-group">

                <label>Banner Descriptoin</label>
                <input type="text" class="form-control" name="banner-Descriptoin" required="required">
              </div>

              <div class="modal-footer">
                <button type="submit" id="Add_data" name="Add_data" class="btn btn-default">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </form>
          </div>

        </div>

      </div>
    </div>
    <!-- End Modal -->

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
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>


  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

  <script type="text/javascript"> 

      $(document).ready(function() { 
        $('input[type="checkbox"]').click(function() { 
          var inputValue = $("this").attr("value"); 
          var targetBox = $("." + inputValue); 
          $("checkbox").not(targetBox).hide(); 

        }); 
      }); 


      function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
          x.className += "responsive";
        } else {
          x.className = "topnav";
        }
      }

      function readURL(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
            $('.blah1')
            .attr('src', e.target.result)
            .width(150)
            .height(100);
          };

          reader.readAsDataURL(input.files[0]);
        }
      }


        $('.getdataid').click(function(){
          var dataId = $(this).attr("data-id");

          $.ajax({
            method:"GET",
            url: "../lefpro/admin/select.php?dataid="+dataId,
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
            url: "../lefpro/admin/delete-data.php",
            data:{dataid:dataId},
            success:function(data){
              $('#delete_data').html(data);
              $('#delete_menu_modal').modal("show");

            }     
          });
        });

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
