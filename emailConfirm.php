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
//gets session variables passed from the detail view edit
      if(isset($_SESSION['Recall_Id']))$Recall_Id = $_SESSION["Recall_Id"];
      if(isset($_SESSION['Recall_URL']))$Recall_URL = $_SESSION["Recall_URL"];
      if(isset($_SESSION['Recall_Number']))$Recall_Number = $_SESSION["Recall_Number"];
      if(isset($_SESSION['Recall_Product_Name']))$Recall_Product_Name = $_SESSION["Recall_Product_Name"];
      if(isset($_SESSION['Potential_Violation_URL']))$Potential_Violation_URL=$_SESSION['Potential_Violation_URL'];
      if(isset($_COOKIE['User_Account_Id']))$User_Account_Id = $_COOKIE["User_Account_Id"];
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
  <title>Success</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="stylesheet.css" />
</head>
<body>
  <a href="clientLanding.php"><img src="CPSCLOGO.png" height=5% width=5% /></a>
  <ul class="nav nav-tabs">
  <li><a href="clientLanding.php">Home</a></li>
  <li><a href="clientListingsPage.php">recalls</a></li>
  <li><a href="PotentialViolationListingsPage.php">Potential Violations</a></li>
  <?php if($Administrator==TRUE){echo "<li class='active'><a href='FlaggedPotentialViolationListingsPage.php'>flagged Potential Violations</a></li>
  <li><a href='ProcessedPotentialViolations.php'>Processed Potential Violations</a></li>
  <li><a href='createListing.php'>Add recalls</a></li>
  <li><a href='clientAccountManagement.php'>Manage Accounts</a></li>
  <li><a href='createAccounts.php'>Create Accounts</a></li>;";}?>
  </ul>
<div style='margin-left: auto; display: block; margin-right: auto;width: 650px;'>
  <?php
  $msg = "a recalled item has been detected as listed for sale on your site.  ".$Potential_Violation_URL." Has been found to be an example of ".$Recall_URL."
   And should therefore be removed from your website in compliance with the laws of the united states.";
  $msg = wordwrap($msg,70);



  use PHPMailer\PHPMailer\PHPMailer;
  require '../vendor/autoload.php';
  //Create a new PHPMailer instance
  $mail = new PHPMailer;
  //Tell PHPMailer to use SMTP
  $mail->isSMTP();
  //Enable SMTP debugging
  // 0 = off (for production use)
  // 1 = client messages
  // 2 = client and server messages
  $mail->SMTPDebug = 2;
  //Set the hostname of the mail server
  $mail->Host = 'smtp.gmail.com';
  // use
  // $mail->Host = gethostbyname('smtp.gmail.com');
  // if your network does not support SMTP over IPv6
  //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
  $mail->Port = 587;
  //Set the encryption system to use - ssl (deprecated) or tls
  $mail->SMTPSecure = 'tls';
  //Whether to use SMTP authentication
  $mail->SMTPAuth = true;
  //Username to use for SMTP authentication - use full email address for gmail
  $mail->Username = "cpscsafetybois@gmail.com";
  //Password to use for SMTP authentication
  $mail->Password = "correcthorsebatterystaple";
  //Set who the message is to be sent from
  $mail->setFrom('cpscsafetybois@gmail.com', 'CPSC recalls');
  //Set who the message is to be sent to
  $mail->addAddress('cpscsafetybois@gmail.com', 'Alex Haggerty');
  //Set the subject line
  $mail->Subject = 'recalled Product';
  //Replace the plain text body with one created manually
  $mail->Body = $msg;
  //send the message, check for errors
  if (!$mail->send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
  } else {
      echo "Message sent!";
  }
    $Dispute_Id='';

    $sql = "insert into dispute (Recall_Id, Recall_Number, User_Account_Id, Status_Id, Dispute_Date)
    values ($Recall_Id,$Recall_Number,$User_Account_Id,2,'".date('Y-m-d')."');";

         $result=$mydb->query($sql);
    //gives a readout of what the update sent to the database, allows for review
         if ($result==1) {


           $sql = "select Dispute_Id from dispute where Recall_Id='$Recall_Id' and Recall_Number=$Recall_Number and User_Account_Id='$User_Account_Id'";
                $result=$mydb->query($sql);
                while($row = mysqli_fetch_array($result)){ $Dispute_Id=$row['Dispute_Id'];}
         }
         else
         {
           echo "an error occured, please try again and ensure that the data is valid.";
         }

         //does the update
             $sql = "update potential_violation set
             User_Account_Id='$User_Account_Id',
             Dispute_Id='$Dispute_Id',
             Potential_Violation_Review_Status=TRUE,
              Potential_Violation_Review_Date='".date('Y-m-d')."'
             where Recall_Id=$Recall_Id and Recall_Number='$Recall_Number';";
                  $result=$mydb->query($sql);
         //gives a readout of what the update sent to the database, allows for review
                  if ($result==1) {
                  }
                  else
                  {
                    echo "an error occured, please try again and ensure that the data is valid.";
                  }
                  echo "<div style='margin:auto;'><p style='margin:auto;'>the database has been updated</p></div>";
           ?>
         </div>
         <center><p style='margin-left: auto; display: block; margin-right: auto;'>
           <a style="position: fixed; bottom: 0; background-color:white;" href="logout.php">Click here to log out</a>
         </p></center>
      </body>
      </html>
