<?php
// Initialize the session
session_start();
 
// Name of the file
$filename = 'project.sql';
// MySQL host
$mysql_host = 'localhost';
// MySQL username
$mysql_username = 'root';
// MySQL password
$mysql_password = '';
// Database name
$mysql_database = 'project';

// Connect to MySQL server
$link = mysqli_connect($mysql_host,$mysql_username,$mysql_password,$mysql_database);

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$sql = "SELECT DISTINCT blogid FROM comments WHERE blogid NOT IN (SELECT blogid FROM comments WHERE sentiment = 'negative') ";

//Group By blogid HAVING SUM(comment.sentiment = 'negative') = 0 ;
if($stmt = $link -> prepare ($sql)){
    $stmt -> execute();
    $stmt -> bind_result($blogid);
    while($stmt -> fetch())
    {
        echo "<br>" ;
        printf("Blog ID: %s\n", $blogid);
    }
   
}
$sql ="SELECT username FROM users WHERE username NOT IN (SELECT postuser FROM blogs)";
/*
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
    while($row = $result->fetch_assoc()){
        echo "Blog ID" .$row['blogid']. "<br>";
    }
}
*/
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
        <h1>All the users with anly positive comments</h1>
  <div class="wrapper">
       
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<a href="welcome.php" class="btn btn-danger">Go Back</a>
			</div>
			
        </form>
</div>