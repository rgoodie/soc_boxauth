<?php


function soc_boxauth_admin() {

  // Instructions and a link to Box Developer
  $form['soc_boxauth_header'] = [
    '#markup'=>t("Information entred below should be identical to what you have in your application settings found on !Box", [
      '!Box' => l('Box Developer', 'https://app.box.com/developers/services'),
    ])
  ];

  // Box client ID
  $form[SOC_BOXAUTH_CLIENTID_VARIABLE] = [
    '#title'=>t('Box API Client ID'),
    '#default_value'=> variable_get(SOC_BOXAUTH_CLIENTID_VARIABLE, ''),
    '#type'=>'textfield',
  ];

  // Box Client secret
  $form[SOC_BOXAUTH_CLIENTSECRET_VARIABLE] = [
    '#title'=>t('Box API Client Secret'),
    '#default_value'=> variable_get(SOC_BOXAUTH_CLIENTSECRET_VARIABLE, ''),
    '#type'=>'textfield',
  ];

  // Box Redirect URL/URI
  $form[SOC_BOXAUTH_REDIRECTURI_VARIABLE] = [
    '#title'=>t('Box API Redirect URI/URL'),
    '#default_value'=> variable_get(SOC_BOXAUTH_REDIRECTURI_VARIABLE, ''),
    '#type'=>'textfield',
  ];


  // Box Success Message
  $form[SOC_BOXAUTH_SUCCESSMESSAGE_VARIABLE] = [
    '#title'=>t('Success Message'),
    '#default_value'=> variable_get(SOC_BOXAUTH_SUCCESSMESSAGE_VARIABLE, t('You have successfully logged into box. We have an access token and will be able to preform actions with box during this session')),
    '#type'=>'textarea',
  ];

  // Box Success Message
  $form[SOC_BOXAUTH_FAILUREMESSAGE_VARIABLE] = [
    '#title'=>t('Success Message'),
    '#default_value'=> variable_get(SOC_BOXAUTH_FAILUREMESSAGE_VARIABLE, t('Box login seems to have failed. ')),
    '#type'=>'textarea',
  ];

  return system_settings_form($form);

}