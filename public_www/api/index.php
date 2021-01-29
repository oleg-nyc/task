<?php

require_once "../../../task/models/UserAction.php";
require_once "../../../task/settings.php";

$config = require("../../../task/db/config.php");

if( strtolower($_SERVER["HTTP_HOST"]) === ALLOWED_HOST )
{

	$db = new PDO($config["db"], $config["username"], $config["password"]);
	$user = new UserAction($db);

	switch($_SERVER["REQUEST_METHOD"]) {
		
		case "GET":
			$result = $user->getAll();
			break;

		case "POST":
				$result = $user->insert(array(
					"name" => $_POST["name"],
					"email" => $_POST["email"],
					"task" => $_POST["task"],
					"done" => $_POST["done"] === "true" ? 1 : 0
				));
			break;

		case "PUT":
			parse_str(file_get_contents("php://input"), $_PUT);

			$result = ( is_array($_PUT) && count($_PUT) > 0 ) ? $user->update(array(
				"id" => intval($_PUT["id"]),
				"name" => $_PUT["name"],
				"email" => $_PUT["email"],
				"task" => $_PUT["task"],
				"done" => $_PUT["done"] === "true" ? 1 : 0
			), $_PUT["sid"]) : $user->update(false);
			break;

		case "DELETE":
			parse_str(file_get_contents("php://input"), $_DELETE);
			$result = $user->remove(intval($_DELETE["id"]), $_DELETE["sid"]);
			break;
	}


	header("Content-Type: application/json");
	echo json_encode($result);
} else echo "Access Denied";
?>
