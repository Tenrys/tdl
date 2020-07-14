<?php

require_once("../includes/init.php");

$method = $_SERVER["REQUEST_METHOD"];

function getJson() {
	$data = null;
	try {
		$data = json_decode(file_get_contents("php://input"), true);
	} catch (Exception $err) {
		var_dump($err);
	}
	return $data;
}

switch ($method) {
	case "GET":
		echo json_encode(User::Find());
		break;

	case "DELETE":
		if (!isset($_SESSION["user"]) || $_SESSION["user"]->getRank() != "ADMIN") break;
		$data = getJson();
		if (!isset($data)) return;

		foreach ($data["users"] as $user) {
			if (isset($user["id"]) && $User = User::Get($user["id"])) {
				User::Delete($User);
			}
		}

		break;

	case "POST":
		if (!isset($_SESSION["user"]) || $_SESSION["user"]->getRank() != "ADMIN") break;
		$data = getJson();
		if (!isset($data)) return;
		if (isset($data["users"])) {
			$result = [];

			foreach ($data["users"] as $user) {
				if (isset($user["id"]) && $User = User::Get($user["id"])) {
					$User->setRank($user["rank"]);
					User::Update($User);
					$result[] = $User;
				}
			}

			echo json_encode($result);
		}
		break;
}


?>