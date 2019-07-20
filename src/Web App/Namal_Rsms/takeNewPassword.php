  <!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Namal RSMS</title>
      <meta name="description" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1">
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
      <style type="text/css">
        body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  border: 1px solid #888;
  width: 60%;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
  -webkit-animation-name: animatetop;
  -webkit-animation-duration: 0.4s;
  animation-name: animatetop;
  animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
  from {top:-300px; opacity:0} 
  to {top:0; opacity:1}
}

@keyframes animatetop {
  from {top:-300px; opacity:0}
  to {top:0; opacity:1}
}

/* The Close Button */
.close {
  color: black;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.modal-header {
  height: 40%;
  padding: 2px 16px;
  background-color: #28bebd;
  color: white;
}

.modal-body {padding: 2px 16px;}
      </style>

    </head>
    <body >
      <div class="topnavbar navbar-expand-lg px-4 py-2 bg-white shadow" >
    <img src="img/logo.svg" style="width: 50px;height: 50px;">
        <h4 class="navbar-brand font-weight-bold text-uppercase text-base">Namal RSMS</h4>
  </div>
      <div class="page-holder d-flex align-items-center" style="background-color: #e4eaec">
        <div class="container">
          <div class="row align-items-center py-5">
            <div class="col-5 col-lg-5 mx-auto mb-5 mb-lg-0">
              	<img src="img/backgroud.svg" alt="" style="width: 450px; height:450px " class="img-fluid">
            </div>

            <div class="col-lg-7 px-lg-4">
              <center><h3 class="mb-4">Fill the below information to update password !</h3></center>
              <form action="updatePassword.php" method="post" class="mt-4">
                <div class="form-group mb-4">
                  <input type="text" name="verificationCode" placeholder="Verification Code" required class="form-control border-0 shadow form-control-lg">
                </div>
                <div class="form-group mb-4">
                  <input type="password" name="newPassword" placeholder="New Password" required class="form-control border-0 shadow form-control-lg text-violet">
                </div>
                <div class="form-group mb-4">
                  <input type="password" name="reNewPassword" placeholder="Re-enter New Password" required class="form-control border-0 shadow form-control-lg text-violet">
                </div>
                 <div class="form-group row">
                              <div class="col-md-3 col-md-offset-4">
                                
                                 <button type="submit" class="btn btn shadow px-5" style="margin-right: 15px;background-color: #28bebd ;color: black;">Update</button>
                                 </div>
                                 <div class="col-md-6">
                                </div>
                  </div>
              </form>
              <form>
                                    <!-- The Modal -->
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
    </div>
    <div class="modal-body">
      <center><p>Verification Code has been sent to your given email address !</p></center>
    </div>
  </div>

</div>
              </form>
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

<script>
$(window).on('load',function(){
        $('#myModal').modal('show');
        setTimeout(function() {$('#myModal').modal('hide');}, 1000);
    });
</script>
    </body>
  </html>