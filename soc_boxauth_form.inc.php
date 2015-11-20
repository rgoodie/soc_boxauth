<?php


function _soc_boxauth_senduser_to_boxauth_content() {


  // make sure everything is in place
  if (!_soc_boxauth_startup_helper()) {
    return false;
  }

  $url = "https://app.box.com/api/oauth2/authorize?response_type=code&" .
    "client_id=" . variable_get(SOC_BOXAUTH_CLIENTID_VARIABLE) .
    "&redirect_uri=" . variable_get(SOC_BOXAUTH_REDIRECTURI_VARIABLE) .
    "&state=security_token%3D" . hash("sha256" , session_id());


  return l('Sign into Box', $url);


}
