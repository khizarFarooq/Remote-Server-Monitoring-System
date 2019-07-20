<?php

include('session.php');
// Create connection
include('databaseConnection.php');
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} 
$action=$_POST['action'];
$hostIp=$_POST['hostIp'];
$hostLocation=$_POST['hostLocation'];
$serverName=$_POST['serverName'];
$serverPort=$_POST['serverPort'];
$webUrl=$_POST['webUrl'];
$pingService="no";
$portService="no";
$httpsService="no";
$pauseOrStart=$_POST['pauseOrStart'];
$normalMinutes=$_POST['normalMinutes'];
$problemMinutes=$_POST['problemMinutes'];
$recheckTime=$_POST['recheckTime'];
if(isset($_POST['pingService']) && 
   $_POST['pingService'] == 'yes') 
{
    $pingService=$_POST['pingService'];
}
if(isset($_POST['portService']) && 
   $_POST['portService'] == 'yes') 
{
    $portService=$_POST['portService'];
}
if(isset($_POST['httpsService']) && 
   $_POST['httpsService'] == 'yes') 
{
    $httpsService=$_POST['httpsService'];
}
$webServerRegQuery="insert into web_server_info VALUES (DEFAULT,INET_ATON('$hostIp'),'$hostLocation','$serverName','$serverPort','$webUrl','$pingService','$portService','$httpsService','$pauseOrStart','$normalMinutes','$problemMinutes','$recheckTime')";
if ($con->query($webServerRegQuery) === TRUE ) {
     $serverId = mysqli_insert_id($con);
    $pingServiceTable=$serverId . "_webServer_Ping_Service";
$portServiceTable=$serverId . "_webServer_Port_Service";
$httpsRequestServiceTable=$serverId . "_webServer_https_Request_Service";
$make_Ping_Service_Table_Query="CREATE TABLE  $pingServiceTable(
id INT(11) UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
reply_From VARCHAR(255),
ttl  VARCHAR(255),
rtt_Min  VARCHAR(255),
rtt_Max  VARCHAR(255) ,
rtt_Ave  VARCHAR(255)   ,
error  VARCHAR(255) ,
sent  VARCHAR(255)  NOT NULL,
received  VARCHAR(255)  NOT NULL,
lost  VARCHAR(255)  NOT NULL,
status  VARCHAR(255)    NOT NULL,
time_Stamp VARCHAR(255) NOT NULL
)";
$make_Port_Service_Table_Query="CREATE TABLE  $portServiceTable(
id INT(11) AUTO_INCREMENT PRIMARY KEY,
status VARCHAR(255) NOT NULL,
time_Stamp VARCHAR(255) NOT NULL
)";
$make_httpsRequest_Service_Table_Query="CREATE TABLE  $httpsRequestServiceTable(
id INT(11) AUTO_INCREMENT PRIMARY KEY,
responseCode VARCHAR(255),
status VARCHAR(255),
time_Stamp VARCHAR(255) NOT NULL
)";
	mysqli_query($con,$make_Ping_Service_Table_Query);
mysqli_query($con,$make_Port_Service_Table_Query);
mysqli_query($con,$make_httpsRequest_Service_Table_Query);
// Get cURL resource

$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://localhost:8000/'.$action.'/'.$serverId.'/'.$hostIp.'/'.$serverPort.'/'.$webUrl.'/'.$pingService.'/'.$portService.'/'.$httpsService.'/'.$pauseOrStart.'/'.$normalMinutes.'/'.$problemMinutes.'/'.$recheckTime,
    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
]);
// Send the request & save response to $resp

$resp = curl_exec($curl);
echo($resp);
// Close request to clear up some resources
curl_close($curl);
    echo "<script type=\"text/javascript\">window.alert('Your web server has been successfully added.');
window.location.href = 'add_New_Server.php';</script>";
exit;

} else {
    echo "Error: " . $webServerRegQuery . "<br>" . $con->error;
}
$con->close();
?>