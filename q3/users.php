<?php

// absolutely everything about this implementation is heinous and might actually
// be a crime against humanity. I'm lazy and don't wanna database.

$default_users = ['default' => 'password123'];

function userdb_get($fname) {
    $raw = file_get_contents($fname);
    if ($raw === false) {
        // no user file. make a default.
        $users = $default_users;
        file_put_contents($fname, json_encode($users));
    } else {
        $users = json_decode($raw, true) ?? die("bad userdb JSON format");
    }
    return $users;
}

function register_user($fname, $uname, $passwd) {
    $users = userdb_get($fname);
    $users[$uname] = $passwd;
    file_put_contents($fname, json_encode($users));
}

function authenticate_user($uname, $passwd) {
    $users = userdb_get($fname);
    if (!isset($users[$uname])) {
        return false;
    } elseif (strcmp($users[$uname], $passwd) !== 0) {
        return false;
    } else {
        return true;
    }
}
