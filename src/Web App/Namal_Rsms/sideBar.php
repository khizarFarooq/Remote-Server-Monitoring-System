<div id="sidebar" class="sidebar py-3" style="background-color: #3b4856">
        <ul class="sidebar-menu list-unstyled">
              <li class="sidebar-list-item"><a href="index.php" class="sidebar-link text-muted"><img src="img/dashBoard.png" style="width:38px;height:38px;margin-left: 5px;"><span style="color: #28bebd">Dashboard</span></a></li>
              <?php
if ($_SESSION['authorizationLevel']=="admin") {
?>
               <li><a href="addNewUser.php" class="sidebar-link text-muted"><img src="img/addUser.png" style="width:40px;height:38px;margin-left: 5px;"><span style="color: #28bebd">Add User</span></a></li>
               
            
              
              <li class="sidebar-list-item"><a href="configUser.php" class="sidebar-link text-muted"><img src="img/configUser.png" style="width:40px;height:38px;margin-left: 5px;"><span style="color: #28bebd">Configure User</span></a></li>
              <li class="sidebar-list-item"><a href="add_New_Server.php" class="sidebar-link text-muted"><img src="img/addServer.png" style="width:40px;height:34px;margin-left: 5px;margin-right: 5px;"><span style="color: #28bebd">Add Server</span></a></li>
              <?php
}
?>
<?php
if (($_SESSION['authorizationLevel']=="admin")||(($_SESSION['authorizationLevel']=="local")&&($_SESSION['dnsAccess']=="yes"))) {
?>
              <li class="sidebar-list-item"><a href="configDNS.php" class="sidebar-link text-muted"><img src="img/dns_server.png" style="width:40px;height:34px;margin-left: 5px;margin-right: 5px;"><span style="color: #28bebd">Configure DNS Server</span></a></li>
           <?php
}
?>   
<?php
if (($_SESSION['authorizationLevel']=="admin")||(($_SESSION['authorizationLevel']=="local")&&($_SESSION['proxyServerAccess']=="yes"))) {
?>
              <li class="sidebar-list-item"><a href="configProxy.php" class="sidebar-link text-muted"><img src="img/proxy_server.png" style="width:40px;height:34px;margin-left: 5px;margin-right: 5px;"><span style="color: #28bebd">Configure Proxy Server</span></a></li>
   <?php
}
?>  
<?php
if (($_SESSION['authorizationLevel']=="admin")||(($_SESSION['authorizationLevel']=="local")&&($_SESSION['webServerAccess']=="yes"))) {
?>          
              <li class="sidebar-list-item"><a href="configWeb.php" class="sidebar-link text-muted"><img src="img/web_server.png" style="width:40px;height:34px;margin-left: 5px;margin-right: 5px;"><span style="color: #28bebd">Configure Web Server</span></a></li>
               <?php
}
?>
              
			  <li class="sidebar-list-item"><a href="logout.php" class="sidebar-link text-muted"><img src="img/logOut.png" style="width:40px;height:34px;margin-left: 5px;margin-right: 5px;"><span style="color: #28bebd">Log out</span></a></li>

        </ul>
      </div>