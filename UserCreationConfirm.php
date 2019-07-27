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
    <li class="active"><a href="clientAccountManagement.php">Create Account</a></li>
</ul>
  <?php
    session_start();

    if(isset($_SESSION['user_account_username']))$user_account_username = $_SESSION['user_account_username'];
    if(isset($_SESSION['user_account_Password']))$user_account_Password = $_SESSION['user_account_Password'];
    echo $user_account_Password;
    echo $user_account_username;
    require_once("db.php");
    $tracker=0;

    $sql = "insert into user_account
            (    user_account_username,   user_account_Password)
            values ('$user_account_username', '$user_account_Password')";
         $result=$mydb->query($sql);

         if ($result==1) {

           $sql = "select * from user_account where user_account_username='$user_account_username' and
                user_account_Password='$user_account_Password'";
                $result=$mydb->query($sql);
                while(($row = mysqli_fetch_array($result)) && $tracker==0) {
           echo "<div><p>A new user has been added to the database:</p></br>";

           echo "<table style='background-color:white;'>
              <tr>

                <th>  user_account_username </th>
                <th>  User_account_Password </th>
                <th>  user_account_ID  </th>
              <tr>
                <td>".$row['user_account_username']."</td>
                <td>".$row['user_account_Password']."</td>
                <td>".$row['user_account_ID']."</td>
              </tr>
            </table></div>";
            $tracker=1;
                   }
         }
         else
         {
           $sql= "delete from listing where user_account_username='$user_account_username' and
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
