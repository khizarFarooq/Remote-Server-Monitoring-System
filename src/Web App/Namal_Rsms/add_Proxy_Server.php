  <?php
include('session.php');
include('databaseConnection.php');
 if(isset($_POST['insert']))  
 {
  $file= addslashes(file_get_contents($_FILES['image']['tmp_name']));
  $query = "UPDATE user_accounts_info SET profileImage=('$file') WHERE Name= '".$_SESSION['userName']."'";
      if(mysqli_query($con, $query))  
      {  
           header("location:add_Proxy_Server.php"); 
      } 
 }
?>
    <!DOCTYPE html>
    <html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add Proxy Server</title>
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
        include ('header.php');
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
                  <div class="card-header" style="text-align: center; background-color: #28bebd">
                    <h3 class="h5 text-uppercase mb-0">Welcome to add new Proxy Server</h3>
                    <div class="line" style="background: #000000"></div>
                    <h1 class="h5  mb-0">Host And Server Detail</h1>
                  </div>
                  <div class="card-body" style="text-align: center;">

                    <form action="proxyServerRegistaration.php" method="post" class="form-horizontal" #signupForm="ngForm">
                      <div class="form-group row">
                        <label class="col-md-2 form-control-label">Host IP :</label>
                        <div class="col-md-4">
                          <input class="form-control"  name= "hostIp" type="text" placeholder="IP Address" class="form-control" required pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}"
                          oninvalid="setCustomValidity('Please enter valid Ip address.')"
                          onchange="try{setCustomValidity('')}catch(e){}"> </div> 
                          <label class="col-md-2 form-control-label">Host Location :</label>
                        <div class="col-md-4">
                          <input class="form-control" type="text" name="hostLocation" placeholder="Location" class="form-control" required>                        
                        </div>                         
                      </div>
                  <div class="line"></div>
              <div class="form-group row">
                        <label class="col-md-2 form-control-label">Server Name :</label>
                        <div class="col-md-4">
                          <input class="form-control"  name= "serverName" type="text" placeholder="Name" class="form-control" required> </div>
                        <label class="col-md-2 form-control-label">Server Port :</label>
                        <div class="col-md-4">
                          <input class="form-control"  name= "serverPort" type="text" placeholder="Port Number" class="form-control" required  pattern="^([0-9]{1,4}|[1-5][0-9]{4}|6[0-4][0-9]{3}|65[0-4][0-9]{2}|655[0-2][0-9]|6553[0-5])$"  title= "Only digits allowed" oninvalid="setCustomValidity('Please enter valid Port No.')"
                          onchange="try{setCustomValidity('')}catch(e){}"> </div>                          
                      </div> 
                      <div class="line"></div>
                      <div class="card-header" style="text-align: center;background-color: #28bebd">
                    <h3 class="h6 text-uppercase mb-0">Website Details</h3>
                  </div>
                  <div class="line"></div>
              <div class="form-group row">
               
                  <label class="col-md-3 form-control-label">Enter the website URL :</label> 
                        <div class="col-md-4">
                          <input class="form-control"  name= "webUrl" placeholder="Website Url" class="form-control" required> </div>  
                          <label class="col-md-5 form-control-label">to ensure server respond with a valid HTTPS response.</label>                      
                      </div>

                      <div class="line"></div>
                      <div class="card-header" style="text-align: center;background-color: #28bebd">
                    <h3 class="h6 text-uppercase mb-0">Services</h3>
                  </div>
                   <div class="line"></div>
                  <div class="form-group row">
                        <div class="col-md-4">
                          <div class="custom-control custom-checkbox">
                            <input id="pingService" checked name="pingService" type="checkbox" value ="yes" class="custom-control-input">
                            <label for="pingService" class="custom-control-label">Ping to Host</label>
                          </div>
                        </div>
                        <div class="col-md-3">
                         <div class="custom-control custom-checkbox">
                            <input id="portService" checked name="portService" type="checkbox" value ="yes" class="custom-control-input">
                            <label for="portService" class="custom-control-label">Server port availability</label>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="custom-control custom-checkbox">
                            <input id="httpsService"checked name= "httpsService" type="checkbox" value ="yes" class="custom-control-input">
                            <label for="httpsService" class="custom-control-label">Https request to server</label>
                          </div>
                        </div>
                      </div>
                      <div class="line"></div>
                      <div class="card-header" style="text-align: center;background-color: #28bebd">
                    <h3 class="h6 text-uppercase mb-0">Monitoring Setting</h3>
                  </div>
                   <div class="line"></div>
                   <label class="col-md-12 form-control-label">Define the basic parameters that determine how the host and service should be monitered.</label> 
               <div class="form-group row">
                    <label class="col-md-3 form-control-label"></label> 
                        <div class="col-md-3">
                           <div class="custom-control custom-radio custom-control-inline">
                            <input id="start" type="radio" name="pauseOrStart" class="custom-control-input" value="start">
                            <label for="start" class="custom-control-label">Start</label>
                          </div>
                        </div>
                        <div class="col-md-2">
                           <div class="custom-control custom-radio custom-control-inline">
                            <input id="pause" type="radio" checked name="pauseOrStart" class="custom-control-input" value="pause">
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
                          <input class="form-control"  name= "normalMinutes" type="text" placeholder="Minutes" class="form-control" required pattern= "^[1-9]\d*$" oninvalid="setCustomValidity('Please enter valid input')"
                          onchange="try{setCustomValidity('')}catch(e){}"> </div>  
                        
                      </div>
                      <h5 >Aftrer potential problem detection</h5>
                      <div class="line"></div>
                      <div class="form-group row">
                  <label class="col-md-4 form-control-label">Re-check the host and services after</label> 
                        <div class="col-md-2">
                          <input class="form-control"  name= "problemMinutes" type="text" placeholder="Minutes" class="form-control" required pattern= "^[1-9]\d*$" oninvalid="setCustomValidity('Please enter valid input')"
                          onchange="try{setCustomValidity('')}catch(e){}"> </div>  
                          <label class="col-md-3 form-control-label">up to</label>
                          <div class="col-md-3">
                          <input class="form-control"  name= "recheckTime" type="text" placeholder="Times" class="form-control" required="required" pattern= "^[1-9]\d*$" oninvalid="setCustomValidity('Please enter valid input')"
                          onchange="try{setCustomValidity('')}catch(e){}"> </div>  
                          <label class="col-md-12 form-control-label">before generating an alert.</label>                      
                      </div>
                    <div class="line"></div>
                          <div class="form-group row" style="float: right;">
                          <div class="col-md-6">
                          <button type="submit" name="action" value="proxyServerRegistration"class="btn btn shadow px-5" style="margin-right: 15px;background-color: #28bebd ;">Submit</button>
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
  </div>
      </body>
       </html>