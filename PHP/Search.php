<?php
 // Initialize the session
session_start();
$tag= $tagarray[]=$count="";
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$tag = trim($_POST["tag"]);
	echo $tag;
	$tagarray = explode(",",$tag);
	$tagcount = count($tagarray);
	for ($count = 0 ; $count < $tagcount; ++$count){
		if(!empty($tagarray[$count])){
		echo "<br>";
		echo $tagarray[$count];
		}
	}
	//$taglist = implode(",",$tag);
	//echo $taglist;
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
		<div class="form-group">
                <label>Tag</label>
                <input type="text" name="tag" class="form-control" value="<?php echo $tag; ?>">
            </div>
			<div class="form-group">
			<input type="submit" class="btn btn-primary" value="Insert a Blog" />
			</div>
		</form>
	</div>
    </div>
</body>
</html>