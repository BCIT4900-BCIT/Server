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
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$groupId = $_GET['groupId'];

$sql = "SELECT * FROM users WHERE groupId = '$groupId'";


$result = mysqli_query($con ,$sql);

$array = array();
while ($row = mysqli_fetch_assoc($result)) 
{
  
  $array[] = $row;
  
}

$response["status"] = "pass";
$response['data'] = $array;
echo json_encode($response);


mysqli_free_result($result);
mysqli_close($con);
 ?>