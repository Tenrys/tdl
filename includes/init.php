<?php

$path = dirname(__FILE__) . "/";

require_once($path . "helpers.php");
require_once($path . "db.php");

require_once($path . "../classes/Item.php");
Item::$db = $db;
require_once($path . "../classes/ToDoItem.php");

require_once($path . "../classes/traits/DateProperty.php");

require_once($path . "../classes/User.php");
require_once($path . "../classes/ToDo.php");

if (!isset($_SESSION)) {
	session_start();
}

/* Debug
if (!isset($_SESSION["user"]) || !$_SESSION["user"]) {
	$user = User::Get(["firstname" => "Marceau"]);
	$_SESSION["user"] = $user;
}
*/
