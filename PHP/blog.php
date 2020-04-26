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

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
if(empty(trim($_POST["subject"]))){
	$subject_err = "please enter a subject.";
} else{
	$subject = trim($_POST["subject"]);
}
if(empty(trim($_POST["description"]))){
	$description_err = "please enter a description.";
} else{
	$description = trim($_POST["description"]);
}
if(empty(trim($_POST["tag"]))){
	$tag_err = "please enter a tag.";
} else{
	$tag = trim($_POST["tag"]);
}
if(empty($subject_err) && empty($description_err)){
	$sql = "INSERT INTO blogs (subject, description, postuser, pdate) VALUES (?, ?, ?, ?)";
	if($stmt = mysqli_prepare($link, $sql)){
		mysqli_stmt_bind_param($stmt, "ssss", $param_subject, $param_description, $param_postuser, $param_pdate);
		$param_subject = $subject;
		$param_description = $description;
		$param_postuser = $_SESSION["username"];
		$param_pdate = date('d-m-y');
		if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
               mysqli_stmt_close($stmt);
			   if(empty($tag_err)){
				   $sql = "INSERT INTO blogstags (blogid, tag) VALUES (LAST_INSERT_ID(), ?)";
				   if($stmt = mysqli_prepare($link, $sql)){
					   mysqli_stmt_bind_param($stmt, "s",$param_tag);
					   $param_tag = $tag;
					   if(mysqli_stmt_execute($stmt)){
						   header("location: login.php");
						   mysqli_stmt_close($stmt);
					   } else{
						   echo "Something went wrong. Please try again later.";
					   }
				   }
			   }
        } else{
			echo "Something went wrong. Please try again later.";
			 mysqli_stmt_close($stmt);
        }
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center;}
		.wrapper{ width: 350px; padding: 20px; }
    </style>

</head>
<body>


    <div class="wrapper">
        <h1>Blog post</h1>
  <div class="wrapper">
        <label>Fill in the fields to insert a new blog.</label>
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
                <label>Tag</label>
                <input type="text" name="tag" class="form-control" value="<?php echo $tag; ?>">
                <span class="help-block"><?php echo $tag_err; ?></span>
            </div>
			<div class="form-group">
            <input type="submit" class="btn btn-primary" value="Insert a Blog" />
			<input type="reset" class="btn btn-default"  value="Reset">
			</div>
			<a href="welcome.php" class="btn btn-danger">cancel</a>
        </form>
</div>

        
        
    </div>
</body>
</html>