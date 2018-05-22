<?php 
$servername = "localhost";
$username = "id5769772_group23";
$password = "group23password";
$dbname = "id5769772_app";


header('Content-Type:Application/json');
	//Creating a connection
$con = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_errno())
{
   die("error connecting");
}

$email       = $_GET['email'];
$groupid     = $_GET['groupid'];
$description = $_GET['taskName'];
$start       = $_GET['start'];
$end         = $_GET['end'];

$day = $_GET['day'];

$alarm = $_GET['alarm'];


$sql = "insert into tasks(email, groupid, description, start, end, day, alarm) values
('$email', '$groupid', '$description', '$start', '$end', '$day', '$alarm')";

$result = mysqli_query($con ,$sql);

if(!$result) 
{
  return;
} 

$response['status'] = "pass";

echo json_encode($response);
mysqli_close($con);
 ?>