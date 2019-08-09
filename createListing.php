<?php
  session_start();
  $recall_ID = "";
  $recall_Product_Name = "";
  $recall_Number = "";
  $recall_date = "";
  $recall_Description = "";
  $err = false;
  $recall_title = "";
  $recall_Last_Publish_Date = "";
  $recall_URL="200";

  if (isset($_POST['submit'])) {
    if(isset($_POST['recall_ID'])) $recall_ID = $_POST['recall_ID'];
    if(isset($_POST['recall_Number'])) $recall_Number = $_POST['recall_Number'];
    if(isset($_POST['recall_date'])) $recall_date = $_POST['recall_date'];
    if(isset($_POST['recall_Description'])) $recall_Description = $_POST['recall_Description'];
    if(isset($_POST['recall_title'])) $recall_title = $_POST['recall_title'];
    if(isset($_POST['recall_Last_Publish_Date'])) $recall_Last_Publish_Date = $_POST['recall_Last_Publish_Date'];
    if(isset($_POST['recall_Product_Name'])) $recall_Product_Name = $_POST['recall_Product_Name'];
    if(isset($_POST['recall_URL'])) $recall_URL = $_POST['recall_URL'];

    if (!empty($recall_ID)
    && !empty($recall_Number)
    && !empty($recall_date)
    && !empty($recall_Description)
    && !empty($recall_title)
    && !empty($recall_Last_Publish_Date)
    && !empty($recall_Product_Name)
    && !empty($recall_URL))
    {

      $_SESSION['recall_title'] = $recall_title;
      $_SESSION['recall_ID'] = $recall_ID;
      $_SESSION['recall_Number'] = $recall_Number;
      $_SESSION['recall_date'] = $recall_date;
      $_SESSION['recall_Description'] = $recall_Description;
      $_SESSION['recall_URL'] = $recall_URL;
      $_SESSION['recall_Last_Publish_Date']= $recall_Last_Publish_Date;
      $_SESSION['recall_Product_Name']=$recall_Product_Name;

      header("Location: listingCreationConfirm.php");
    }
    else
    {
      $err = true;
    }
  }
?>

<!doctype html>
<html>
<head>
  <title>Recall Listing Creation</title>

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
  <li class="active"><a href="createListing.php">Add Recalls</a></li>
  <li><a href="clientAccountManagement.php">Manage Account</a></li>
  </ul>
      <div style='margin-left: auto; display: block; margin-right: auto;width: 300px;'>
      ENTER NEW LISTING INFORMATION
    </br>
  </br>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
    <label>recall_title:
      <input type="text" name="recall_title" value="<?php echo $recall_title; ?>" />
      <?php
        if ($err && empty($recall_title)) {
          echo "<label class='errlabel'>Please enter a valid recall_title.</label>";
        }
      ?>
    </label>
    <br />
    <label>Recalled Product Name:
      <input type="text" name="recall_Product_Name" value="<?php echo $recall_Product_Name; ?>" />
      <?php
        if ($err && empty($recall_ID)) {
          echo "<label class='errlabel'>Please enter a valid recall_ID.</label>";
        }
      ?>
    </label>
    <label>ID:
      <input type="number" name="recall_ID" value="<?php echo $recall_ID; ?>" />
      <?php
        if ($err && empty($recall_ID)) {
          echo "<label class='errlabel'>Please enter a valid recall_ID.</label>";
        }
      ?>
    </label>
    <br />

    <label>Number:
      <input type="text" name="recall_Number" value="<?php echo $recall_Number; ?>" />
      <?php
        if ($err && empty($recall_Number)) {
          echo "<label class='errlabel'>Please enter a recall_Number.</label>";
        }
      ?>
    </label>
    <br />

    <label>Recall Date:
      <input type="date" name="recall_date" value="<?php echo date('Y-m-d'); ?>"min="<?php echo date('Y-m-d'); ?>" max="2090-12-31" />
      <?php
        if ($err && empty($recall_date)) {
          echo "<label class='errlabel'>Please enter a proper recall_date.</label>";
        }
      ?>
    </label>
    <br />
    <label>Recall Last Publish Date:
      <input type="date" name="recall_Last_Publish_Date" value="<?php echo date('Y-m-d'); ?>"min="<?php echo date('Y-m-d'); ?>" max="2090-12-31" />
      <?php
        if ($err && empty($recall_Last_Publish_Date)) {
          echo "<label class='errlabel'>Please enter a proper number of recall_Last_Publish_Date.</label>";
        }
      ?>
    </label>
    <br />

    <label>Description:
      <input type="text" name="recall_Description" value="<?php echo $recall_Description; ?>" />
      <?php
        if ($err && empty($recall_Description)) {
          echo "<label class='errlabel'>Please enter a Location.</label>";
        }
      ?>
    </label>
    <br />
    <input type="hidden" name="recall_Product_Name" value=<?php $recall_Product_Name ?>/>
    <input type="submit" name="submit" value="Submit" />
  </form>

</div>
<p style='margin-left: auto; display: block; margin-right: auto;'>
  <a style="background-color:white;" href="logout.php">Click here to log out</a>
</p>
</body>
