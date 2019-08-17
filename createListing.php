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
  $Recall_Id = "";
  $Recall_Product_Name = "";
  $Recall_Number = "";
  $Recall_Date = "";
  $Recall_Description = "";
  $err = false;
  $Recall_Title = "";
  $Recall_Last_Publish_Date = "";
  $Recall_URL="";

  if (isset($_POST['submit'])) {
    if(isset($_POST['Recall_Id'])) $Recall_Id = $_POST['Recall_Id'];
    if(isset($_POST['Recall_Number'])) $Recall_Number = $_POST['Recall_Number'];
    if(isset($_POST['Recall_Date'])) $Recall_Date = $_POST['Recall_Date'];
    if(isset($_POST['Recall_Description'])) $Recall_Description = $_POST['Recall_Description'];
    if(isset($_POST['Recall_Title'])) $Recall_Title = $_POST['Recall_Title'];
    if(isset($_POST['Recall_Last_Publish_Date'])) $Recall_Last_Publish_Date = $_POST['Recall_Last_Publish_Date'];
    if(isset($_POST['Recall_Product_Name'])) $Recall_Product_Name = $_POST['Recall_Product_Name'];
    if(isset($_POST['Recall_URL'])) $Recall_URL = $_POST['Recall_URL'];

    if (!empty($Recall_Id)
    && !empty($Recall_Number)
    && !empty($Recall_Date)
    && !empty($Recall_Description)
    && !empty($Recall_Title)
    && !empty($Recall_Last_Publish_Date)
    && !empty($Recall_Product_Name)
    && !empty($Recall_URL))
    {

      $_SESSION['Recall_Title'] = $Recall_Title;
      $_SESSION['Recall_Id'] = $Recall_Id;
      $_SESSION['Recall_Number'] = $Recall_Number;
      $_SESSION['Recall_Date'] = $Recall_Date;
      $_SESSION['Recall_Description'] = $Recall_Description;
      $_SESSION['Recall_URL'] = $Recall_URL;
      $_SESSION['Recall_Last_Publish_Date']= $Recall_Last_Publish_Date;
      $_SESSION['Recall_Product_Name']=$Recall_Product_Name;

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
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-145779038-1"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'UA-145779038-1');
</script>
  <title>recall Listing Creation</title>

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
  <li><a href="PotentialViolationListingsPage.php">Potential Violations</a></li>
  <?php if($Administrator==TRUE){echo "<li><a href='FlaggedPotentialViolationListingsPage.php'>flagged Potential Violations</a></li>
  <li><a href='ProcessedPotentialViolations.php'>Processed Potential Violations</a></li>
  <li class='active'><a href='createListing.php'>Add recalls</a></li>
  <li><a href='clientAccountManagement.php'>Manage Accounts</a></li>
  <li><a href='createAccounts.php'>Create Accounts</a></li>;";}?>
  </ul>
      <div style='margin-left: auto; display: block; margin-right: auto;width: 300px;'>
      ENTER NEW LISTING INFORMATION
    </br>
  </br>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
    <label>recall Title:
      <input type="text" name="Recall_Title" value="<?php echo $Recall_Title; ?>" />
      <?php
        if ($err && empty($Recall_Title)) {
          echo "<label class='errlabel'>Please enter a valid Recall_Title.</label>";
        }
      ?>
    </label>
    <br />
    <label>recall Product Name:
      <input type="text" name="Recall_Product_Name" value="<?php echo $Recall_Product_Name; ?>" />
      <?php
        if ($err && empty($Recall_Id)) {
          echo "<label class='errlabel'>Please enter a valid Recall_Id.</label>";
        }
      ?>
    </label>
    <label>recall ID:
      <input type="number" name="Recall_Id" value="<?php echo $Recall_Id; ?>" />
      <?php
        if ($err && empty($Recall_Id)) {
          echo "<label class='errlabel'>Please enter a valid Recall_Id.</label>";
        }
      ?>
    </label>
    <br />

    <label>recall Number:
      <input type="text" name="Recall_Number" value="<?php echo $Recall_Number; ?>" />
      <?php
        if ($err && empty($Recall_Number)) {
          echo "<label class='errlabel'>Please enter a Recall_Number.</label>";
        }
      ?>
    </label>
    <br />

    <label>recall Date:
      <input type="date" name="Recall_Date" value="<?php echo date('Y-m-d'); ?>"min="<?php echo date('Y-m-d'); ?>" max="2090-12-31" />
      <?php
        if ($err && empty($Recall_Date)) {
          echo "<label class='errlabel'>Please enter a proper Recall_Date.</label>";
        }
      ?>
    </label>
    <br />
    <label>recall Last Publish Date:
      <input type="date" name="Recall_Last_Publish_Date" value="<?php echo date('Y-m-d'); ?>"min="<?php echo date('Y-m-d'); ?>" max="2090-12-31" />
      <?php
        if ($err && empty($Recall_Last_Publish_Date)) {
          echo "<label class='errlabel'>Please enter a proper number of Recall_Last_Publish_Date.</label>";
        }
      ?>
    </label>
    <br />

    <label>recall Description:
      <input type="text" name="Recall_Description" value="<?php echo $Recall_Description; ?>" />
      <?php
        if ($err && empty($Recall_Description)) {
          echo "<label class='errlabel'>Please enter a Location.</label>";
        }
      ?>
    </label>
    <br />
    <label>recall URL:
    <input type="text" name="Recall_URL" value="<?php echo $Recall_URL; ?>" />
    <?php
      if ($err && empty($Recall_URL)) {
        echo "<label class='errlabel'>Please enter a URL.</label>";
      }
      ?>
    <input type="submit" name="submit" value="Submit" />
  </form>

</div>
<center><p style='margin-left: auto; display: block; margin-right: auto;'>
  <a style="position: fixed; bottom: 0; background-color:white;" href="logout.php">Click here to log out</a>
</p></center>
</body>
</html>
