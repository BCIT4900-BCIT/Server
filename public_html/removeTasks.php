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
        die("cannot connect to db");
        mysqli_close($con);
        return;
    }
    $email = $_GET['email'];
    $groupid = $_GET['groupid'];
    $taskName = $_GET['taskName'];
    $start = $_GET['start'];
    $end = $_GET['end'];
    $day = $_GET['day'];
  
    $sql = "DELETE FROM tasks WHERE email ='$email' AND groupid = '$groupid' AND description = '$taskName' AND start = '$start' AND end  = '$end' AND day = '$day'";
  
    $result = mysqli_query($con ,$sql);
    if($result == null)
    {
        return;
    }
    if(mysqli_affected_rows($con)>0)
    {
        $response['status']  = "pass";
    }
    else
    {
        $response['status'] = "pass";
    }
    echo json_encode($response);
  
    mysqli_close($con);
?>