<?php

$allowed_cmds = array(
	"title",
	"contents");
$arguments =  drush_get_arguments();

if (count($arguments) < 5) {
	drush_print("Usage :");
	drush_print(" 	drush scr " .  basename(__FILE__) . " <folder-id> <active-access-token> <command>");
	
	exit(drush_print('missing argument'));
}


$folderid = $arguments[2];
$access = $arguments[3];
$command = $arguments[4];

if (!is_numeric($folderid)) {
	die(drush_print('Folder id expected to be a number.' . $folderid));
} 
if (!array_search(strtolower($command), $allowed_cmds, true)) {
	//die(drush_print('Allowed commands are: ' + implode(',', $allowed_cmds)));
}





$folder = New BoxFolder($folderid, $access);

drush_print(print_r($folder));