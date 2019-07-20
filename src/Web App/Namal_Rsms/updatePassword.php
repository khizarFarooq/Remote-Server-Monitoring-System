<?php
 session_start();
include('databaseConnection.php');
$verificationEmail=$_SESSION['verificationEmail'];
$verificationCode=$_POST['verificationCode'];
$newPassword=$_POST['newPassword'];
$reNewPassword=$_POST['reNewPassword'];
if(($verificationCode==$_SESSION['verificationCode'])&&($newPassword==$reNewPassword)){
	$query="UPDATE user_accounts_info SET Password='$newPassword' WHERE Email='$verificationEmail'";
	if ($con->query($query) === TRUE) {
	    header("location:login.php");
	}
	else {
    echo "Error updating record: " . $con->error;
}
}
if($verificationCode!=$_SESSION['verificationCode']){
	 echo "<script type=\"text/javascript\">window.alert('Verification code is not matched.');
	 window.location.href = 'takeNewPassword.php';</script>";
}
if($newPassword!=$reNewPassword){
	 echo "<script type=\"text/javascript\">window.alert('New Password and Confirm Password is not matched.');
	 window.location.href = 'takeNewPassword.php';</script>";
}
?>