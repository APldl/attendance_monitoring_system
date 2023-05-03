<?php
require_once('path/to/dashboard_FM.php');

if (isset($_POST['logout'])) {

session_destroy();

header("Location: login.php");

exit;
}

?>