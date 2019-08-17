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
?>
<html>
<head>
  <title>recall Confirmation</title>

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
  <li><a href='clientAccountManagement.php'>Manage Accounts</a></li>
  <li class='active'><a href='createAccounts.php'>Create Accounts</a></li>;";}?>
  </ul>
  <?php

    if(isset($_SESSION['User_Account_Username']))$User_Account_Username = $_SESSION['User_Account_Username'];
    if(isset($_SESSION['User_Account_Password']))$User_Account_Password = $_SESSION['User_Account_Password'];
    if(isset($_SESSION['firstName'])) $firstName = $_SESSION['firstName'];
    if(isset($_SESSION['lastName'])) $lastName = $_SESSION['lastName'];
    if(isset($_SESSION['email'])) $email = $_SESSION['email'];
    if(isset($_SESSION['Admin'])) $Admin = $_SESSION['Admin'];

    $tracker=0;
    $sql = "insert into employee (Employee_Admin)
            values ($Admin);";
            $result=$mydb->query($sql);
    $sql = "Insert into user_account (Employee_Id,User_Account_Username, User_Account_Password, User_Account_FirstName, User_Account_LastName, User_Account_Email)
            VALUES(LAST_INSERT_ID(),'$User_Account_Username','$User_Account_Password','$firstName','$lastName','$email');";
         $result=$mydb->query($sql);

         if ($result==1) {

           $sql = "select * from user_account where User_Account_Username='$User_Account_Username' and
                User_Account_Password='$User_Account_Password'";
                $result=$mydb->query($sql);
                while(($row = mysqli_fetch_array($result)) && $tracker==0) {
           echo "<div><p>A new user has been added to the database:</p></br>";

           echo "<table style='background-color:white;'>
              <tr>

                <th>  user account username </th>
                <th>  User account Password </th>
                <th>  First Name </th>
                <th>  Last Name </th>
                <th>  Email  </th>
              <tr>
                <td>".$row['User_Account_Username']."</td>
                <td>".$row['User_Account_Password']."</td>
                <td>".$row['User_Account_FirstName']."</td>
                <td>".$row['User_Account_LastName']."</td>
                <td>".$row['User_Account_Email']."</td>
              </tr>
            </table></div>";
            $tracker==1;
                   }
         }
         else
         {
           echo "<div>an error occured, please try again</div>";
         }
  ?>
  <p style='margin-left: auto; display: block; margin-right: auto;'>
    <a style="background-color:white;" href="logout.php">Click here to log out</a>
  </p>
</body>
</html>
