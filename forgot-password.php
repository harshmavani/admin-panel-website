<?php

include "config.php";

$email = $div = $new_password = $confirm_password = "";
$email_err = $new_password_err = $confirm_password_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){

  if (empty(trim($_POST["email"]))) {
    $email_err = "<p class='alert alert-danger pt-1 pb-1'>"."Please enter your email."."</p>";
  }else{
    $email = trim($_POST["email"]);
  }

  if (empty($email_err)) {
    $sql= "SELECT id, email FROM admin_data WHERE email = ?";
    if($stmt = mysqli_prepare($link, $sql)){
      mysqli_stmt_bind_param($stmt, "s", $param_email);
      $param_email = $email;
      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
         mysqli_stmt_bind_result($stmt, $id, $email);

         $div = 
         '<div class="form-group">
         <input type="password" class="form-control form-control-user" id="new_password" name="new_password" placeholder="Enter new password">
         </div>
         <div class="form-group">
         <input type="password" class="form-control form-control-user" id="confirm_password" name="confirm_password" placeholder="Enter confirm password">
         </div>
         ';

         if (empty($_POST["new_password"])) {
          $new_password_err = "<p class='alert alert-danger pt-1 pb-1'>"."Please enter your new password"."</p>";
        }elseif(strlen($_POST["new_password"]) < 9){
          $new_password_err = "<p class='alert alert-danger pt-1 pb-1'>"."Password must have atleast 9 characters."."</p>";
        }else{
         $new_password = $_POST["new_password"];
       }

       if (empty($_POST["confirm_password"])) {
        $confirm_password_err = "<p class='alert alert-danger pt-1 pb-1'>"."Please enter your confirm password"."</p>";
      }else{
        $confirm_password = $_POST["confirm_password"];

        if (empty($new_password_err) && ($new_password != $confirm_password)) {
          $confirm_password_err = "<p class='alert alert-danger pt-1 pb-1'>"."Password did not match"."</p>";
        }
      }

      if(empty($new_password_err) && empty($confirm_password_err)){
        $sql = "UPDATE admin_data SET password = ? WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
          mysqli_stmt_bind_param($stmt, "ss", $param_password, $param_email);

          $param_password = $new_password;
          $param_email = $email;

          if(mysqli_stmt_execute($stmt)){
            header("location: login.php");
            exit();
          } else{
            echo "Oops! Something went wrong. Please try again later.";
          } 
          mysqli_stmt_close($stmt);
        }
      }


    } else{
      $email_err ="<p class='alert alert-danger pt-1 pb-1'>"."No account found with that email."."</p>";
    }
  }else{
    echo "Oops! Something went wrong. Please try again later.";
  }
  mysqli_stmt_close($stmt);

}
}
mysqli_close($link);

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

  <title>admin</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">


        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                    <hr>
                  </div>
                  <form class="user" method="POST">
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address..."  value="<?php echo $email; ?>">
                    </div>
                    <?php echo $div ; ?>
                    <div class="form-group">
                      <?php echo "$email_err $new_password_err $confirm_password_err"; ?>
                    </div>
                    <div class="form-group">
                     <input type="submit" class="btn btn-block btn-primary" value="forgot password">
                   </div>               
                 </form>
                 <hr>
                 <div class="text-center">
                  <a class="small" href="register.php">Create an Account!</a>
                </div>
               <div class="text-center">
                  <a class="small" href="login.php">Already have an account? Login!</a>
                </div>
              </div>

        </div>
      </div>


  </div>

</div>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

</body>

</html>
