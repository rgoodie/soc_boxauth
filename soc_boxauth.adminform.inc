<?php



function soc_boxauth_admin() {

  // Instructions and a link to Box Developer
  $form['soc_boxauth_header'] = [
    '#markup' => t("Information entred below should be identical to what you have in your application settings found on !Box", [
      '!Box' => l('Box Developer', 'https://app.box.com/developers/services'),
    ])
  ];


  // Box Field set
  $form['boxapi'] = [
    '#type' => 'fieldset',
    '#title' => t('Box API Values'),
    '#weight' => 1,
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  ];


  // Box client ID -------------------------------------
  $form['boxapi'] [SOC_BOXAUTH_CLIENTID_VARIABLE] = [
    '#title' => t('Box API Client ID'),
    '#default_value' => variable_get(SOC_BOXAUTH_CLIENTID_VARIABLE, ''),
    '#type' => 'textfield',
  ];

  // Box Client secret
  $form['boxapi'] [SOC_BOXAUTH_CLIENTSECRET_VARIABLE] = [
    '#title' => t('Box API Client Secret'),
    '#default_value' => variable_get(SOC_BOXAUTH_CLIENTSECRET_VARIABLE, ''),
    '#type' => 'textfield',
  ];

  // Box Redirect URL/URI
  $form['boxapi'] [SOC_BOXAUTH_REDIRECTURI_VARIABLE] = [
    '#title' => t('Box API Redirect URI/URL'),
    '#default_value' => variable_get(SOC_BOXAUTH_REDIRECTURI_VARIABLE, ''),
    '#type' => 'textfield',
  ];


  // Technical -------------------------------------
  $form['tech'] = [
    '#type' => 'fieldset',
    '#title' => t('Technical Considerations and Debugging'),
    '#weight' => 2,
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  ];

  // Amount of time / Renew token
  $form['tech'] [SOC_BOXAUTH_RENEWTIME_VARIABLE] = [
    '#title' => t('Threshold of time allowed before renewing token (in minutes)'),
    '#default_value' => variable_get(SOC_BOXAUTH_RENEWTIME_VARIABLE, 10),
    '#type' => 'textfield',
    '#description' => t("This module tracks how many seconds the auth token has left until it expires. This number, in minutes, is lowest amount before expiration that we'll allow. ")
  ];

  // Debug option
  $form['tech'] [SOC_BOXAUTH_DEBUGSTATE_VARIABLE] = [
    '#title' => t('Show auth token in dpm() if exists'),
    '#type' => 'checkbox',
    '#default_value' => variable_get(SOC_BOXAUTH_DEBUGSTATE_VARIABLE, FALSE),
  ];


  // User Feedback -------------------------------------
  $form['text'] = [
    '#type' => 'fieldset',
    '#title' => t('Status Text for User Feedback'),
    '#weight' => 5,
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  ];

  // Box Success Message
  $form['text'][SOC_BOXAUTH_SUCCESSMESSAGE_VARIABLE] = [
    '#title' => t('Success Message'),
    '#default_value' => variable_get(SOC_BOXAUTH_SUCCESSMESSAGE_VARIABLE, t('You have successfully logged into box. We have an access token and will be able to preform actions with box during this session')),
    '#type' => 'textarea',
  ];

  // Box Success Message
  $form['text'][SOC_BOXAUTH_FAILUREMESSAGE_VARIABLE] = [
    '#title' => t('Success Message'),
    '#default_value' => variable_get(SOC_BOXAUTH_FAILUREMESSAGE_VARIABLE, t('Box login seems to have failed. ')),
    '#type' => 'textarea',
  ];


  return system_settings_form($form);

}