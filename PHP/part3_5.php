<?php
// Initialize the session
session_start();
require_once "config.php";
$user1 = $user2 = "";
$user1_err = $user2_err = "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center;}
		.wrapper{ width: 350px; margin: auto; }
    </style>
</head>
<body>
	<div class="wrapper">
        <h1>The people these two users follow</h1>
		<div class="wrapper">
		<?php
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			if(empty(trim($_POST["user1"]))){
				$user1_err = "Please enter user1.";
			} 
			else{
				$user1 = trim($_POST["user1"]);
			}
			if(empty(trim($_POST["user2"]))){
				$user2_err = "Please enter user2.";
			} 
			else{
				$user2 = trim($_POST["user2"]);
			}
			if(empty($user1_err) && empty($user2_err)){
				$sql ="SELECT DISTINCT username FROM follows,users WHERE username IN (SELECT username FROM follows,users WHERE (users.username=follows.leader AND follows.follower = ?)) AND (users.username=follows.leader AND follows.follower = ?) ";
				if($stmt = mysqli_prepare($link, $sql)){
					mysqli_stmt_bind_param($stmt , "ss", $param_follwer, $param_follwer2);
					$param_follwer = $user1;
					$param_follwer2 = $user2;
					if(mysqli_stmt_execute($stmt)){
						mysqli_stmt_store_result($stmt);
						mysqli_stmt_bind_result($stmt, $leader);
						while(mysqli_stmt_fetch($stmt)){
								echo '<div class="wrapper">';
								echo "<h3>leader: $leader</h3>";
								echo "</div>";
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
			}
		}
		?>
		</div>
		<div class="wrapper">
        <p>Please select two users.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($user1_err)) ? 'has-error' : ''; ?>">
                <label>User1</label>
                <input type="text" name="user1" class="form-control" maxlength="20" value="<?php echo $user1; ?>">
                <span class="help-block"><?php echo $user1_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($user2_err)) ? 'has-error' : ''; ?>">
                <label>User2</label>
                <input type="text" name="user2" class="form-control" maxlength="20" value="<?php echo $user2; ?>">
                <span class="help-block"><?php echo $user2_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="submit">
            </div>
        </form>
		</div>    
		<div>
		<a href="welcome.php" class="btn btn-danger">cancel</a>
		</div>
	</div>
</body>
</head>
</html>