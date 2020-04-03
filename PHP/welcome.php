
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

if(isset($_POST['button1'])){
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'assign3');
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($link->connect_error) {
        die("Connection failed: " . $link->connect_error);
    }
    ChromePhp::log('Intializing Database');

$sql="DROP TABLE IF EXISTS `teaches`;";
$sql.="DROP TABLE IF EXISTS `takes`;";
$sql.="DROP TABLE IF EXISTS `advisor`;";
$sql.="DROP TABLE IF EXISTS `student`;";
$sql.="DROP TABLE IF EXISTS `section`;";
$sql.="DROP TABLE IF EXISTS `prereq`;";
$sql.="DROP TABLE IF EXISTS `instructor`;";
$sql.="DROP TABLE IF EXISTS `course`;";
$sql.="DROP TABLE IF EXISTS `time_slot`;";
$sql.="DROP TABLE IF EXISTS `department`;";
$sql.="DROP TABLE IF EXISTS `classroom`;";

if(mysqli_multi_query($link,$sql)){
    ChromePhp::log('all tables dropped');
}else{
    echo(mysqli_error($link));
}
$link->close();
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


$sql = "CREATE TABLE `classroom` (
    `building` varchar(15) NOT NULL,
    `room_number` varchar(7) NOT NULL,
    `capacity` decimal(4,0) DEFAULT NULL,
    PRIMARY KEY (`building`,`room_number`));";

if(mysqli_query($link,$sql)){
    ChromePhp::log('classroom created successfully');
}else{
    echo(mysqli_error($link));
}

$sql = "CREATE TABLE `department` (
    `dept_name` varchar(20) NOT NULL,
    `building` varchar(15) DEFAULT NULL,
    `budget` decimal(12,2) DEFAULT NULL,
    PRIMARY KEY (`dept_name`),
    CONSTRAINT `department_chk_1` CHECK ((`budget` > 0)))";

if(mysqli_query($link,$sql)){
    ChromePhp::log('department created successfully');
}else{
    echo(mysqli_error($link));
}

$sql = "CREATE TABLE `time_slot` (
    `time_slot_id` varchar(4) NOT NULL,
    `day` varchar(1) NOT NULL,
    `start_hr` decimal(2,0) NOT NULL,
    `start_min` decimal(2,0) NOT NULL,
    `end_hr` decimal(2,0) DEFAULT NULL,
    `end_min` decimal(2,0) DEFAULT NULL,
    PRIMARY KEY (`time_slot_id`,`day`,`start_hr`,`start_min`),
    CONSTRAINT `time_slot_chk_1` CHECK (((`start_hr` >= 0) and (`start_hr` < 24))),
    CONSTRAINT `time_slot_chk_2` CHECK (((`start_min` >= 0) and (`start_min` < 60))),
    CONSTRAINT `time_slot_chk_3` CHECK (((`end_hr` >= 0) and (`end_hr` < 24))),
    CONSTRAINT `time_slot_chk_4` CHECK (((`end_min` >= 0) and (`end_min` < 60))));";
if(mysqli_query($link,$sql)){
    ChromePhp::log('time_slot created successfully');
}else{
    echo(mysqli_error($link));
}


$sql = "CREATE TABLE `course` (
`course_id` varchar(8) NOT NULL,
`title` varchar(50) DEFAULT NULL,
`dept_name` varchar(20) DEFAULT NULL,
`credits` decimal(2,0) DEFAULT NULL,
PRIMARY KEY (`course_id`),
KEY `dept_name` (`dept_name`),
CONSTRAINT `course_ibfk_1` FOREIGN KEY (`dept_name`) REFERENCES `department` (`dept_name`) ON DELETE SET NULL,
CONSTRAINT `course_chk_1` CHECK ((`credits` > 0)));";
if(mysqli_query($link,$sql)){
    ChromePhp::log('course created successfully');
}else{
    echo(mysqli_error($link));
}

$sql = "CREATE TABLE `instructor` (
  `ID` varchar(5) NOT NULL,
  `name` varchar(20) NOT NULL,
  `dept_name` varchar(20) DEFAULT NULL,
  `salary` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `dept_name` (`dept_name`),
  CONSTRAINT `instructor_ibfk_1` FOREIGN KEY (`dept_name`) REFERENCES `department` (`dept_name`) ON DELETE SET NULL,
  CONSTRAINT `instructor_chk_1` CHECK ((`salary` > 29000)));";
if(mysqli_query($link,$sql)){
    ChromePhp::log('instructor created successfully');
}else{
    echo(mysqli_error($link));
}

