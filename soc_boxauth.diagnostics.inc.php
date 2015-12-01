<?php

//require_once(__DIR__ . "/PHPBox/BoxFolder.php");

function _soc_boxauth_diagnostics() {

    // Dump what I think the refresh token call should be
    dpm("curl https://api.box.com/oauth2/token \
-d 'grant_type=refresh_token&refresh_token={$_SESSION['box']['refresh_token']}&client_id="
    . variable_get(SOC_BOXAUTH_CLIENTID_VARIABLE) . "&client_secret=" . variable_get(SOC_BOXAUTH_CLIENTSECRET_VARIABLE) . " ' \
-X POST");


    $content = '<pre>';
    $content .= print_r($_SESSION['box'], true);

    $folder = New BoxFolder(0, $_SESSION['box']['access_token']);
    $content .= print_r($folder->getItems(), true);

    $content .='</pre>';
    return $content;
}
