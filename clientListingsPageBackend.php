<?php
session_start();
require_once("db.php");
if(isset($_SESSION['user_account_username'])) $user_account_username=$_SESSION['user_account_username'];
if(isset($_SESSION['user_account_ID'])) $user_account_ID=$_SESSION['user_account_ID'];
if (isset($_POST["submit"])) {
    if(isset($_POST["recall_ID"])) $_SESSION['recall_ID']=$_POST["recall_ID"];
    if(isset($_POST["recall_Number"])) $_SESSION['recall_Number']=$_POST["recall_Number"];
    Header("Location:  clientListingDetailView.php");
  }

echo
    "<div style='margin-left: auto; display: block; margin-right: auto;width: 1200px;'>
<table>
    <tr>
      <th>  ID &nbsp;</th>
      <th>  Number &nbsp;</th>
      <th>  product name  &nbsp;</th>
      <th>  title &nbsp;</th>
      <th>  Detail View &nbsp;</th>
    </tr>";
// filter constructor
$conditions = "where recall_ID IS NOT NULL";
if(isset($_GET['nameDropdown'])&& !empty($_GET['nameDropdown'])) {
  $conditions=$conditions." and recall_Product_Name='".$_GET['nameDropdown']."'";}
if(isset($_GET['recall_ID']) && !empty($_GET['recall_ID'])) {
  $conditions=$conditions." and recall_ID='".$_GET['recall_ID']."'";}
if(isset($_GET['recall_Number']) && !empty($_GET['recall_Number'])) {
  $conditions= $conditions."and recall_Number='".$_GET['recall_Number']."'";}

/*
elseif(isset($_GET['recall_date']) && !empty($_GET['recall_date'])) {
  $conditions=$conditions." and recall_date='".$_GET['recall_date']."'";}
elseif(isset($_GET['recall_Last_Publish_Date'])) {
    $conditions=$conditions." and recall_Last_Publish_Date='".$_GET['recall_Last_Publish_Date']."'";}
*/


        $sql="select * from recall ".$conditions;
        echo $conditions;
?>
<html>
<head>
</head>
<body style="background-color:skyblue;">

  <div id="pieChart" style="margin: auto;
  background-color:white;
  width: 850px;
  border: 3px solid black;
  padding: 10px;
  text-align:center;"></div>

  <script src="//cdnjs.cloudflare.com/ajax/libs/d3/4.7.2/d3.min.js"></script>
  <script src="d3pie.min.js"></script>
  <script>
  var pie = new d3pie("pieChart", {
  	"header": {
  		"title": {
  			"text": "All Potential Violations",
  			"fontSize": 20,
  			"font": "open sans"
  		},
  		"subtitle": {
  			"text": "by process status",
  			"color": "#999999",
  			"font": "open sans"
  		},
  		"titleSubtitlePadding": 9
  	},
  	"footer": {
  		"color": "#999999",
  		"fontSize": 10,
  		"font": "open sans",
  		"location": "bottom-left"
  	},
  	"size": {
  		"canvasWidth": 590,
  		"pieInnerRadius": "40%",
  		"pieOuterRadius": "63%"
  	},
  	"data": {
  		"sortOrder": "value-desc",
  		"content": [
  			{
  				"label": "Reviewed by staff",
  				"value": <?php $sql2=("select count(Potential_Violation_Review_Status) as total from potential_violation where Potential_Violation_Review_Status='1';");
          $result = $mydb->query($sql2);
          while($row=mysqli_fetch_array($result)){echo $row['total'];}?>,
  				"color": "#1c6898"
  			},
  			{
  				"label": "Awaiting Review by staff",
  				"value": <?php $sql2=("select count(Potential_Violation_Review_Status) as total from potential_violation where Potential_Violation_Review_Status='0';");
          $result = $mydb->query($sql2);
          while($row=mysqli_fetch_array($result)){echo $row['total'];}?>,
  				"color": "#a39216"
  			}
  		]
  	},
  	"labels": {
  		"outer": {
  			"pieDistance": 32
  		},
  		"inner": {
  			"hideWhenLessThanPercentage": 3
  		},
  		"mainLabel": {
  			"fontSize": 11
  		},
  		"percentage": {
  			"color": "#ffffff",
  			"decimalPlaces": 0
  		},
  		"value": {
  			"color": "#adadad",
  			"fontSize": 11
  		},
  		"lines": {
  			"enabled": true
  		},
  		"truncation": {
  			"enabled": true
  		}
  	},
  	"effects": {
  		"pullOutSegmentOnClick": {
  			"effect": "linear",
  			"speed": 400,
  			"size": 8
  		}
  	},
  	"misc": {
  		"gradient": {
  			"enabled": true,
  			"percentage": 100
  		}
  	}
  });
  </script>
</body>
</html>
<?php
$result = $mydb->query($sql);


  while($row = mysqli_fetch_array($result)) {
    echo
    "<tr>
        <td>".$row['recall_ID']."&nbsp</td>
        <td>".$row['recall_Number']."&nbsp</td>
        <td>".$row['recall_Product_Name']."&nbsp</td>
        <td>".$row['recall_title']."&nbsp</td>";

    echo"<td><form method='post'
        action='".$_SERVER['PHP_SELF']."'>
        <input type='hidden' name='recall_ID' value=".$row['recall_ID']." />
        <input type='hidden' name='recall_Number' value=".$row['recall_Number']." />
        <input type='submit' name='submit' value='View More' />
        </form></td>
      </tr>

      ";
  }
  echo "</table></div>";
?>
