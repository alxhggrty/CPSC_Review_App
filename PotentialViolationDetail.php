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
  $Recall_URL= '';
  $Potential_Violation_URL='';

  $err = false;



    if(isset($_SESSION['Recall_Id'])) $Recall_Id = $_SESSION['Recall_Id'];
    if(isset($_SESSION['Recall_Number'])) $Recall_Number = $_SESSION['Recall_Number'];
    if(isset($_SESSION['Recall_Product_Name'])) {
      $Potential_Violation_URL = $_SESSION['Recall_Product_Name'];
      $Recall_Product_Name= $_SESSION['Recall_Product_Name'];}
    if(isset($_SESSION['Recall_URL'])) $Recall_URL = $_SESSION['Recall_URL'];
    $Potential_Violation_URL= "https://duckduckgo.com/?q=!ducky ".$Recall_Product_Name."-''bidding has ended on this item''-''The listing you''re looking for has ended.''+site:ebay.com/itm";
    if (!empty($Recall_Id)
    && !empty($Recall_Number)
    && !empty($Recall_Product_Name)
    && !empty($Recall_URL)
    && isset($_POST['submit']))
    {

      $_SESSION['Recall_Id'] = $Recall_Id;
      $_SESSION['Recall_Number'] = $Recall_Number;
      $_SESSION['Recall_URL'] = $Recall_URL;
      $_SESSION['Recall_Product_Name']=$Recall_Product_Name;
      $_SESSION['Potential_Violation_URL'] = $Potential_Violation_URL;

      header("Location: PotentialViolationCreationConfirm.php");
    }
    else
    {
      $err = true;
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
  <li class="active"><a href="clientLanding.php">Home</a></li>
  <li><a href="clientListingsPage.php">recalls</a></li>
  <li><a href="PotentialViolationListingsPage.php">Potential Violations</a></li>
  <?php if($Administrator==TRUE){echo "<li><a href='FlaggedPotentialViolationListingsPage.php'>flagged Potential Violations</a></li>
  <li><a href='ProcessedPotentialViolations.php'>Processed Potential Violations</a></li>
  <li><a href='createListing.php'>Add recalls</a></li>
  <li><a href='clientAccountManagement.php'>Manage Accounts</a></li>
  <li><a href='createAccounts.php'>Create Accounts</a></li>;";}?>
  </ul>
      <div style='margin-left: auto; display: block; margin-right: auto;width: 300px;'>
      ENTER NEW POTENTIAL VIOLATION INFORMATION
    </br>
  </br>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">

    <label>Recall_Product_Name:
      <input type="text" readonly="readonly" name="Recall_Product_Name" value="<?php echo $Recall_Product_Name; ?>" />
      <?php
        if ($err && empty($Recall_Id)) {
          echo "<label class='errlabel'>Please enter a valid Recall_Id.</label>";
        }
      ?>
    </label>
    <label>Recall_Id:
      <input type="number" readonly="readonly" name="Recall_Id" value="<?php echo $Recall_Id; ?>" />
      <?php
        if ($err && empty($Recall_Id)) {
          echo "<label class='errlabel'>Please enter a valid Recall_Id.</label>";
        }
      ?>
    </label>
    <br />

    <label>Recall_Number:
      <input type="text" readonly="readonly" name="Recall_Number" value="<?php echo $Recall_Number; ?>" />
      <?php
        if ($err && empty($Recall_Number)) {
          echo "<label class='errlabel'>Please enter a Recall_Number.</label>";
        }
      ?>
    </label>
    <br />
    <label>Potential_Violation_URL:
      <input type="text" name="Potential_Violation_URL" value="<?php echo $Potential_Violation_URL ?>" />
      <?php
        if ($err && empty($Potential_Violation_URL)) {
          echo "<label class='errlabel'>Please enter a Recall_Number.</label>";
        }
      ?>
    </label>
    <br />

    <input type="hidden" name="Recall_Id" value=<?php $Recall_Id ?>/>
    <input type="hidden" name="Recall_Number" value=<?php $Recall_Number ?>/>
    <input type="hidden" name="Recall_URL" value=<?php $Recall_URL ?>/>
    <input type="hidden" name="Potential_Violation_URL" value=<?php $Potential_Violation_URL ?>/>
    <input type="submit" name="submit" value="Submit" />
  </form>

</div>
<p style='margin-left: auto; display: block; margin-right: auto;'>
  <a style="background-color:white;" href="logout.php">Click here to log out</a>
</p>
</body>
