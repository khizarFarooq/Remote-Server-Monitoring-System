<?php

include('session.php');
include('databaseConnection.php');
if(isset($_POST['insert']))  
 {
  $file= addslashes(file_get_contents($_FILES['image']['tmp_name']));
  $query = "UPDATE user_accounts_info SET profileImage=('$file') WHERE Name= '".$_SESSION['userName']."'";
      if(mysqli_query($con, $query))  
      {  
           header("location:index.php"); 
      } 
 }
$query="SELECT `ID`, INET_NTOA(`Host_ip`) AS inet, `Host_location`, `Server_name`, `Server_port`, `Web_url`, `Ping_service`,`Port_service`,`Https_service`,`Monitoring_config`,`Normal_checking_time`,`Recheck_time`,`Upto_time`FROM `proxy_server_info`";
$result = mysqli_query($con,$query);
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Configure Proxy Server</title>
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
            <div class="row">
            	<div class="col-lg-12">
                <form action="editProxyServer.php" method="POST">
                <div class="card">
                  <div class="card-header" style="background-color: #28bebd">
                    <center><h6 class="text-uppercase mb-0">Proxy Server Info</h6></center>
                  </div>
                  <div class="card-body"> 
                  <div class="scrollable">
                   <table class="table table-bordered text-center">                     
    <div class="table responsive">
        <thead >
            <tr class="table-active">
              <!-- <th >Id</th> -->
                          <th>Ip</th>
                          <th >Location</th>
                          <th>Server Name</th>
                          <th >Server Port</th>
                          <th >Testing Url</th>
                          <th >Ping Service</th>
                          <th >Port Service</th>
                          <th>Https Service</th>
                          <th>Config Info</th>
                          <!-- <th>Normal Time</th>
                          <th>Rechek Time</th>
                          <th>Retries</th> -->
                          <th>Action</th>
                          
            </tr>
        </thead>
        <tbody>
<?php 
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

// . $row["ID"]. '</td><td>'
       // <td>' . $row["Normal_checking_time"] .'</td>
       //            <td>' . $row["Recheck_time"] .'</td>
       //            <td>' . $row["Upto_time"] .'</td>
        echo '<tr class="table-info">
         
                  <td scope="row">'. $row["inet"] .'</td>
                  <td> '.$row["Host_location"] .'</td>
                  <td>' . $row["Server_name"] .'</td>
                  <td>' . $row["Server_port"] .'</td>
                  <td>' . $row["Web_url"] .'</td>
                  <td>' . $row["Ping_service"] .'</td>
                  <td>' . $row["Port_service"] .'</td>
                  <td>' . $row["Https_service"] .'</td>
                  <td>' . $row["Monitoring_config"] .'</td>
                    <td><button type="submit" class="btn btn shadow px-5" style="background-color: #3b4856 ;" name="edit" 
                  value='.$row["ID"].' >Edit</button>
        </td>
                </tr>';
    }
} else {
    echo "0 results";
} 
?>
       </tbody>
    </div>
</table>
</div>

                   </div>
                </div>
              </form>
              </div>
            </div>
          </section>
        </div>
              </div>
            </div>
          </div>
        </footer>
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