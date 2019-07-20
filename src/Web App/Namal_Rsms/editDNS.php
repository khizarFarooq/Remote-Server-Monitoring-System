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
           header("location:editDNS.php"); 
      } 
 }
$ID=$_POST['edit'];
$query="SELECT `ID`, INET_NTOA(`Host_ip`) AS inet, `Host_location`, `Server_name`, `Server_port`, `FQDN`, `Ping_service`,`Port_service`,`DNS_resolution`,`Monitoring_config`,`Normal_checking_time`,`Recheck_time`,`Upto_time`FROM `dns_info` Where ID=$ID";
$result = mysqli_query($con,$query);
if (!$result) exit("The query did not succeded");
else {
    while ($row = mysqli_fetch_array($result)) {
        $Ip=$row['inet'];
        $location=$row['Host_location'];
        $serverName=$row['Server_name'];
        $serverPort=$row['Server_port'];
        $FQDN=$row['FQDN'];
        $pingService=$row['Ping_service'];
        $portService=$row['Port_service'];
        $dnsResolution=$row['DNS_resolution'];
        $monitoringConfig=$row['Monitoring_config'];
        $normalCheckTime=$row['Normal_checking_time'];
        $recheckTime=$row['Recheck_time'];
        $retries=$row['Upto_time'];
    }
}
?>
    <!DOCTYPE html>
    <html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Edit DNS Server Info</title>
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
          <section class="py-5">
            <div class="row">
              <div class="col-lg-12 mb-5">
                <div class="card">
                  <div class="card-header" style="text-align: center;background-color: #28bebd ;">
                    <h3 class="h5 text-uppercase mb-0">Welcome to edit DNS Server</h3>
                    <div class="line" style="background: #000000"></div>
                    <h1 class="h5  mb-0">Host And Server Detail</h1>
                  </div>
                  <div class="card-body" style="text-align: center;">

                    <form  method="POST" action="updateDnsInfo.php" class="form-horizontal" #signupForm="ngForm">
                      <div class="form-group row">
                        <label class="col-md-2 form-control-label">Host IP :</label>
                        <div class="col-md-4">
                          <input class="form-control"  name= "hostIp" type="text" placeholder="IP Address" value="<?php echo $Ip; ?>" class="form-control" required pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}"
                          oninvalid="setCustomValidity('Please enter valid Ip address.')"
                          onchange="try{setCustomValidity('')}catch(e){}"> </div> 
                          <label class="col-md-2 form-control-label">Host Location :</label>
                        <div class="col-md-4">
                          <input class="form-control" type="text" name="hostLocation" value="<?php echo $location; ?>"placeholder="Location" class="form-control" required>                        
                        </div>                         
                      </div>
                  <div class="line"></div>
              <div class="form-group row">
                        <label class="col-md-2 form-control-label">Server Name :</label>
                        <div class="col-md-4">
                          <input class="form-control"  name= "serverName" value="<?php echo $serverName; ?>"type="text" placeholder="Name" class="form-control" required> </div>
                        <label class="col-md-2 form-control-label">Server Port :</label>
                        <div class="col-md-4">
                          <input class="form-control"  name= "serverPort" value="<?php echo $serverPort; ?>" type="text" placeholder="Port Number" class="form-control" required pattern="^([0-9]{1,4}|[1-5][0-9]{4}|6[0-4][0-9]{3}|65[0-4][0-9]{2}|655[0-2][0-9]|6553[0-5])$" title= "Only digits allowed" oninvalid="setCustomValidity('Please enter valid Port No.')"
                          onchange="try{setCustomValidity('')}catch(e){}"> </div>                          
                      </div>
                      <div class="line"></div>
                      <div class="card-header" style="text-align: center;background-color: #28bebd ;">
                    <h3 class="h6 text-uppercase mb-0">Query Information</h3>
                  </div>
                  <div class="line"></div>
              <div class="form-group row">
              	<label class="col-md-1 form-control-label"></label>
              	  <label class="col-md-4 form-control-label">Enter fully qualified domain name :</label> 
                        <div class="col-md-3">
                          <input class="form-control"  name= "fqdn" value="<?php echo $FQDN; ?>"type="text" placeholder="FQDN" class="form-control" required> </div>  
                          <label class="col-md-3 form-control-label">you'd like to monitor.</label>                      
                      </div>




                      <div class="line"></div>
                      <div class="card-header" style="text-align: center;background-color: #28bebd ;">
                    <h3 class="h6 text-uppercase mb-0">Services</h3>
                  </div>
                   <div class="line"></div>
                  <div class="form-group row">
                        <div class="col-md-4">
                          <div class="custom-control custom-checkbox">
                            <input id="pingService" name="pingService" value ="yes"  <?php if($pingService=="yes"){echo "checked";}?> type="checkbox" class="custom-control-input">
                            <label for="pingService" class="custom-control-label">Ping to Host</label>
                          </div>
                        </div>
                        <div class="col-md-3">
                        	<div class="custom-control custom-checkbox">
                            <input id="portService" name="portService" value="yes" <?php if($portService=="yes"){echo "checked";}?> type="checkbox" class="custom-control-input">
                            <label for="portService" class="custom-control-label">Server port availability</label>
                          </div>
                        </div>
                        <div class="col-md-4">
                        	<div class="custom-control custom-checkbox">
                            <input id="dnsResolution" name="dnsResolution" value="yes" <?php if($dnsResolution=="yes"){echo "checked";}?> type="checkbox" class="custom-control-input">
                            <label for="dnsResolution" class="custom-control-label">DNS Resolution</label>
                          </div>
                        </div>
                      </div>
                      <div class="line"></div>
                      <div class="card-header" style="text-align: center;background-color: #28bebd ;">
                    <h3 class="h6 text-uppercase mb-0">Monitoring Setting</h3>
                  </div>
                   <div class="line"></div>
                   <label class="col-md-12 form-control-label">Define the basic parameters that determine how the host and service should be monitered.</label> 
                  <div class="form-group row">
                    <label class="col-md-3 form-control-label"></label> 
                        <div class="col-md-3">
                           <div class="custom-control custom-radio custom-control-inline">
                            <input id="start" type="radio" name="pauseOrStart" class="custom-control-input" value="start" <?php if($monitoringConfig=="start"){echo "checked";}?>>
                            <label for="start" class="custom-control-label">Start</label>
                          </div>
                        </div>
                        <div class="col-md-2">
                           <div class="custom-control custom-radio custom-control-inline">
                            <input id="pause" type="radio" name="pauseOrStart" class="custom-control-input" value="pause" <?php if($monitoringConfig=="pause"){echo "checked";}?>>
                            <label for="pause" class="custom-control-label">Pause</label>
                          </div>
                        </div>
                      </div>
                      <h5 >Under normal circumstances</h5>
                      <div class="line"></div>
                      <div class="form-group row">
              	<label class="col-md-3 form-control-label"></label>
              	  <label class="col-md-4 form-control-label">Monitor the host and services after every</label> 
                        <div class="col-md-2">
                          <input class="form-control"  name= "normalMinutes" value="<?php echo $normalCheckTime; ?>"type="text" placeholder="Minutes" class="form-control" required pattern= "^[1-9]\d*$" oninvalid="setCustomValidity('Please enter valid input')"
                          onchange="try{setCustomValidity('')}catch(e){}"> </div>  
                        
                      </div>
                      <h5 >Aftrer potential problem detection</h5>
                      <div class="line"></div>
                      <div class="form-group row">
              	  <label class="col-md-4 form-control-label">Re-check the host and services after</label> 
                        <div class="col-md-2">
                          <input class="form-control"  name= "problemMinutes"   value="<?php echo $recheckTime; ?>" type="text" placeholder="Minutes" class="form-control" required pattern= "^[1-9]\d*$" oninvalid="setCustomValidity('Please enter valid input')"
                          onchange="try{setCustomValidity('')}catch(e){}"> </div>  
                          <label class="col-md-3 form-control-label">up to</label>
                          <div class="col-md-3">
                          <input class="form-control"  name= "recheckTime" value="<?php echo $retries; ?>"type="text" placeholder="Times" class="form-control" required pattern= "^[1-9]\d*$" oninvalid="setCustomValidity('Please enter valid input')"
                          onchange="try{setCustomValidity('')}catch(e){}"> </div>  
                          <label class="col-md-12 form-control-label">before generating an alert.</label>                      
                      </div>  
                    <div class="line"></div>
                          <div class="form-group row" style="float: right;">
                          <div class="col-md-6">
                          <button type="submit" name="serverId" <?php echo 'value='.$ID.'' ?> class="btn btn shadow px-5" style="margin-right: 15px;background-color: #28bebd ;">Update</button>
                          </div>
                          </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </section>
      </div>
    </div>
      </body>
       </html>