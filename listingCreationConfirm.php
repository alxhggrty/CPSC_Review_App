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
      <img src="reynholm.png" height=5% width=5% />
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
    if(isset($_SESSION['recall_date']))$recall_date = $_SESSION['recall_date'];
    if(isset($_SESSION['recall_Description']))$recall_Description = $_SESSION['recall_Description'];
    if(isset($_SESSION['recall_title']))$recall_title=$_SESSION['recall_title'];
    if(isset($_SESSION['recall_Last_Publish_Date']))$recall_Last_Publish_Date=$_SESSION['recall_Last_Publish_Date'];//for integration with login page
    if(isset($_SESSION['recall_Product_Name']))$recall_Product_Name=$_SESSION['recall_Product_Name'];
    if(isset($_SESSION['recall_URL']))$recall_URL=$_SESSION['recall_URL'];
    echo $recall_URL;

    require_once("db.php");

    $sql = "insert into recall
            (       recall_Description,     recall_ID,   recall_Number,     recall_date,    recall_title,recall_Last_Publish_Date,    recall_Product_Name,    recall_URL)
            values ('$recall_Description', '$recall_ID', '$recall_Number', '$recall_date', '$recall_title','$recall_Last_Publish_Date', '$recall_Product_Name', '$recall_URL')";
         $result=$mydb->query($sql);

         if ($result==1) {

           $sql = "select * from recall where recall_ID='$recall_ID' and
                recall_Number='$recall_Number' and
                recall_date='$recall_date' and
                recall_Description='$recall_Description' and
                recall_title='$recall_title'";
                $result=$mydb->query($sql);
                while($row = mysqli_fetch_array($result)){
           echo "<div><p>A new Recall has been added to the database:</p></br>";

           echo "<table style='background-color:white;'>
              <tr>
                <th>  recall_URL </th>
                <th>  recall_Description  </th>
                <th>  recall_ID </th>
                <th>  recall Number </th>
                <th>  recall_date  </th>
                <th>  recall_title  </th>
                <th>  recall_Product_Name </th>
              </tr>
              <tr>
                <td>".$row['recall_URL']."</td>
                <td>".$row['recall_Description']."</td>
                <td>".$row['recall_ID']."</td>
                <td>".$row['recall_Number']."</td>
                <td>".$row['recall_date']."</td>
                <td>".$row['recall_title']."</td>
                <td>".$row['recall_Product_Name']."</td>
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
