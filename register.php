<?php
// Include config file
require_once "db_connect.php";
 
// Define variables and initialize with empty values
$first_name = $last_name = $user_name = $email = $phone = $password = $confirm_password = "";
$first_name_err = $last_name_err = $user_name_err = $email_err = $phone_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Validate first name
    $input_first_name = trim($_POST["first_name"]);
    if(empty($input_first_name)){
        $first_name_err = "Please enter your first name.";
    } elseif(!filter_var($input_first_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $first_name_err = "Please enter a valid name.";
    } else{
        $first_name = $input_first_name;
    }
    
    // Validate last name
    $input_last_name = trim($_POST["last_name"]);
    if(empty($input_last_name)){
        $last_name_err = "Please enter an address.";
    } else{
        $last_name = $input_last_name;
    }
 
    // Validate username
    if(empty(trim($_POST["user_name"]))){
        $user_name_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["user_name"]))){
        $user_name_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT admin_id FROM admin WHERE user_name = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_user_name);
            
            // Set parameters
            $param_user_name = trim($_POST["user_name"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $user_name_err = "This username is already taken.";
                } else{
                    $user_name = trim($_POST["user_name"]);
                }
            } else{
                echo "Oops! Something went wrong. Select query failed.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter an email.";
    } else{
        $email = $input_email;
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Validate phone
    $input_phone = trim($_POST["phone"]);
    if(empty($input_phone)){
        $phone_err = "Please enter the phone number i.e. ##########.";
    } else{
        $phone = $input_phone;
    }
    
    // Check input errors before inserting in database
    if(empty($first_name_err) && empty($last_name_err) && empty($user_name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($phone_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO admin (first_name, last_name, user_name, email, password, phone) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssss", $param_first_name, $param_last_name, $param_user_name, $param_email, $param_password, $param_phone);
            
            // Set parameters
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_user_name = $user_name;
            $param_email = $email;
            $param_password = $password;
            $param_phone = $phone;
            
            // Attempt to execute the prepared statement
            #$stmt->execute();
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                printf("Error: %s.\n", $stmt->error);
                echo "Oops! Something went wrong. Insert failed to the database.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $mysqli->close();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>">
                <span class="invalid-feedback"><?php echo $first_name_err; ?></span>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>">
                <span class="invalid-feedback"><?php echo $last_name_err; ?></span>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="user_name" class="form-control <?php echo (!empty($user_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $user_name; ?>">
                <span class="invalid-feedback"><?php echo $user_name_err; ?></span>
            </div> 
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>   
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone; ?>">
                <span class="invalid-feedback"><?php echo $phone_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>