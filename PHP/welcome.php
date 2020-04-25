<?php
// Initialize the session
session_start();
include 'ChromePhp.php';
ChromePhp::log('Welcome Page granted');
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

if(isset($_POST['insert_a_blog'])){
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'assign3');
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($link->connect_error) {
        die("Connection failed: " . $link->connect_error);
    }




$link->close();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }.wrapper{ width: 350px; padding: 20px; }
    </style>

</head>
<body>


    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
  <div class="wrapper">
        <label>Fill in the fielsds to insert a new blog.</label>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Subject</label>
                <input type="text" name="subject" class="form-control" >  
            </div>    
            <div class="form-group ">
                <label>Description</label>
                <input type="text" name="description" class="form-control" >
                
            </div>
            <div class="form-group">
                <label>Tag</label>
                <input type="text" name="tag" class="form-control" >   
            </div>

            <input type="submit" name="insert_a_blog" class="btn btn-primary" value="Insert a Blog" />
        </form>
</div>

        
        
    </div>
    <p>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
</body>
</html>
