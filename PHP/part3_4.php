<?php
// Initialize the session
session_start();
require_once "config.php";
$maxcount = "";

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
		$sql ="SELECT postuser, COUNT(*) AS `count1` FROM blogs GROUP BY blogs.postuser, blogs.pdate HAVING (blogs.pdate = '2020-02-10') ORDER BY count1 DESC ";
		if($stmt = mysqli_prepare($link, $sql)){
			if(mysqli_stmt_execute($stmt)){
				mysqli_stmt_store_result($stmt);
				mysqli_stmt_bind_result($stmt, $postuser , $count);
				while(mysqli_stmt_fetch($stmt)){
					if($maxcount <= $count){
						$maxcount = $count;
						echo '<div class="wrapper">';
						echo "<h3> User: $postuser </h3>";
						echo '</div>';
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
		?>
		</div>
		<div>
		<a href="welcome.php" class="btn btn-danger">cancel</a>
		</div>
	</div>
</body>
</head>
</html>