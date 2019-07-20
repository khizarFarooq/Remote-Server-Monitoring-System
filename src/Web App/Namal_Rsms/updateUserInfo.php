<?php
include('session.php');
// Create connection
include('databaseConnection.php');
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} 
$ID=$_POST['userId'];
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
$query="UPDATE user_accounts_info SET Name= '$name', Password='$password', Email='$email', Contact_no='$contactNo', Authorization_level='$authorizationLevel',webServer_Access='$webServerAccess',proxyServer_Access='$proxyServerAccess',dnsServer_Access='$dnsServerAccess' WHERE ID='$ID'";
if ($con->query($query) === TRUE) {
     echo "<script type=\"text/javascript\">window.alert('User record updated successfully.');
window.location.href = 'configUser.php';</script>";
exit;
} else {
    echo "Error updating record: " . $con->error;
}
$con->close();
?>