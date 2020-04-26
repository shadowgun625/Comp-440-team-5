<?php
// Initialize the session
session_start();

// Include config file
require_once "config.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
} 
 // Define variables and initialize with empty values
$description = $tag = $subject = "";
$description_err = $tag_err = $subject_err = "";
$date = date('d-m-y h:i:s');

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($description_err) && empty($tag_err) && empty($subject_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO blogs (description, pdate, postuser, subject) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){    
            // Attempt to execute the prepared statement
			mysqli_stmt_bind_param($stmt, "ssss", $param_description, $param_pdate, $param_postuser, $param_subject);
			$param_description = $description;
			$param_pdate = $pdate;
			$param_postuser = $postuser;
			$param_subject = $subject;
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: welcome.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1><b><?php echo htmlspecialchars($_SESSION["username"]); ?></b> Please Insert Blog</h1>
    </div>
	<div class="wrapper">
		<p>Please fill this form for you blog to be subitted<p>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<div class="form-group <?php echo (!empty($subject_err)) ? 'has-error' : ''; ?>">
                <label>Subject</label>
                <input type="text" name="subject" class="form-control" value="<?php echo $subject; ?>">
                <span class="help-block"><?php echo $subject_err; ?></span>
            </div>    
			<div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                <label>Description</label>
                <input type="text" name="description" class="form-control" value="<?php echo $description; ?>">
                <span class="help-block"><?php echo $description_err; ?></span>
            </div>    
			<div class="form-group <?php echo (!empty($tag_err)) ? 'has-error' : ''; ?>">
                <label>Tags</label>
                <input type="text" name="Tag" class="form-control" value="<?php echo $tag; ?>">
                <span class="help-block"><?php echo $tag_err; ?></span>
            </div>  
	<p>
        <a href="Welcome.php" class="btn btn-danger">submit</a>
    </p>
	<p>
        <a href="Welcome.php" class="btn btn-danger">cancel</a>
    </p>
</body>
</html>