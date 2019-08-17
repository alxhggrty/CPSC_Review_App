<?php
session_start();
require_once("db.php");
$Administrator=FALSE;
if(isset($_COOKIE["User_Account_Id"]) &&(isset($_COOKIE["User_Account_Password"])) && (isset($_COOKIE["User_Account_Username"]))) {
  $User_Account_Id=$_COOKIE["User_Account_Id"];
  $User_Account_Password=$_COOKIE['User_Account_Password'];
  $User_Account_Username=$_COOKIE['User_Account_Username'];

  $sql="select Employee_Admin from user_account, employee where User_Account_Id='$User_Account_Id' and User_Account_Password='$User_Account_Password'
  and User_Account_Username='$User_Account_Username' and user_account.Employee_Id=employee.Employee_Id";
  $result = $mydb->query($sql);
  if($result->num_rows == 0){Header("Location:  clientLogin.php");}
  else{
  while($row=mysqli_fetch_array($result)){
  if($row['Employee_Admin']){$Administrator=1;}
  else{Header("Location:  clientLanding.php");}
        }
      }
    }
else{Header("Location:  clientLogin.php");}

      if (isset($_POST["DeleteAccount"])) {
          if(isset($_POST["User_Account_Id"])) $User_Account_Id=$_POST["User_Account_Id"];
          if(isset($_POST["Employee_Id"])) $Employee_Id=$_POST["Employee_Id"];
          $sql="delete from dispute where User_Account_Id='$User_Account_Id'";
          $mydb->query($sql);
          $sql="delete from user_account where User_Account_Id='$User_Account_Id'";
          $mydb->query($sql);
          $sql="delete from employee where Employee_Id='$Employee_Id'";
          $mydb->query($sql);
          Header("Location:  clientAccountManagement.php");
        }
?>
<html>
<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-145779038-1"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'UA-145779038-1');
</script>
  <title>Account Management</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="stylesheet.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  <a href="clientLanding.php"><img src="CPSCLOGO.png" height=5% width=5% /></a>
  <ul class="nav nav-tabs">
  <li><a href="clientLanding.php">Home</a></li>
  <li><a href="clientListingsPage.php">recalls</a></li>
  <li><a href="PotentialViolationListingsPage.php">Potential Violations</a></li>
  <?php if($Administrator==TRUE){echo "<li><a href='FlaggedPotentialViolationListingsPage.php'>flagged Potential Violations</a></li>
  <li><a href='ProcessedPotentialViolations.php'>Processed Potential Violations</a></li>
  <li><a href='createListing.php'>Add recalls</a></li>
  <li class='active'><a href='clientAccountManagement.php'>Manage Accounts</a></li>
  <li><a href='createAccounts.php'>Create Accounts</a></li>;";}?>
  </ul>
  <?php
    if (isset($_SESSION['User_Account_Id'])) $User_Account_Id=$_SESSION['User_Account_Id'];
    if (isset($_SESSION['User_Account_Username'])) $User_Account_Username=$_SESSION['User_Account_Username'];




$sql="select * from user_account, employee where user_account.Employee_Id=employee.Employee_Id"
   ?>
   <div style='margin-left: auto; display: block; margin-right: auto;width: 900px;'>
   <table style='margin: auto;'>
   <tr>
     <th> username &nbsp;</th>
     <th>  password &nbsp;</th>
     <th>  employee ID  &nbsp;</th>
     <th>  admin? </th>
     <th>  Delete Account</th>
   </tr>
   <?php
   $admin='';
   $result = $mydb->query($sql);

     while($row = mysqli_fetch_array($result)) {
       if($row['Employee_Admin']){$admin="Administrator";}
       else {$admin="general employee";}
       echo "<tr><td>".$row['User_Account_Username']."</td>
       <td>".$row['User_Account_Password']."</td>
       <td>".$row['Employee_Id']."</td>
       <td>".$admin."</td>
       <td><form method='post'
           action='".$_SERVER['PHP_SELF']."'>
             <input type='submit' name='DeleteAccount' value='Delete Account' />
             <input type='hidden' name='User_Account_Id' value='".$row['User_Account_Id']."' />
             <input type='hidden' name='Employee_Id' value='".$row['Employee_Id']."' />
           </form></td></tr>
       ";
     }
       ?>
     </div>
     <center><p style='margin-left: auto; display: block; margin-right: auto;'>
       <a style="position: fixed; bottom: 0; background-color:white;" href="logout.php">Click here to log out</a>
     </p></center>
  </body>
  </html>
