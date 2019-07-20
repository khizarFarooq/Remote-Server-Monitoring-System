      <?php
include('session.php');
include('databaseConnection.php');
 if(isset($_POST['insert']))  
 {
  $file= addslashes(file_get_contents($_FILES['image']['tmp_name']));
  $query = "UPDATE user_accounts_info SET profileImage=('$file') WHERE Name= '".$_SESSION['userName']."'";
      if(mysqli_query($con, $query))  
      {  
           header("location:add_New_Server.php"); 
      } 
 }
?>
    <!DOCTYPE html>
    <html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add new Server</title>
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
    <link rel="shortcut icon" href="img/backgroud.svg">
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
          <section class="py-3">
            <div class="row">
              <div class="col-lg-12 mb-5">
                <div class="card">
                  <div class="card-header" style="text-align: center; background-color: #28bebd">
                    <h3 class="h5 text-uppercase mb-0">Add new Server</h3>
                    <div class="line" style="background: #000000"></div>
                    <h1 class="h5  mb-0">What type of Server you would like to add ?</h1>
                  </div>
                   <div class="card-body" style="text-align: center;">
                     <form class="form-horizontal" #signupForm="ngForm">
                      <div class="form-group row">
                        <label class="col-md-4 form-control-label" >Proxy Server</label>
                        <label class="col-md-4 form-control-label" >DNS Server</label>
                        <label class="col-md-2 form-control-label" >Web Server</label>
                      </div>
                      <div class="form-group row" >
                        <div class="col-md-4">
                         <a href="add_Proxy_Server.php"><img src="img/proxy_server.png" style="width: 180px;height:180px;"> </a></div>
                         <div class="col-md-4">
                         <a href="add_DNS_Server.php"><img src="img/dns_server.png" style="width: 180px;height:180px;"></a> </div>
                         <div class="form-group row">
                        <div class="col-md-4">
                         <a href="add_Web_Server.php"><img src="img/web_server.png" style="width: 180px;height:180px;"></a> </div>                        
                      </div>
                                                
                      </div>
                     
                    </form>
                   </div>
                  </div>
                  </div>
                </div>
      </body>
       </html>