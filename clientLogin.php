<?php
  $user_account_username="";
  $user_account_password="";
  $remember="no";
  $user_account_ID = "";
  $user_account_username = "";
  $error = false;
  $loginOK = null;

  if(isset($_POST["submit"])){
    if(isset($_POST["user_account_username"])) $user_account_username=$_POST["user_account_username"];
    if(isset($_POST["user_account_password"])) $user_account_password=$_POST["user_account_password"];
    if(isset($_POST["remember"])) $remember=$_POST["remember"];
  //  if(isset($_POST["user_account_ID"])) $remember=$_POST["user_account_ID"];

    //echo ($user_account_username.".".$user_account_password.".".$remember);
    if(empty($user_account_username) || empty($user_account_password)) {
      $error=true;
    }

    //set cookies for remembering the user name
   if(!empty($user_account_username) && $remember=="yes"){
      setcookie("user_account_username", $user_account_username, time()+60*60*24, "/");
    }

    if(!$error){
      //check user_account_username and user_account_password with the database record
      require_once("db.php");
      $sql = "select user_account_password, user_account_ID, user_account_username from user_account where user_account_username='$user_account_username'";
      $result = $mydb->query($sql);

      $row=mysqli_fetch_array($result);
      if ($row){
        if(strcmp($user_account_password, $row["user_account_password"]) ==0 ){
          $loginOK=true;
        } else {
          $loginOK = false;
        }
      }

      $sql = "select Employee_Admin_Boolean from employee where user_account_ID='$user_account_ID'";
      $result = $mydb->query($sql);

      if($loginOK) {
        //set session variable to remember the user_account_username
        session_start();
        $_SESSION["user_account_username"] = $user_account_username;
        $_SESSION["user_account_ID"] = $row["user_account_ID"];
        $_SESSION["user_account_username"] = $row["user_account_username"];
       setcookie("user_account_password", $user_account_password, time()+86400*3);

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
        <td><input type="text" name="user_account_username" value="<?php
          if(!empty($user_account_username))
            echo $user_account_username;
          else if(isset($_COOKIE['user_account_username'])) {
            echo $_COOKIE['user_account_username'];
          }
        ?>" /><?php if($error && empty($user_account_username)) echo "<span class='errlabel'> please enter a user_account_username</span>"; ?></td>
      </tr>
      <tr>
        <td>user_account_password</td>
      </tr>
      <tr>
        <td><input type="user_account_password" name="user_account_password" value="<?php if(!empty($user_account_password)) echo $user_account_password; ?>" /><?php if($error && empty($user_account_password)) echo "<span class='errlabel'> please enter a user_account_password</span>"; ?></td>
      </tr>
    </table>


    <table>
      <tr>
        <td><input type="checkbox" name="remember" value="yes"/><label>Remember me</label></td>
      </tr>
      <tr>
        <td><?php if(!is_null($loginOK) && $loginOK==false) echo "<span class='errlabel'>username and user_account_password do not match.</span>"; ?></td>
      </tr>
      <tr>
        <td><input type="submit" name="submit" value="Login" /></td>
      </tr>
    </table>
  </form>


<a href="createClient.php">Create an account.</a>
</br>
<a href=who.html>Return to Account Selection</a></div>
</body>
</html>
