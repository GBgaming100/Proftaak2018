<?php

	session_start();

	echo json_encode($_SESSION['messages']);

	unset($_SESSION['messages']);

?>