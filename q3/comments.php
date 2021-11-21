<?php
define("COMMENTDB_FNAME", "./commentdb.json");

function commentdb_get($fname) {
  $comments = array();
  if (file_exists($fname)) {
    $raw = file_get_contents($fname) ?? die("unexpected");
    $comments = json_decode($raw) ?? die("bad commentdb JSON format");
  } else {
    file_put_contents($fname, json_encode($comments));
  }
  return $comments;
}

function commentdb_add($fname, $user, $text) {
    $cdb = commentdb_get($fname);
    $cdb[] = ["uname" => $user, "text" => $text];
    file_put_contents($fname, json_encode($cdb));
}

