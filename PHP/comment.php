<?php
 // Initialize the session
session_start();
$tag= $tagarray[]=$count="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
}
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
        <h1>Search</h1>
  <div class="wrapper">
        <label>Please type in a tag</label>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<div class="form-group">
                <input type="text" name="comment" class="form-control" value="<?php echo $comment; ?>">
            </div>
			<div class="form-group">
			<input type="submit" class="btn btn-primary" value="Insert a comment" />
			</div>
		</form>
	</div>
    </div>
</body>
</html>