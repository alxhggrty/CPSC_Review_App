<!doctype html>
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
  <title>CPSC recallS</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="stylesheet.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  <img src="CPSCLOGO.png" height="5%" width="5%">
  <div style='margin:auto; width: 300px;'><p style='margin:auto;'>
  <?php

    echo "Thank you for visiting!<br>";
    echo "You have successfully logged out. <br> Please <a href='clientLogin.php'>click here to login again</a>";

    if (isset($_COOKIE['User_Account_Id'])) $_COOKIE['User_Account_Id']="";
  ?>
</p></div>
</body>
</html>
