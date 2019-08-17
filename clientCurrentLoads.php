<?php
session_start();

if(isset($_SESSION['User_Account_Username'])) $User_Account_Username=$_SESSION['User_Account_Username'];
if(isset($_SESSION['User_Account_Id'])) $User_Account_Id=$_SESSION['User_Account_Id'];
require_once("db.php");

if (isset($_POST["submit"])) {
    if(isset($_POST["Recall_Id"])) $_SESSION['Recall_Id']=$_POST["Recall_Id"];
    Header("Location:  clientListingDetailView.php");
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
  <title>CPSC Potential Violations</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="stylesheet.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <meta charset="utf-8">
</head>
	<body onload=<clearAll()>
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


<script src="//cdnjs.cloudflare.com/ajax/libs/d3/4.7.2/d3.min.js"></script>
<script src="d3pie.min.js"></script>
<script>

function clearAll()
{document.getElementById("nameDropdown").innerHTML="<?php
$sql="select distinct Recall_Product_Name from listing where User_Account_Id='$User_Account_Id'";
$result = $mydb->query($sql);
echo "<select id='namedropdown' name='namedropdown'><option value=''></option>";
while($row=mysqli_fetch_array($result)){
  $Selection=$row["Recall_Product_Name"];
  echo "<option value = '$Selection'>$Selection</option>";
}
echo "</select>";
?>";

document.getElementById("destinationDropdown").innerHTML="<?php
$sql="select distinct destination from listing where User_Account_Id='$User_Account_Id'";
$result = $mydb->query($sql);
echo "<select id='destinationDropdown'><option value=''></option>";
while($row=mysqli_fetch_array($result)){
  $Selection=$row["destination"];
  echo "<option value = '$Selection'>$Selection</option>";
}
echo "</select>";
?>"
$(function(){
  $.ajax({url:"clientListingsPageBackend.php?namedropdown="+
  $("#namedropdown").val()+"&Recall_Id="+
  $("#Recall_Id").val()+"&Recall_Date="+
  $("#Recall_Date").val()+
  "&destinationDropdown="+
  $("#destinationDropdown").val()+
  "&Recall_Id="+$("#Recall_Id").val()+
  "&Recall_Last_Publish_Date="+$("#Recall_Last_Publish_Date").val(),
    async:true,
    success:function(result){
      $("#contentArea").html(result);
    }
  })
})
}
</script>
<div style="left-margin:auto;right-margin:auto;display:block;width:850px;">

		<table style="text-align:center;left-margin:auto;right-margin:auto;display:block;">
		  <tr>
		    <td>Recall_Product_Name:</td>
		    <td><?php
		    $sql="select distinct Recall_Product_Name from listing where User_Account_Id='$User_Account_Id'";
		    $result = $mydb->query($sql);
		    echo "<select id='namedropdown' name='namedropdown'><option value=''></option>";
		    while($row=mysqli_fetch_array($result)){
		      $Selection=$row["Recall_Product_Name"];
		      echo "<option value = '$Selection'>$Selection</option>";
		    }
		    echo "</select>";
		    ?></td>
		    <td>Maximum Rate/Mile:</td>
		    <td><input type="number" id="Recall_Id" name="Recall_Id" value="" /></td>
        <td>Minimum Rate/Mile:</td>
       <td><input type="number" name="Recall_Id" id="Recall_Id" value="" /></td>

		  </tr>
		  <tr>
		    <td>Destination:</td>
		    <td><?php
		    $sql="select distinct destination from listing where User_Account_Id='$User_Account_Id'";
		    $result = $mydb->query($sql);
		    echo "<select id='destinationDropdown'><option value=''></option>";
		    while($row=mysqli_fetch_array($result)){
		      $Selection=$row["destination"];
		      echo "<option value = '$Selection'>$Selection</option>";
		    }
		    echo "</select>";
		    ?></td>
        <td>Maximum Weight:</td>
        <td><input type="number" id="Recall_Date" name="Recall_Date" value="" /></td>
		    <td>Minimum Weight:</td>
		    <td><input type="number" id="Recall_Last_Publish_Date" name="Recall_Last_Publish_Date" value="" /></td>
		  </tr>
		  <tr>
        <td><input type="hidden" name="state" id="state" value="IT" /></td>
		    <td><button id="resetSearch" name="resetSearch" onclick="clearAll();">Reset Search</button></td>
		</table>

  </div>
		<script src="jquery-3.1.1.min.js"></script>
		<script>

        $(function(){
        $("#Recall_Id, #Recall_Date, #Recall_Last_Publish_Date, #Recall_Id, #destinationDropdown, #namedropdown").change(function(){
          $.ajax({url:"clientListingsPageBackend.php?namedropdown="+
          $("#namedropdown").val()+"&Recall_Id="+
          $("#Recall_Id").val()+"&Recall_Date="+
          $("#Recall_Date").val()+
          "&destinationDropdown="+
          $("#destinationDropdown").val()+
          "&Recall_Id="+$("#Recall_Id").val()+
          "&Recall_Last_Publish_Date="+$("#Recall_Last_Publish_Date").val(),
            async:true,
            success:function(result){
              $("#contentArea").html(result);
            }
          })
        })
        })
        $(function(){
        $("#resetSearch").onclick(function(){
          $.ajax({url:"clientListingsPageBackend.php?namedropdown="+
          $("#namedropdown").val()+"&Recall_Id="+
          $("#Recall_Id").val()+"&Recall_Date="+
          $("#Recall_Date").val()+
          "&destinationDropdown="+
          $("#destinationDropdown").val()+
          "&Recall_Id="+$("#Recall_Id").val()+
          "&Recall_Last_Publish_Date="+$("#Recall_Last_Publish_Date").val(),
            async:true,
            success:function(result){
              $("#contentArea").html(result);
            }
          })
        })
        })


</script>

<div id="contentArea"></div>
<p style='margin-left: auto; display: block; margin-right: auto;'>
  <a style="background-color:white;" href="logout.php">Click here to log out</a>
</p>
</body>
</html>