$sql = "CREATE TABLE `prereq` (
  `course_id` varchar(8) NOT NULL,
  `prereq_id` varchar(8) NOT NULL,
  PRIMARY KEY (`course_id`,`prereq_id`),
  KEY `prereq_id` (`prereq_id`),
  CONSTRAINT `prereq_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE,
  CONSTRAINT `prereq_ibfk_2` FOREIGN KEY (`prereq_id`) REFERENCES `course` (`course_id`));";
if(mysqli_query($link,$sql)){
    ChromePhp::log('prereq created successfully');
}else{
    echo(mysqli_error($link));
}

$sql = "CREATE TABLE `section` (
  `course_id` varchar(8) NOT NULL,
  `sec_id` varchar(8) NOT NULL,
  `semester` varchar(6) NOT NULL,
  `year` decimal(4,0) NOT NULL,
  `building` varchar(15) DEFAULT NULL,
  `room_number` varchar(7) DEFAULT NULL,
  `time_slot_id` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`course_id`,`sec_id`,`semester`,`year`),
  KEY `building` (`building`,`room_number`),
  CONSTRAINT `section_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE,
  CONSTRAINT `section_ibfk_2` FOREIGN KEY (`building`, `room_number`) REFERENCES `classroom` (`building`, `room_number`) ON DELETE SET NULL,
  CONSTRAINT `section_chk_1` CHECK ((`semester` in (_utf8mb4'Fall',_utf8mb4'Winter',_utf8mb4'Spring',_utf8mb4'Summer'))),
  CONSTRAINT `section_chk_2` CHECK (((`year` > 1701) and (`year` < 2100))));";
if(mysqli_query($link,$sql)){
    ChromePhp::log('section created successfully');
}else{
    echo(mysqli_error($link));
}


$sql = "CREATE TABLE `student` (
  `ID` varchar(5) NOT NULL,
  `name` varchar(20) NOT NULL,
  `dept_name` varchar(20) DEFAULT NULL,
  `tot_cred` decimal(3,0) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `dept_name` (`dept_name`),
  CONSTRAINT `student_ibfk_1` FOREIGN KEY (`dept_name`) REFERENCES `department` (`dept_name`) ON DELETE SET NULL,
  CONSTRAINT `student_chk_1` CHECK ((`tot_cred` >= 0)));";
if(mysqli_query($link,$sql)){
    ChromePhp::log('student created successfully');
}else{
    echo(mysqli_error($link));
}

$sql = "CREATE TABLE `advisor` (
    `s_ID` varchar(5) NOT NULL,
    `i_ID` varchar(5) DEFAULT NULL,
    PRIMARY KEY (`s_ID`),
    KEY `i_ID` (`i_ID`),
    CONSTRAINT `advisor_ibfk_1` FOREIGN KEY (`i_ID`) REFERENCES `instructor` (`ID`) ON DELETE SET NULL,
    CONSTRAINT `advisor_ibfk_2` FOREIGN KEY (`s_ID`) REFERENCES `student` (`ID`) ON DELETE CASCADE);";
    if(mysqli_query($link,$sql)){
        ChromePhp::log('advisor created successfully');
    }else{
        echo(mysqli_error($link));
    }

$sql = "CREATE TABLE `takes` (
  `ID` varchar(5) NOT NULL,
  `course_id` varchar(8) NOT NULL,
  `sec_id` varchar(8) NOT NULL,
  `semester` varchar(6) NOT NULL,
  `year` decimal(4,0) NOT NULL,
  `grade` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`ID`,`course_id`,`sec_id`,`semester`,`year`),
  KEY `course_id` (`course_id`,`sec_id`,`semester`,`year`),
  CONSTRAINT `takes_ibfk_1` FOREIGN KEY (`course_id`, `sec_id`, `semester`, `year`) REFERENCES `section` (`course_id`, `sec_id`, `semester`, `year`) ON DELETE CASCADE,
  CONSTRAINT `takes_ibfk_2` FOREIGN KEY (`ID`) REFERENCES `student` (`ID`) ON DELETE CASCADE);";
if(mysqli_query($link,$sql)){
    ChromePhp::log('takes created successfully');
}else{
    echo(mysqli_error($link));
}

$sql = "CREATE TABLE `teaches` (
  `ID` varchar(5) NOT NULL,
  `course_id` varchar(8) NOT NULL,
  `sec_id` varchar(8) NOT NULL,
  `semester` varchar(6) NOT NULL,
  `year` decimal(4,0) NOT NULL,
  PRIMARY KEY (`ID`,`course_id`,`sec_id`,`semester`,`year`),
  KEY `course_id` (`course_id`,`sec_id`,`semester`,`year`),
  CONSTRAINT `teaches_ibfk_1` FOREIGN KEY (`course_id`, `sec_id`, `semester`, `year`) REFERENCES `section` (`course_id`, `sec_id`, `semester`, `year`) ON DELETE CASCADE,
  CONSTRAINT `teaches_ibfk_2` FOREIGN KEY (`ID`) REFERENCES `instructor` (`ID`) ON DELETE CASCADE);";
if(mysqli_query($link,$sql)){
    ChromePhp::log('teaches created successfully');
}else{
    echo(mysqli_error($link));
}

$sql = "INSERT INTO `student` VALUES 
('john', 'pass1234'),
('john', 'pass1234'),
('john', 'pass1234'),
('john', 'pass1234'),
('john', 'pass1234'),
('john', 'pass1234'),
('john', 'pass1234'),
('john', 'pass1234'),
('john', 'pass1234'),
('john', 'pass1234');";
if(mysqli_query($link,$sql)){
    ChromePhp::log('Inserted 10 students successfully');
}else{
    echo(mysqli_error($link));
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
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
        <h1>
        <form name="form" method="post">
        <input type="submit" name="button1" value="Intialize Database!" />
        </h1>
    </div>
    <p>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
</body>
</html>