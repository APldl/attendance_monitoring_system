<?php

require_once 'connection.php';

if (isset($_SESSION['user_id']) && isset($_POST['request_id'])) {
  $user_id = $_SESSION['user_id'];
  $request_id = $_POST['request_id'];
} else {
  echo 'error';
  exit();
}

$query_delete = "DELETE FROM request WHERE user_id = $user_id AND request_id = $request_id";
$result_delete = mysqli_query($conn, $query_delete);

if (mysqli_affected_rows($conn) > 0) {
  echo 'success';
} else {
  echo 'error';
}
?>
