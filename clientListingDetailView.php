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
        }
      }
    }
else{Header("Location:  clientLogin.php");}


if(isset($_SESSION["Recall_Id"])) $Recall_Id=$_SESSION["Recall_Id"];
if(isset($_SESSION["Recall_Number"])) $Recall_Number=$_SESSION["Recall_Number"];
if(isset($_POST["Recall_Id"])) $Recall_Id=$_POST["Recall_Id"];
if(isset($_POST["Recall_Number"])) $Recall_Number=$_POST["Recall_Number"];


    if (isset($_POST["edit"])) {
      if(isset($_POST["Recall_Id"])&& isset($_POST['Recall_Number'])) {

      $_SESSION['Recall_Id']=$_POST["Recall_Id"];
      $_SESSION['Recall_Number']=$_POST['Recall_Number'];}

        Header("Location:  editListing.php");
      }
      if (isset($_POST["cancel"])) {
        if(isset($_POST["Recall_Id"])&& isset($_POST['Recall_Number'])) {

        $_SESSION['Recall_Id']=$_POST["Recall_Id"];
        $_SESSION['Recall_Number']=$_POST['Recall_Number'];}

          Header("Location:  clientCancelListing.php");
        }
        if (isset($_POST["addViolation"])) {
          if(isset($_POST["Recall_Id"])&& isset($_POST['Recall_Number'])) {

          $_SESSION['Recall_Id']=$_POST["Recall_Id"];
          $_SESSION['Recall_Number']=$_POST['Recall_Number'];
          $_SESSION['Recall_Product_Name']=$_POST['Recall_Product_Name'];
          $_SESSION['Recall_URL']=$_POST['Recall_URL'];

            Header("Location:  createPotentialViolation.php");
          }
}

?>
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
  <title>CPSC</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="stylesheet.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  <a href="clientLanding.php"><img src="CPSCLOGO.png" height=5% width=5% /></a>
  <ul class="nav nav-tabs">
  <li><a href="clientLanding.php">Home</a></li>
  <li class="active"><a href="clientListingsPage.php">recalls</a></li>
  <li><a href="PotentialViolationListingsPage.php">Potential Violations</a></li>
  <?php if($Administrator==TRUE){echo "<li><a href='FlaggedPotentialViolationListingsPage.php'>flagged Potential Violations</a></li>
  <li><a href='ProcessedPotentialViolations.php'>Processed Potential Violations</a></li>
  <li><a href='createListing.php'>Add recalls</a></li>
  <li><a href='clientAccountManagement.php'>Manage Accounts</a></li>
  <li><a href='createAccounts.php'>Create Accounts</a></li>;";}?>
  </ul>
  <?php
    if (isset($_SESSION['Recall_Id']) && isset($_SESSION['Recall_Number'])) {
      $Recall_Id=$_SESSION['Recall_Id'];
      $Recall_Number=$_SESSION['Recall_Number'];}


    $sql="select * from recall where Recall_Id='$Recall_Id' and Recall_Number='$Recall_Number'";
    $result = $mydb->query($sql);
    while($row=mysqli_fetch_array($result)){
      echo "<div style='margin: auto; display: block;width: 800px;'><table style='margin:auto;'>
      <tr>
      <th>recall Information</th>
      <th></th>
  <tr>
    <td>recall ID</td>
    <td>".$row['Recall_Id']."</td>
  </tr>
  <tr>
    <td>recall Number</td>
    <td>".$row['Recall_Number']."</td>
  </tr>
  <tr>
    <td>recall date</td>
    <td>".$row['Recall_Date']."</td>
  </tr>
  <tr>
    <td>description</td>
    <td>".$row['Recall_Description']."</td>
  </tr>
  <tr>
    <td>Title</td>
    <td>".$row['Recall_Title']."</td>
  </tr>
  <tr>
    <td>Last Published On</td>
    <td>".$row['Recall_Last_Publish_Date']."</td>
  </tr>
  <tr>
    <td>Product Name</td>
    <td>".$row['Recall_Product_Name']."</td>
  </tr>
  <tr>
    <td>CPSC URL</td>
    <td><a href='".$row['Recall_URL']."'>CPSC Official recall Page</a></td>
  </tr>";
  if($Administrator==TRUE){echo "
  <tr>
    <td><form method='post' type=submit
        action='".$_SERVER['PHP_SELF']."'>
          <input type='submit' name='edit' value='Edit recall' />
          <input type='hidden' name='Recall_Id' value='".$row['Recall_Id']."' />
          <input type='hidden' name='Recall_Number' value='".$row['Recall_Number']."' />
        </form>
    </td>
    <td><form method='post'
        action='".$_SERVER['PHP_SELF']."'>
          <input type='submit' name='cancel' value='Remove recall' />
          <input type='hidden' name='Recall_Id' value='".$row['Recall_Id']."' />
          <input type='hidden' name='Recall_Number' value='".$row['Recall_Number']."' />
        </form>
    </td>
  </tr>";}
  echo "<tr><td><form method='post' action='".$_SERVER['PHP_SELF']."'>
    <input type='submit' name='addViolation' value='generate potential violation' />
    <input type='hidden' name='Recall_Id' value='".$row['Recall_Id']."' />
    <input type='hidden' name='Recall_Number' value='".$row['Recall_Number']."' />
    <input type='hidden' name='Recall_Product_Name' value='".$row['Recall_Product_Name']."' />
    <input type='hidden' name='Recall_URL' value='".$row['Recall_URL']."' />

  </form>
  </tr>";
echo "</table></div>";
    }

   ?>
   <center><p style='margin-left: auto; display: block; margin-right: auto;'>
     <a style="position: fixed; bottom: 0; background-color:white;" href="logout.php">Click here to log out</a>
   </p></center>
</body>
</html>
