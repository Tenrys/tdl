<?php

require_once("../includes/init.php");

$method = $_SERVER["REQUEST_METHOD"];

function updateTodo(&$ToDo, &$todo) {
	$ToDo->setCreatedAt(new DateTime($todo["createdAt"]["date"]));
	if (isset($todo["startedAt"]))
		$ToDo->setStartedAt(new DateTime($todo["startedAt"]["date"]));
	if (isset($todo["completedAt"]))
		$ToDo->setCompletedAt(new DateTime($todo["completedAt"]["date"]));
	if ($todo["status"] == "IN_PROGRESS" && $ToDo->getStatus() != $todo["status"])
		$ToDo->setstartedAt(new DateTime());
	if ($todo["status"] == "COMPLETED" && $ToDo->getStatus() != $todo["status"])
		$ToDo->setCompletedAt(new DateTime());
	$ToDo->setDescription($todo["description"]);
	if (isset($todo["assigned"]))
		$ToDo->setAssigned($todo["assigned"]["id"]);
	$ToDo->setStatus($todo["status"]);
}

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
		echo json_encode(ToDo::Find());
		break;

	case "DELETE":
		$data = getJson();
		if (!isset($data)) return;

		foreach ($data["todos"] as $todo) {
			if ($todo["id"] && $ToDo = ToDo::Get($todo["id"])) {
				ToDo::Delete($ToDo);
			}
		}

		break;

	case "POST":
		$data = getJson();
		if (!isset($data)) return;
		if (isset($data["todos"])) {
			$result = [];

			foreach ($data["todos"] as $todo) {
				if ($todo["id"] && $ToDo = ToDo::Get($todo["id"])) {
					updateTodo($ToDo, $todo);
					ToDo::Update($ToDo);
					$result[] = $ToDo;
				}
			}

			echo json_encode($result);
		} else if (isset($data["todo"])) {
			$todo = $data["todo"];
			$ToDo = new ToDo();
			updateTodo($ToDo, $todo);
			ToDo::Insert($ToDo);
		}
		break;
}


?>