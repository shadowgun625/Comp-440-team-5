<?php
// Initialize the session
session_start();
require_once "config.php";

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
        <h1>All users who never had negative comments</h1>
		<div class="wrapper">
		<?php
		$sql ="SELECT DISTINCT postuser FROM blogs INNER JOIN comments ON blogs.blogid = comments.blogid AND comments.sentiment NOT IN ('negative') ";
		if($stmt = mysqli_prepare($link, $sql)){
			if(mysqli_stmt_execute($stmt)){
				mysqli_stmt_store_result($stmt);
				mysqli_stmt_bind_result($stmt, $postuser);
				while(mysqli_stmt_fetch($stmt)){
					$sql2 = "SELECT * From comments INNER JOIN blogs ON blogs.blogid = comments.blogid AND comments.sentiment = 'negative' AND blogs.postuser = ?  ";
					if($stmt2 = mysqli_prepare($link, $sql2)){
						mysqli_stmt_bind_param($stmt2, "s", $param_postuser);
						$param_postuser = $postuser;
						if(mysqli_stmt_execute($stmt2)){
							mysqli_stmt_store_result($stmt2);
							if(mysqli_stmt_num_rows($stmt2)<1){
								echo '<div class="wrapper">';
								echo "<h3>User: $postuser</h3>";
								echo "</div>";
							}
						}
						else{
							echo "could not execure second statment";
						}
					}
					else{
						echo "could not prepare second statment";
					}
					mysqli_stmt_close($stmt2);
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
		?>
		</div>
		<div>
		<a href="welcome.php" class="btn btn-danger">cancel</a>
		</div>
	</div>
</body>
</head>
</html>