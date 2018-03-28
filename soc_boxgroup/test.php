<?php

$allowed_cmds = array(
    "title",
    "contents",
    "add-user");
$arguments = drush_get_arguments();

if (count($arguments) < 5) {
    drush_print("Usage :");
    drush_print(" 	drush scr " . basename(__FILE__) . " <folder-id> <active-access-token> <command>");

    _boxgroup_log_the_error('missing argument'));
}


$folderid = $arguments[2];
$access = $arguments[3];
$command = $arguments[4];

if (!is_numeric($folderid)) {
    _boxgroup_log_the_error('Folder id expected to be a number.' . $folderid);
}



$folder = New BoxFolder($folderid, $access);




// Switch block for commands:
switch ($command) {

    // Add User
    case 'add-user':
        $email = filter_var($arguments[5], FILTER_VALIDATE_EMAIL);
        if (!$email) {
            _boxgroup_log_the_error("Is $email a valid address?");
        }
        if ($email) {
            if ($folder->addUser($email)) {
                drush_print("Adding user email $email to $folder->getFolderName()");
            }
        }

        break;

    case 'del-user' :
        $email = filter_var($arguments[5], FILTER_VALIDATE_EMAIL);
        if (!$email) {
            _boxgroup_log_the_error("Is $email a valid address?");
        }
        if ($folder->removeUserByEmail($email));

}







function _boxgroup_log_the_error($msg ) {
    watchdog("BOXGROUP DRUSH", $msg);
    exit(drush_print($msg));

}