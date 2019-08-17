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
//gets session variables passed from the detail view edit
      $Recall_Id = $_SESSION["Recall_Id"];
      $Recall_Number = $_SESSION["Recall_Number"];
      $Recall_Date = $_SESSION["Recall_Date"];
      $Recall_Description = $_SESSION["Recall_Description"];
      $Recall_Title=$_SESSION["Recall_Title"];
      $Recall_Last_Publish_Date=$_SESSION['Recall_Last_Publish_Date'];
      $Recall_Product_Name=$_SESSION['Recall_Product_Name'];
      $Recall_URL=$_SESSION['Recall_URL'];
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
  <title>Success</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="stylesheet.css" />
</head>
<body>
  <a href="clientLanding.php"><img src="CPSCLOGO.png" height=5% width=5% /></a>
  <ul class="nav nav-tabs">
  <li class="active"><a href="clientLanding.php">Home</a></li>
  <li><a href="clientListingsPage.php">recalls</a></li>
  <li><a href="PotentialViolationListingsPage.php">Potential Violations</a></li>
  <?php if($Administrator==TRUE){echo "<li><a href='FlaggedPotentialViolationListingsPage.php'>flagged Potential Violations</a></li>
  <li><a href='ProcessedPotentialViolations.php'>Processed Potential Violations</a></li>
  <li><a href='createListing.php'>Add recalls</a></li>
  <li><a href='clientAccountManagement.php'>Manage Accounts</a></li>
  <li><a href='createAccounts.php'>Create Accounts</a></li>;";}?>
  </ul>
<div style='margin-left: auto; display: block; margin-right: auto;width: 650px;'>
  <?php



//does the update
    $sql = "update recall set Recall_Description='$Recall_Description',
    Recall_Date='$Recall_Date', Recall_Title='$Recall_Title',Recall_Product_Name='$Recall_Product_Name',
    Recall_URL='$Recall_URL'where Recall_Id=$Recall_Id and Recall_Number='$Recall_Number';";

         $result=$mydb->query($sql);
//gives a readout of what the update sent to the database, allows for review
         if ($result==1) {


           $sql = "select * from recall where Recall_Id='$Recall_Id' and Recall_Number=$Recall_Number";
                $result=$mydb->query($sql);
                while($row = mysqli_fetch_array($result)){
           echo "<p>An edited recall is now posted:</p></br>";

           echo "<table style='background-color:white;'>
              <tr>
                <th>  recall ID </th>
                <th>  recall Number  </th>
                <th>  recall Date </th>
                <th>  recall Description </th>
                <th>  recall Title  </th>
                <th>  Last Publish Date  </th>
                <th>  recall Product Name </th>
                <th>  recall URL </th>
              </tr>
              <tr>
                <td>".$row['Recall_Id']."</td>
                <td>".$row['Recall_Number']."</td>
                <td>".$row['Recall_Date']."</td>
                <td>".$row['Recall_Description']."</td>
                <td>".$row['Recall_Title']."</td>
                <td>".$row['Recall_Last_Publish_Date']."</td>
                <td>".$row['Recall_Product_Name']."</td>
                <td>".$row['Recall_URL']."</td>
              </tr>
            </table>";
                   }
         }
         else
         {
           echo "an error occured, please try again and ensure that the data is valid.";
         }
  ?>
</div>
<p><a style='background:white' href="clientListingsPage.php">Click Here to Return to the recalls Page</a></p>
<p><a href="logout.php" style='background:white'>Click here to log out</a></p>
</body>
</html>
