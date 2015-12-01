<?php



function _soc_boxauth_diagnostics() {


    if (!BoxFolderOperations::isSessionActive()) {
        return 'Box not active';
    };

    $content = '<pre>';
    $content .= print_r($_SESSION['box'], true);

    $folder = New BoxFolder(0, $_SESSION['box']['access_token']);
    $content .= print_r($folder->getItems(), true);

    $content .='</pre>';
    return $content;
}
