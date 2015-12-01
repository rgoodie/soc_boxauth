<?php


/**
 * This function is handles the callback from Box API.
 * @return string
 */
function _soc_boxauth_get_code_from_box_handler() {

  // get query string parameters
  $qs = drupal_get_query_parameters();

  watchdog(SOC_BOXAUTH_MODULENAME, "Got code back from Box", $qs, WATCHDOG_INFO);


  // Stage post data and create http query
  $post_data = http_build_query([
    'grant_type' => 'authorization_code',
    'code' => $qs['code'],
    'client_id' => variable_get(SOC_BOXAUTH_CLIENTID_VARIABLE),
    'client_secret' => variable_get(SOC_BOXAUTH_CLIENTSECRET_VARIABLE),
  ]);

  // With the access code in hand, we make the second request to gain access
  // to the Box access token.
  $result = file_get_contents(
    "https://api.box.com/oauth2/token",
    FALSE,
    stream_context_create([
      'http' => [
        'method' => 'POST',
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'content' => $post_data,
      ]
    ])
  );


  // save to session. Decoded json object into php array
  $_SESSION['box'] = drupal_json_decode($result);
  $_SESSION['box']['expires_time'] = time() + SOC_BOXAUTH_EXPIREOFFSET;

  // If successful, the ['box']['access_token'] will exists. Log and report
  // to user.
  if (isset($_SESSION['box']['access_token'])) {
    drupal_set_message(t(variable_get(SOC_BOXAUTH_SUCCESSMESSAGE_VARIABLE)));
    watchdog(SOC_BOXAUTH_MODULENAME, 'Successful box access_token');
  }

  // Else, if that array index doesn't exists, something may not have processed
  // correctly.
  else {
    drupal_set_message(t(variable_get(SOC_BOXAUTH_FAILUREMESSAGE_VARIABLE)), 'error');
    watchdog(SOC_BOXAUTH_MODULENAME, 'Failed box access_token');
  }

   return "Returned from Box";


}
