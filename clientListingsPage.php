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
  <title>CPSC Recalls</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="stylesheet.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <meta charset="utf-8">
</head>
	<body onload="clearAll()">
    <img src="reynholm.jpg" height=5% width=5% />
    <ul class="nav nav-tabs">
    <li><a href="clientLanding.php">Home</a></li>
    <li class="active"><a href="clientListingsPage.php">Recalls</a></li>
    <li><a href="clientCurrentLoads.php">Potential Violations</a></li>
    <li><a href="clientPastLoads.php">Processed Potential Violations</a></li>
    <li><a href="createListing.php">Add Recalls</a></li>
    <li><a href="clientAccountManagement.php">Manage Account</a></li>
    </ul>

<script src="//cdnjs.cloudflare.com/ajax/libs/d3/4.7.2/d3.min.js"></script>
<script src="d3pie.min.js"></script>
<script>


function clearAll()
{document.getElementById("recall_Product_Name").innerHTML="<?php
$sql="select distinct recall_Product_Name from recall";
$result = $mydb->query($sql);
echo "<select id='recall_Product_Name' name='recall_Product_Name'><option value=''></option>";
while($row=mysqli_fetch_array($result)){
  $Selection=$row["recall_Product_Name"];
  echo "<option value = '$Selection'>$Selection</option>";
}
echo "</select>";

?>";
document.getElementById("recall_ID").innerHTML="<?php
$sql="select distinct recall_ID from recall";
$result = $mydb->query($sql);
echo "<select id='recall_ID' name='recall_ID'><option value=''></option>";
while($row=mysqli_fetch_array($result)){
  $Selection=$row["recall_ID"];
  echo "<option value = '$Selection'>$Selection</option>";
}
echo "</select>";
?>"

document.getElementById("recall_Number").value="";
document.getElementById("recall_date").value="";
document.getElementById("recall_Product_Name").selectedIndex = "1";

$(function(){
  $.ajax({url:"clientListingsPageBackend.php?recall_Product_Name="+
  $("#recall_Product_Name").val()+"&recall_ID="+
  $("#recall_ID").val()+"&recall_date="+
  $("#recall_date").val()+
  "&recall_Number="+$("#recall_Number").val()+
  "&recall_Last_Publish_Date="+$("#recall_Last_Publish_Date").val(),
    async:true,
    success:function(result){
      $("#contentArea").html(result);
    }
  })
})
document.getElementById("recall_Product_Name").selectedIndex = "";
}
</script>
<div style="left-margin:auto;right-margin:auto;display:block;width:850px;">

    <table style="text-align:center;left-margin:auto;right-margin:auto;display:block;">
		  <tr>
		    <td>Product Name:</td>
		    <td><?php
		    $sql="select distinct recall_Product_Name from recall";
		    $result = $mydb->query($sql);
		    echo "<select style='width:500px' id='recall_Product_Name' name='recall_Product_Name'><option value=''></option>";
		    while($row=mysqli_fetch_array($result)){
		      $Selection=$row["recall_Product_Name"];
		      echo "<option value = '$Selection'>$Selection</option>";
		    }
		    echo "</select>";
		    ?></td>
      </tr>
      <tr>
        <td><?php
       $sql="select distinct recall_ID from recall";
       $result = $mydb->query($sql);
       echo "<select id='recall_ID'><option value=''></option>";
       while($row=mysqli_fetch_array($result)){
         $Selection=$row["recall_ID"];
         echo "<option value = '$Selection'>$Selection</option>";
       }
       echo "</select>";
       ?></td>
        <td>Recall Number:</td>
        <td><?php
       $sql="select distinct recall_Number from recall";
       $result = $mydb->query($sql);
       echo "<select id='recall_Number'><option value=''></option>";
       while($row=mysqli_fetch_array($result)){
         $Selection=$row["recall_Number"];
         echo "<option value = '$Selection'>$Selection</option>";
       }
       echo "</select>";
       ?></td>

		  </tr>
		  <tr>

		    <td><input type="date" id="recall_Last_Publish_Date" name="recall_Last_Publish_Date" value="" /></td>
		  </tr>
		  <tr>
		    <td><button id="resetSearch" name="resetSearch" onclick="clearAll()">Reset Search</button></td>
		  </tr>
		</table>
</div>

		<script src="jquery-3.1.1.min.js"></script>
		<script>

        $(function(){
        $("#recall_ID, #recall_date, #recall_Last_Publish_Date, #recall_Number, #recall_Product_Name").change(function(){
          $.ajax({url:"clientListingsPageBackend.php?recall_Product_Name="+
          $("#recall_Product_Name").val()+"&recall_ID="+
          $("#recall_ID").val()+"&recall_date="+
          $("#recall_date").val()+
          "&recall_Number="+$("#recall_Number").val()+
          "&recall_Last_Publish_Date="+$("#recall_Last_Publish_Date").val(),
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
  <a style="" href="logout.php">Click here to log out</a>
</p>
</body>
</html>
