<?php

require_once "create.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Employees Details</h2>
                        <button class="btn btn-success pull-right"  data-toggle="modal" data-target="#exampleModal">Add New Employee</button>
                    </div>
                    
                    <?php
                    // Include config file
                    require_once "config.php";

                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM employees";
                    if($result = $mysqli->query($sql)){
                        if($result->num_rows > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Address</th>";
                                        echo "<th>Salary</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch_array()){
                                    $view = '<button onclick="GetUserDetails('.$row['id'].')" class = "btn btn-success"><i class="fa fa-eye"></i></button>';
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['address'] . "</td>";
                                        echo "<td>" . $row['salary'] . "</td>";
                                        echo "<td>";
                                            // echo "<a href='create.php' class='btn btn-success pull-right'>". $row['id'] ."</a>";
                                            echo $view;
                                            // echo "<a href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            // echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            $result->free();
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
                    }
                    
                    // Close connection
                    $mysqli->close();
                    ?>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="wrapper">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <div class="page-header">
                                                <h2>Create Record</h2>
                                            </div>
                                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                                <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                                                    <label>Name</label>
                                                    <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                                                    <span class="help-block"><?php echo $name_err;?></span>
                                                </div>
                                                <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                                                    <label>Address</label>
                                                    <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                                                    <span class="help-block"><?php echo $address_err;?></span>
                                                </div>
                                                <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                                                    <label>Salary</label>
                                                    <input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
                                                    <span class="help-block"><?php echo $salary_err;?></span>
                                                </div>
                                                <input type="submit" class="btn btn-primary" value="Submit">
                                                <a href="" class="btn btn-default">Cancel</a><hr>
                                            </form>
                                        </div>
                                    </div>        
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>
    <!-- update modal -->
	
    <div class="modal" id="update_user_modal">
  <div class="modal-dialog">
    <div class="modal-content">

    <div class="modal-header">  
                     <h4 class="modal-title">Employee Details</h4> 
                     <button type="button" class="close" data-dismiss="modal">&times;</button>   
                </div>  
                <div class="modal-body" id="employee_detail">  
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>   
      </div>

    </div>
  </div>
</div>
    <script type="text/javascript"> 
        //get data from user 
            function GetUserDetails(id){
                $.ajax({  
                    url:"select.php",  
                    method:"post",  
                    data:{id:id},  
                    success:function(data){ 
                        $('#employee_detail').html(data);
                        $('#update_user_modal').modal("show"); 
                        
                    }  
                });
            }
            
    </script>
</body>
</html>