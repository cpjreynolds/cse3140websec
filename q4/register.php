<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    .error { color: #FF0000; }
    .success { color: #00ab66; }
  </style>
  <title>CSE3140 WebSec Lab</title>
</head>

<body>

<?php
require('./users.php');

$uname_err = $passwd_err = $passwd_conf_err = $success = "";
$username = $passwd = $passwdconfirm = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["username"])) {
    $uname_err = "Username is required";
  } else {
    $username = $_POST["username"];
  }

  if (empty($_POST["passwd"])) {
    $passwd_err = "Password is required";
  } else {
    $passwd = $_POST["passwd"];
  }

  if (strcmp($passwd, $_POST["passwdconfirm"]) != 0) {
    $passwd_conf_err = "Passwords do not match";
  }

  $err = $uname_err || $passwd_err || $passwd_conf_err;

  if (!$err) {
    register_user(USERDB_FNAME, $username, $passwd);
    $success = 'Account creation successful';
    $username = $passwd = "";
  }
}
?>

  <header>
    <h1>CSE3140 Web Security Lab</h1>
    <h2>Section 5: Group 14</h2>
    <h4>Cole Reynolds and Jordan Hattar</h4>
  </header>
  <hr><hr>
    <a href="./index.php">Go Home</a>
  <hr>
    <b>Register for an account:</b>
  <hr>
  <br>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Username:<br><input type="text" name="username" value="<?php echo $username;?>">
    <span class="error">* <?php echo $uname_err;?></span>
    <br><br>
    Password:<br><input type="password" name="passwd" value="<?php echo $passwd;?>">
    <span class="error">* <?php echo $passwd_err;?></span>
    <br><br>
    Confirm password:<br><input type="password" name="passwdconfirm">
    <span class="error">* <?php echo $passwd_conf_err;?></span>
    <br><br>
    <input type="submit" name="submit" value="Submit">
  </form>
  <br>
  <span class="success"><?php echo $success;?></span>
</body>
</html>
