<?php

//require_once('../PHPBox/BoxFolderOperations.class.php');

function soc_boxgroup_test($gid) {

  $box_id = BoxFolderOperations::getBoxFolderID($gid);

  $folder = new BoxFolder($box_id, BoxFolderOperations::getCurrentAccessToken());

  $to_return[] = 'TESTING:';
  $to_return[] = $box_id;
  //$to_return[] = '<pre>' . print_r(json_decode($folder->getCollaborations()), TRUE) . '</pre>';


  $to_return[] = '<h2>Collaborators Object</h2><pre>' . print_r($folder->getCollabortiorNames(), TRUE) . '</pre>';


  return '<p>' . implode('</p><p>', $to_return) . '</p>';
}