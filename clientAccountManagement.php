<?php
session_start();
    require_once("db.php");
?>
<html>
<head>
  <title>Account Management</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="stylesheet.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
      <img src="CPSCLOGO.png" height=5% width=5% />
  <ul class="nav nav-tabs">
    <li><a href="clientLanding.php">Home</a></li>
    <li><a href="clientListingsPage.php">Recalls</a></li>
    <li><a href="clientCurrentLoads.php">Potential Violations</a></li>
    <li><a href="clientPastLoads.php">Processed Potential Violations</a></li>
    <li><a href="createListing.php">Add Recalls</a></li>
    <li><a href="clientAccountManagement.php">Manage Account</a></li>
  <li class="active"><a href="createAccounts.php">Create Accounts</a></li>
</ul>
  <?php
    if (isset($_SESSION['user_account_ID'])) $user_account_ID=$_SESSION['user_account_ID'];
    if (isset($_SESSION['user_account_username'])) $user_account_username=$_SESSION['user_account_username'];
      if (isset($_POST["DeleteAccount"])) {
          if(isset($_POST["user_account_ID"])) $_SESSION['user_account_ID']=$_POST["user_account_ID"];
          $sql="delete from user_account where user_account_ID='$user_account_ID'";
          $mydb->query($sql);
          Header("Location:  clientAccountManagement.php");
        }


    $sql="select distinct * from user_account where user_account_ID='$user_account_ID'";
    $result = $mydb->query($sql);
    while($row=mysqli_fetch_array($result)){
      echo "<div style='margin-left: auto; display: block; margin-right: auto;width: 300px;'><table>
      <tr>
      <th>Client Information</th>
      <th></th>
      </tr>
  <tr>
    <td>user_account_ID</td>
    <td>".$row['user_account_ID']."</td>
  </tr>
  <tr>
    <td>user_account_username</td>
    <td>".$row['user_account_username']."</td>
  </tr>
  <tr>
    <td>
    </td>
    <td><form method='post'
        action='".$_SERVER['PHP_SELF']."'>
          <input type='submit' name='DeleteAccount' value='Delete Account' />
          <input type='hidden' name='user_account_ID' value='".$row['user_account_ID']."' />
        </form>
    </td>
  </tr>";
echo "</table></div>";
    }
$sql="select * from user_account left join employee on user_account.user_account_ID=employee.user_account_ID"
   ?>
   <div style='margin-left: auto; display: block; margin-right: auto;width: 1200px;'>
   <table>
   <tr>
     <th>  user_account_username &nbsp;</th>
     <th>  user_account_password &nbsp;</th>
     <th>  employee_ID  &nbsp;</th>
     <th>  admin boolean</th>
     <th>  Delete Account</th>
   </tr>
   <?php
   $result = $mydb->query($sql);

     while($row = mysqli_fetch_array($result)) {
       echo "<tr><td>".$row['user_account_username']."</td>
       <td>".$row['user_account_Password']."</td>
       <td>".$row['employee_ID']."</td>
       <td>".$row['Employee_Admin_Boolean']."</td>
       <td><form method='post'
           action='".$_SERVER['PHP_SELF']."'>
             <input type='submit' name='DeleteAccount' value='Delete Account' />
             <input type='hidden' name='user_account_ID' value='".$row['user_account_ID']."' />
           </form></td></tr>
       ";
     }
       ?>
   <p><a href="logout.php">Click here to log out</a></p>
</body>
</html>
