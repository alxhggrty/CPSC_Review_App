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
  if(isset($_SESSION["Recall_Id"])) $Recall_Id = $_SESSION["Recall_Id"];
  if(isset($_SESSION["Recall_Number"])) $Recall_Number = $_SESSION["Recall_Number"];
  $err=false;
  $sql="select * from recall where Recall_Id='$Recall_Id' and Recall_Number='$Recall_Number'";
  $result = $mydb->query($sql);
  while($row=mysqli_fetch_array($result)){
    $Recall_Id=$row['Recall_Id'];
    $Recall_Number=$row['Recall_Number'];
    $Recall_Date=$row['Recall_Date'];
    $Recall_Description=$row['Recall_Description'];
    $Recall_Title=$row['Recall_Title'];
    $Recall_Last_Publish_Date=$row['Recall_Last_Publish_Date'];
    $Recall_Product_Name=$row['Recall_Product_Name'];
    $Recall_URL=$row['Recall_URL'];

  }
  if (isset($_POST["submit"])) {


    if (!empty($Recall_Number) && !empty($Recall_Date) && !empty($Recall_Last_Publish_Date)
        && !empty($Recall_Id) && !empty($Recall_Description)&& !empty($Recall_Product_Name)&& !empty($Recall_URL))
    {
     if(isset($_POST["Recall_Id"])) $_SESSION["Recall_Id"] = $_POST["Recall_Id"];
      if(isset($_POST["Recall_Number"])) $_SESSION["Recall_Number"] = $_POST["Recall_Number"];
      if(isset($_POST["Recall_Date"])) $_SESSION["Recall_Date"] = $_POST["Recall_Date"];
      if(isset($_POST["Recall_Description"])) $_SESSION["Recall_Description"] = $_POST["Recall_Description"];
      if(isset($_POST["Recall_Title"])) $_SESSION["Recall_Title"] = $_POST["Recall_Title"];
      if(isset($_POST["Recall_Last_Publish_Date"])) $_SESSION["Recall_Last_Publish_Date"] = $_POST["Recall_Last_Publish_Date"];
      if(isset($_POST["Recall_Product_Name"])) $_SESSION["Recall_Product_Name"] = $_POST["Recall_Product_Name"];
      if(isset($_POST["Recall_URL"])) $_SESSION["Recall_URL"] = $_POST["Recall_URL"];
      header("Location: editListingConfirm.php");
    }
    else
    {
      $err = true;
    }
  }
?>

<!doctype html>
<html>
<script>document.getElementById('datePicker').value = new Date().toDateInputValue();
</script>
<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-145779038-1"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'UA-145779038-1');
</script>
  <title>CPSC recallS</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="stylesheet.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  <a href="clientLanding.php"><img src="CPSCLOGO.png" height=5% width=5% /></a>
  <ul class="nav nav-tabs">
  <li class="active"><a href="clientLanding.php">Home</a></li>
  <li><a href="clientListingsPage.php">recalls</a></li>
  <li><a href="PotentialViolationListingsPage.php">Potential Violations</a></li>
  <?php if($Administrator==TRUE){echo "<li><a href='FlaggedPotentialViolationListingsPage.php'>flagged Potential Violations</a></li>
  <li><a href='ProcessedPotentialViolations.php'>Processed Potential Violations</a></li>
  <li><a href='createListing.php'>Add recalls</a></li>
  <li><a href='clientAccountManagement.php'>Manage Accounts</a></li>
  <li><a href='createAccounts.php'>Create Accounts</a></li>;";}?>
  </ul>
      <div style='margin-left: auto; display: block; margin-right: auto;width: 800px;'>
      ENTER NEW recall INFORMATION
    </br>
  </br>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
    <label>Recall_Id:
      <input type="text" name="Recall_Id" value="<?php echo $Recall_Id; ?>" />
      <?php
        if ($err && empty($Recall_Id)) {
          echo "<label class='errlabel'>Please enter a valid Recall_Id.</label>";
        }
      ?>
    </label>
    <br />
    <label>Recall_Number:
      <input type="text" name="Recall_Number" value="<?php echo $Recall_Number; ?>" />
      <?php
        if ($err && empty($Recall_Number)) {
          echo "<label class='errlabel'>Please enter a valid Recall_Number.</label>";
        }
      ?>
    </label>
    <br />

    <label>Recall_Date:
      <input type="date" name="Recall_Date" value="<?php echo date('Y-m-d'); ?>"min="<?php echo date('Y-m-d'); ?>" max="2100-12-31"/>
      <?php
        if ($err && empty($Recall_Date)) {
          echo "<label class='errlabel'>Please enter a Recall_Date.</label>";
        }
      ?>
    </label>
    <br />

    <label>Recall_Description:
      <textarea rows=5 style='width:500px' name='Recall_Description'><?php echo $Recall_Description; ?> </textarea>
      <?php
        if ($err && empty($Recall_Description)) {
          echo "<label class='errlabel'>Please enter a proper Recall_Description.</label>";
        }
      ?>
    </label>
    <br />
    <label>Recall_Title:
      <textarea rows=5 style='width:500px' name='Recall_Title'><?php echo $Recall_Title; ?> </textarea>
      <?php
        if ($err && empty($Recall_Title)) {
          echo "<label class='errlabel'>Please enter a proper Recall_Title.</label>";
        }
      ?>
    </label>
    <br />

    <label>Recall_Last_Publish_Date:
      <input type="date" name="Recall_Last_Publish_Date" value="<?php echo $Recall_Last_Publish_Date; ?>" />
      <?php
        if ($err && empty($Recall_Last_Publish_Date)) {
          echo "<label class='errlabel'>Please enter a Location.</label>";
        }
      ?>
    </label>
    <br />
    <label>Recall_Product_Name:
      <textarea rows=5 style='width:500px' name='Recall_Product_Name'><?php echo $Recall_Product_Name; ?>" </textarea>
      <?php
        if ($err && empty($Recall_Product_Name)) {
          echo "<label class='errlabel'>Please enter a valid Recall_Product_Name.</label>";
        }
      ?>
    </label>
    <br />
    <label>Recall_URL:
      <textarea rows=5 style='width:500px' name='Recall_URL'> <?php echo $Recall_URL; ?> </textarea>
      <?php
        if ($err && empty($Recall_URL)) {
          echo "<label class='errlabel'>Please enter a valid Recall_URL.</label>";
        }
      ?>
    </label>
    <br />
    <input type='submit' name='submit' value='save edited recall' />
  </form>

</div>
<p style='margin-left: auto; display: block; margin-right: auto;'>
  <a style="background-color:white;" href="logout.php">Click here to log out</a>
</p>
</body>
