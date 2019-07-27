<?php
session_start();
if(isset($_SESSION["recall_ID"])) $recall_ID=$_SESSION["recall_ID"];
if(isset($_SESSION["recall_Number"])) $recall_Number=$_SESSION["recall_Number"];
if(isset($_POST["recall_ID"])) $recall_ID=$_POST["recall_ID"];
if(isset($_POST["recall_Number"])) $recall_Number=$_POST["recall_Number"];
?>
<html>
<head>
  <title>CPSC</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="stylesheet.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
      <img src="CPSCLOGO.png" height=5% width=5% />
      <ul class="nav nav-tabs">
      <li><a href="clientLanding.php">Home</a></li>
      <li class="active"><a href="clientListingsPage.php">Recalls</a></li>
      <li><a href="clientCurrentLoads.php">Potential Violations</a></li>
      <li><a href="clientPastLoads.php">Processed Potential Violations</a></li>
      <li><a href="createListing.php">Add Recalls</a></li>
      <li><a href="clientAccountManagement.php">Manage Account</a></li>
    </ul>
  <?php
    if (isset($_SESSION['recall_ID']) && isset($_SESSION['recall_Number'])) {
      $recall_ID=$_SESSION['recall_ID'];
      $recall_Number=$_SESSION['recall_Number'];}

    if (isset($_POST["edit"])) {
      if(isset($_POST["recall_ID"])&& isset($_POST['recall_Number'])) {

      $_SESSION['recall_ID']=$_POST["recall_ID"];
      $_SESSION['recall_Number']=$_POST['recall_Number'];}

        Header("Location:  editListing.php");
      }
      if (isset($_POST["cancel"])) {
        if(isset($_POST["recall_ID"])&& isset($_POST['recall_Number'])) {

        $_SESSION['recall_ID']=$_POST["recall_ID"];
        $_SESSION['recall_Number']=$_POST['recall_Number'];}

          Header("Location:  clientCancelListing.php");
        }
        if (isset($_POST["addViolation"])) {
          if(isset($_POST["recall_ID"])&& isset($_POST['recall_Number'])) {

          $_SESSION['recall_ID']=$_POST["recall_ID"];
          $_SESSION['recall_Number']=$_POST['recall_Number'];
          $_SESSION['recall_Product_Name']=$_POST['recall_Product_Name'];
          $_SESSION['recall_URL']=$_POST['recall_URL'];

            Header("Location:  createPotentialViolation.php");
          }
}
    require_once("db.php");
    $sql="select * from recall where recall_ID='$recall_ID' and recall_Number='$recall_Number'";
    $result = $mydb->query($sql);
    while($row=mysqli_fetch_array($result)){
      echo "<div style='margin-left: auto; display: block; margin-right: auto;width: 800px;'><table>
      <tr>
      <th>recall Information</th>
      <th></th>
  <tr>
    <td>Recall ID</td>
    <td>".$row['recall_ID']."</td>
  </tr>
  <tr>
    <td>Recall Number</td>
    <td>".$row['recall_Number']."</td>
  </tr>
  <tr>
    <td>recall date</td>
    <td>".$row['recall_date']."</td>
  </tr>
  <tr>
    <td>description</td>
    <td>".$row['recall_Description']."</td>
  </tr>
  <tr>
    <td>Title</td>
    <td>".$row['recall_title']."</td>
  </tr>
  <tr>
    <td>Last Published On</td>
    <td>".$row['recall_Last_Publish_Date']."</td>
  </tr>
  <tr>
    <td>Product Name</td>
    <td>".$row['recall_Product_Name']."</td>
  </tr>
  <tr>
    <td>CPSC URL</td>
    <td><a href='".$row['recall_URL']."'>CPSC Official Recall Page</a></td>
  </tr>
  <tr>
    <td><form method='post' type=submit
        action='".$_SERVER['PHP_SELF']."'>
          <input type='submit' name='edit' value='Edit recall' />
          <input type='hidden' name='recall_ID' value='".$row['recall_ID']."' />
          <input type='hidden' name='recall_Number' value='".$row['recall_Number']."' />
        </form>
    </td>
    <td><form method='post'
        action='".$_SERVER['PHP_SELF']."'>
          <input type='submit' name='cancel' value='Remove recall' />
          <input type='hidden' name='recall_ID' value='".$row['recall_ID']."' />
          <input type='hidden' name='recall_Number' value='".$row['recall_Number']."' />
        </form>
    </td>
  </tr>";
  echo "<tr><td><form method='post' action='".$_SERVER['PHP_SELF']."'>
    <input type='submit' name='addViolation' value='generate potential violation' />
    <input type='hidden' name='recall_ID' value='".$row['recall_ID']."' />
    <input type='hidden' name='recall_Number' value='".$row['recall_Number']."' />
    <input type='hidden' name='recall_Product_Name' value='".$row['recall_Product_Name']."' />
    <input type='hidden' name='recall_URL' value='".$row['recall_URL']."' />

  </form>
  </tr>";
echo "</table></div>";
    }

   ?>
   <p><a href="logout.php">Click here to log out</a></p>
</body>
</html>
