<?php
 // Initialize the session
session_start();
require_once "config.php";
$search=$not_found=$blogpage="";
$search_err="";
$_SESSION['id']="";
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<div class="form-group <?php echo (!empty($search_err)) ? 'has-error' : ''; ?>">
                <input type="text" name="search" class="form-control" placeholder="please type in a tag" value="<?php echo $search; ?>">
				<span class="help-block"><?php echo $search_err; ?></span>
				<span class="help-block"><?php echo $not_found; ?></span>
            </div>
			<div class="form-group">
			<input type="submit" class="btn btn-primary" value="Search Tag" />
			</div>
		</form>
	</div>
	<?php
	if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(empty(trim($_POST["search"]))){
		$search_err="Please enter a tag";
	}
	else{
		$search = trim($_POST["search"]);
	}
	if(empty($search_err)){
		$sql = "SELECT blogid FROM blogstags WHERE tag = ?";
		if($stmt = mysqli_prepare($link, $sql)){
		mysqli_stmt_bind_param($stmt, "s", $param_search);
		$param_search = $search;
			if(mysqli_stmt_execute($stmt)){
				mysqli_stmt_store_result($stmt);
				if(mysqli_stmt_num_rows($stmt) < 1){
					$not_found = "tag $search not found";
				}
				else{
					mysqli_stmt_bind_result($stmt, $blogid);
					while (mysqli_stmt_fetch($stmt)) {
						$sql2 = "SELECT subject, description, postuser,pdate FROM blogs WHERE blogid = ?";
						if($secondstmt = mysqli_prepare($link,$sql2)){
							mysqli_stmt_bind_param($secondstmt,"s", $param_blogid);
							$param_blogid = $blogid;
								if(mysqli_stmt_execute($secondstmt)){
									mysqli_stmt_store_result($secondstmt);
									mysqli_stmt_bind_result($secondstmt, $subject,$description,$postuser,$pdate);
									while(mysqli_stmt_fetch($secondstmt)){
										echo"
										<form align = 'left'>
											<dl>
											<dt>Poster</dt>
											<dd>$postuser</dd>
											<dt>Subject</dt>
											<dd>$subject</dd>
											<dt>Tag</dt>
											<dd>$search</dd>
											<dt>Description</dt>
											<dd>$description</dd>
											<dt>posted</dt>
											<dd>$pdate</dd>
											</dl>
											<input type='submit' class='btn btn-primary' value='details'>
											</form>";
											
									}
								}
							mysqli_stmt_close($secondstmt);
						}
						else{
							printf("Error message: %s\n", mysqli_error($link));
						}
						
						
					}
				}
			}
			else{
				echo "stament failed";
			}
		mysqli_stmt_close($stmt);
		}
	}
}
	?>
    </div>
</body>
</html>