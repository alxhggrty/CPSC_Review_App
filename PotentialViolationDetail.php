<?php
  session_start();
  $recall_ID = "";
  $recall_Product_Name = "";
  $recall_Number = "";
  $Recall_URL= '';
  $Potential_Violation_URL='';

  $err = false;



    if(isset($_SESSION['recall_ID'])) $recall_ID = $_SESSION['recall_ID'];
    if(isset($_SESSION['recall_Number'])) $recall_Number = $_SESSION['recall_Number'];
    if(isset($_SESSION['recall_Product_Name'])) {
      $Potential_Violation_URL = $_SESSION['recall_Product_Name'];
      $recall_Product_Name= $_SESSION['recall_Product_Name'];}
    if(isset($_SESSION['recall_URL'])) $recall_URL = $_SESSION['recall_URL'];
    $Potential_Violation_URL= "https://duckduckgo.com/?q=!ducky ".$recall_Product_Name."-''bidding has ended on this item''-''The listing you''re looking for has ended.''+site:ebay.com/itm";
    if (!empty($recall_ID)
    && !empty($recall_Number)
    && !empty($recall_Product_Name)
    && !empty($recall_URL)
    && isset($_POST['submit']))
    {

      $_SESSION['recall_ID'] = $recall_ID;
      $_SESSION['recall_Number'] = $recall_Number;
      $_SESSION['recall_URL'] = $recall_URL;
      $_SESSION['recall_Product_Name']=$recall_Product_Name;
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
      ENTER NEW POTENTIAL VIOLATION INFORMATION
    </br>
  </br>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">

    <label>recall_Product_Name:
      <input type="text" readonly="readonly" name="recall_Product_Name" value="<?php echo $recall_Product_Name; ?>" />
      <?php
        if ($err && empty($recall_ID)) {
          echo "<label class='errlabel'>Please enter a valid recall_ID.</label>";
        }
      ?>
    </label>
    <label>recall_ID:
      <input type="number" readonly="readonly" name="recall_ID" value="<?php echo $recall_ID; ?>" />
      <?php
        if ($err && empty($recall_ID)) {
          echo "<label class='errlabel'>Please enter a valid recall_ID.</label>";
        }
      ?>
    </label>
    <br />

    <label>recall_Number:
      <input type="text" readonly="readonly" name="recall_Number" value="<?php echo $recall_Number; ?>" />
      <?php
        if ($err && empty($recall_Number)) {
          echo "<label class='errlabel'>Please enter a recall_Number.</label>";
        }
      ?>
    </label>
    <br />
    <label>Potential_Violation_URL:
      <input type="text" name="Potential_Violation_URL" value="<?php echo $Potential_Violation_URL ?>" />
      <?php
        if ($err && empty($Potential_Violation_URL)) {
          echo "<label class='errlabel'>Please enter a recall_Number.</label>";
        }
      ?>
    </label>
    <br />

    <input type="hidden" name="recall_ID" value=<?php $recall_ID ?>/>
    <input type="hidden" name="recall_Number" value=<?php $recall_Number ?>/>
    <input type="hidden" name="recall_URL" value=<?php $recall_URL ?>/>
    <input type="hidden" name="Potential_Violation_URL" value=<?php $Potential_Violation_URL ?>/>
    <input type="submit" name="submit" value="Submit" />
  </form>

</div>
<p style='margin-left: auto; display: block; margin-right: auto;'>
  <a style="background-color:white;" href="logout.php">Click here to log out</a>
</p>
</body>
