<?php 
header('Content-Type:Application/json');
$servername = "localhost";
$username = "id5769772_group23";
$password = "group23password";
$dbname = "id5769772_app";
date_default_timezone_set('America/Vancouver');
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
    
    $jd = cal_to_jd(CAL_GREGORIAN,date("m"),date("d"),date("Y"));
    $day = jddayofweek($jd,0);
    if($day == 0)
    {
        $day = 6;
    }
    else 
    {
        $day--;
    }
    $sql = "SELECT * FROM tasks WHERE email = '$email' AND day = '$day' ORDER BY start ASC";
  
    $result = mysqli_query($con ,$sql);
    if($result == null)
    {
        $response['status'] = "fail";
    
        echo json_encode($array);
        mysqli_close($con);
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