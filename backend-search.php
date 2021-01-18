<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "admin_panel");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
if(isset($_REQUEST["term"])){
    // Prepare a select statement
    $sql = "SELECT * FROM affiliate_data_table WHERE ProductName LIKE ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        
        // Set parameters
        $param_term = $_REQUEST["term"] . '%';
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                echo "<div style='font-weight: 600;margin-top: 20px;text-align: center;inline-size: -webkit-fill-available;'>Search result :</div>";

                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                        $show_product = "SELECT * FROM affiliate_data_table WHERE ProductName = '".$row['ProductName']."'";
                        $query = mysqli_query($link, $show_product);
$row=mysqli_fetch_assoc($query);
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
            } else{
                echo "<p style='font-weight: 600;margin-top: 20px;'>No matches found</p>";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
}
 
// close connection
mysqli_close($link);
?>