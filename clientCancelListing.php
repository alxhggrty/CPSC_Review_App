<!doctype html>
<html>
<head>
  <title>Success</title>
</head>
   <link rel="stylesheet" href="stylesheet.css">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<body style="background-color:slategrey;">
  <img src="reynholm.jpg" height=5% width=5% />
<ul class="nav nav-tabs">
<li><a href="clientLanding.php">Home</a></li>
<li><a href="clientListingsPage.php">Your Listings</a></li>
<li><a href="clientCurrentLoads.php">Loads in Transit</a></li>
<li><a href="clientPastLoads.php">Past Loads</a></li>
<li><a href="createListing.php">Create Listing</a></li>
<li><a href="clientAccountManagement.php">Manage Account</a></li>
<li class="active"><a href="">Cancel Listing</a></li>
</ul>
<div style='margin-left: auto; display: block; margin-right: auto;width: 650px;'>
  <?php
    session_start();
    $recall_ID=$_SESSION['recall_ID'];
    $recall_Number=$_SESSION['$recall_Number'];


    require_once("db.php");

    $sql = "delete from recall where recall_ID='$recall_ID' and recall_Number='$recall_Number'";

         $result=$mydb->query($sql);

         if ($result==1) {
           echo "<p>A Recall has been deleted!</p></br>";
                   }
         }
         else
         {
           echo "an error occured, please try again and ensure that the data is valid.";
         }
  ?>
</div>
<p><a style='background:white' href="clientListingsPage.php">Click Here to Return to the Recalls Page</a></p>
<p><a href="logout.php">Click here to log out</a></p>
</body>
</html>
