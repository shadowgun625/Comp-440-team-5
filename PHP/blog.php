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
$description = $tag = $subject = $pdate = $tagarray[]=$count = "";
$description_err = $tag_err = $subject_err = $pdate_err = "";

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
$sql = "SELECT * FROM blogs WHERE pdate >= DATE_FORMAT(CURDATE(), '%Y-%m-%d') AND postuser = ?";
if($stmt = mysqli_prepare($link,$sql)){
	mysqli_stmt_bind_param($stmt, "s", $param_postuser);
	$param_postuser = $_SESSION["username"];
	if(mysqli_stmt_execute($stmt)){
		mysqli_stmt_store_result($stmt);
		if(mysqli_stmt_num_rows($stmt) > 1){
			$pdate_err = "You have reached the daily limit of 2 blogs per day";
		} else{
			$pdate = date('Y-m-d');
		}
	}else{
		echo "Oops! Something went wrong.Please try again later.";
	}
	mysqli_stmt_close($stmt);
}
$pdate = date('Y-m-d');
if(empty($subject_err) && empty($description_err)&& empty($pdate_err)){
	$sql = "INSERT INTO blogs (subject, description, postuser, pdate) VALUES (?, ?, ?, ?)";
	if($stmt = mysqli_prepare($link, $sql)){
		mysqli_stmt_bind_param($stmt, "ssss", $param_subject, $param_description, $param_postuser, $param_pdate);
		$param_subject = $subject;
		$param_description = $description;
		$param_postuser = $_SESSION["username"];
		$param_pdate = date('Y-m-d');
		if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
               mysqli_stmt_close($stmt);
			   if(empty($tag_err)){
				   $tagarray = explode(",",$tag);
				   $tagcount = count($tagarray);
				   for ($count = 0 ; $count < $tagcount; ++$count){
					if(!empty($tagarray[$count])){
					$sql = "INSERT INTO blogstags (blogid, tag) VALUES (LAST_INSERT_ID(), ?)";
					if($stmt = mysqli_prepare($link, $sql)){
					   mysqli_stmt_bind_param($stmt, "s",$param_tag);
					   $param_tag = $tagarray[$count];
					   if(mysqli_stmt_execute($stmt)){
						   mysqli_stmt_close($stmt);
					   } else{
						   echo "Something went wrong. Please try again later.";
					   }
					
				   }
					}
				  }
				  header("location: login.php");
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 15px sans-serif; text-align: center;}
		.wrapper{ width: 500px; margin: auto;}
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
                <input type="text" name="subject" class="form-control" maxlength="50" value="<?php echo $subject; ?>"
				placeholder = "ex.Buttercream cake">
                <span class="help-block"><?php echo $subject_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                <label>Description</label>
                <textarea type="text" rows="10" maxlength="250" name="description" class="form-control" value="<?php echo $description; ?>"
				placeholder = "ex.Buttercream cakes are way better than those fondant coverd cakes"></textarea>
                <span class="help-block"><?php echo $description_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($tag_err)) ? 'has-error' : ''; ?>">
                <label>Tags</label>
                <input type="text" name="tag" class="form-control" maxlength="20" value="<?php echo $tag; ?>" 
				placeholder = "ex.cake,delicous,hungry or tasty">
                <span class="help-block"><?php echo $tag_err; ?></span>
			<div class="form-group">
			<input type="submit" class="btn btn-primary" value="Insert a Blog" />
			<input type="reset" class="btn btn-default"  value="Reset">
			<a href="welcome.php" class="btn btn-danger">cancel</a>
			</div>
			<span class="help-block"><?php echo $pdate_err; ?></span>
        </form>
</div>

        
        
    </div>
</body>
</html>