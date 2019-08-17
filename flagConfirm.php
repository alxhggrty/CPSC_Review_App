<?php
session_start();
require_once("db.php");
$Administrator=FALSE;
if(isset($_COOKIE["User_Account_Id"]) &&(isset($_COOKIE["User_Account_Password"])) && (isset($_COOKIE["User_Account_Username"]))) {
  $User_Account_Id=$_COOKIE["User_Account_Id"];
  $User_Account_Password=$_COOKIE['User_Account_Password'];
  $User_Account_Username=$_COOKIE['User_Account_Username'];

  $sql="select Employee_Admin from user_account, employee where User_Account_Id='$User_Account_Id' and User_Account_Password='$User_Account_Password'
  and User_Account_Username='$User_Account_Username' and user_account.Employee_Id=employee.Employee_Id;";
  $result = $mydb->query($sql);
  if($result->num_rows == 0){Header("Location:  clientLogin.php");}
  else{
  while($row=mysqli_fetch_array($result)){
  if($row['Employee_Admin']){$Administrator=1;}
        }
      }
    }
else{Header("Location:  clientLogin.php");}
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
  <li class="active"><a href="PotentialViolationListingsPage.php">Potential Violations</a></li>
  <?php if($Administrator==TRUE){echo "<li><a href='FlaggedPotentialViolationListingsPage.php'>flagged Potential Violations</a></li>
  <li><a href='ProcessedPotentialViolations.php'>Processed Potential Violations</a></li>
  <li><a href='createListing.php'>Add recalls</a></li>
  <li><a href='clientAccountManagement.php'>Manage Accounts</a></li>
  <li><a href='createAccounts.php'>Create Accounts</a></li>;";}?>
  </ul>
  <?php
$Recall_Id='';
$Recall_Number='';
$User_Account_Id='';
$Potential_Violation_URL='';
    if(isset($_SESSION['Recall_Id']))$Recall_Id = $_SESSION['Recall_Id'];
    if(isset($_SESSION['Recall_Number']))$Recall_Number = $_SESSION['Recall_Number'];
    if(isset($_SESSION['Potential_Violation_URL']))$Potential_Violation_URL=str_replace("'","''",$_SESSION['Potential_Violation_URL']);
    if(isset($_COOKIE['User_Account_Id']))$User_Account_Id=$_COOKIE['User_Account_Id'];

    $tracker=0;

    $sql = "insert into flag
            (    Recall_Id,   Recall_Number,   Potential_Violation_URL, User_Account_Id)
            values ('$Recall_Id', '$Recall_Number','$Potential_Violation_URL', $User_Account_Id);";
         $result=$mydb->query($sql);

         if ($result==1) {

           $sql = "select * from flag, user_account where Recall_Id='$Recall_Id' and
                Recall_Number='$Recall_Number' and flag.User_Account_Id=user_account.User_Account_Id and flag.User_Account_Id=$User_Account_Id;";
                $result=$mydb->query($sql);
                while(($row = mysqli_fetch_array($result)) && $tracker==0) {
           echo "<div><p>A new flag has been added to the database:</p></br>";

           echo "<table style='background-color:white;margin:auto;'>
              <tr>

                <th>  Potential Violation URL  </th>
                <th>  User Name </th>
                <th>  User ID </th>
              </tr>
              <tr>

                <td>".$row['Potential_Violation_URL']."</td>
                <td>".$row['User_Account_FirstName']." ".$row['User_Account_LastName']."</td>
                <td>".$row['User_Account_Id']."</td>
              </tr>
            </table></div>";
            $tracker=1;
                   }
         }

  ?>
  <center><p style='margin-left: auto; display: block; margin-right: auto;'>
    <a style="position: fixed; bottom: 0; background-color:white;" href="logout.php">Click here to log out</a>
  </p></center>
</body>
</html>
