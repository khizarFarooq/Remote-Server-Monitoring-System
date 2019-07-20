
<!-- navbar-->
    <header class="header" >
      <nav class="navbar navbar-expand-lg px-4 py-2 shadow" style="background-color: white"><a href="#" class="sidebar-toggler text-gray-500 mr-4 mr-lg-5 lead"><i class="fas fa-align-left " style="color: black;"></i></a> 
      <h4 class="navbar-brand font-weight-bold text-uppercase text-base" style="margin-left: 60px;color: black;">Namal RSMS</h4>
      <img src="img/logo.svg" style="width: 50px;height: 50px;">

        <ul class="ml-auto d-flex align-items-center list-unstyled mb-0">
          <li class="nav-item dropdown mr-3"><a id="notifications" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle text-gray-400 px-1"><i class="fa fa-bell" style="color: black;font-size:16px"></i><span class="notification-icon" style="background-color: red;"></span></a>
            <div aria-labelledby="notifications" class="dropdown-menu"><a href="#" class="dropdown-item">
               
                <div class="d-flex align-items-center">
                  <a href="viewAlerts.php"><div class="icon icon-lr bg text-white" style="background-color: #28bebd "><i class="fas fa-envelope"></i></div></a>
                    <a href="viewAlerts.php" class="dropdown-item text-center"><small class="font-weight-bold headings-font-family text-uppercase">View Alerts</small></a>
                  
                </div>
            </div>
          </li>
          <form method="post" enctype="multipart/form-data">
          <li class="nav-item dropdown ml-auto"><a id="userInfo" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><?php  
                $selectProfile = "SELECT profileImage FROM user_accounts_info WHERE Name='".$_SESSION['userName']."'";
                $output = mysqli_query($con, $selectProfile);  
                while($row = mysqli_fetch_array($output))  
                {  if ( !empty( $row['profileImage'] ) ) {
 echo '<img src="data:image/jpeg;base64,'.base64_encode($row['profileImage'] ).'" style="max-width: 1.8rem;" class="img-fluid rounded-circle shadow"" /> 
                     '; 
                          }
                          else{
                            echo('<img src="img/userProfile.png" style="max-width: 1.8rem;" class="img-fluid rounded-circle shadow">');
                          }
                      
                          
                     
                }?>  </a>
            <div aria-labelledby="userInfo" class="dropdown-menu"><a href="#" class="dropdown-item"><strong class="d-block text headings-font-family"><?php echo "Name : ".$_SESSION['userName']; ?></strong><strong></strong><?php echo "Authorization Level : ".$_SESSION['authorizationLevel']; ?></strong></a>
              <div class="dropdown-divider"></div><center><input type="file" name="image" id="image"></center>
              <br />  
                     <input type="submit" name="insert" id="insert" value="Insert" class="btn btn" style="background-color: #28bebd" />  
              <div class="dropdown-divider"></div><a href="logout.php" class="dropdown-item">Logout</a>
            </div>
          </li>
          </form>
        </ul>
      </nav>
    </header>