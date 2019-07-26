<?php
  session_start();
//gets session variables passed from the detail view edit
      $recall_ID = $_SESSION["recall_ID"];
      $recall_Number = $_SESSION["recall_Number"];
      $recall_date = $_SESSION["recall_date"];
      $recall_Description = $_SESSION["recall_Description"];
      $recall_title=$_SESSION["recall_title"];
      $recall_Last_Publish_Date=$_SESSION['recall_Last_Publish_Date'];
      $recall_Product_Name=$_SESSION['recall_Product_Name'];
      $recall_URL=$_SESSION['recall_URL'];
?>
<html>
<head>
  <title>Success</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="stylesheet.css" />
</head>
<body>
  <img src="reynholm.jpg" height=5% width=5% />
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



    require_once("db.php");
//does the update
    $sql = "update recall set recall_Description='$recall_Description',
    recall_date='$recall_date', recall_title='$recall_title',recall_Product_Name='$recall_Product_Name',
    recall_URL='$recall_URL'where recall_ID=$recall_ID and recall_Number='$recall_Number';";

         $result=$mydb->query($sql);
//gives a readout of what the update sent to the database, allows for review
         if ($result==1) {


           $sql = "select * from recall where recall_ID='$recall_ID' and recall_Number=$recall_Number";
                $result=$mydb->query($sql);
                while($row = mysqli_fetch_array($result)){
           echo "<p>An edited recall is now posted:</p></br>";

           echo "<table style='background-color:white;'>
              <tr>
                <th>  Recall ID </th>
                <th>  recall Number  </th>
                <th>  recall Date </th>
                <th>  Recall Description </th>
                <th>  Recall Title  </th>
                <th>  Last Publish Date  </th>
                <th>  recall Product Name </th>
                <th>  recall URL </th>
              </tr>
              <tr>
                <td>".$row['recall_ID']."</td>
                <td>".$row['recall_Number']."</td>
                <td>".$row['recall_date']."</td>
                <td>".$row['recall_Description']."</td>
                <td>".$row['recall_title']."</td>
                <td>".$row['recall_Last_Publish_Date']."</td>
                <td>".$row['recall_Product_Name']."</td>
                <td>".$row['recall_URL']."</td>
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
