<?php 
$servername = "localhost";
$username = "id5769772_group23";
$password = "group23password";
$dbname = "id5769772_app";

//Creating a connection
$con = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_errno())
{
   die("database failed");
   return;
}

$email    = $_GET['email'];
$password = $_GET['password'];

$sql = "SELECT groupid FROM users WHERE email = '$email' AND password = '$password'";
$result = mysqli_query($con ,$sql);

if($result == null)
{
    return;
}

$row = mysqli_fetch_assoc($result);
$groupid = $row['groupid'];
 
$response = array();
//status and role (if groupid is null then role is parent if not child) 
if(mysqli_num_rows($result) == 0) // when either email or password is not matching
{
    $response['status'] = "FAIL";
}
elseif ($groupid != null) // role: child when there is a groupid found
{
    $response['status'] = "PASS";
    $response['role'] = "CHILD";
    
} 
elseif($groupid == null) // role: parent when there is no groupid found
{
    $response['status'] = "PASS";
    $response['role'] = "PARENT";
} 

echo json_encode($response);

mysqli_free_result($result);
mysqli_close($con);
?>