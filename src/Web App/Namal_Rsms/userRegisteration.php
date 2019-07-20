<?php
include('session.php');
// Create connection
include('databaseConnection.php');
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
$name=$_POST['name'];
$password=$_POST['password'];
$email=$_POST['email'];
$contactNo=$_POST['contactNo'];
$authorizationLevel=$_POST['authorizationLevel'];
$webServerAccess="no";
$proxyServerAccess="no";
$dnsServerAccess="no";
if($authorizationLevel=='admin'){
	$webServerAccess="yes";
    $proxyServerAccess="yes";
    $dnsServerAccess="yes";
}
if(isset($_POST['webServerAccess']) && 
   $_POST['webServerAccess'] == 'yes') 
{
    $webServerAccess=$_POST['webServerAccess'];
}
if(isset($_POST['proxyServerAccess']) && 
   $_POST['proxyServerAccess'] == 'yes') 
{
    $proxyServerAccess=$_POST['proxyServerAccess'];
}
if(isset($_POST['dnsServerAccess']) && 
   $_POST['dnsServerAccess'] == 'yes') 
{
    $dnsServerAccess=$_POST['dnsServerAccess'];
}
$query=" select * from user_accounts_info where Email= '$email' OR Contact_no='$contactNo'";
$result = mysqli_query($con,$query);
$row = mysqli_num_rows($result);
if($row==1)
{
  $error = "Email Address or Contact No is already taken.\\nTry again.";
  echo "<script type=\"text/javascript\">window.alert('$error');
window.location.href = 'addNewUser.php';</script>";
exit;
}
else
{
  $path='img/userProfile.png';
	$userRegQuery="insert into user_accounts_info VALUES (DEFAULT,'$name','$password','$email','$contactNo','$authorizationLevel','$webServerAccess','$proxyServerAccess','$dnsServerAccess','')";
	mysqli_query($con,$userRegQuery);
	 echo "<script type=\"text/javascript\">window.alert('User has been created successfully.');
window.location.href = 'index.php';</script>";
exit;
	//header("location:index.php");
}
?>