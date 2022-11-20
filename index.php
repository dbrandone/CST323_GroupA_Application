<?php
date_default_timezone_set('America/Phoenix');


require_once (dirname(_FILE_) . '/vendor/autoload.php');
use Monolog\Level1;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

//create a log channel
$log = new Logger('Lunaris_Admin');
$log->pushHandler(new StreamHandler(_DIR_ . '/CST323GroupAEmployeeApplication.log', Logger::DEBUG));


if($_SESSION["loggedin"] != true){
    $log->error('user was not logged in, rerout to login.php Auto login redirect');
    header("location: login.php");
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>

<a href="logout.php">Logout</a>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Employees Details</h2>
                        <a href="create_employee.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Employee</a>
                    </div>
                    <?php
                    //Error Reporting
                    ini_set('display_errors', '1');
                    ini_set('display_startup_errors', '1');
                    error_reporting(E_ALL);
                    
                    // Include config file
                    require_once "db_connect.php";
                    
                    // Attempt select query execution
                    
                    $sql = "SELECT * FROM employees";
                    if($result = $mysqli->query($sql)) {
                       
                    if (mysqli_num_rows($result) > 0) {
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>First Name</th>";
                                        echo "<th>Last Name</th>";
                                        echo "<th>Hire Date</th>";
                                        echo "<th>State</th>";
                                        echo "<th>Phone</th>";
                                        echo "<th>Position</th>";
                                        echo "<th>Salary</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                
                                while($row = $result->fetch_array()) {
                                    echo "<tr>";
                                        echo "<td>" . $row['employee_id'] . "</td>";
                                        echo "<td>" . $row['first_name'] . "</td>";
                                        echo "<td>" . $row['last_name'] . "</td>";
                                        echo "<td>" . $row['hire_date'] . "</td>";
                                        echo "<td>" . $row['state'] . "</td>";
                                        echo "<td>" . $row['phone'] . "</td>";
                                        echo "<td>" . $row['position'] . "</td>";
                                        echo "<td>" . $row['salary'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="read_employee.php?id='. $row['employee_id'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update_employee.php?id=' . $row['employee_id'] . '&fn=' . $row['first_name'] . '&ln=' . $row['last_name'] . '&hd=' . $row['hire_date'] . '&st=' . $row['state'] . '&pn=' . $row['phone'] . '&ps=' . $row['position'] . '&sa=' . $row['salary'].'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete_employee.php?id='. $row['employee_id'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            $result->free();
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    }else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    // Close connection
                    $mysqli->close();
                   
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
