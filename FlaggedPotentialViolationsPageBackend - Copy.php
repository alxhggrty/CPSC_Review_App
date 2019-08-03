<?php
session_start();
require_once("db.php");
if(isset($_SESSION['user_account_username'])) $user_account_username=$_SESSION['user_account_username'];
if(isset($_SESSION['user_account_ID'])) $user_account_ID=$_SESSION['user_account_ID'];
if (isset($_POST["submit"])) {

  if(isset($_POST['recall_ID']))$_SESSION['recall_ID']=$_POST['recall_ID'];
  if(isset($_POST['recall_Number']))$_SESSION['recall_Number']=$_POST['recall_Number'];
  if(isset($_POST['Potential_Violation_URL']))$_SESSION['Potential_Violation_URL']=$_POST['Potential_Violation_URL'];
  header("Location: flagConfirm.php");
/* sql for confirmation page
 $sql = "insert into flag
          (    recall_ID,   recall_Number,   Potential_Violation_URL, 	user_account_ID)
          values ($_POST['Recall_ID'],
           '$_POST['recall_Number']',
           '$_POST['Potential_Violation_URL']',
           '$_SESSION['user_account_ID']')";
       $result=$mydb->query($sql);

       if ($result==1) {echo "a new flag has been created"}
*/
  }

echo
    "<div style='margin-left: auto; display: block; margin-right: auto;width: 1200px;'>
<table>
    <tr>
      <th>  ID &nbsp;</th>
      <th>  Number &nbsp;</th>
      <th>  Product Name &nbsp;</th>
      <th>  CPSC URL  &nbsp;</th>
      <th>  potential_violation_URL</th>
      <th>  total_flags</th>
      <th>  resolution Action</th>
    </tr>";
// filter constructor
$conditions = "where Potential_Violation_Review_Status is true and potential_violation.employee_ID=employee.employee_ID and recall.recall_ID=potential_violation.Recall_ID and recall.recall_Number=potential_violation.Recall_Number";
if(isset($_GET['Recall_ID']) && !empty($_GET['Recall_ID'])) {
  $conditions=$conditions." and Recall_ID='".$_GET['Recall_ID']."'";}
if(isset($_GET['Recall_Number']) && !empty($_GET['Recall_Number'])) {
  $conditions= $conditions."and Recall_Number='".$_GET['Recall_Number']."'";}

/*
elseif(isset($_GET['Recall_date']) && !empty($_GET['Recall_date'])) {
  $conditions=$conditions." and Recall_date='".$_GET['Recall_date']."'";}
elseif(isset($_GET['Recall_Last_Publish_Date'])) {
    $conditions=$conditions." and Recall_Last_Publish_Date='".$_GET['Recall_Last_Publish_Date']."'";}
*/


        $sql="Select count(flag.Potential_Violation_URL) as total_flags, recall.recall_ID, recall.recall_Number, recall_Product_Name, recall_URL, 	flag.Potential_Violation_URL
From recall, flag, potential_violation
Where recall.recall_ID=potential_Violation.Recall_ID
and recall.recall_number=potential_Violation.Recall_Number
and potential_violation.Potential_Violation_URL=flag. Potential_Violation_URL
group by recall_ID, recall_number, flag.potential_Violation_URL
order by total_flags desc;";
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
        <td><a href='".$row['recall_URL']."'>CPSC URL</a></td>
        <td><a href='".$row['Potential_Violation_URL']."'>Sales Link</a></td>
        <td>".$row['total_flags']."&nbsp</td>
        <td><form><input type='submit' name ='sendEmail' value='Send Email'>
        </form><form><input type='submit' name ='notRelevant' value='Not Relevant'>
        </form></td>";

    ;
  }
  echo "</table></div>";
?>
