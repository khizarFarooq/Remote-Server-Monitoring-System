<?php
include('session.php');
// Create connection
include('databaseConnection.php');
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
$action="updateDns"; 
$ID=$_POST['serverId'];
$hostIp=$_POST['hostIp'];
$hostLocation=$_POST['hostLocation'];
$serverName=$_POST['serverName'];
$serverPort=$_POST['serverPort'];
$fqdn=$_POST['fqdn'];
$pingService="no";
$portService="no";
$dnsResolution="no";
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
if(isset($_POST['dnsResolution']) && 
   $_POST['dnsResolution'] == 'yes') 
{
    $dnsResolution=$_POST['dnsResolution'];
}
$query = "UPDATE dns_info SET Host_ip=INET_ATON('$hostIp'),Host_location='$hostLocation',Server_name='$serverName',Server_port='$serverPort',FQDN='$fqdn',Ping_service='$pingService',Port_service='$portService',DNS_resolution='$dnsResolution',Monitoring_config='$pauseOrStart',Normal_checking_time='$normalMinutes',Recheck_time='$problemMinutes',Upto_time='$recheckTime' WHERE ID='$ID'";
if ($con->query($query) === TRUE) {
	// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://localhost:8000/'.$action.'/'.$ID.'/'.$hostIp.'/'.$serverPort.'/'.$fqdn.'/'.$pingService.'/'.$portService.'/'.$dnsResolution.'/'.$pauseOrStart.'/'.$normalMinutes.'/'.$problemMinutes.'/'.$recheckTime,
    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
]);
// Send the request & save response to $resp

$resp = curl_exec($curl);
echo($resp);
// Close request to clear up some resources
curl_close($curl);
     echo "<script type=\"text/javascript\">window.alert('Your DNS configuration updated successfully.');
window.location.href = 'configDNS.php';</script>";
exit;
} else {
    echo "Error updating record: " . $con->error;
}

$con->close();
?>