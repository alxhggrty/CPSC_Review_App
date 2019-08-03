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
      <th>  Product Name &nbsp;</th>
      <th>  CPSC URL  &nbsp;</th>
      <th>  potential_violation_URL</th>
      <th>  Flag?</th>
    </tr>";
// filter constructor
$conditions = "where Potential_Violation_Review_Status is false and recall.recall_ID=potential_violation.Recall_ID and recall.recall_Number=potential_violation.Recall_Number";
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


        $sql="Select *
From recall, potential_violation ".$conditions;
?>
<html>
<head>
</head>
<body style="background-color:skyblue;">



</body>
</html>
<?php
$result = $mydb->query($sql);

  while($row = mysqli_fetch_array($result)) {
    echo
    "<tr>
        <td>".$row['recall_Product_Name']."&nbsp</td>
        <td><a href='".$row['recall_URL']."'>CPSC URL</a></td>
        <td><a href='".$row['Potential_Violation_URL']."'>Sales Link</a></td>
        <td><form><input type='hidden' id='recall_Number' name='recall_Number' value=".$row['recall_Number'].">
        <input type='hidden' id='Potential_Violation_URL' name='Potential_Violation_URL' value=".$row['Potential_Violation_URL'].">
        <input type='hidden' id='recall_ID' name='recall_ID' value=".$row['recall_Number'].">
        <input type='submit' id='submit' name ='submit' value='flag'>
        </td></form><tr>";

    ;
  }
  echo "</table></div>";
?>
