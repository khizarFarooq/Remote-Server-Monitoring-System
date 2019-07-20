<?php
include('session.php');
include('databaseConnection.php');
 if(isset($_POST['insert']))  
 {
  $file= addslashes(file_get_contents($_FILES['image']['tmp_name']));
  $query = "UPDATE user_accounts_info SET profileImage=('$file') WHERE Name= '".$_SESSION['userName']."'";
      if(mysqli_query($con, $query))  
      {  
           header("location:configUser.php"); 
      } 
 }  
$query="SELECT `ID`,`Name`, `Password`, `Email`, `Contact_no`, `Authorization_level`,`webServer_Access`,`proxyServer_Access`,`dnsServer_Access`FROM `user_accounts_info`";
$result = mysqli_query($con,$query);

if(isset($_GET['delUser'])){
  $ID=$_GET['delUser'];
  echo $ID;
}
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Configure User</title>
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
.edit_btn {
    text-decoration: none;
    padding: 2px 5px;
    background: #2E8B57;
    color: white;
    border-radius: 3px;
}

.del_btn {
    text-decoration: none;
    padding: 2px 5px;
    color: white;
    border-radius: 3px;
    background: #800000;
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
              <div class="col-lg-12 mb-5">
                <form id="form" name="form">
                <div class="card">
                  <div class="card-header" style="background-color: #28bebd">
                    <center ><h6 class="text-uppercase mb-0" >User Account Info</h6></center>
                  </div>
                  <div class="card-body"> 
                  <div class="scrollable">
                   <table class="table table-bordered text-center"style="background-color: #e4eaec" >                     
    <div class="table responsive">
        <thead >
            <tr class="table-active">
              <!-- <th >Id</th> -->
                          <th>Name</th>
                          <th >Password</th>
                          <th>Email</th>
                          <th >Cell No</th>
                          <th >Permission</th>
                          <th >Web Server Access</th>
                          <th >Proxy Server Access</th>
                          <th>DNS Access</th>
                          <th>Action</th>
            </tr>
        </thead>
        <tbody>
<?php while($row = $result->fetch_assoc()) { ?>
      <tr class="table-info">
        <!-- <td><?php echo $row['ID']; ?></td> -->
        <td><?php echo $row['Name']; ?></td>
        <td><?php echo $row['Password']; ?></td>
        <td><?php echo $row['Email']; ?></td>
        <td><?php echo $row['Contact_no']; ?></td>
        <td><?php echo $row['Authorization_level']; ?></td>
        <td><?php echo $row['webServer_Access']; ?></td>
        <td><?php echo $row['proxyServer_Access']; ?></td>
        <td><?php echo $row['dnsServer_Access']; ?></td>
        <td style='white-space: nowrap'><a class="edit_btn" href="editUserInfo.php?editUser=<?php echo $row['ID']; ?>">Edit</a>
          <a class="del_btn" href="deleteUserAccount.php?delUser=<?php echo $row['ID']; ?>">Del</a></td>
      </tr>
    <?php } ?>
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
    <script type="text/javascript">
      function removeUser(){
        alert("test");
      }
    </script>
  </body>
</html>