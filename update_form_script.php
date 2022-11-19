<?php

date_default_timezone_set('America/Phoenix');


require_once (dirname(_FILE_) . '/vendor/autoload.php');
use Monolog\Level1;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

//create a log channel
$log = new Logger('Lunaris_Admin');
$log->pushHandler(new StreamHandler(_DIR_ . '/LunarisTechAdmin.log', Logger::DEBUG));

require_once "db_connect.php";
    
// Define variables and initialize with empty values
$first_name = $last_name = $hire_date = $state = $phone = $position = $salary = "";
$first_name_err = $last_name_err = $hire_date_err = $state_err = $phone_err = $position_err = $salary_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"]) && !empty($_GET["id"])){
    // Validate name
    $input_first_name = trim($_GET["first_name"]);
    if(empty($input_first_name)){
        $first_name_err = "Please enter your first name.";
    } elseif(!filter_var($input_first_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $first_name_err = "Please enter a valid name.";
    } else{
        $first_name = $input_first_name;
    }
    
    // Validate last name
    $input_last_name = trim($_GET["last_name"]);
    if(empty($input_last_name)){
        $last_name_err = "Please enter an address.";
    } else{
        $last_name = $input_last_name;
    }
    
    // Validate hire date
    $input_hire_date = trim($_GET["hire_date"]);
    if(empty($input_hire_date)){
        $hire_date_err = "Please enter the hire date.";
    } else{
        $hire_date = $input_hire_date;
    }
    
    // Validate state
    $input_state = trim($_GET["state"]);
    if(empty($input_last_name)){
        $state_err = "Please enter the full state name.";
    } else{
        $state = $input_state;
    }
    
    // Validate phone
    $input_phone = trim($_GET["phone"]);
    if(empty($input_phone)){
        $phone_err = "Please enter the phone number i.e. ##########.";
    } else{
        $phone = $input_phone;
    }
    
    // Validate position
    $input_position = trim($_GET["position"]);
    if(empty($input_position)){
        $position_err = "Please enter the position.";
    } else{
        $position = $input_position;
    }
    
    // Validate salary
    $input_salary = trim($_GET["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";
    } elseif(!is_numeric($input_salary)){
        $salary_err = "Please enter a positive integer to.";
    } else{
        $salary = $input_salary;
    }
    
    // Check input errors before inserting in database
    if(empty($first_name_err) && empty($last_name_err) && empty($hire_date_err) && empty($state_err) && empty($phone_err) && empty($position_err) && empty($salary_err)){
        // Prepare an insert statement
        $sql = "UPDATE employees SET first_name= ?, last_name= ?, hire_date= ?, state= ?, phone= ?, position= ?, salary= ? WHERE employee_id = ?";
        if($stmt = $mysqli->prepare($sql)) {
            
            
            // Bind the parameters
            $stmt->bind_param("ssssssdi", $param_first_name, $param_last_name, $param_hire_date, $param_state, $param_phone, $param_position, $param_salary, $param_id);
            
            // Set parameters
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_hire_date = $hire_date;
            $param_state = $state;
            $param_phone = $phone;
            $param_position = $position;
            $param_salary = $salary;
            $param_id = trim($_GET["id"]);
            
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: index.php");
                $log->info('The selected employee data has been successfully updated.');
            } else{
                printf("Error: %s.\n", $stmt->error);
                echo "Oops! Something went wrong. Insert failed to the database.";
                $log->error('The selected employee data could not be updated.');
            }
            
            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $mysqli->close();
    
} else {
    echo "main post failed.";
}
?>
 