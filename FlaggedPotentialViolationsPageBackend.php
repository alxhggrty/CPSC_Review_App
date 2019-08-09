<?php
session_start();
require_once("db.php");
if(isset($_SESSION['user_account_username'])) $user_account_username=$_SESSION['user_account_username'];
if(isset($_SESSION['user_account_ID'])) $user_account_ID=$_SESSION['user_account_ID'];

if (isset($_POST["sendEmail"])) {

  if(isset($_POST['recall_ID']))$_SESSION['recall_ID']=$_POST['recall_ID'];
  if(isset($_POST['recall_Number']))$_SESSION['recall_Number']=$_POST['recall_Number'];
  if(isset($_POST['Potential_Violation_URL']))$_SESSION['Potential_Violation_URL']=$_POST['Potential_Violation_URL'];
  if(isset($_POST['recall_URL']))$_SESSION['recall_URL']=$_POST['recall_URL'];
  if(isset($_POST['recall_Product_Name']))$_SESSION['recall_Product_Name']=$_POST['recall_Product_Name'];
  header("Location: emailConfirm.php");}

  if (isset($_POST["notRelevant"])) {

    if(isset($_POST['recall_ID']))$_SESSION['recall_ID']=$_POST['recall_ID'];
    if(isset($_POST['recall_Number']))$_SESSION['recall_Number']=$_POST['recall_Number'];
    if(isset($_POST['Potential_Violation_URL']))$_SESSION['Potential_Violation_URL']=$_POST['Potential_Violation_URL'];
    header("Location: notRelevantConfirm.php");
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
$conditions = "";
if(isset($_GET['Recall_ID']) && !empty($_GET['Recall_ID'])) {
  $conditions=$conditions." and Recall_ID='".$_GET['Recall_ID']."'";}
if(isset($_GET['Recall_Number']) && !empty($_GET['Recall_Number'])) {
  $conditions= $conditions."and Recall_Number='".$_GET['Recall_Number']."'";}
  if(isset($_GET['Recall_product_name']) && !empty($_GET['Recall_product_name'])) {
    $conditions= $conditions."and Recall_product_name='".$_GET['Recall_product_name']."'";}

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
and potential_violation.Potential_Violation_URL=flag. Potential_Violation_URL and Potential_Violation_Review_Status=0 ".$conditions."
group by recall_ID, recall_number, flag.potential_Violation_URL
order by total_flags desc;";
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
        <td>".$row['recall_ID']."&nbsp</td>
        <td>".$row['recall_Number']."&nbsp</td>
        <td>".$row['recall_Product_Name']."&nbsp</td>
        <td><a href='".$row['recall_URL']."'>CPSC URL</a></td>
        <td><a href='".$row['Potential_Violation_URL']."'>Sales Link</a></td>
        <td>".$row['total_flags']."&nbsp</td>
        <td>

        <form method='post' action=".$_SERVER['PHP_SELF'].">
        <input type='hidden' id='recall_Number' name='recall_Number' value=".$row['recall_Number'].">
        <input type='hidden' id='recall_ID' name='recall_ID' value=".$row['recall_ID'].">
        <input type='hidden' id='Potential_Violation_URL' name='Potential_Violation_URL' value=".$row['Potential_Violation_URL'].">
        <input type='hidden' id='recall_URL' name='recall_URL' value=".$row['recall_URL'].">
        <input type='hidden' id='recall_Product_Name' name='recall_Product_Name' value=".$row['recall_Product_Name'].">
        <input type='submit' name ='sendEmail' value='Send Email'>
        </form>
        <form method='post' action=".$_SERVER['PHP_SELF'].">
        <input type='hidden' id='recall_Number' name='recall_Number' value=".$row['recall_Number'].">
        <input type='hidden' id='recall_ID' name='recall_ID' value=".$row['recall_ID'].">
        <input type='hidden' id='Potential_Violation_URL' name='Potential_Violation_URL' value=".$row['Potential_Violation_URL'].">
        <input type='submit' name ='notRelevant' value='Not Relevant'>
        </form>
        </td>";

    ;
  }
  echo "</table></div>";
?>
