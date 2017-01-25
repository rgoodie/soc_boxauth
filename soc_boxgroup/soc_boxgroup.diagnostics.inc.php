<?php

// require_once('../PHPBox/BoxFolderOperations.class.php');

function soc_boxgroup_test($gid) {

  if (!BoxFolderOperations::isSessionActive()) {
    return 'Box session not active';
};

$box_id = BoxFolderOperations::getBoxFolderID($gid);
dpm($box_id);

if (!is_numeric($box_id)) {
    die('Box id must be numeric');
}

    //  $box_id
     // $folder = new BoxFolder(0, BoxFolderOperations::getCurrentAccessToken());
$folder = New BoxFolder($box_id, $_SESSION['box']['access_token']);



$to_return[] = 'TESTING:';
$to_return[] = $box_id;
$to_return[] = '<h2>Name:</h2> ' . $folder->getFolderName();
$to_return[] = '<h2>Collaborators</h2><pre>' . print_r($folder->getCollabortiorNames(), TRUE) . '</pre>';


 // $to_return[] = '<h2>Collaborators Object</h2><pre>' . print_r($folder->getCollabortiorNames(), TRUE) . '</pre>';


return '<p>' . implode('</p><p>', $to_return) . '</p>';
}