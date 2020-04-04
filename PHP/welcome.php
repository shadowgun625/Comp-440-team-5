
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

$sql = "INSERT INTO `classroom` VALUES 
('JD', '1234', 2),
('JD', '1235', 2),
('JD', '1236', 2),
('JD', '1237', 2),
('JD', '1238', 2),
('JD', '1239', 2),
('JD', '1241', 2),
('JD', '1242', 2),
('JD', '1243', 2),
('JD', '1244', 2);";
if ($link->query($sql) === TRUE) {
    echo "New record in clasroom created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $link->error;
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

$sql = "INSERT INTO `department` VALUES 
('Computer Science', 'JD', 278000),
('Economics', 'BB', 40000),
('Mathematics', 'LO',70000),
('Kinesiology', 'RE', 25000),
('History', 'SC', 276000),
('Anthropology', 'MS', 256000),
('Nursing', 'JD', 278000),
('Music', 'CS', 25600),
('Biology', 'CR', 45000),
('Manegment', 'JR', 455000);";
if ($link->query($sql) === TRUE) {
    echo "New record in departament created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $link->error;
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

$sql = "INSERT INTO `time_slot` VALUES 
('1231', 'M', 9, 30, 10, 45),
('1232', 'M', 11, 0, 12, 15),
('1233', 'M', 1, 30, 2, 45),
('1234', 'M', 3, 0, 4, 15),
('1235', 'M', 9, 30, 10, 45),
('1236', 'M', 9, 30, 10, 45),
('1237', 'M', 4, 30, 5, 45),
('1238', 'M', 11, 0, 12, 15),
('1239', 'M', 9, 30, 10, 45),
('1230', 'M', 9, 30, 10, 45);";
if ($link->query($sql) === TRUE) {
    echo "New record in time_slot created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $link->error;
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

$sql = "INSERT INTO `course` VALUES 
('1231', 'Course1', 'Computer Science', 3),
('1234', 'Course1', 'Computer Science', 3),
('1235', 'Course1', 'Computer Science', 3),
('1236', 'Course1', 'Computer Science', 4),
('1237', 'Course1', 'Computer Science', 3),
('1238', 'Course1', 'Computer Science', 3),
('1239', 'Course1', 'Computer Science', 3),
('1230', 'Course1', 'Computer Science', 4),
('1232', 'Course1', 'Computer Science', 3),
('1233', 'Course1', 'Computer Science', 3);";

if ($link->query($sql) === TRUE) {
    echo "New record in course created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $link->error;
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

$sql = "INSERT INTO `instructor` VALUES 
('1231', 'Anna', 'Computer Science', 30000),
('1234', 'Mike', 'Computer Science', 30000),
('1235', 'Mike', 'Computer Science', 345000),
('1236', 'Mike', 'Computer Science', 435000),
('1237', 'Mike', 'Computer Science', 30000),
('1238', 'Mike', 'Computer Science', 300000),
('1239', 'Mike', 'Computer Science', 312000),
('1230', 'Mike', 'Computer Science', 40000),
('1232', 'Mike', 'Computer Science', 30000),
('1233', 'Anna', 'Computer Science', 30000);";

if ($link->query($sql) === TRUE) {
    echo "New record in instructor created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $link->error;
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

$sql = "INSERT INTO `prereq` VALUES 
('1231', '1231'),
('1234', '1232'),
('1235', '1233'),
('1236', '1234'),
('1237', '1235'),
('1238', '1236'),
('1239', '1237'),
('1230', '1238'),
('1232', '1239'),
('1233', '1230');";

if ($link->query($sql) === TRUE) {
    echo "New record in prereq created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $link->error;
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

$sql = "INSERT INTO `section` VALUES 
('1230', '5670', 'Fall' , '2020' , 'JD', '1234', '1231'),
('1231', '5671', 'Fall' , '2020' , 'JD', '1235', '1231'),
('1232', '5672', 'Fall' , '2020' , 'JD', '1236', '1231'),
('1233', '5673', 'Fall' , '2020' , 'JD', '1237', '1231'),
('1234', '5674', 'Fall' , '2020' , 'JD', '1238', '1231'),
('1235', '5675', 'Fall' , '2020' , 'JD', '1239', '1231'),
('1236', '5676', 'Fall' , '2020' , 'JD', '1241', '1231'),
('1237', '5677', 'Fall' , '2020' , 'JD', '1242', '1231'),
('1238', '5678', 'Fall' , '2020' , 'JD', '1243', '1231'),
('1239', '5679', 'Fall' , '2020' , 'JD', '1244', '1231');";

if ($link->query($sql) === TRUE) {
    echo "New record in section created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $link->error;
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

$sql = "INSERT INTO `student` VALUES 
('1231', 'Anna', 'Computer Science', 12),
('1234', 'Mike', 'Economics', 3),
('1235', 'Mike', 'Anthropology', 3),
('1236', 'Mike', 'Biology', 4),
('1237', 'Mike', 'Nursing', 3),
('1238', 'Mike', 'Manegment', 3),
('1239', 'Mike', 'Computer Science', 3),
('1230', 'Mike', 'Music', 4),
('1232', 'Mike', 'History', 3),
('1233', 'Anna', 'History', 3);";

if ($link->query($sql) === TRUE) {
    echo "New record in student created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $link->error;
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

$sql = "INSERT INTO `advisor` VALUES 
('1231', '1231'),
('1234', '1231'),
('1235', '1231'),
('1236', '1231'),
('1237', '1231'),
('1238', '1231'),
('1239', '1231'),
('1230', '1231'),
('1232', '1231'),
('1233', '1231');";

if ($link->query($sql) === TRUE) {
    echo "New record in advisor created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $link->error;
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

$sql = "INSERT INTO `takes` VALUES 
('1230', '1230', '5670', 'Fall' , '2020' , 'A'),
('1231', '1231', '5671', 'Fall' , '2020' , 'A'),
('1232', '1232', '5672', 'Fall' , '2020' , 'A'),
('1233', '1233', '5673', 'Fall' , '2020' , 'A'),
('1234', '1234', '5674', 'Fall' , '2020' , 'A'),
('1235', '1235', '5675', 'Fall' , '2020' , 'A'),
('1236', '1236', '5676', 'Fall' , '2020' , 'A'),
('1237', '1237', '5677', 'Fall' , '2020' , 'A'),
('1238', '1238', '5678', 'Fall' , '2020' , 'A'),
('1239', '1239', '5679', 'Fall' , '2020' , 'A');";

if ($link->query($sql) === TRUE) {
    echo "New record in takes created successfully";
} else {
    echo "takes";
    echo "Error: " . $sql . "<br>" . $link->error;
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

$sql = "INSERT INTO `teaches` VALUES 
('1230', '1230', '5670', 'Fall' , '2020'),
('1231', '1231', '5671', 'Fall' , '2020'),
('1232', '1232', '5672', 'Fall' , '2020'),
('1233', '1233', '5673', 'Fall' , '2020'),
('1234', '1234', '5674', 'Fall' , '2020'),
('1235', '1235', '5675', 'Fall' , '2020'),
('1236', '1236', '5676', 'Fall' , '2020'),
('1237', '1237', '5677', 'Fall' , '2020'),
('1238', '1238', '5678', 'Fall' , '2020'),
('1239', '1239', '5679', 'Fall' , '2020');";

if ($link->query($sql) === TRUE) {
    echo "New record in teaches created successfully";
} else {
    echo "teaches";
    echo "Error: " . $sql . "<br>" . $link->error;
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
        <input type="submit" name="button1" class="btn btn-primary" value="Intialize Database!" />
        </h1>
    </div>
    <p>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
</body>
</html>