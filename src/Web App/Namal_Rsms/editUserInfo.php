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
           header("location:editUserInfo.php"); 
      } 
 }  
if(isset($_GET['editUser'])){
  $ID=$_GET['editUser'];
  $query="SELECT `ID`,`Name`, `Password`, `Email`, `Contact_no`, `Authorization_level`,`webServer_Access`,`proxyServer_Access`,`dnsServer_Access`FROM `user_accounts_info` Where ID=$ID";

$result = mysqli_query($con,$query);
if (!$result) exit("The query did not succeded");
else {
    while ($row = mysqli_fetch_array($result)) {
        $name=$row['Name'];
        $password=$row['Password'];
        $email=$row['Email'];
        $contactNo=$row['Contact_no'];
        $authorizationLevel=$row['Authorization_level'];
        $webServerAccess=$row['webServer_Access'];
        $proxyServerAccess=$row['proxyServer_Access'];
        $dnsServerAccess=$row['dnsServer_Access'];
    }
}
}

?>
    <!DOCTYPE html>
    <html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Update User Info</title>
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

      <body onload="showServerAccessDiv()">
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
                 
                  <div class="card-header" style="text-align: center;background-color: #28bebd">
                    <h3 class="h5 text-uppercase mb-0">General Info</h3>
                  </div>
                  <div class="card-body" style="text-align: center;">

                    <form name ="add_New_User" class="form-horizontal" #signupForm="ngForm"  method="post" action="updateUserInfo.php">
                      <div class="form-group row">
                        <label class="col-md-2 form-control-label">Name :</label>
                        <div class="col-md-4">
                          <input class="form-control"  name= "name"  value="<?php echo $name; ?>" type="text" placeholder="Name"  id="name"class="form-control" required> </div>
                        <label class="col-md-2 form-control-label">Password :</label>
                        <div class="col-md-4">
                          <input class="form-control"  name= "password"  value="<?php echo $password; ?>" type="password" placeholder="Password" class="form-control" required> </div>                          
                      </div>
                      <div class="line"></div>
                      <div class="form-group row">
                        <label class="col-md-2 form-control-label">Email Address :</label>
                        <div class="col-md-4">
                          <input class="form-control" type="text" name="email"  value="<?php echo $email; ?>" placeholder="Email Address" class="form-control" required>                        
                        </div>
                        <label class="col-md-2 form-control-label">Contact No :</label>
                        <div class="col-md-4">
                          <input class="form-control" type="text" name="contactNo"  value="<?php echo $contactNo; ?>"  placeholder="Contact No" class="form-control" required>
                        </div>
                      </div>
                      <div class="line"></div>
                      <div class="form-group row">
                        
                         <label class="col-md-2 form-control-label">Authorization Level:</label>
                   <div class="col-md-4 select mb-3">
                          <select  name="authorizationLevel" onchange="showDiv('monitoringServerAccess', this)" class="form-control"> 
                            <option value="choose">Choose</option>
                            <option value="admin" <?=$authorizationLevel == 'admin' ? ' selected="selected"' : '';?>>Admin</option>
                            <option value="local" <?=$authorizationLevel == 'local' ? ' selected="selected"' : '';?>>Local</option>
                          </select>
                        </div>
                      </div>
                      <div class="line"></div>
                      <div style="display: none;" id="monitoringServerAccess">
                      <div class="form-group row">
                        <div class="col-md-4">
                          <div class="custom-control custom-checkbox">
                            <input id="webServerAccess" name="webServerAccess" value ="yes" type="checkbox" class="custom-control-input" <?php if($webServerAccess=="yes"){echo "checked";}?>>
                            <label for="webServerAccess" class="custom-control-label">Web Server Access</label>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="custom-control custom-checkbox">
                            <input id="proxyServerAccess" name="proxyServerAccess" value="yes" type="checkbox" class="custom-control-input"<?php if($proxyServerAccess=="yes"){echo "checked";}?>>
                            <label for="proxyServerAccess" class="custom-control-label">Proxy Server Access</label>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="custom-control custom-checkbox">
                            <input id="dnsServerAccess" name="dnsServerAccess" value="yes" type="checkbox" class="custom-control-input"<?php if($dnsServerAccess=="yes"){echo "checked";}?>>
                            <label for="dnsServerAccess" class="custom-control-label">DNS Access</label>
                          </div>
                        </div>
                      </div>
                      </div>
                    <div class="line"></div>
                          <div class="form-group row" style="float: right;">
                          <div class="col-md-6">
                          <button id="submit" type="submit" name="userId" <?php echo 'value='.$ID.'' ?>  onclick="validateForm()" class="btn btn shadow px-5" style="margin-right: 15px;background-color: #28bebd ;">Update</button>
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
       <script type="text/javascript">
  document.getElementById("username").value = getSavedValue("username"); 
 //Save the value function - save it to localStorage as (ID, VALUE)
        function saveValue(e){
            var id = e.id;  // get the sender's id to save it . 
            var val = e.value; // get the value. 
            localStorage.setItem(id, val);// Every time user writing something, the localStorage's value will override . 
        }
        //get the saved value function - return the value of "v" from localStorage. 
        function getSavedValue  (v){
            if (!localStorage.getItem(v)) {
                return "";// You can change this to your defualt value. 
            }
            return localStorage.getItem(v);
        }
function validateForm() {
  var email=document.forms["add_New_User"]["email"].value;
  var contactNo=document.forms["add_New_User"]["contactNo"].value;
  var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  var contactFormat= /^\d{10}$/;
  var authorizationLevel=document.forms["add_New_User"]["authorizationLevel"].value;
  var btn = document.getElementById("submit");

if(! email.match(mailformat))
{
window.alert("You have entered an invalid email address !  ");
email.focus();
return false;
}
else
  if(! contactNo.match(contactFormat))
{
window.alert("You have entered an invalid contact No !");
contactNo.focus();
return false;
}
else
  if(authorizationLevel=="choose")
{
window.alert("Please select authorization Level!");
authorizationLevel.focus();
return false;
}
else
  if((! email.match(mailformat)) || (! contactNo.match(contactFormat)) ){
  window.alert("You have entered an invalid contact No Or Email address !");
  return false;
}
else {
 return true;
}
}
function showDiv(divId, element)
{
    document.getElementById(divId).style.display = element.value == "local" ? 'block' : 'none';
}
function showServerAccessDiv(){
  var authorizationLevel=document.forms["add_New_User"]["authorizationLevel"].value;
  document.getElementById('monitoringServerAccess').style.display = authorizationLevel == "local" ? 'block' : 'none';
  
}
</script>