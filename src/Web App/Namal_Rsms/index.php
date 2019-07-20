<?php
include('session.php');
include('databaseConnection.php');
$page = $_SERVER['PHP_SELF'];
$sec = "30";
 if(isset($_POST['insert']))  
 {
  $file= addslashes(file_get_contents($_FILES['image']['tmp_name']));
  $query = "UPDATE user_accounts_info SET profileImage=('$file') WHERE Name= '".$_SESSION['userName']."'";
      if(mysqli_query($con, $query))  
      {  
           header("location:index.php"); 
      } 
 }
?>
<html>
  <head>
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <!-- Google fonts - Popppins for copy-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,800">
    <!-- orion icons-->
    <link rel="stylesheet" href="css/orionicons.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/logo.svg">
    <style type="text/css">
      .scrollable{
  height: 200px;
  overflow: scroll;
}
.circle {
  height: 50px;
  width: 50px;
  background-color: #555;
  border-radius: 50%;
}
.meanings{
  position: center;
}
#firstLabel {
    margin-right: 50px;
}
    </style>
   
  </head>
  <body>
    <?php
    include 'header.php';
    ?>
    <div class="d-flex align-items-stretch">
       <?php
    include 'sideBar.php';
    ?>
      <div class="page-holder w-100 d-flex flex-wrap">
        <div class="container-fluid px-xl-5">
          <?php
          if(($_SESSION['authorizationLevel']=="admin") || ($_SESSION['authorizationLevel']=="local" && ($_SESSION['webServerAccess']=="yes"))){
          ?>
          <section class="py-3">
            <center>
            <div class="col-lg-12">
          <div class="card" style="background-color: #e4eaec">
            <div class="card-body">
              <center>
                <font size="4" style="color: #181818;">Status :</font>
      <svg width="40" height="20">
  <rect width="200" height="80" style="fill:#A9A9A9;stroke-width:3;" />
</svg> 
<label style="margin-left: 3px;margin-right: 15px;">Not Monitoring</label>
   
     
     <svg width="40" height="20">
       <rect width="200" height="80" style="fill:#00FF00;stroke-width:3;" />
</svg> 
<label  style="margin-left: 3px;margin-right: 15px;">Up</label>
    
   
     <svg width="40" height="20">
      <rect width="200" height="80" style="fill:#FF0000;stroke-width:3;margin-left: 10px; " />
</svg>
<label style="margin-left: 3px;">Down</label>
</center>
</div>
     </div>
     </div>
     </center>
     </section>
          <section class="py-3">
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-header" style="background-color: #28bebd">
                    <center><h6 class="text-uppercase mb-0">Web Server Current Status</h6></center>
                  </div>
                  <div class="card-body">  
                  <div class="scrollable">                        
                    <table class="table table-striped table-sm card-text">
                      <thead>
                        <tr>
                          <th>Sr.No</th>
                          <th>Host Name</th>
                          <th>Server Name</th>
                          <th>Host Status</th>
                          <th>Port Status</th>
                          <th>Https Request Status</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                      $query="SELECT `ID`, INET_NTOA(`Host_ip`) AS hIp, `Host_location`, `Server_name`, `Server_port`, `Web_url`, `Ping_service`,`Port_service`,`Https_service`,`Monitoring_config`,`Normal_checking_time`,`Recheck_time`,`Upto_time`FROM `web_server_info`";
$result=mysqli_query($con,$query);
if ($result->num_rows > 0) {
    // output data of each row
$counter=1;
   while($row = mysqli_fetch_array($result))
{
$ping_service_table=$row['ID']."_webServer_Ping_Service";
echo "<tr>";
echo "<td>" . $counter. "</td>";
echo "<td>" . $row['hIp'] . "</td>";
echo "<td>" . $row['Server_name'] . "</td>";
if(($row['Ping_service']=="yes" && $row['Monitoring_config']=="start")||($row['Ping_service']=="no" && $row['Monitoring_config']=="pause")){
  $ping_service_table=$row['ID']."_webserver_ping_service";
  $selectStatus="SELECT `status` from  $ping_service_table  ORDER BY id DESC LIMIT 1 ";
  $output = mysqli_query($con,$selectStatus);
  $statusRow = mysqli_fetch_array($output); 
  if($statusRow['status']=="OK"){
     echo "<td>" . '<svg width="60" height="30">
  <rect x="34" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #00FF00;stroke:black;stroke-width:3;opacity:100" />
</svg> '."<td>" ;
  }
  if($statusRow['status']=="UNREACHABLE"||$statusRow['status']=="TIMEOUT"){
     echo "<td>" . '<svg width="60" height="30">
  <rect x="34" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #FF0000;stroke:black;stroke-width:3;opacity:100" />
</svg> '."<td>" ;
  }    
}
else {
  echo "<td>" . '<svg width="60" height="30">
  <rect x="34" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #A9A9A9;stroke:black;stroke-width:3;opacity:100" />
</svg> '."<td>" ;
  }


if(($row['Port_service']=="yes"&& $row['Monitoring_config']=="start")||($row['Port_service']=="no"&& $row['Monitoring_config']=="pause")){
  $port_service_table=$row['ID']."_webserver_port_service";
  $selectStatus="SELECT `status` from  $port_service_table  ORDER BY id DESC LIMIT 1 ";
  $output = mysqli_query($con,$selectStatus);
  $statusRow = mysqli_fetch_array($output); 
  if($statusRow['status']=="up"){
     echo '<svg width="60" height="30">
  <rect x="40" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #00FF00;stroke:black;stroke-width:3;opacity:100" />
</svg> ' ;
 }
  if($statusRow['status']=="Unknown Host"||$statusRow['status']=="Time Out"){
     echo "<td>" . '<svg width="60" height="30">
  <rect x="40" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #FF0000;stroke:black;stroke-width:3;opacity:100" />
</svg> '."<td>" ;
  }    
}
else {
  echo '<svg width="60" height="30">
  <rect x="40" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #A9A9A9;stroke:black;stroke-width:3;opacity:100" />
</svg> ' ;
  }

if(($row['Https_service']=="yes" && $row['Monitoring_config']=="start")||($row['Https_service']=="no" && $row['Monitoring_config']=="pause")){
  $httpsRequest_service_table=$row['ID']."_webserver_https_request_service";
  $selectStatus="SELECT `status` from  $httpsRequest_service_table  ORDER BY id DESC LIMIT 1 ";
  $output = mysqli_query($con,$selectStatus);
  $statusRow = mysqli_fetch_array($output); 
  if($statusRow['status']=="UP"){
     echo  "<td>" . '<svg width="60" height="30">
  <rect x="30" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #00FF00;stroke:black;stroke-width:3;opacity:100" />
</svg> ' ."<td>";
  }
  else {
     echo "<td>" . '<svg width="60" height="30">
  <rect x="30" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #FF0000;stroke:black;stroke-width:3;opacity:100" />
</svg> '."<td>" ;
  }    
}
else {
  echo "<td>" .'<svg width="60" height="30">
  <rect x="30" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #A9A9A9;stroke:black;stroke-width:3;opacity:100" />
</svg> '."<td>" ;
  }



echo "</tr>";
$counter=$counter+1;
}
} else {
    echo "0 results";
} 
?>
                      </tbody>
                    </table>
                  </div>
                </div>
                </div>
              </div>
            </div>
          </section>
          <?php
        }
          ?>
          <?php
          if(($_SESSION['authorizationLevel']=="admin") || ($_SESSION['authorizationLevel']=="local" && ($_SESSION['proxyServerAccess']=="yes"))){
          ?>
          <section class="py-4">
            <div class="row">
               <div class="col-lg-12">
                <div class="card">
                  <div class="card-header" style="background-color: #28bebd">
                    <center><h6 class="text-uppercase mb-0">Proxy Server Current Status</h6></center>
                  </div>
                  <div class="card-body">   
                  <div class="scrollable">                       
                    <table class="table table-striped table-sm card-text">
                      <thead>
                        <tr>
                          <th>Sr.No</th>
                          <th>Host Name</th>
                          <th>Server Name</th>
                          <th>Host Status</th>
                          <th>Port Status</th>
                          <th>Https Request Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                         $query="SELECT `ID`, INET_NTOA(`Host_ip`) AS inet, `Host_location`, `Server_name`, `Server_port`, `Web_url`, `Ping_service`,`Port_service`,`Https_service`,`Monitoring_config`,`Normal_checking_time`,`Recheck_time`,`Upto_time`FROM `proxy_server_info`";
  $result = mysqli_query($con,$query);
if ($result->num_rows > 0) {
$counter=1;
    // output data of each row
   while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $counter. "</td>";
echo "<td>" . $row['inet'] . "</td>";
echo "<td>" . $row['Server_name'] . "</td>";
if(($row['Ping_service']=="yes" && $row['Monitoring_config']=="start")||($row['Ping_service']=="no" && $row['Monitoring_config']=="pause")){
  $ping_service_table=$row['ID']."_proxy_server_ping_service";
  $selectStatus="SELECT `status` from  $ping_service_table  ORDER BY id DESC LIMIT 1 ";
  $output = mysqli_query($con,$selectStatus);
  $statusRow = mysqli_fetch_array($output); 
  if($statusRow['status']=="OK"){
     echo "<td>" . '<svg width="60" height="30">
  <rect x="34" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #00FF00;stroke:black;stroke-width:3;opacity:100" />
</svg> '."<td>" ;
  }
  if($statusRow['status']=="UNREACHABLE"||$statusRow['status']=="TIMEOUT"){
     echo "<td>" . '<svg width="60" height="30">
  <rect x="34" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #FF0000;stroke:black;stroke-width:3;opacity:100" />
</svg> '."<td>" ;
  }    
}
else {
  echo "<td>" . '<svg width="60" height="30">
  <rect x="34" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #A9A9A9;stroke:black;stroke-width:3;opacity:100" />
</svg> '."<td>" ;
  }


if(($row['Port_service']=="yes"&& $row['Monitoring_config']=="start")||($row['Port_service']=="no"&& $row['Monitoring_config']=="pause")){
  $port_service_table=$row['ID']."_proxy_server_port_service";
  $selectStatus="SELECT `status` from  $port_service_table  ORDER BY id DESC LIMIT 1 ";
  $output = mysqli_query($con,$selectStatus);
  $statusRow = mysqli_fetch_array($output); 
  if($statusRow['status']=="up"){
     echo '<svg width="60" height="30">
  <rect x="40" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #00FF00;stroke:black;stroke-width:3;opacity:100" />
</svg> ' ;
  }
  if($statusRow['status']=="Unknown Host"||$statusRow['status']=="Time Out"){
     echo "<td>" . '<svg width="60" height="30">
  <rect x="40" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #FF0000;stroke:black;stroke-width:3;opacity:100" />
</svg> '."<td>" ;
  }    
}
else {
  echo '<svg width="60" height="30">
  <rect x="40" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #A9A9A9;stroke:black;stroke-width:3;opacity:100" />
</svg> ' ;
  }

if(($row['Https_service']=="yes" && $row['Monitoring_config']=="start")||($row['Https_service']=="no" && $row['Monitoring_config']=="pause")){
  $httpsRequest_service_table=$row['ID']."_proxy_server_https_request_service";
  $selectStatus="SELECT `status` from  $httpsRequest_service_table  ORDER BY id DESC LIMIT 1 ";
  $output = mysqli_query($con,$selectStatus);
  $statusRow = mysqli_fetch_array($output); 
  if($statusRow['status']=="UP"){
     echo "<td>" . '<svg width="60" height="30">
  <rect x="30" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #00FF00;stroke:black;stroke-width:3;opacity:100" />
</svg> '."<td>" ;
  }
  else {
     echo "<td>" . '<svg width="60" height="30">
  <rect x="30" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #FF0000;stroke:black;stroke-width:3;opacity:100" />
</svg> '."<td>" ;
  }    
}
else {
  echo "<td>" .'<svg width="60" height="30">
  <rect x="30" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #A9A9A9;stroke:black;stroke-width:3;opacity:100" />
</svg> '."<td>" ;
  }

echo "</tr>";
$counter=$counter+1;
}
} else {
    echo "0 results";
} 
?>
                      </tbody>
                    </table>
                  </div>
                </div>
                </div>
              </div>
            </div>
          </section>
          <?php
        }
          ?>
          <?php
          if(($_SESSION['authorizationLevel']=="admin") || ($_SESSION['authorizationLevel']=="local" && ($_SESSION['dnsAccess']=="yes"))){
          ?>
          <section   class="py-4">
             <div class="row">
                 <div class="col-lg-12">
                <div class="card">
                  <div class="card-header" style="background-color: #28bebd">
                    <center><h6 class="text-uppercase mb-0">Domain Name Server Current Status</h6></center>
                  </div>
                  <div class="card-body">   
                  <div class="scrollable">
                    <table class="table table-striped table-sm card-text">
                      <thead>
                        <tr>
                          <th>Sr.No</th>
                          <th>Host Name</th>
                          <th>Server Name</th>
                          <th>Host Status</th>
                          <th>Port Status</th>
                          <th>DNS Query Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $query="SELECT `ID`, INET_NTOA(`Host_ip`) AS inet, `Host_location`, `Server_name`, `Server_port`, `FQDN`, `Ping_service`,`Port_service`,`DNS_resolution`,`Monitoring_config`,`Normal_checking_time`,`Recheck_time`,`Upto_time`FROM `dns_info`";
$result = mysqli_query($con,$query);
if ($result->num_rows > 0) {
    // output data of each row
  $counter=1;
   while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $counter. "</td>";
echo "<td>" . $row['inet'] . "</td>";
echo "<td>" . $row['Server_name'] . "</td>";
if(($row['Ping_service']=="yes" && $row['Monitoring_config']=="start")||($row['Ping_service']=="no" && $row['Monitoring_config']=="pause")){
  $ping_service_table=$row['ID']."_dns_ping_service";
  $selectStatus="SELECT `status` from  $ping_service_table  ORDER BY id DESC LIMIT 1 ";
  $output = mysqli_query($con,$selectStatus);
  $statusRow = mysqli_fetch_array($output); 
  if($statusRow['status']=="OK"){
     echo "<td>" . '<svg width="60" height="30">
  <rect x="34" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #00FF00;stroke:black;stroke-width:3;opacity:100" />
</svg> '."<td>" ;
  }
  if($statusRow['status']=="UNREACHABLE"||$statusRow['status']=="TIMEOUT"){
     echo "<td>" . '<svg width="60" height="30">
  <rect x="34" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #FF0000;stroke:black;stroke-width:3;opacity:100" />
</svg> '."<td>" ;
  }    
}
else {
  echo "<td>" . '<svg width="60" height="30">
  <rect x="34" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #A9A9A9;stroke:black;stroke-width:3;opacity:100" />
</svg> '."<td>" ;
  }



if(($row['Port_service']=="yes"&& $row['Monitoring_config']=="start")||($row['Port_service']=="no"&& $row['Monitoring_config']=="pause")){
  $port_service_table=$row['ID']."_dns_port_service";
  $selectStatus="SELECT `status` from  $port_service_table  ORDER BY id DESC LIMIT 1 ";
  $output = mysqli_query($con,$selectStatus);
  $statusRow = mysqli_fetch_array($output); 
  if($statusRow['status']=="up"){
     echo  '<svg width="60" height="30">
  <rect x="40" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #00FF00;stroke:black;stroke-width:3;opacity:100" />
</svg> ' ;
  }
  if($statusRow['status']=="Unknown Host"||$statusRow['status']=="Time Out"){
     echo "<td>" . '<svg width="60" height="30">
  <rect x="40" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #FF0000;stroke:black;stroke-width:3;opacity:100" />
</svg> '."<td>" ;
  }    
}
else {
  echo '<svg width="60" height="30">
  <rect x="40" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #A9A9A9;stroke:black;stroke-width:3;opacity:100" />
</svg> ' ;
  }



  if(($row['DNS_resolution']=="yes"&& $row['Monitoring_config']=="start")||($row['DNS_resolution']=="no"&& $row['Monitoring_config']=="pause")){
  $dnsQuery_service_table=$row['ID']."_dns_domain_name_resolution_service";
  $selectStatus="SELECT `status` from  $dnsQuery_service_table  ORDER BY id DESC LIMIT 1 ";
  $output = mysqli_query($con,$selectStatus);
  $statusRow = mysqli_fetch_array($output); 
  if($statusRow['status']!="OK"){
echo "<td>" . '<svg width="80" height="30">
  <rect x="50" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #FF0000;stroke:black;stroke-width:3;opacity:100" />
</svg> '."<td>" ;
  }
  else {
      echo "<td>" . '<svg width="80" height="30">
  <rect x="50" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #00FF00;stroke:black;stroke-width:3;opacity:100" />
</svg> '."<td>" ;
  }    
}
else {
  echo "<td>" . '<svg width="80" height="30">
  <rect x="50" y="10" rx="10" ry="10" width="15" height="15"
  style="fill:  #A9A9A9;stroke:black;stroke-width:3;opacity:100" />
</svg> '."<td>" ;
  }

echo "</tr>";
$counter=$counter+1;
}
} else {
    echo "0 results";
} 
?>
                      </tbody>
                    </table>
                  </div>
                </div>
                </div>
              </div>
            </div>
          </section>
          <?php
        }
          ?>
        </div>
        </div>
      </div>

      </div>
    </div>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <script src="js/front.js"></script>
  </body>
</html>
 <script>  
 $(document).ready(function(){  
      $('#insert').click(function(){  
           var image_name = $('#image').val();  
           if(image_name == '')  
           {  
                alert("Please Select Image");  
                return false;  
           }  
           else  
           {  
                var extension = $('#image').val().split('.').pop().toLowerCase();  
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)  
                {  
                     alert('Invalid Image File');  
                     $('#image').val('');  
                     return false;  
                }  
           }  
      });  
 });  
 </script>