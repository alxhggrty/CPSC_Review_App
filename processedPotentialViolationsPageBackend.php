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




if(isset($_COOKIE['User_Account_Username'])) $User_Account_Username=$_COOKIE['User_Account_Username'];
if(isset($_COOKIE['User_Account_Id'])) $User_Account_Id=$_COOKIE['User_Account_Id'];

if (isset($_POST["submit"])) {
  if(isset($_POST['Dispute_Id']))$_SESSION['Dispute_Id']=$_POST['Dispute_Id'];
  if(isset($_POST['mode']))$_SESSION['mode']=$_POST['mode'];
  header("Location: redirect.php");}

echo
    "<div style='margin-left: auto; display: block; margin-right: auto;width: 1200px;'>
<table style='margin:auto;'>
    <tr>
      <th>  ID &nbsp;</th>
      <th>  Number &nbsp;</th>
      <th>  Product Name &nbsp;</th>
      <th>  Employee Name &nbsp;</th>
      <th>  Potential Violation Review Date</th>
      <th>  Status</th>
      <th>  Status Change? </th>
    </tr>";
// filter constructor
$conditions = "where potential_violation.Dispute_Id=dispute.Dispute_Id
 and potential_violation.Recall_Id=recall.Recall_Id and potential_violation.Recall_Number=recall.Recall_Number";
if(isset($_GET['nameDropdown']) && !empty($_GET['nameDropdown'])) {
    $conditions=$conditions." and Recall_Product_Name LIKE '%".preg_replace('/[\x00-\x1F\x7F-\xFF]/', '%', $_GET['nameDropdown'])."%'";}




        $sql="select * from potential_violation, recall, user_account, dispute ".$conditions."
        group by Potential_Violation_URL ORDER BY Recall_Product_Name ASC;";


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
$status='';
$result = $mydb->query($sql);

  while($row = mysqli_fetch_array($result)) {
    if($row['Status_Id']==1){$status="Listing Was Not Relevant to the Recall";}
    elseif($row['Status_Id']==2){$status="Email Sent";}
    elseif($row['Status_Id']==3){$status="Email Sent, contested";}
    elseif($row['Status_Id']==4){$status="Email Sent, Contest resolved in favor of recall";}
    elseif($row['Status_Id']==5){$status="Email Sent, Contest resolved in favor of vendor";}
    elseif($row['Status_Id']==6){$status="Email Sent, Listing Removed";}
    echo
    "<tr>
        <td>".$row['Recall_Id']."&nbsp</td>
        <td>".$row['Recall_Number']."&nbsp</td>
        <td>".$row['Recall_Product_Name']."&nbsp</td>
        <td>".$row['User_Account_FirstName']." ".$row['User_Account_LastName']."</td>
        <td>".$row['Potential_Violation_Review_Date']."</td>
        <td>$status</td>";
        if($row['Status_Id']==2){echo "<td><form method='post'
            action='".$_SERVER['PHP_SELF']."'>
              <input type='submit' name='submit' value='Lister Contests Recall' />
              <input type='hidden' name='Dispute_Id' value='".$row['Dispute_Id']."' />
              <input type='hidden' name='mode' value='3' />
            </form><form method='post'
                action='".$_SERVER['PHP_SELF']."'>
                  <input type='submit' name='submit' value='Lister Complied' />
                  <input type='hidden' name='Dispute_Id' value='".$row['Dispute_Id']."' />
                  <input type='hidden' name='mode' value='6' />
                </form></td>";}
        elseif($row['Status_Id']==3){echo "<td><form method='post'
            action='".$_SERVER['PHP_SELF']."'>
              <input type='submit' name='submit' value='Recall Confirmed' />
              <input type='hidden' name='Dispute_Id' value='".$row['Dispute_Id']."' />
              <input type='hidden' name='mode' value='4' />
            </form><form method='post'
                action='".$_SERVER['PHP_SELF']."'>
                  <input type='submit' name='submit' value='Recall Denied' />
                  <input type='hidden' name='Dispute_Id' value='".$row['Dispute_Id']."' />
                  <input type='hidden' name='mode' value='5' />
                </form></td>";}
        else {echo "<td> No Further Action Necessary</td>";}

    ;
  }


?>
