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
else{Header("Location:  clientLogin.php");}?>
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
  <li class='active'><a href='createListing.php'>Add recalls</a></li>
  <li><a href='clientAccountManagement.php'>Manage Accounts</a></li>
  <li><a href='createAccounts.php'>Create Accounts</a></li>;";}?>
  </ul>
  <?php

    if(isset($_SESSION['Recall_Id']))$Recall_Id = $_SESSION['Recall_Id'];
    if(isset($_SESSION['Recall_Number']))$Recall_Number = $_SESSION['Recall_Number'];
    if(isset($_SESSION['Recall_Date']))$Recall_Date = $_SESSION['Recall_Date'];
    if(isset($_SESSION['Recall_Description']))$Recall_Description = $_SESSION['Recall_Description'];
    if(isset($_SESSION['Recall_Title']))$Recall_Title=$_SESSION['Recall_Title'];
    if(isset($_SESSION['Recall_Last_Publish_Date']))$Recall_Last_Publish_Date=$_SESSION['Recall_Last_Publish_Date'];
    if(isset($_SESSION['Recall_Product_Name']))$Recall_Product_Name=$_SESSION['Recall_Product_Name'];
    if(isset($_SESSION['Recall_URL']))$Recall_URL=$_SESSION['Recall_URL'];
    echo $Recall_URL;

    require_once("db.php");

    $sql = "insert into recall
            (       Recall_Description,     Recall_Id,   Recall_Number,     Recall_Date,    Recall_Title,Recall_Last_Publish_Date,    Recall_Product_Name,    Recall_URL)
            values ('$Recall_Description', '$Recall_Id', '$Recall_Number', '$Recall_Date', '$Recall_Title','$Recall_Last_Publish_Date', '$Recall_Product_Name', '$Recall_URL')";
         $result=$mydb->query($sql);

         if ($result==1) {

           $sql = "select * from recall where Recall_Id='$Recall_Id' and
                Recall_Number='$Recall_Number' and
                Recall_Date='$Recall_Date' and
                Recall_Description='$Recall_Description' and
                Recall_Title='$Recall_Title'";
                $result=$mydb->query($sql);
                while($row = mysqli_fetch_array($result)){
           echo "<div><p>A new recall has been added to the database:</p></br>";

           echo "<table style='background-color:white; margin:auto;'>
              <tr>
                <th>  Recall URL </th>
                <th>  Recall Description  </th>
                <th>  Recall Id </th>
                <th>  recall Number </th>
                <th>  Recall Date  </th>
                <th>  Recall Title  </th>
                <th>  Recall Product Name </th>
              </tr>
              <tr>
                <td>".$row['Recall_URL']."</td>
                <td>".$row['Recall_Description']."</td>
                <td>".$row['Recall_Id']."</td>
                <td>".$row['Recall_Number']."</td>
                <td>".$row['Recall_Date']."</td>
                <td>".$row['Recall_Title']."</td>
                <td>".$row['Recall_Product_Name']."</td>
              </tr>
            </table></div>";
                   }
         }
         else
         {
           $sql= "delete from listing where Recall_Id='$Recall_Id' and
                Recall_Number='$Recall_Number' and
                Recall_Date='$Recall_Date' and
                Recall_Description='$Recall_Description' and
                Recall_Title='$Recall_Title' and
                Recall_Product_Name='$Recall_Product_Name' and
                Recall_URL='$Recall_URL'";
                $result=$mydb->query($sql);
           echo "<div>an error occured, please try again</div>";
         }
  ?>
  <center><p style='margin-left: auto; display: block; margin-right: auto;'>
    <a style="position: fixed; bottom: 0; background-color:white;" href="logout.php">Click here to log out</a>
  </p></center>
</body>
</html>
