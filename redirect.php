<?php
session_start();
require_once("db.php");
$mode='';
$Dispute_Id='';
if(isset($_SESSION['Dispute_Id'])) $Dispute_Id=$_SESSION['Dispute_Id'];
if(isset($_SESSION['mode'])) $mode=$_SESSION['mode'];
$sql="update dispute set Status_Id='$mode' where Dispute_Id='$Dispute_Id'";
$mydb->query($sql);
echo '<script>window.location.href = "ProcessedPotentialViolations.php";</script>';
?>
