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
  $User_Account_Username = "";
  $User_Account_Password = "";
  $admin=0;
  $firstName='';
  $lastName='';
  $email='';

  if (isset($_POST['submit'])) {
    if(isset($_POST['User_Account_Password'])) $_SESSION['User_Account_Password'] = $_POST['User_Account_Password'];
    if(isset($_POST['User_Account_Username'])) $_SESSION['User_Account_Username'] = $_POST['User_Account_Username'];
    if(isset($_POST['Admin'])) {$_SESSION['Admin'] = 1;} else {$_SESSION['Admin'] = 0;}
    if(isset($_POST['firstName'])) $_SESSION['firstName'] = $_POST['firstName'];
    if(isset($_POST['lastName'])) $_SESSION['lastName'] = $_POST['lastName'];
    if(isset($_POST['email'])) $_SESSION['email'] = $_POST['email'];
      header("Location: UserCreationConfirm.php");
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
  <title>Account Creation</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="stylesheet.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
    $('#Admin').on('change', function(){
   this.value = this.checked ? 1 : 0;
   // alert(this.value);
}).change();
</script>
</head>
<body>
  <a href="clientLanding.php"><img src="CPSCLOGO.png" height=5% width=5% /></a>
  <ul class="nav nav-tabs">
  <li><a href="clientLanding.php">Home</a></li>
  <li><a href="clientListingsPage.php">recalls</a></li>
  <li><a href="PotentialViolationListingsPage.php">Potential Violations</a></li>
  <?php if($Administrator==TRUE){echo "<li><a href='FlaggedPotentialViolationListingsPage.php'>flagged Potential Violations</a></li>
  <li><a href='ProcessedPotentialViolations.php'>Processed Potential Violations</a></li>
  <li><a href='createListing.php'>Add recalls</a></li>
  <li><a href='clientAccountManagement.php'>Manage Accounts</a></li>
  <li class='active'><a href='createAccounts.php'>Create Accounts</a></li>;";}?>
  </ul>
      <div style='margin-left: auto; display: block; margin-right: auto;width: 300px;'>
      ENTER NEW USER INFORMATION
    </br>
  </br>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
    <br />
    <label>User_Account_Username:
      <input type="text" name="User_Account_Username" value="<?php echo $User_Account_Username; ?>" />
      <?php
        if (empty($User_Account_Password)) {
          //echo "<label class='errlabel'>Please enter a valid User_Account_Username.</label>";
        }
      ?>
    </label>
    <label>User_Account_Password:
      <input type="text" name="User_Account_Password" value="<?php echo $User_Account_Password; ?>" />
      <?php
        if (empty($User_Account_Password)) {
          //echo "<label class='errlabel'>Please enter a valid User_Account_Password.</label>";
        }
      ?>
    </label>
    <label>First Name:
      <input type="text" name="firstName" value="<?php echo $firstName; ?>" />
      <?php
        if (empty($User_Account_Password)) {
          //echo "<label class='errlabel'>Please enter a valid User_Account_Password.</label>";
        }
      ?>
    </label>
    <label>Last Name:
      <input type="text" name="lastName" value="<?php echo $lastName; ?>" />
      <?php
        if (empty($User_Account_Password)) {
          //echo "<label class='errlabel'>Please enter a valid User_Account_Password.</label>";
        }
      ?>
    </label>
    <label>Email:
      <input type="text" name="email" value="<?php echo $email; ?>" />
      <?php
        if (empty($User_Account_Password)) {
          //echo "<label class='errlabel'>Please enter a valid User_Account_Password.</label>";
        }
      ?>
    </label>
    <label>Administrator?:
      <input type="checkbox" name="Admin" id="Admin" value="<?php echo $admin; ?>" />
      <?php
        if (empty($User_Account_Password)) {
          //echo "<label class='errlabel'>Please enter a valid User_Account_Password.</label>";
        }
      ?>
    </label>
    <br />
    <input type="submit" name="submit" value="Submit" />
  </form>

</div>
<center><p style='margin-left: auto; display: block; margin-right: auto;'>
  <a style="position: fixed; bottom: 0; background-color:white;" href="logout.php">Click here to log out</a>
</p></center>
</body>
</html>
