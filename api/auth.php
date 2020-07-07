<?php

require_once("../includes/init.php");

echo json_encode($_SESSION["user"] ?? []);

?>