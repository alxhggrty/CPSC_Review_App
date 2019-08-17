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
  else{Header("Location:  clientLanding.php");}
        }
      }
    }
else{Header("Location:  clientLogin.php");}
if(isset($_SESSION['User_Account_Username'])) $User_Account_Username=$_SESSION['User_Account_Username'];
if(isset($_SESSION['User_Account_Id'])) $User_Account_Id=$_SESSION['User_Account_Id'];

if (isset($_POST["sendEmail"])) {

  if(isset($_POST['Recall_Id']))$_SESSION['Recall_Id']=$_POST['Recall_Id'];
  if(isset($_POST['Recall_Number']))$_SESSION['Recall_Number']=$_POST['Recall_Number'];
  if(isset($_POST['Potential_Violation_URL']))$_SESSION['Potential_Violation_URL']=$_POST['Potential_Violation_URL'];
  if(isset($_POST['Recall_URL']))$_SESSION['Recall_URL']=$_POST['Recall_URL'];
  if(isset($_POST['Recall_Product_Name']))$_SESSION['Recall_Product_Name']=$_POST['Recall_Product_Name'];
  header("Location: emailConfirm.php");}

  if (isset($_POST["notRelevant"])) {

    if(isset($_POST['Recall_Id']))$_SESSION['Recall_Id']=$_POST['Recall_Id'];
    if(isset($_POST['Recall_Number']))$_SESSION['Recall_Number']=$_POST['Recall_Number'];
    if(isset($_POST['Potential_Violation_URL']))$_SESSION['Potential_Violation_URL']=$_POST['Potential_Violation_URL'];
    header("Location: notRelevantConfirm.php");
/* sql for confirmation page
 $sql = "insert into flag
          (    Recall_Id,   Recall_Number,   Potential_Violation_URL, 	User_Account_Id)
          values ($_POST['Recall_Id'],
           '$_POST['Recall_Number']',
           '$_POST['Potential_Violation_URL']',
           '$_SESSION['User_Account_Id']')";
       $result=$mydb->query($sql);

       if ($result==1) {echo "a new flag has been created"}
*/
  }

echo
    "<div style='margin-left: auto; display: block; margin-right: auto;width: 1200px;'>
<table style='margin:auto;'>
    <tr>
      <th>  ID &nbsp;</th>
      <th>  Title &nbsp;</th>
      <th>  Recall Description &nbsp;</th>
      <th>  Potential Violation URL</th>
      <th>  Total flags</th>
      <th>  Action </th>
    </tr>";
// filter constructor
$conditions = "";
  if(isset($_GET['nameDropdown']) && (!empty($_GET['nameDropdown']) && !($_GET['nameDropdown']=="Object object]"))) {
      $conditions=$conditions." and Recall_Product_Name LIKE '".preg_replace('/[\x00-\x1F\x7F-\xFF]/', '%', $_GET['nameDropdown'])."%'";}

/*
elseif(isset($_GET['Recall_Date']) && !empty($_GET['Recall_Date'])) {
  $conditions=$conditions." and Recall_Date='".$_GET['Recall_Date']."'";}
elseif(isset($_GET['Recall_Last_Publish_Date'])) {
    $conditions=$conditions." and Recall_Last_Publish_Date='".$_GET['Recall_Last_Publish_Date']."'";}
*/


        $sql="Select count(flag.Recall_Id) as total_flags, recall.Recall_Id,
        recall.Recall_Number, recall.Recall_Product_Name, recall.Recall_Title,
        recall.Recall_URL, 	flag.Potential_Violation_URL
        From recall, flag, potential_violation
        Where recall.Recall_Id=potential_violation.Recall_Id
        and recall.Recall_Number=potential_violation.Recall_Number
        and potential_violation.Recall_Id=flag.Recall_Id
        and potential_violation.Recall_Number = flag.Recall_Number".$conditions."
        and potential_violation.Recall_Id NOT IN (select Recall_Id from dispute)
        and potential_violation.Recall_Number NOT IN (select Recall_Number from dispute)
        group by recall.Recall_Id, recall.Recall_Number, flag.Potential_Violation_URL
        order by total_flags desc; ";
        
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
        <td>".$row['Recall_Id']."&nbsp</td>
        <td><a href='".$row['Recall_URL']."'>".$row['Recall_Product_Name']."</a></td>
        <td>".$row['Recall_Title']."&nbsp</td>
        <td><a href='".$holder."'>".get_page_title($holder)."</a></td>
        <td>".$row['total_flags']."&nbsp</td>
        <td>

        <form method='post' action=".$_SERVER['PHP_SELF'].">
        <input type='hidden' id='Recall_Number' name='Recall_Number' value=".$row['Recall_Number'].">
        <input type='hidden' id='Recall_Id' name='Recall_Id' value=".$row['Recall_Id'].">
        <input type='hidden' id='Potential_Violation_URL' name='Potential_Violation_URL' value=".$row['Potential_Violation_URL'].">
        <input type='hidden' id='Recall_URL' name='Recall_URL' value=".$row['Recall_URL'].">
        <input type='hidden' id='Recall_Product_Name' name='Recall_Product_Name' value=".$row['Recall_Product_Name'].">
        <input type='submit' name ='sendEmail' value='Send Email'>
        </form>
        <form method='post' action=".$_SERVER['PHP_SELF'].">
        <input type='hidden' id='Recall_Number' name='Recall_Number' value=".$row['Recall_Number'].">
        <input type='hidden' id='Recall_Id' name='Recall_Id' value=".$row['Recall_Id'].">
        <input type='hidden' id='Potential_Violation_URL' name='Potential_Violation_URL' value=".$row['Potential_Violation_URL'].">
        <input type='submit' name ='notRelevant' value='Not Relevant'>
        </form>
        </td>";

    ;
  }
  echo "</table></div>";
?>
