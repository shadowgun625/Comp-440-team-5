<?php
// Initialize the session
session_start();
require_once "config.php";
$user = "";
$user_err="";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<?php
$sql = "SELECT blogid FROM blogs WHERE postuser = 'john'";

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
        <h1>All the blogs with only positive comments</h1>
		<div class="wrapper">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($user_err)) ? 'has-error' : ''; ?>">
                <label>User</label>
                <input type="text" name="user" class="form-control" maxlength="20" value="<?php echo $user; ?>">
                <span class="help-block"><?php echo $user_err; ?></span>
            </div>    
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="submit">
            </div>
        </form>
  <?php
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(empty(trim($_POST["user"]))){
			$user_err = "Please enter username.";
		} 
		else{
			$user = trim($_POST["user"]);
		}
	if(empty($user_err)){
		echo '<div class="wrapper">';
		echo "<h2> $user postivie blogs are: </h2>";
		$sql = "SELECT blogid, subject FROM blogs WHERE postuser = ?";
		if($stmt = mysqli_prepare($link, $sql)){
			mysqli_stmt_bind_param($stmt, "s", $param_postuser);
			$param_postuser = $user;
			if(mysqli_stmt_execute($stmt)){
				mysqli_stmt_store_result($stmt);
				mysqli_stmt_bind_result($stmt, $blogid, $subject);
				while(mysqli_stmt_fetch($stmt)){
					$sql2 = "SELECT * FROM comments WHERE blogid= ? AND sentiment = 'negative' ";
					if($stmt2 = mysqli_prepare($link, $sql2)){
						mysqli_stmt_bind_param($stmt2, "s", $param_blogid);
						$param_blogid = $blogid;
						if(mysqli_stmt_execute($stmt2)){
							mysqli_stmt_store_result($stmt2);
							if(mysqli_stmt_num_rows($stmt2)<1){
								echo '<div class="wrapper">';
								echo "<h3>BlogID: $blogid</h3>";
								echo "<h3>Subject: $subject</h3>";
								echo '</div>';
							}
							
						}
						else{
							echo "could not execute second statment";
						}
						mysqli_stmt_close($stmt2);
					}
					else{
						echo "could not prepare second statment ";
					}
				}
			}
			
			else{
				echo "could not execute statment";
			}
		mysqli_stmt_close($stmt);
		}
		else{
			echo "could not prepare statment";
		}
		echo '</div>';
	}
}
	

	?>
       
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<a href="welcome.php" class="btn btn-danger">Go Back</a>
			</div>
			
        </form>
</div>