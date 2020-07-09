<?php

function mysql_timestamp(DateTime $date) {
	return date("Y-m-d H:i:s", $date->getTimestamp());
}

function index() {
	header("Location: index.php");
	die;
}

$ranks = [
	"USER" => "Utilisateur",
	"ADMIN" => "Admin",
];

?>