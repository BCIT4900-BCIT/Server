<?php 
header('Content-Type:Application/json');
$servername = "localhost";
$username = "id5769772_group23";
$password = "group23password";
$dbname = "id5769772_app";

    //Creating a connection
    $con = mysqli_connect($servername, $username, $password, $dbname);
    
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();      
        $response['status'] = "fail";
        echo json_encode($array);
        mysqli_close($con);
        return;
    }
    $email = $_GET['email'];
  
    $sql = "SELECT * FROM tasks WHERE email = '$email'";
  
    $result = mysqli_query($con ,$sql);
    if($result == null)
    {
        return;
    }
    
    $response = array();
    $array = array();
    while ($row = mysqli_fetch_assoc($result)) 
    {
    	
    	$array[] = $row;
    	
    }
    $response['status'] = "pass";
    $response['data'] = $array;
	
    echo json_encode($response);
  
    mysqli_free_result($result);
    mysqli_close($con);
?>