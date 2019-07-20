<?php
include('session.php');
include('databaseConnection.php');
 if(isset($_POST['insert']))  
 {
  $file= addslashes(file_get_contents($_FILES['image']['tmp_name']));
  $query = "UPDATE user_accounts_info SET profileImage=('$file') WHERE Name= '".$_SESSION['userName']."'";
      if(mysqli_query($con, $query))  
      {  
           //echo '<script>alert("Image Inserted into Database")</script>'; 
           header("location:viewAlerts.php"); 
      } 
 }

?>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Alerts</title>
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
  height: 490px;
  overflow: scroll;
}
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
        <div class="container-fluid px-xl-3">
          <section class="py-3">
            <div class="row" >
            	<div class="col-lg-12">
                <div class="card">
                  <div class="card-header" style="background-color: #28bebd ;">
                    <center><h6 class="text-uppercase mb-0">Alerts</h6></center>
                  </div>

                  <div class="card-body">  
                  <div class="scrollable">                       
                    <table class="table table-bordered text-center " style="background-color: #e4eaec">
                      <div class="table responsive">
                      <thead align="center">
                        <tr class="table-active">
                          <th>Sr.No</th>
                          <th>Server</th>
                          <th>Alert</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      <?php
if ($_SESSION['authorizationLevel']=="admin") {
$query="SELECT `ID`,`server_name`,`Alerts` FROM `alerts` ORDER BY ID DESC";
$result = mysqli_query($con,$query);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

// . $row["ID"]. '</td><td>'
        echo '<tr class="table-info">
                  <td scope="row">'. $row["ID"] .'</td>
                  <td> '.$row["server_name"] .'</td>
                  <td>' . $row["Alerts"] .'</td> 
                </tr>';
    }
} else {
    echo "0 results";
} 
 }
 if ($_SESSION['authorizationLevel']=="local") {
$selectAccessQuery="SELECT * FROM `user_accounts_info` WHERE Name='".$_SESSION['userName']."'" ;
$output= mysqli_query($con,$selectAccessQuery);
$row = mysqli_fetch_array($output);
if($row['webServer_Access']=='yes'&&$row['proxyServer_Access']=='yes'&&$row['dnsServer_Access']=='yes'){
  $query="SELECT * FROM alerts ORDER BY ID DESC" ;
$result = mysqli_query($con,$query);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

// . $row["ID"]. '</td><td>'
        echo '<tr class="table-info">
                  <td scope="row">'. $row["ID"] .'</td>
                  <td> '.$row["server_name"] .'</td>
                  <td>' . $row["Alerts"] .'</td> 
                </tr>';
    }
} else {
    echo "0 results";
} 
}
if($row['webServer_Access']=='yes'&&$row['proxyServer_Access']=='no'&&$row['dnsServer_Access']=='no'){
  $query="SELECT * FROM `alerts` WHERE server_name='WEB' ORDER BY ID DESC ";
$result = mysqli_query($con,$query);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

// . $row["ID"]. '</td><td>'
        echo '<tr class="table-info">
                  <td scope="row">'. $row["ID"] .'</td>
                  <td> '.$row["server_name"] .'</td>
                  <td>' . $row["Alerts"] .'</td> 
                </tr>';
    }
} else {
    echo "0 results";
} 
}
if($row['webServer_Access']=='no'&&$row['proxyServer_Access']=='yes'&&$row['dnsServer_Access']=='no'){
  $query="SELECT * FROM `alerts` WHERE server_name='PROXY' ORDER BY ID DESC ";
$result = mysqli_query($con,$query);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

// . $row["ID"]. '</td><td>'
        echo '<tr class="table-info">
                  <td scope="row">'. $row["ID"] .'</td>
                  <td> '.$row["server_name"] .'</td>
                  <td>' . $row["Alerts"] .'</td> 
                </tr>';
    }
} else {
    echo "0 results";
} 
}
if($row['webServer_Access']=='no'&&$row['proxyServer_Access']=='no'&&$row['dnsServer_Access']=='yes'){
  $query="SELECT * FROM `alerts` WHERE server_name='DNS' ORDER BY ID DESC ";
$result = mysqli_query($con,$query);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

// . $row["ID"]. '</td><td>'
        echo '<tr class="table-info">
                  <td scope="row">'. $row["ID"] .'</td>
                  <td> '.$row["server_name"] .'</td>
                  <td>' . $row["Alerts"] .'</td> 
                </tr>';
    }
} else {
    echo "0 results";
} 
}
if($row['webServer_Access']=='yes'&&$row['proxyServer_Access']=='yes'&&$row['dnsServer_Access']=='no'){
  $query="SELECT * FROM `alerts` WHERE server_name='WEB' AND  server_name='PROXY' ORDER BY ID DESC ";
$result = mysqli_query($con,$query);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

// . $row["ID"]. '</td><td>'
        echo '<tr class="table-info">
                  <td scope="row">'. $row["ID"] .'</td>
                  <td> '.$row["server_name"] .'</td>
                  <td>' . $row["Alerts"] .'</td> 
                </tr>';
    }
} else {
    echo "0 results";
} 
}
if($row['webServer_Access']=='no'&&$row['proxyServer_Access']=='yes'&&$row['dnsServer_Access']=='yes'){
  $query="SELECT * FROM `alerts` WHERE server_name='PROXY' AND server_name='DNS' ORDER BY ID DESC ";
$result = mysqli_query($con,$query);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

// . $row["ID"]. '</td><td>'
        echo '<tr class="table-info">
                  <td scope="row">'. $row["ID"] .'</td>
                  <td> '.$row["server_name"] .'</td>
                  <td>' . $row["Alerts"] .'</td> 
                </tr>';
    }
} else {
    echo "0 results";
} 

if($row['webServer_Access']=='yes'&&$row['proxyServer_Access']=='no'&&$row['dnsServer_Access']=='yes'){
  $query="SELECT * FROM `alerts` WHERE server_name='WEB' AND server_name='DNS' ORDER BY ID DESC ";
$result = mysqli_query($con,$query);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

// . $row["ID"]. '</td><td>'
        echo '<tr class="table-info">
                  <td scope="row">'. $row["ID"] .'</td>
                  <td> '.$row["server_name"] .'</td>
                  <td>' . $row["Alerts"] .'</td> 
                </tr>';
    }
} else {
    echo "0 results";
} 
}}
 }
?>
                     
                      </tbody>
                    </div>
                    </table>
                  </div>
                  </div>
                </div>
              </div>
              
            </div>
          </section>
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