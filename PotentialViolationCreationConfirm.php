<!doctype html>
<html>
<head>
  <title>Recall Confirmation</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="stylesheet.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
      <img src="CPSCLOGO.png" height=5% width=5% />
  <ul class="nav nav-tabs">
  <li><a href="clientLanding.php">Home</a></li>
  <li><a href="clientListingsPage.php">Your Listings</a></li>
  <li><a href="clientCurrentLoads.php">Loads in Transit</a></li>
  <li><a href="clientPastLoads.php">Past Loads</a></li>
  <li><a href="createListing.php">Create Listing</a></li>
    <li><a href="clientAccountManagement.php">Manage Account</a></li>
</ul>
  <?php
    session_start();

    if(isset($_SESSION['recall_ID']))$recall_ID = $_SESSION['recall_ID'];
    if(isset($_SESSION['recall_Number']))$recall_Number = $_SESSION['recall_Number'];
    if(isset($_SESSION['Potential_Violation_URL']))$Potential_Violation_URL=$_SESSION['Potential_Violation_URL'];
    if(isset($_SESSION['recall_URL']))$recall_URL=$_SESSION['recall_URL'];

    require_once("db.php");
    $tracker=0;

    $sql = "insert into potential_violation
            (    recall_ID,   recall_Number,   Potential_Violation_URL, 	Potential_Violation_Review_Status, Potential_Violation_Review_Date, Employee_ID)
            values ('$recall_ID', '$recall_Number','$Potential_Violation_URL', FALSE, NULL, NULL)";
         $result=$mydb->query($sql);

         if ($result==1) {

           $sql = "select * from potential_violation where recall_ID='$recall_ID' and
                recall_Number='$recall_Number'";
                $result=$mydb->query($sql);
                while($row = mysqli_fetch_array($result)) {
           echo "<div><p>A new potential violation has been added to the database:</p></br>";

           echo "<table style='background-color:white;'>
              <tr>

                <th>  recall_ID </th>
                <th>  recall Number </th>
                <th>  Potential_Violation_URL  </th>
                <th>  Potential_Violation_Review_Status  </th>
                <th>  Potential_Violation_Review_Date </th>
                <th>  Employee_ID </th>
              </tr>
              <tr>
                <td>".$row['Recall_ID']."</td>
                <td>".$row['Recall_Number']."</td>
                <td>".$row['Potential_Violation_URL']."</td>
                <td>".$row['Potential_Violation_Review_Status']."</td>
                <td>".$row['Potential_Violation_Review_Date']."</td>
                <td>".$row['Employee_ID']."</td>
              </tr>
            </table></div>";
                   }
         }
         else
         {
           $sql= "delete from listing where recall_ID='$recall_ID' and
                recall_Number='$recall_Number' and
                recall_date='$recall_date' and
                recall_Description='$recall_Description' and
                recall_title='$recall_title' and
                recall_Product_Name='$recall_Product_Name' and
                recall_URL='$recall_URL'";
                $result=$mydb->query($sql);
           echo "<div>an error occured, please try again</div>";
         }
  ?>
  <p style='margin-left: auto; display: block; margin-right: auto;'>
    <a style="background-color:white;" href="logout.php">Click here to log out</a>
  </p>
</body>
</html>
