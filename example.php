<?php
/****************************************

  \\\\\\\\\ \\   \\ \\\\\\\  \\\\\\   \\\\\\   \\\\\\\\\\  \\\\\\\\
  \\\        \\   \\ \\   \\  \\   \\  \\   \\          \\  \\    \\
  \\          \\\\\\\ \\\\\\\  \\    \\ \\    \\ \\\\\\\\\\  \\\\\\\
   \\\         \\   \\ \\       \\   \\  \\   \\  \\      \\  \\    \\
    \\\\\\\\\\  \\   \\ \\\\\\\  \\\\\\   \\\\\\   \\\\\\\\\\  \\    \\


  Cheddar_PHP is a PHP library that works directly with the Cheddarapp.com API.
  It is released open source under the MIT license, and I welcome all contributions through Github.
  
  Version: 1.1.0
  GitHub repository: http://github.com/bilawal360/cheddar-php
  Author website: http://bilaw.al/

  See LICENSE for full information on the license.
  
*****************************************/

/**
 * We need to include Cheddar to be able to use it.
 */
require_once 'Cheddar.php';

/**
 * This allows us to load up Cheddar with our application keys.
 *
 * @usage   $cheddar = new Cheddar\API(array('app_id' => 'APP ID HERE', 'app_secret' => 'APP SECRET HERE'));
 * @usage   $cheddar = new Cheddar\API('app_id=APP ID HERE&app_secret=APP SECRET HERE');
 */
$cheddar = new Cheddar\API('app_id=APP ID HERE&app_secret=APP SECRET HERE');

/**
 * This allows us to insert a valid access token to make authenticated requests.
 *
 * @usage   $cheddar->set_access_token('set access token here');
 */
$cheddar->set_access_token('set access token here');

/**
 * The code below deals entirely with oAuth. You only need to store $access_token in a database.
 */
if(! $access_token = $cheddar->get_access_token()) {
	$cheddar->authorize();
}

/**
 * Now we can run authenticated calls. Easy peasy. See examples below.
*/

/*
 * See information about authenticated user.
 *
 * @usage   $res = $cheddar->call('/v1/me');
 * @usage   $username = $cheddar->call('/v1/me')->username;
*/

/*
 * Creates a new list under the authenticated user.
 *
 * @usage   $res = $cheddar->call('/v1/lists', array(
 *                'list[title]' => 'New title name'
 *             )
 *          );
*/

/*
 * See all the lists under the authenticated user.
 *
 * @usage   $res = $cheddar->call('/v1/lists');
 *          foreach($res as $i=>$list) {
 *             echo "List ID: {$list->id}<br>";
 *             echo "List Name: {$list->title}<br><hr>";
 *          }
*/

/*
 * See a specific list information under the authenticated user.
 *
 * @usage   $res = $cheddar->call('/v1/lists/5407');
 *          echo "List ID: {$res->id}<br>";
 *          echo "List Name: {$res->title}<br><hr>";
*/

/*
 * Updates information from a specific list under the authenticated user.
 *
 * @usage   $res = $cheddar->call('/v1/lists/5407', array(
 *                'list[title]' => 'Updated title name'
 *             )
 *          );
*/

/*
 * See all the tasks on a specific list under the authenticated user.
 *
 * @usage   $res = $cheddar->call('/v1/lists/5407/tasks');
 *          foreach($res as $i=>$task) {
 *             echo "Task ID: {$task->id}<br>";
 *             echo "Task Name: {$task->display_html}<br><hr>";
 *          }
*/

/*
 * See a specific task under the authenticated user.
 *
 * @usage   $res = $cheddar->call('/v1/tasks/41589');
 *          echo "Task ID: {$res->id}<br>";
 *          echo "Task Name: {$res->display_html}<br><hr>";
*/

/*
 * Update a task under the authenticated user.
 *
 * @usage   $res = $cheddar->call('/v1/tasks/41589', array(
 *                 'task[text]' => 'Updated task name'
 *             )
 *          );
*/

/*
 * Create a task under a specific list under the authenticated user.
 *
 * @usage   $res = $cheddar->call('/v1/lists/5407/tasks', array(
 *                'task[text]' => 'New task name'
 *              )
 *          );
*/

/*
 * Check if an error has occurred during the request.
 *
 * @usage    $res = $cheddar->call('/v1/me');
 *           if($res->error) {
 *              die($res->error_description);
 *           }
*/

/**
 * Debugging and plus an example of the /v1/me command.
 */
header('Content-Type: text/javascript');
var_dump($cheddar->call('/v1/me'));