<?php
// Initialize the session
session_start();
require_once "config.php";
$last_pair = "";

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
        <h1>Pair of users who gave each other only positive comments</h1>
		<div class="wrapper">
		<?php
		$sql ="SELECT username FROM users ";
		if($stmt = mysqli_prepare($link, $sql)){
			if(mysqli_stmt_execute($stmt)){
				mysqli_stmt_store_result($stmt);
				mysqli_stmt_bind_result($stmt, $username);
				while(mysqli_stmt_fetch($stmt)){
					if($last_pair != $username){
						$sql2 = "SELECT DISTINCT author FROM `comments` INNER JOIN blogs ON blogs.blogid = comments.blogid AND comments.sentiment = 'positive' AND blogs.postuser = ? ";
						if($stmt2 = mysqli_prepare($link, $sql2)){
							mysqli_stmt_bind_param($stmt2, "s", $param_postuser);
							$param_postuser = $username;
							if(mysqli_stmt_execute($stmt2)){
								mysqli_stmt_store_result($stmt2);
								mysqli_stmt_bind_result($stmt2, $author);
								while(mysqli_stmt_fetch($stmt2)){
									$sql3 = "SELECT * FROM `comments` INNER JOIN blogs ON blogs.blogid = comments.blogid AND author = ? AND comments.sentiment = 'negative' AND blogs.postuser = ? ";
									if($stmt3 = mysqli_prepare($link, $sql3)){
										mysqli_stmt_bind_param($stmt3, "ss", $param_author, $param_postuser);
										$param_author = $author;
										if(mysqli_stmt_execute($stmt3)){
											mysqli_stmt_store_result($stmt3);
											if(mysqli_stmt_num_rows($stmt3)<1){
												$sql4="SELECT * FROM `comments` INNER JOIN blogs ON blogs.blogid = comments.blogid AND author = ? AND comments.sentiment = 'negative' AND blogs.postuser = ? ";
												if($stmt4 = mysqli_prepare($link, $sql4)){
													mysqli_stmt_bind_param($stmt4 , "ss", $param_author2, $param_postuser2);
													$param_postuser2 = $author;
													$param_author2 = $username;
													if(mysqli_stmt_execute($stmt4)){
														mysqli_stmt_store_result($stmt4);
														if(mysqli_stmt_num_rowS($stmt4)<1){
															echo '<div class-"wrapper">';
															echo "<h3> Pair($username, $author) </h3";
															echo '</div>';
															$last_pair = $author;
														}
													}
													else{
														echo "could not execute statment four";
													}
													mysqli_stmt_close($stmt4);
												}
												else{
													echo "could not prepare statment four";
												}
											}
										}
										else{
											echo "could not execute thrid statment";
										}
										mysqli_stmt_close($stmt3);
									}
									else{
										echo "could not prepare third statment";
									}
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