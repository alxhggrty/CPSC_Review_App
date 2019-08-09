<?php
  session_start();
//gets session variables passed from the detail view edit
      if(isset($_SESSION['recall_ID']))$recall_ID = $_SESSION["recall_ID"];
      if(isset($_SESSION['recall_URL']))$recall_URL = $_SESSION["recall_URL"];
      if(isset($_SESSION['recall_Number']))$recall_Number = $_SESSION["recall_Number"];
      if(isset($_SESSION['recall_Product_Name']))$recall_Product_Name = $_SESSION["recall_Product_Name"];
      if(isset($_SESSION['Potential_Violation_URL']))$Potential_Violation_URL=$_SESSION['Potential_Violation_URL'];
      $employee_ID='';
?>
<html>
<head>
  <title>Success</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="stylesheet.css" />
</head>
<body>
  <img src="CPSCLOGO.png" height=5% width=5% />
  <ul class="nav nav-tabs">
  <li><a href="clientLanding.php">Home</a></li>
  <li class="active"><a href="clientListingsPage.php">Recalls</a></li>
  <li><a href="clientCurrentLoads.php">Potential Violations</a></li>
  <li><a href="clientPastLoads.php">Processed Potential Violations</a></li>
  <li><a href="createListing.php">Add Recalls</a></li>
  <li><a href="clientAccountManagement.php">Manage Account</a></li>
</ul>
<div style='margin-left: auto; display: block; margin-right: auto;width: 650px;'>
  <?php
  $msg = "a recalled item has been detected as listed for sale on your site.  ".$Potential_Violation_URL." Has been found to be an example of ".$recall_Product_Name."
   And should therefore be removed from your website in compliance with the laws of the united states. For further information, see".$recall_URL;
  $msg = wordwrap($msg,70);



    require_once("db.php");
    $sql="select employee_ID from employee where user_account_ID='".$_SESSION['user_account_ID']."';";
    $result = $mydb->query($sql);

      while($row = mysqli_fetch_array($result)) {$employee_ID=$row['employee_ID'];};
//does the update
    $sql = "update potential_violation set employee_ID='$employee_ID',
    Potential_Violation_Review_Status=TRUE, potential_violation_resolution=FALSE, Potential_Violation_Review_Date='".date('Y-m-d')."'
    where Recall_ID=$recall_ID and Recall_Number='$recall_Number' and Potential_Violation_URL='$Potential_Violation_URL';";

         $result=$mydb->query($sql);
//gives a readout of what the update sent to the database, allows for review
         if ($result==1) {


           $sql = "select * from potential_violation where recall_ID='$recall_ID' and recall_Number=$recall_Number and Potential_Violation_URL='$Potential_Violation_URL'";
                $result=$mydb->query($sql);
                while($row = mysqli_fetch_array($result)){
           echo "<p>a violation has been marked as not relevant:</p></br>";

           echo "<table style='background-color:white;'>
              <tr>
                <th>  Potential Violation URL </th>
              </tr>
              <tr>
                <td>".$row['Potential_Violation_URL']."</td>
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
<p><a style='background:white' href="clientListingsPage.php">Click Here to Return to the Recalls Page</a></p>
<p><a href="logout.php" style='background:white'>Click here to log out</a></p>
</body>
</html>
