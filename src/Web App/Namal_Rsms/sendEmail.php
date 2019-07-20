<?php
 session_start();
 include('databaseConnection.php');
 $to =$_POST['emailAddress'];
$query=" SELECT * from user_accounts_info where Email= '$to'";
$result =$con->query($query);
if($result->num_rows > 0)
{
$message = rand(999, 99999);
$_SESSION['verificationEmail']=$to;
$_SESSION['verificationCode']=$message;
$subject = "Namal Rsms Verification Code is Here !";
$headers = "From: khizardogar6@gmail.com";
if(mail($to,$subject,$message,$headers)){
	header("location:takeNewPassword.php");
}	
else 
	echo "Email sending failed";
 }
else 
	echo "<script type=\"text/javascript\">window.alert('Your given email address is not exist.');
window.location.href = 'login.php';</script>";
 $con->close();
?>