<?php
  $email="";
  $password="";
  $remember="no";
  $clientID = "";
  $clientName = "";
  $error = false;
  $loginOK = null;

  if(isset($_POST["submit"])){
    if(isset($_POST["email"])) $email=$_POST["email"];
    if(isset($_POST["password"])) $password=$_POST["password"];
    if(isset($_POST["remember"])) $remember=$_POST["remember"];
  //  if(isset($_POST["clientID"])) $remember=$_POST["clientID"];

    //echo ($email.".".$password.".".$remember);
    if(empty($email) || empty($password)) {
      $error=true;
    }

    //set cookies for remembering the user name
   if(!empty($email) && $remember=="yes"){
      setcookie("email", $email, time()+60*60*24, "/");
    }

    if(!$error){
      //check email and password with the database record
      require_once("db.php");
      $sql = "select password, clientID, clientName from client where email='$email'";
      $result = $mydb->query($sql);

      $row=mysqli_fetch_array($result);
      if ($row){
        if(strcmp($password, $row["password"]) ==0 ){
          $loginOK=true;
        } else {
          $loginOK = false;
        }
      }

      $sql = "select type from client where email='$email'";
      $result = $mydb->query($sql);

      if($loginOK) {
        //set session variable to remember the email
        session_start();
        $_SESSION["email"] = $email;
        $_SESSION["clientID"] = $row["clientID"];
        $_SESSION["clientName"] = $row["clientName"];
       setcookie("password", $password, time()+86400*3);

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
    <center><img src="reynholm.png" height="5%" width="5%"></center>
</nav>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
    <div style='margin-left: auto; display: block; margin-right: auto;width: 300px;'>
      <table style="border:0px white;">
      <tr>
        <td>email</td>
      </tr>
      <tr>
        <td><input type="text" name="email" value="<?php
          if(!empty($email))
            echo $email;
          else if(isset($_COOKIE['email'])) {
            echo $_COOKIE['email'];
          }
        ?>" /><?php if($error && empty($email)) echo "<span class='errlabel'> please enter a email</span>"; ?></td>
      </tr>
      <tr>
        <td>password</td>
      </tr>
      <tr>
        <td><input type="password" name="password" value="<?php if(!empty($password)) echo $password; ?>" /><?php if($error && empty($password)) echo "<span class='errlabel'> please enter a password</span>"; ?></td>
      </tr>
    </table>


    <table>
      <tr>
        <td><input type="checkbox" name="remember" value="yes"/><label>Remember me</label></td>
      </tr>
      <tr>
        <td><?php if(!is_null($loginOK) && $loginOK==false) echo "<span class='errlabel'>email and password do not match.</span>"; ?></td>
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
