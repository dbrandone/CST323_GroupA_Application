<?php
session_start();

if (! $_SESSION['loggedin']) {
    echo "Only logged in users may access this page. Click <a href='login.php'here</a> to login<br>";
    exit;
}

// Include config file
require_once "db_connect.php";


// Define variables and initialize with empty values
$id = $_GET['id'];
$first_name = $_GET['fn'];
$last_name = $_GET['ln'];
$hire_date = $_GET['hd'];
$state = $_GET['st'];
$phone = $_GET['pn'];
$position = $_GET['ps'];
$salary = $_GET['sa'];


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please fill this form and submit to update employee record in the database.</p>
                    <form action='update_form_script.php' method="GET">
                        <div class="form-group">
                            
                            <input type="hidden" name="id" class="form-control" value="<?php echo $id; ?>"/>
                        </div>
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>">
                            <span class="invalid-feedback"><?php echo $first_name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <textarea name="last_name" class="form-control <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?>"><?php echo $last_name; ?></textarea>
                            <span class="invalid-feedback"><?php echo $last_name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Hire Date</label>
                            <input type="text" name="hire_date" class="form-control <?php echo (!empty($hire_date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $hire_date; ?>">
                            <span class="invalid-feedback"><?php echo $hire_date_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" name="state" class="form-control <?php echo (!empty($state_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $state; ?>">
                            <span class="invalid-feedback"><?php echo $state_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone; ?>">
                            <span class="invalid-feedback"><?php echo $phone_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Position</label>
                            <input type="text" name="position" class="form-control <?php echo (!empty($position_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $position; ?>">
                            <span class="invalid-feedback"><?php echo $position_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $salary_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>


