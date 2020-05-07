<?php
// Include config file

if(isset($_POST["id"]))  
 {  
      $output = '';  
      require_once "config.php";  
      $query = "SELECT * FROM employees WHERE id = '".$_POST["id"]."'";  
      $result = mysqli_query($mysqli, $query);  
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= '  
                <tr>  
                     <td width="30%"><label>Name</label></td>  
                     <td width="70%">'.$row["name"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Address</label></td>  
                     <td width="70%">'.$row["address"].'</td>  
                </tr>   
                <tr>  
                     <td width="30%"><label>Salary</label></td>  
                     <td width="70%">'.$row["salary"].' Year</td>  
                </tr>  
                ';  
      }  
      $output .= "</table></div>";  
      echo $output;  
 }  
?>