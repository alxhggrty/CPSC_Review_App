<?php
session_start();
require_once("db.php");
if(isset($_SESSION['User_Account_Username'])) $User_Account_Username=$_SESSION['User_Account_Username'];
if(isset($_COOKIE["User_Account_Id"])) $User_Account_Id=$_COOKIE["User_Account_Id"];
if (isset($_POST["submit"])) {
  if(isset($_POST['Recall_Id']))$_SESSION['Recall_Id']=$_POST['Recall_Id'];
  if(isset($_POST['Recall_Number']))$_SESSION['Recall_Number']=$_POST['Recall_Number'];
  if(isset($_POST['Potential_Violation_URL']))$_SESSION['Potential_Violation_URL']=$_POST['Potential_Violation_URL'];
  header("Location: flagConfirm.php");
  }

echo
    "<div style='margin-left: auto; display: block; margin-right: auto;width: 1200px;'>
<table style='margin:auto;'>
    <tr>
      <th>  Product Name &nbsp;</th>
      <th>  CPSC URL  &nbsp;</th>
      <th>  Potential Violation URL</th>
      <th>  flag? </th>
    </tr>";
// filter constructor
$conditions = "where Potential_Violation_Review_Status is false and recall.Recall_Id=potential_violation.Recall_Id
and recall.Recall_Number=potential_violation.Recall_Number and potential_violation.Potential_Violation_URL is not null
and potential_violation.Potential_Violation_URL<>'' ";
if(isset($_GET['nameDropdown']) && !empty($_GET['nameDropdown'])) {
    $conditions=$conditions." and Recall_Product_Name LIKE '".preg_replace('/[\x00-\x1F\x7F-\xFF]/', '%', $_GET['nameDropdown'])."%'";}


/*
elseif(isset($_GET['Recall_Date']) && !empty($_GET['Recall_Date'])) {
  $conditions=$conditions." and Recall_Date='".$_GET['Recall_Date']."'";}
elseif(isset($_GET['Recall_Last_Publish_Date'])) {
    $conditions=$conditions." and Recall_Last_Publish_Date='".$_GET['Recall_Last_Publish_Date']."'";}
*/


        $sql="Select *
From recall, potential_violation ".$conditions;
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
</head>
<body style="background-color:skyblue;">



</body>
</html>
<?php
function get_page_title($url){
if( !($data = file_get_contents($url)) ) return false;

if( preg_match("#<title>(.+)<\/title>#iU", $data, $t))  {
return trim($t[1]);
} else {
return false;
}
}
$result = $mydb->query($sql);
  while($row = mysqli_fetch_array($result)) {
    $holder="http://".$row['Potential_Violation_URL'];
    $holder=str_replace("http://http://","http://",$holder);
    echo
    "<tr>
        <td><a href='".$row['Recall_URL']."'>".$row['Recall_Product_Name']."</a></td>
        <td>".$row['Recall_Title']."&nbsp</td>
        <td><a href=http://'".$row['Potential_Violation_URL']."'target='_blank'>".get_page_title($holder)."</a></td>
        <td><form method='post' action=".$_SERVER['PHP_SELF']."><input type='hidden' id='Recall_Number' name='Recall_Number' value=".$row['Recall_Number'].">
        <input type='hidden' id='Potential_Violation_URL' name='Potential_Violation_URL' value=".$holder.">
        <input type='hidden' id='Recall_Id' name='Recall_Id' value=".$row['Recall_Id'].">
        <input type='submit' id='submit' name ='submit' value='flag'>
        </td></form><tr>";

    ;
  }
  echo "</table></div>";
?>
