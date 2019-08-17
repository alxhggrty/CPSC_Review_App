<?php
  $User_Account_Username="";
  $User_Account_Password="";
  $remember="no";
  $error = false;
  $loginOK = null;

  if(isset($_POST["submit"])){
    if(isset($_POST["User_Account_Username"])) $User_Account_Username=$_POST["User_Account_Username"];
    if(isset($_POST["User_Account_Password"])) $User_Account_Password=$_POST["User_Account_Password"];
    if(isset($_POST["remember"])) $remember=$_POST["remember"];

    if(empty($User_Account_Username) || empty($User_Account_Password)) {
      $error=true;
    }

    //set cookies for remembering the user name
   if(!empty($User_Account_Username) && $remember=="yes"){
    }

    if(!$error){
      //check User_Account_Username and User_Account_Password with the database record
      require_once("db.php");
      $sql = "select User_Account_Password, User_Account_Id, User_Account_Username from user_account where User_Account_Username='$User_Account_Username'";
      $result = $mydb->query($sql);

      $row=mysqli_fetch_array($result);
      if ($row){
        if(strcmp($User_Account_Password, $row["User_Account_Password"]) ==0 ){
          $loginOK=true;
        } else {
          $loginOK = false;
        }
      }



      if($loginOK) {
        //set session variable to remember the User_Account_Username
        session_start();
        $_SESSION["User_Account_Id"] = $row["User_Account_Id"];
        $_SESSION["User_Account_Username"] = $row["User_Account_Username"];
        setcookie('User_Account_Id', $row["User_Account_Id"], time()+86400*3, '/');
        setcookie('User_Account_Password', $row["User_Account_Password"], time()+86400*3, '/');
           setcookie("User_Account_Username", $User_Account_Username, time()+60*60*24, "/");
/*echo "alert('".$_COOKIE['User_Account_Id']." ".$_COOKIE['User_Account_Password']." ".$_COOKIE['User_Account_Username']."fuck');";*/
        Header("Location:clientLanding.php");
        }
    }
  }

 ?>
<!doctype html>
<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="stylesheet.css" />
  <title>Login</title>
  <style>
    .errlabel {color:red};
  </style>
</head>
<body>
  <nav>
    <center><img src="CPSCLOGO.png" height="5%" width="5%"></center>
</nav>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
    <div style='margin-left: auto; display: block; margin-right: auto;width: 300px;'>
      <table style="border:0px white;">
      <tr>
        <td>Username</td>
      </tr>
      <tr>
        <td><input type="text" name="User_Account_Username" value="<?php
          if(!empty($User_Account_Username))
            echo $User_Account_Username;
          else if(isset($_COOKIE['User_Account_Username'])) {
            echo $_COOKIE['User_Account_Username'];
          }
        ?>" /><?php if($error && empty($User_Account_Username)) echo "<span class='errlabel'> please enter a User_Account_Username</span>"; ?></td>
      </tr>
      <tr>
        <td>User_Account_Password</td>
      </tr>
      <tr>
        <td><input type="password" name="User_Account_Password" value="<?php if(!empty($User_Account_Password)) echo $User_Account_Password; ?>" /><?php if($error && empty($User_Account_Password)) echo "<span class='errlabel'> please enter a User_Account_Password</span>"; ?></td>
      </tr>
    </table>


    <table>
      <tr>
        <td><input type="checkbox" name="remember" value="yes"/><label>Remember me</label></td>
      </tr>
      <tr>
        <td><?php if(!is_null($loginOK) && $loginOK==false) echo "<span class='errlabel'>username and User_Account_Password do not match.</span>"; ?></td>
      </tr>
      <tr>
        <td><input type="submit" name="submit" value="Login" /></td>
      </tr>
    </table>
  </form>



</body>
</html>
