<?php
include('session.php');
include('databaseConnection.php');
$email=$_POST['email'];
$password=$_POST['password'];
$query=" SELECT * from user_accounts_info where Email= '$email' && Password = '$password' ";
$result = mysqli_query($con,$query);
$row = mysqli_fetch_array($result);
if($row['Email'] == $email && $row['Password'] == $password)
{
	$_SESSION['userName']=$row['Name'];
	$_SESSION['webServerAccess']=$row['webServer_Access'];
	$_SESSION['proxyServerAccess']=$row['proxyServer_Access'];
	$_SESSION['dnsAccess']=$row['dnsServer_Access'];
	$_SESSION['authorizationLevel']=$row['Authorization_level'];
	header("location:index.php");   
}
else
{
	header("location:login.php");
}
?>