<?php

//require_once(__DIR__ . "/PHPBox/BoxFolder.php");

function _soc_boxauth_diagnostics() {


    $content = '<pre>';
    $content .= print_r($_SESSION['box'], true);

    $folder = New BoxFolder(0, $_SESSION['box']['access_token']);
    $content .= print_r($folder->getItems(), true);

    $content .='</pre>';
    return $content;
}
