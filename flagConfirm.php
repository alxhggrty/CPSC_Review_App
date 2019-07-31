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
    <li><a href="clientListingsPage.php">Recalls</a></li>
    <li><a href="clientCurrentLoads.php">Potential Violations</a></li>
    <li><a href="clientPastLoads.php">Processed Potential Violations</a></li>
    <li><a href="createListing.php">Add Recalls</a></li>
    <li><a href="clientAccountManagement.php">Manage Account</a></li>
</ul>
  <?php
    session_start();
$recall_ID='';
$recall_Number='';
$User_account_ID='';
$Potential_Violation_URL='';
    if(isset($_SESSION['recall_ID']))$recall_ID = $_SESSION['recall_ID'];
    if(isset($_SESSION['recall_Number']))$recall_Number = $_SESSION['recall_Number'];
    if(isset($_SESSION['Potential_Violation_URL']))$Potential_Violation_URL=$_SESSION['Potential_Violation_URL'];
    if(isset($_SESSION['user_account_ID']))$User_account_ID=$_SESSION['user_account_ID'];
    echo $recall_ID.$recall_Number.$Potential_Violation_URL.$User_account_ID;

    require_once("db.php");
    $tracker=0;

    $sql = "insert into flag
            (    recall_ID,   recall_Number,   Potential_Violation_URL, User_account_ID)
            values ('$recall_ID', '$recall_Number','$Potential_Violation_URL', $User_account_ID)";
         $result=$mydb->query($sql);
echo $sql;
         if ($result==1) {

           $sql = "select * from flag where recall_ID='$recall_ID' and
                recall_Number='$recall_Number' and User_account_ID=$User_account_ID";
                $result=$mydb->query($sql);
                while(($row = mysqli_fetch_array($result)) && $tracker==0) {
           echo "<div><p>A new flag has been added to the database:</p></br>";

           echo "<table style='background-color:white;'>
              <tr>

                <th>  recall_ID </th>
                <th>  recall Number </th>
                <th>  Potential_Violation_URL  </th>
                <th>  User_account_ID </th>
              </tr>
              <tr>
                <td>".$row['Recall_ID']."</td>
                <td>".$row['Recall_Number']."</td>
                <td>".$row['Potential_Violation_URL']."</td>
                <td>".$row['User_account_ID']."</td>
              </tr>
            </table></div>";
            $tracker=1;
                   }
         }
        
  ?>
  <p style='margin-left: auto; display: block; margin-right: auto;'>
    <a style="background-color:white;" href="logout.php">Click here to log out</a>
  </p>
</body>
</html>
