<?php
session_start();

if(isset($_SESSION['user_account_username'])) $user_account_username=$_SESSION['user_account_username'];
if(isset($_SESSION['user_account_ID'])) $user_account_ID=$_SESSION['user_account_ID'];
require_once("db.php");

if (isset($_POST["submit"])) {
    if(isset($_POST["recall_ID"])) $_SESSION['recall_ID']=$_POST["recall_ID"];
    Header("Location:  clientListingDetailView.php");
  }
?>

<html lang="en" dir="ltr">
<head>
  <title>CPSC RECALLS</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="stylesheet.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <meta charset="utf-8">
</head>
	<body onload="clearAll()">
		<img src="CPSCLOGO.png" height=5% width=5% />
    <ul class="nav nav-tabs">
    <li><a href="clientLanding.php">Home</a></li>
    <li><a href="clientListingsPage.php">Recalls</a></li>
    <li><a href="clientCurrentLoads.php">Potential Violations</a></li>
    <li class="active"><a href="clientPastLoads.php">Processed Potential Violations</a></li>
    <li><a href="createListing.php">Add Recalls</a></li>
    <li><a href="clientAccountManagement.php">Manage Account</a></li>
  </ul>

<script src="//cdnjs.cloudflare.com/ajax/libs/d3/4.7.2/d3.min.js"></script>
<script src="d3pie.min.js"></script>
<script>
function clearAll()
{document.getElementById("namedropdown").innerHTML="<?php
$sql="select distinct recall_product_name from listing where user_account_ID='$user_account_ID'";
$result = $mydb->query($sql);
echo "<select id='namedropdown' name='namedropdown'><option value=''></option>";
while($row=mysqli_fetch_array($result)){
  $Selection=$row["recall_product_name"];
  echo "<option value = '$Selection'>$Selection</option>";
}
echo "</select>";
?>";

document.getElementById("destinationDropdown").innerHTML="<?php
$sql="select distinct destination from listing where user_account_ID='$user_account_ID'";
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
  $("#namedropdown").val()+"&recall_ID="+
  $("#recall_ID").val()+"&recall_date="+
  $("#recall_date").val()+
  "&destinationDropdown="+
  $("#destinationDropdown").val()+
  "&recall_ID="+$("#recall_ID").val()+
  "&recall_last_publish_date="+$("#recall_last_publish_date").val(),
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
        <td>recall_product_name:</td>
        <td><?php
        $sql="select distinct recall_product_name from listing where user_account_ID='$user_account_ID'";
        $result = $mydb->query($sql);
        echo "<select id='namedropdown' name='namedropdown'><option value=''></option>";
        while($row=mysqli_fetch_array($result)){
          $Selection=$row["recall_product_name"];
          echo "<option value = '$Selection'>$Selection</option>";
        }
        echo "</select>";
        ?></td>
        <td>Maximum Rate/Mile:</td>
        <td><input type="number" id="recall_ID" name="recall_ID" value="" /></td>
        <td>Minimum Rate/Mile:</td>
       <td><input type="number" name="recall_ID" id="recall_ID" value="" /></td>

      </tr>
      <tr>
        <td>Destination:</td>
        <td><?php
        $sql="select distinct destination from listing where user_account_ID='$user_account_ID'";
        $result = $mydb->query($sql);
        echo "<select id='destinationDropdown'><option value=''></option>";
        while($row=mysqli_fetch_array($result)){
          $Selection=$row["destination"];
          echo "<option value = '$Selection'>$Selection</option>";
        }
        echo "</select>";
        ?></td>
        <td>Maximum Weight:</td>
        <td><input type="number" id="recall_date" name="recall_date" value="" /></td>
        <td>Minimum Weight:</td>
        <td><input type="number" id="recall_last_publish_date" name="recall_last_publish_date" value="" /></td>
      </tr>
      <tr>
        <td><input type="hidden" name="state" id="state" value="F" /></td>
        <td><button id="resetSearch" name="resetSearch" onclick="clearAll();">Reset Search</button></td>
    </table>

  </div>

		<script src="jquery-3.1.1.min.js"></script>
		<script>

        $(function(){
        $("#recall_ID, #recall_date, #recall_last_publish_date, #recall_ID, #destinationDropdown, #namedropdown").change(function(){
          $.ajax({url:"clientListingsPageBackend.php?namedropdown="+
          $("#namedropdown").val()+"&recall_ID="+
          $("#recall_ID").val()+"&recall_date="+
          $("#recall_date").val()+
          "&destinationDropdown="+
          $("#destinationDropdown").val()+
          "&recall_ID="+$("#recall_ID").val()+
          "&recall_last_publish_date="+$("#recall_last_publish_date").val(),
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
          $("#namedropdown").val()+"&recall_ID="+
          $("#recall_ID").val()+"&recall_date="+
          $("#recall_date").val()+
          "&destinationDropdown="+
          $("#destinationDropdown").val()+
          "&recall_ID="+$("#recall_ID").val()+
          "&recall_last_publish_date="+$("#recall_last_publish_date").val(),
            async:true,
            success:function(result){
              $("#contentArea").html(result);
            }
          })
        })
        })


</script>

<div id="contentArea"></div>
<p style='margin-left: auto; display: block; margin-right: auto; background-color:slategrey;'>
  <a style="background-color:white;" href="logout.php">Click here to log out</a>
</p>
</body>
</html>
