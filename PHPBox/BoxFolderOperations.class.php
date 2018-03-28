<?php

/**
 * BoxFolderOperations.class.PHP
 * Copyright (C) 2015  rg_chi via SoC
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BoxFolderOperations
 *
 * @author 
 */
class BoxFolderOperations {
  const BOX_OPERATIONS_NAME = 'Box Operations';


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

    // If we have an access token session in memeory return it.
    if (isset($_SESSION['box'])) {
      if (isset($_SESSION['box']['access_token'])) {
        return $_SESSION['box']['access_token'];
      }
      else {
        //dpm($_SESSION);
        return FALSE;
      }
    }


    else {
      watchdog(self::BOX_OPERATIONS_NAME, 'Session not started');
      drupal_set_message('Box session not active', 'error');
      return FALSE;

    }
  }

  /**
   * Helper function to get the Box id number from the node. Includes
   * a check to see if the node is an organic group or not.
   */
  public static function getBoxFolderID($gid) {


    // Is session active
    self::isSessionActive();

    $node = node_load($gid);

    // ->soc_boxgroup_folder

    // if not group
    if (!og_is_group('node', $node)) {
      $msg = t('@node_title is not an Group', [
        '@node_title' => $node->title,
      ]);
      watchdog(self::BOX_OPERATIONS_NAME, $msg);
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

  public static function isSessionActive() {
    if (!isset($_SESSION['box'])) {
      $msg = t('There <b>is no session active</b> between this site and box. Please !link now. ', [
        '!link' => l('start that session now', 'do/box/auth'),
      ]);
      $msg .= t('Any user added or removed from the group will not match up to the linked Box Folder. ');
      drupal_set_message($msg, 'warning');
      watchdog(self::BOX_OPERATIONS_NAME, 'Box session not active');
      return FALSE;
    }


    else {
      return TRUE;
    }
  }

  public static function doPost($url, $postdata, $header = '', $dataencode = 'JSON') {


    // Catch bad encoding by issuing an error. The array $encode_type will
    // contain acceptable methods. Return false and stop processing here.
    $encode_types = ['QUERY', 'HTTP', 'JSON'];
    if (!in_array($dataencode, $encode_types)) {
      $msg = t('ERROR in call to @function in @file. Data Enocde must be !list', [
        '@function' => __FUNCTION__,
        '@file' => __FILE__,
        '!list' => implode(', ', $encode_types),
      ]);
      watchdog(self::BOX_OPERATIONS_NAME, $msg);
      drupal_set_message($msg, 'error');

      return FALSE;
    }

    // Decide how to encode data. Some calls will require post data to be
    // encoded as a JSON string. Other calls will require QUERY.
    switch ($dataencode) {

      case 'QUERY':
      case 'HTTP':
        $postdata = http_build_query($postdata);
        break;
      case 'JSON':
      default:
        $postdata = trim(json_encode($postdata));
        break;
    }


    // cURL magic
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);

    // Skip header if blank
    if ($header != '') {
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        $header,
      ));
    }

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
