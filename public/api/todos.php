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
	$ToDo->setAssigned($todo["assigned"]["id"]);
	$ToDo->setStatus($todo["status"]);
}

if ($method == "GET") {
	echo json_encode(ToDo::Find());
} else {
	$POST = null;
	try {
		$POST = json_decode(file_get_contents("php://input"), true);
	} catch (Exception $e) {
		var_dump($e);
	}
	if (!isset($POST)) return;
	if (isset($POST["todos"])) {
		$result = [];

		foreach ($POST["todos"] as $todo) {
			if ($todo["id"] && $ToDo = ToDo::Get($todo["id"])) {
				updateTodo($ToDo, $todo);
				ToDo::Update($ToDo);
				$result[] = $ToDo;
			}
		}

		echo json_encode($result);
	} else if (isset($POST["todo"])) {
		$todo = $POST["todo"];
		$ToDo = new ToDo();
		updateTodo($ToDo, $todo);
		ToDo::Insert($ToDo);
	}
}


?>