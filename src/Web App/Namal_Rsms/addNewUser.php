     <?php
include('session.php');
include('databaseConnection.php');
 if(isset($_POST['insert']))  
 {
  $file= addslashes(file_get_contents($_FILES['image']['tmp_name']));
  $query = "UPDATE user_accounts_info SET profileImage=('$file') WHERE Name= '".$_SESSION['userName']."'";
      if(mysqli_query($con, $query))  
      {  
           header("location:addNewUser.php"); 
      } 
 }  
?>
     <!DOCTYPE html>
    <html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add new User</title>
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
    <script type="text/javascript">
      document.getElementById("name").value = localStorage.getItem("Name");    // set the value to this input
        document.getElementById("password").value = localStorage.getItem("Password");
        document.getElementById("email").value = localStorage.getItem("Email");
        document.getElementById("contactNo").value = localStorage.getItem("ContactNo");
        document.getElementById("authorizationLevel").value = localStorage.getItem("AuthorizationLevel");
        function save() {
          var Name = document.getElementById("name").value;
          var Email = document.getElementById("Email").value;
          var Password = document.getElementById("Password").value;
          var ContactNo = document.getElementById("ContactNo").value;
          var AuthorizationLevel = document.getElementById("AuthorizationLevel").value;
           localStorage.setItem("Name", Name);
           localStorage.setItem("Password", Password);
           localStorage.setItem("Email", Email);
           localStorage.setItem("ContactNo", ContactNo);
           localStorage.setItem("AuthorizationLevel", AuthorizationLevel);
        }
function showDiv(divId, element)
{
    document.getElementById(divId).style.display = element.value == "local" ? 'block' : 'none';
}
</script>
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
              <div class="col-lg-12 mb-5">
                <div class="card">
                  <div class="card-header" style="text-align: center;background-color: #28bebd">
                    <h3 class="h5 text-uppercase mb-0">General Info</h3>
                  </div>
                  <div class="card-body" style="text-align: center;">

                    <form name ="add_New_User" class="form-horizontal" #signupForm="ngForm"  method="POST"action="userRegisteration.php" onSubmit="save()" >
                      <div class="form-group row">
                        <label class="col-md-2 form-control-label">Name :</label>
                        <div class="col-md-4">
                          <input class="form-control"  name= "name" type="text" placeholder="Name"  id="name" onkeyup='saveValue(this);' value="<?php if(isset($_POST['name'])){
                            echo $_POST['name'];
                          }
                          ?>"class="form-control" required> </div>
                        <label class="col-md-2 form-control-label">Password :</label>
                        <div class="col-md-4">
                          <input class="form-control"  name= "password" id= "password" onkeyup='saveValue(this);'  type="password" placeholder="Password" class="form-control" required> </div>                          
                      </div>
                      <div class="line"></div>
                      <div class="form-group row">
                        <label class="col-md-2 form-control-label">Email Address :</label>
                        <div class="col-md-4">
                          <input class="form-control" type="email" name="email" id="email" onkeyup='saveValue(this);' placeholder="user@gmail.com" class="form-control" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                          oninvalid="setCustomValidity('Please enter valid email ')"
                          onchange="try{setCustomValidity('')}catch(e){}">                        
                        </div>
                      
                        <label class="col-md-2 form-control-label">Contact No :</label>
                        <div class="col-md-4">
                          <input class="form-control" type="text" name="contactNo" id="contactNo" onkeyup='saveValue(this);' class="form-control" required placeholder="03000000000"  pattern="03[0-9]{2}(?!1234567)(?!1111111)(?!7654321)[0-9]{7}" maxlength="12"
                          oninvalid="setCustomValidity('Please enter valid contact no ')"
                          onchange="try{setCustomValidity('')}catch(e){}" >
                        </div>
                        
                      </div>
                      <div class="line"></div>
                      <div class="form-group row">
                        
                         <label class="col-md-2 form-control-label">Authorization Level:</label>
                   <div class="col-md-4 select mb-3">
                          <select  name="authorizationLevel"  id="authorizationLevel" onkeyup='saveValue(this);' onchange="showDiv('monitoringServerAccess', this)" class="form-control">
                            <option value="local" selected="selected">Local</option>
                            <option value="admin" selected="selected">Admin</option>
                          </select>
                        </div>
                      </div>
                      
                      <div class="line"></div>
                      <div style="display: none;" id="monitoringServerAccess">
                      <div class="form-group row">
                        <div class="col-md-4">
                          <div class="custom-control custom-checkbox">
                            <input id="webServerAccess" name="webServerAccess" value ="yes" type="checkbox" class="custom-control-input">
                            <label for="webServerAccess" class="custom-control-label">Web Server Access</label>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="custom-control custom-checkbox">
                            <input id="proxyServerAccess" name="proxyServerAccess" value="yes" type="checkbox" class="custom-control-input">
                            <label for="proxyServerAccess" class="custom-control-label">Proxy Server Access</label>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="custom-control custom-checkbox">
                            <input id="dnsServerAccess" name="dnsServerAccess" value="yes" type="checkbox" class="custom-control-input">
                            <label for="dnsServerAccess" class="custom-control-label">DNS Access</label>
                          </div>
                        </div>
                      </div>
                      </div>
                    <div class="line"></div>
                          <div class="form-group row" style="float: right;">
                          <div class="col-md-6">
                          <button name="register" type="submit" value="Register" class="btn btn shadow px-5" style="margin-right: 15px;background-color: #28bebd ;">Register</button>
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
       