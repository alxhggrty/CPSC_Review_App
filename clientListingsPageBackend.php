<?php
session_start();
require_once("db.php");
if(isset($_SESSION['User_Account_Username'])) $User_Account_Username=$_SESSION['User_Account_Username'];
if(isset($_SESSION['User_Account_Id'])) $User_Account_Id=$_SESSION['User_Account_Id'];
if (isset($_POST["submit"])) {
    if(isset($_POST["Recall_Id"])) $_SESSION['Recall_Id']=$_POST["Recall_Id"];
    if(isset($_POST["Recall_Number"])) $_SESSION['Recall_Number']=$_POST["Recall_Number"];
    Header("Location:  clientListingDetailView.php");
  }

echo
    "<div style='margin-left: auto; display: block; margin-right: auto;width: 1200px;'>
<table>
    <tr>
      <th>  ID &nbsp;</th>
      <th>  Number</th>
      <th>  Product Name  &nbsp;</th>
      <th>  recall Title &nbsp;</th>
      <th>  Detail View &nbsp;</th>
    </tr>";
// filter constructor
echo $_GET['nameDropdown'];
$conditions = "where Recall_Id IS NOT NULL";
if(isset($_GET['nameDropdown'])&& !empty($_GET['nameDropdown'])) {
  $conditions=$conditions." and Recall_Product_Name LIKE '".preg_replace('/[\x00-\x1F\x7F-\xFF]/', '%', $_GET['nameDropdown'])."%'";}
/*
elseif(isset($_GET['Recall_Date']) && !empty($_GET['Recall_Date'])) {
  $conditions=$conditions." and Recall_Date='".$_GET['Recall_Date']."'";}
elseif(isset($_GET['Recall_Last_Publish_Date'])) {
    $conditions=$conditions." and Recall_Last_Publish_Date='".$_GET['Recall_Last_Publish_Date']."'";}
*/


        $sql="select * from recall ".$conditions;
        
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

</head>
<body style="background-color:skyblue;">

</body>
</html>
<?php
$result = $mydb->query($sql);


  while($row = mysqli_fetch_array($result)) {
    echo
    "<tr>
        <td>".$row['Recall_Id']."&nbsp</td>
        <td>".$row['Recall_Number']."&nbsp</td>
        <td>".$row['Recall_Product_Name']."&nbsp</td>
        <td>".$row['Recall_Title']."&nbsp</td>";

    echo"<td><form method='post'
        action='".$_SERVER['PHP_SELF']."'>
        <input type='hidden' name='Recall_Id' value=".$row['Recall_Id']." />
        <input type='hidden' name='Recall_Number' value=".$row['Recall_Number']." />
        <input type='submit' name='submit' value='View More' />
        </form></td>
      </tr>

      ";
  }
  echo "</table></div>";
?>
