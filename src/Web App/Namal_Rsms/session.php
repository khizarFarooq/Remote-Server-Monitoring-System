  <?php
session_start();
if(!(isset($_SESSION['authorizationLevel']))){
  header("location:login.php");
}
?>