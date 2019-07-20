<?php
include('session.php');
include('databaseConnection.php');
$ID=$_GET['delUser'];
$query="DELETE FROM `user_accounts_info` Where ID=$ID";
mysqli_query($con,$query);
header('location:configUser.php');
?>