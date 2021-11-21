<?php

// absolutely everything about this implementation is heinous and might actually
// be a crime against humanity. I'm lazy and don't wanna database.
define("USERDB_FNAME", './userdb.json');

function userdb_get($fname) {
  $users = array();
  $users['default'] = password_hash('password123', PASSWORD_DEFAULT);
  if (file_exists($fname)) {
    $raw = file_get_contents($fname) ?? die("unexpected");
    $users = json_decode($raw, true) ?? die("bad userdb JSON format");
  } else {
    file_put_contents($fname, json_encode($users));
  }
  return $users;
}

function register_user($fname, $uname, $passwd) {
    $users = userdb_get($fname);
    $users[$uname] = password_hash($passwd, PASSWORD_DEFAULT);
    file_put_contents($fname, json_encode($users));
}

function authenticate_user($fname, $uname, $passwd) {
  $users = userdb_get($fname);
  if (isset($users[$uname])) {
    return password_verify($passwd, $users[$uname]);
  } else {
    return false;
  }
}
