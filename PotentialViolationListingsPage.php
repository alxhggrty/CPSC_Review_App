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


if (isset($_POST["submit"])) {
    if(isset($_POST["Recall_Id"])) {$_SESSION['Recall_Id']=$_POST["Recall_Id"];

    Header("Location:  PotentialViolationDetailView.php");
  }
}
?>

<html lang="en" dir="ltr">
<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-145779038-1"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'UA-145779038-1');
</script>
  <title>CPSC recalls</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="stylesheet.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <meta charset="utf-8">
</head>
<script>
$(document).ready(function(){
$.ajax({ url:"PotentialViolationsPageBackend.php?nameDropdown="+
$("#nameDropdown").val(),
        context: document.body,
        success: function(result){
          $("#contentArea").html(result);
        }});
});
</script>
	<body>
    <a href="clientLanding.php"><img src="CPSCLOGO.png" height=5% width=5% /></a>
    <ul class="nav nav-tabs">
    <li><a href="clientLanding.php">Home</a></li>
    <li><a href="clientListingsPage.php">recalls</a></li>
    <li class="active"><a href="PotentialViolationListingsPage.php">Potential Violations</a></li>
    <?php if($Administrator==TRUE){echo "<li><a href='FlaggedPotentialViolationListingsPage.php'>flagged Potential Violations</a></li>
    <li><a href='ProcessedPotentialViolations.php'>Processed Potential Violations</a></li>
    <li><a href='createListing.php'>Add recalls</a></li>
    <li><a href='clientAccountManagement.php'>Manage Accounts</a></li>
    <li><a href='createAccounts.php'>Create Accounts</a></li>;";}?>
    </ul>

      <script src="//cdnjs.cloudflare.com/ajax/libs/d3/4.7.2/d3.min.js"></script>
      <div style="left-margin:auto;right-margin:auto;display:block;width:850px;">

          <table style="text-align:center;left-margin:auto;right-margin:auto;display:block;">
      		  <tr>
      		    <td>Product Name:</td>
      		    <td><?php
      		    $sql="select distinct Recall_Product_Name from recall, potential_violation where Potential_Violation_Review_Status is false
       and recall.Recall_Id=potential_violation.Recall_Id
      and recall.Recall_Number=potential_violation.Recall_Number;";
      		    $result = $mydb->query($sql);
      		    echo "<select style='width:500px' id='nameDropdown' name='nameDropdown'><option value=''></option>";
      		    while($row=mysqli_fetch_array($result)){
      		      $Selection=$row["Recall_Product_Name"];
      		      echo "<option value = '$Selection'>$Selection</option>";
      		    }
      		    echo "</select>";
      		    ?></td>
      		  <tr>
      		    <td><button id="resetSearch" name="resetSearch" value="Reload Page" onClick="window.location.reload();">Reset Search</button></td>
      		  </tr>
      		</table>
      </div>

      		<script src="jquery-3.1.1.min.js"></script>
      		<script>

                  $(function(){
                  $("#nameDropdown").change(function(){
                    $.ajax({url:"PotentialViolationsPageBackend.php?nameDropdown="+
                    $("#nameDropdown").val(),
                      async:true,
                      success:function(result){
                        $("#contentArea").html(result);
                      }
                    })
                  })
                  })
      </script>

      <div id="contentArea"></div>
      <center><p style='margin-left: auto; display: block; margin-right: auto;'>
        <a style="position: fixed; bottom: 0; background-color:white;" href="logout.php">Click here to log out</a>
      </p></center>
   </body>
   </html>
