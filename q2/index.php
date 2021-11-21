<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CSE3140 WebSec Lab</title>
  </head>

  <body>
    <header>
      <h1>CSE3140 Web Security Lab</h1>
      <h2>Section 5: Group 14</h2>
      <h4>Cole Reynolds and Jordan Hattar</h4>
    </header>
    <hr>
    <p>
      <b>This</b> <i>is</i> <sup>some</sup> <sub><s><b>very</b></s></sub> <u>pretty</u> <em><strong>text.</em></strong>
    </p>
    <p>I don't know CSS, so I decided HTML, JavaScript and PHP was enough language for two weeks.</p>
    <p>Also I have the design acumen of a blind orangutan.</p>
    <hr>

    <h3>Write a comment:</h3>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      Name:<br><input type="text" name="name">
      <br><br>
      Comment:<br><textarea name="comment" rows="3" cols="40"></textarea>
      <br><br>
      <input type="submit" name="submit" value="Submit">
    </form>
    <br>
    <hr><b>Comments:</b><hr>

    <ul>
<?php
require('./comments.php');

$name = $ctext = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $ctext = $_POST["comment"];
  commentdb_add(COMMENTDB_FNAME, $name, $ctext);
}

$comments = commentdb_get('./commentdb.json');

foreach ($comments as $comment) {?>
  <li><b>user: </b><?php echo($comment->uname); ?></li>
  <blockquote><i><?php echo($comment->text);?></i></blockquote>
<?php }?>
    </ul>

  </body>
</html>
