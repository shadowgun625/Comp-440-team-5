<?php
session_start();
require_once "config.php";
$blogid = $_GET['id'];
$description=$sentiment=$cdate="";
$blogid_err = $description_err = $cdate_err = $user_err = "";
if(empty(trim($blogid))){
		$blogid_err="Error could not find blog id";
}
else{
	if(empty($blogid_err)){
		$sql = "SELECT subject, description, postuser,pdate FROM blogs WHERE blogid = ?";
		if($stmt = mysqli_prepare($link, $sql)){
		mysqli_stmt_bind_param($stmt, "s", $param_blogid);
		$param_blogid = $blogid;
			if(mysqli_stmt_execute($stmt)){
				mysqli_stmt_store_result($stmt);
					mysqli_stmt_bind_result($stmt, $subject,$description,$postuser,$pdate);
					mysqli_stmt_fetch($stmt);
					echo'<div style="text-align:left" class="wrapper">';
					echo"<h2>Blog poster: $postuser</h2>";
					echo"<h2>Subject: $subject</h2>";
					echo"<h2>Description</h2>";
					echo"<h2>$description</h2>";
					echo"<h2>posted: $pdate</h2>";
					echo"</div>";
			}
		}
	}
		mysqli_stmt_close($stmt);
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(empty(trim($_POST["description"]))){
		$description_err = "please enter your comment's description.";
	}
	else{
		$description = trim($_POST["description"]);
	}
	$sql = "SELECT * FROM comments WHERE cdate = DATE_FORMAT(CURDATE(), '%Y-%m-%d') AND author = ?";
	if($stmt = mysqli_prepare($link,$sql)){
		mysqli_stmt_bind_param($stmt, "s", $param_author);
		$param_author = $_SESSION["username"];
		if(mysqli_stmt_execute($stmt)){
			mysqli_stmt_store_result($stmt);
			if(mysqli_stmt_num_rows($stmt) > 2){
				$cdate_err = "You have reached the daily limit of 3 blogs per day";
			} 
		}
		else{
			echo "Oops! Something went wrong.Please try again later.";
		}
		mysqli_stmt_close($stmt);
	}
	$sql = "SELECT * FROM comments WHERE cdate = DATE_FORMAT(CURDATE(), '%Y-%m-%d') AND blogid = ? AND author = ?";
	if($stmt = mysqli_prepare($link,$sql)){
		mysqli_stmt_bind_param($stmt, "ss", $param_blogid, $param_author);
		$param_blogid = $blogid;
		$param_author = $_SESSION["username"];
		if(mysqli_stmt_execute($stmt)){
			mysqli_stmt_store_result($stmt);
			if(mysqli_stmt_num_rows($stmt) > 0){
				$cdate_err = "You can only post one comment per blog per day";
			} 
		}
		else{
			echo "Oops! Something went wrong.Please try again later.";
		}
		mysqli_stmt_close($stmt);
	}
	$sql = "SELECT postuser FROM blogs WHERE blogid = ?";
	if($stmt = mysqli_prepare($link,$sql)){
		mysqli_stmt_bind_param($stmt, "s", $param_blogid);
		$param_blogid = $blogid;
		if(mysqli_stmt_execute($stmt)){
			mysqli_stmt_store_result($stmt);
			mysqli_stmt_bind_result($stmt, $postuser);
			mysqli_stmt_fetch($stmt);
			if($postuser == $_SESSION["username"]){
				$user_err = "you cannot post on your own blog";
			}
		}
		else{
			echo "Oops! Something went wrong.Please try again later.";
		}
		mysqli_stmt_close($stmt);
	}
	else{
		echo "something went wrong";
	}
	$sentiment = trim($_POST["sentiment"]);
	if(empty($description_err) && empty($cdate_err) && empty($user_err)){
		$sql = "INSERT INTO comments (sentiment,description,cdate,blogid,author) VALUES (?,?,?,?,?)";
		if($stmt = mysqli_prepare($link, $sql)){
			mysqli_stmt_bind_param($stmt, "sssss", $param_sentiment, $param_description, $param_cdate, $param_blogid, $param_author);
			$param_sentiment = $sentiment;
			$param_description = $description;
			$param_cdate = date('Y-m-d');
			$param_blogid = $blogid;
			$param_author = $_SESSION["username"];
			if(mysqli_stmt_execute($stmt)){
				mysqli_stmt_close($stmt);
				//header("location: search.php");
			}
			else{
				echo "could not execute statment";
			}
		}
		else{
			echo" erro has occured in preparing statment";
		}
	}
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
        <h2>Leave a comment</h2>
		<div class="wrapper">
		<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">  
            <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                <label>comment</label>
                <textarea type="text" rows="10" maxlength="250" name="description" class="form-control" value="<?php echo $description; ?>"
				placeholder = "ex.Buttercream cakes are way better than those fondant coverd cakes"></textarea>
                <span class="help-block"><?php echo $description_err; ?></span>
            </div>
			<div class="form-group">
			<label>Sentiment</label>
			<select id="sentiment" name="sentiment">
				<option value="positive">Positive</option>
				<option value="negative">Negative</option>
			</select>
			</div>
			<div class="form-group">
			<input type="submit" class="btn btn-primary" value="Insert a comment" />
			<span class="help-block"><?php echo $cdate_err; ?></span>
			<span class="help-block"><?php echo $user_err; ?></span>
			<a href="search.php" class="btn btn-danger">cancel</a>
			</div>
        </form>
		</div>
    </div>
</body>
</html>