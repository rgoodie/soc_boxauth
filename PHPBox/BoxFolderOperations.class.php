<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BoxFolderOperations
 *
 * @author richard
 */
class BoxFolderOperations {


  /**
   * When testing locally, this is an optional file that reads in data. That
   * data contains the developer key, etc. This would be used in conjunction
   * with a test file. Not used in production.  options.ini is not included
   * in any repo.
   *
   * @return array
   */
  public static function getOptions() {
    return parse_ini_file('options.ini');
  }


  public static function getCurrentAccessToken() {
    if (isset($_SESSION['box'])) {
      return $_SESSION['box']['access_token'];
    }
    else {
      watchdog('Box Operations', 'Session not started');
      return drupal_set_message('Box session not active', 'error');
    }
  }



  /**
   * Helper function to get the Box id number from the node. Includes
   * a check to see if the node is an organic group or not.
   */
  public static function getBoxFolderID($gid) {


    // Is session active
    _soc_boxgroup_issessionactive();

    $node = node_load($gid);

    // ->soc_boxgroup_folder

    // if not group
    if (!og_is_group('node', $node)) {
      $msg = t('@node_title is not an Group', [
        '@node_title' => $node->title,
      ]);
      watchdog(SOC_BOXGROUP_MODULE_NAME, $msg);
      drupal_set_message($msg, 'error');
      return FALSE;
    }

    // return URL if we can
    $ent = entity_metadata_wrapper('node', $node);
    $box_id = $ent->soc_boxgroup_folder->value();

    // if field is blank
    if (is_null($box_id)) {
      $msg = t('@node_title does not have a box folder url assigned to it', [
        '@node_title' => $node->title,
      ]);
      watchdog(SOC_BOXGROUP_MODULE_NAME, $msg);
      drupal_set_message($msg, 'error');
      return FALSE;
    }

    // is it not numeric
    if (!is_numeric($box_id)) {
      watchdog(SOC_BOXGROUP_MODULE_NAME, t('@node_title (@nid) does not have a numeric folder id assigned to it', [
        '@node_title' => $node->title,
        '@nid' => $node->nid
      ]));

      return FALSE;
    }

    // Lastly, if we get this far, just return the value;
    return $ent->soc_boxgroup_folder->value();


  }


  public static function doPost($url, $postdata, $header) {
    // cURL magic
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      $header,
    ));

    //execute post
    $result = curl_exec($ch);

    //close connection
    curl_close($ch);

    return $result;
  }


  public static function doGet($url, $header) {
    // cURL magic
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      $header,
    ));

    //execute post
    $result = curl_exec($ch);

    //close connection
    curl_close($ch);

    return $result;
  }


}