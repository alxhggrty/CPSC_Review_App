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



if(isset($_SESSION['User_Account_Username'])) $User_Account_Username=$_SESSION['User_Account_Username'];
if(isset($_COOKIE["User_Account_Id"])) $User_Account_Id=$_COOKIE["User_Account_Id"];
if(isset($_COOKIE["User_Account_Password"])) $User_Account_Password=$_COOKIE["User_Account_Password"];
if (isset($_POST["submit"])) {
    if(isset($_POST["Recall_Id"])) $_SESSION['Recall_Id']=$_POST["Recall_Id"];
    if(isset($_POST["Recall_Number"])) {$_SESSION['Recall_Number']=$_POST["Recall_Number"];
    Header("Location:  clientListingDetailView.php");
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
  <title>CPSC recall Management</title>

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

<img style='margin-left: auto; display: block; margin-right: auto;' src="CPSCPage.png" width=1000px/>

<?php
//resume the session variable on this page
$User_Account_Id = $_COOKIE["User_Account_Id"];
$User_Account_Password = $_COOKIE["User_Account_Password"];
$User_Account_Username = $_SESSION["User_Account_Username"];
$timeString = "";
$currentTime = date("a");
if ($currentTime == "am") {
  $timeString = "morning";
} else {
  $timeString = "afternoon";
}
$sql="select distinct User_Account_FirstName, User_Account_LastName from user_account where User_Account_Id=$User_Account_Id";
$result = $mydb->query($sql);
while($row = mysqli_fetch_array($result)){
    echo "<div style='text-align:center;width: 1000px;'>Good ".$timeString." ".$row['User_Account_FirstName']." ".$row['User_Account_LastName']."!
    </div>";
  }
    ?>    <div style='margin: auto; display: block; width: 1000px;background-color:white;'>
      <center><h1 style='margin:auto;'><?php if($Administrator==TRUE){echo "Reports & ";}?>Recent recalls</h1></center>
        <table style='margin:auto;'>
        <tr>
          <th>  ID &nbsp;</th>
          <th>  Number</th>
          <th>  Product Name  &nbsp;</th>
          <th>  recall Title &nbsp;</th>
          <th>  Detail View &nbsp;</th>
        </tr>
    <?php
    $sql="select * from recall order by Recall_Date desc";

    $result = $mydb->query($sql);

    $counter=10;
  while(($row = mysqli_fetch_array($result))&&$counter>0){
      ?><tr>
          <td><?php echo $row['Recall_Id'];?>&nbsp</td>
          <td><?php echo $row['Recall_Number'];?>&nbsp</td>
          <td><?php echo $row['Recall_Product_Name'];?>&nbsp</td>
          <td><?php echo $row['Recall_Title'];?>&nbsp</td>

      <td><form method='post'
          <?php echo "action='".$_SERVER['PHP_SELF']."'>";?>
          <input type='hidden' name='Recall_Id' value=<?php echo $row['Recall_Id'];?> />
          <input type='hidden' name='Recall_Number' value=<?php echo $row['Recall_Number'];?> />
          <input type='submit' name='submit' value='View More' />
          </form></td>
        </tr>
        <?php $counter--;
    }
?>
</div>
<?php
if($Administrator==TRUE){echo "
<div class='tableauPlaceholder' id='viz1565918179535' style='position: relative;width=1000px'><noscript><a href='#'>
  <img alt=' ' src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;Fi&#47;Final_15659118608940&#47;Final-FinalDashboard&#47;1_rss.png'
  style='border: none' /></a></noscript><object class='tableauViz'
  style='display:none;'>
  <param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' />
     <param name='embed_code_version' value='3' />
     <param name='site_root' value='' />
     <param name='name' value='Final_15659118608940&#47;Final-FinalDashboard' />
     <param name='tabs' value='no' />
     <param name='toolbar' value='yes' />
     <param name='static_image'
     value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;Fi&#47;Final_15659118608940&#47;Final-FinalDashboard&#47;1.png' />
     <param name='animate_transition' value='yes' />
     <param name='display_static_image' value='yes' />
     <param name='display_spinner' value='yes' />
     <param name='display_overlay' value='yes' />
     <param name='display_count' value='yes' />
   </object>
 </div>
 <script type='text/javascript'>
 var divElement = document.getElementById('viz1565918179535');
 var vizElement = divElement.getElementsByTagName('object')[0];
 if ( divElement.offsetWidth > 800 ) { vizElement.style.width='800px';vizElement.style.height='827px';}
 else if ( divElement.offsetWidth > 500 ) { vizElement.style.width='800px';vizElement.style.height='827px';}
 else { vizElement.style.width='100%';vizElement.style.height='1427px';}
 var scriptElement = document.createElement('script');
 scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';
 vizElement.parentNode.insertBefore(scriptElement, vizElement);
</script>";}?>


   <center><p style='margin-left: auto; display: block; margin-right: auto;'>
     <a style="position: fixed; bottom: 0; background-color:white;" href="logout.php">Click here to log out</a>
   </p></center>
</body>
</html>
