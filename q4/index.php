<?php
session_start();

require('./comments.php');
require('./users.php');

$username = $passwd = $ctext = "";
$uname_err = $passwd_err = $ctext_err = $login_err = $success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_SESSION["name"])) {
    if (empty($_POST["ctext"])) {
      $ctext_err = "Comment cannot be empty";
    } else {
      $ctext = $_POST["ctext"];
      commentdb_add(COMMENTDB_FNAME, $_SESSION["name"], $ctext);
      $ctext = "";
    }
  } else {
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

    $err = $uname_err || $passwd_err;

    if (!$err) {
      $isauth = authenticate_user(USERDB_FNAME, $username, $passwd);
      if ($isauth) {
        $_SESSION["name"] = $username;
        $success = "Login success";
        $ctext = "";
        $login_err = "";
      } else {
        $login_err = "Login failed: check your credentials or register for an account";
        $passwd = "";
      }
    } else {
      $success="";
    }
  }
}?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
    .error { color: #ff0000; }
    .success { color: #00ab66; }
    </style>
    <title>CSE3140 WebSec Lab</title>
  </head>

  <body>
    <header>
      <h1>CSE3140 Web Security Lab</h1>
      <h2>Section 5: Group 14</h2>
      <h4>Cole Reynolds and Jordan Hattar</h4>
    </header>
    <hr><hr>
    <p>
      <b>This</b> <i>is</i> <sup>some</sup> <sub><s><b>very</b></s></sub> <u>pretty</u> <em><strong>text.</strong></em>
    </p>
    <p>I don't know CSS, so I decided HTML, JavaScript and PHP was enough language for two weeks.</p>
    <p>Also I have the design acumen of a blind orangutan.</p>
    <hr>
    <a href="./register.php">Register for an account</a>
<?php if (isset($_SESSION["name"])) {?>
| Current User: <b><?php echo $_SESSION["name"];?></b> | <a href="./logout.php">Logout</a>
<?php }?>
    <hr>
<?php
  if (isset($_SESSION["name"])) {?>

    <h3>Write a comment:</h3><hr>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      Comment:<br><textarea name="ctext" rows="3" cols="40"><?php echo $ctext?></textarea>
      <span class="error">* <?php echo $ctext_err;?></span>
      <br><br>
      <input type="submit" name="submit" value="Submit">
    </form><br>
<?php
  } else {?>

    <h3>Login</h3><hr>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      Username:<br><input type="text" name="username" value="<?php echo $username;?>">
      <span class="error">* <?php echo $uname_err;?></span>
      <br><br>
      Password:<br><input type="password" name="passwd" value="<?php echo $passwd;?>">
      <span class="error">* <?php echo $passwd_err;?></span>
      <br><br>
      <input type="submit" name="submit" value="Submit">
    </form><br>
    <span class="success"><?php echo $success;?></span>
    <span class="error"><?php echo $login_err;?></span>


<?php }?>

    <hr><b>Comments:</b><hr>
    <ul>
<?php
$comments = commentdb_get('./commentdb.json');
foreach ($comments as $comment) {?>
  <li><b>user: </b><?php echo($comment->uname);?></li>
  <blockquote><i><?php echo($comment->text);?></i></blockquote>
<?php } ?>
    </ul>
  </body>
</html>
