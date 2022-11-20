<?php

date_default_timezone_set('America/Phoenix');


require_once (dirname(_FILE_) . '/vendor/autoload.php');
use Monolog\Level1;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

//create a log channel
$log = new Logger('Lunaris_Admin');
$log->pushHandler(new StreamHandler(_DIR_ . '/CST323GroupAEmployeeApplication.log', Logger::DEBUG));


if (! $_SESSION["loggedin"]) {
    echo "Only logged in users may access this page. Click <a href='login.php'here</a> to login<br>";
    $log->info('user session has been verified.');
    exit;
}

// Process delete operation after confirmation
if(isset($_GET["id"]) && !empty($_GET["id"])){
    // Include config file
    require_once "db_connect.php";
   
     // Prepare a delete statement
    $sql = "DELETE FROM employees WHERE employee_id = ?";
    
    if($stmt = $mysqli->prepare($sql)){  
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_employee_id);
        
        // Set parameters
        $param_employee_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Records deleted successfully. Redirect to landing page
           header("location: index.php");
            printf("Error: %s.\n" , $param_employee_id);
            $log->info('the selected employee has been removed from the database.');
            exit();
        } else{
            printf("Error: %s.\n", $stmt->error);
            echo "Oops! Something went wrong. Please try again later.";
            $log->error('the selected employee could not be removed from the database.');
        } 
 
    
    // Close statement
    $stmt->close();
    }
    // Close connection
    $mysqli->close(); 
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        printf("Error: %s.\n" , $_GET["id"]);
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    } 
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Delete Record</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="employee_id" value="<?php echo trim($_GET["employee_id"]); ?>"/>
                            <p>Are you sure you want to delete this employee record?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="index.php" class="btn btn-secondary ml-2">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
