<?php
session_start();
if(isset($_SESSION['recall_ID'])) $recall_ID= $_SESSION['recall_ID'];
if(isset($_SESSION['recall_Number'])) $recall_Number= $_SESSION['recall_Number'];
if(isset($_SESSION['recall_date'])) $recall_ID= $_SESSION['recall_date'];
if(isset($_SESSION['recall_Description'])) $recall_Description= $_SESSION['recall_Description'];
if(isset($_SESSION['recall_title'])) $recall_title= $_SESSION['recall_title'];
if(isset($_SESSION['recall_Product_Name'])) $recall_Product_Name= $_SESSION['recall_Product_Name'];
if(isset($_SESSION['recall_Last_Publish_Date'])) $recall_Last_Publish_Date= $_SESSION['recall_Last_Publish_Date'];
if(isset($_SESSION['recall_URL'])) $recall_URL=$_SESSION['recall_URL'];
 $_SESSION['recall_Number']
echo $_SESSION['recall_date']
echo $_SESSION['recall_Description']
echo $_SESSION['recall_title']
echo $_SESSION['recall_Product_Name']
echo $_SESSION['recall_Last_Publish_Date']
echo $_SESSION['recall_URL']
require_once("db.php");
/*
$sql = "insert into recall
(recall_ID,recall_Number,recall_date,recall_Description,
recall_title,recall_Last_Publish_Date,recall_Product_Name,recall_URL)
values ('$recall_ID', '$recall_Number', '$recall_date', '$recall_Description', '$recall_title','$recall_Last_Publish_Date', '$recall_Product_Name', '$recall_URL')";
$result=$mydb->query($sql);

     if ($result==1) {
       if(isset($recall_ID)) $_SESSION['recall_ID']=$recall_ID;
       if(isset($recall_Number)) $_SESSION['recall_Number']=$recall_Number;
           Header("Location:  clientListingDetailView.php");
         }

           ?>
<!doctype html>
<html>
</html>
