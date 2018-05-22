<?php 
$servername = "localhost";
$username = "id5769772_group23";
$password = "group23password";
$dbname = "id5769772_app";

	//Creating a connection
	$con = mysqli_connect($servername, $username, $password, $dbname);
  
    if (mysqli_connect_errno())
    {
       echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
  $email = $_GET['email'];
  
  $sql = "SELECT max(updated_at) FROM users WHERE groupid = '$email'";
  $response = array();
  $result = mysqli_query($con ,$sql);
  if($result == null)
  {
      $response['status'] = "fail";
      echo json_encode($response);
  }
  
    $row = mysqli_fetch_assoc($result);
    $response['status'] = "pass";
    $response['timestamp'] = $row['max(updated_at)'];
    
  header('Content-Type:Application/json');
  echo json_encode($response);
  
  mysqli_free_result($result);
  mysqli_close($con);
 ?>