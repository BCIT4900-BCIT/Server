<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "app";

	//Creating a connection
	$con = mysqli_connect($servername, $username, $password, $dbname);
  
    if (mysqli_connect_errno())
    {
       echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
  $email = $_GET['email'];
  
  $sql = "SELECT * FROM tasks WHERE email = $email";
  
  $result = mysqli_query($con ,$sql);
  
	while ($row = mysqli_fetch_assoc($result)) 
  {
		
		$array[] = $row;
		
	}
  header('Content-Type:Application/json');
  echo json_encode($array);
  
  mysqli_free_result($result);
  mysqli_close($con);
 ?>