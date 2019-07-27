<?php
  session_start();
  $user_account_username = "";
  $user_account_Password = "";

  if (isset($_POST['submit'])) {
    if(isset($_POST['user_account_Password'])) $_SESSION['user_account_Password'] = $_POST['user_account_Password'];
    if(isset($_POST['user_account_username'])) $_SESSION['user_account_username'] = $_POST['user_account_username'];

      header("Location: userCreationConfirm.php");
    }
?>

<!doctype html>
<html>
<head>
  <title>Account Creation</title>

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
  <li class="active"><a href="createAccounts.php">Create Accounts</a></li>
  </ul>
      <div style='margin-left: auto; display: block; margin-right: auto;width: 300px;'>
      ENTER NEW USER INFORMATION
    </br>
  </br>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
    <br />
    <label>user_account_username:
      <input type="text" name="user_account_username" value="<?php echo $user_account_username; ?>" />
      <?php
        if (empty($user_account_Password)) {
          //echo "<label class='errlabel'>Please enter a valid user_account_username.</label>";
        }
      ?>
    </label>
    <label>user_account_Password:
      <input type="text" name="user_account_Password" value="<?php echo $user_account_Password; ?>" />
      <?php
        if (empty($user_account_Password)) {
          //echo "<label class='errlabel'>Please enter a valid user_account_Password.</label>";
        }
      ?>
    </label>
    <br />
    <input type="submit" name="submit" value="Submit" />
  </form>

</div>
<p style='margin-left: auto; display: block; margin-right: auto;'>
  <a style="background-color:white;" href="logout.php">Click here to log out</a>
</p>
</body>
