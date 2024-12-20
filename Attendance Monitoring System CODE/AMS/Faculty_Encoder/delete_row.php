<?php
require_once 'connection.php';

if (isset($_POST['user_id']) && isset($_POST['schedule_id'])) {
  $user_id = $_POST['user_id'];
  $schedule_id = $_POST['schedule_id'];
} else {
  echo 'error';
  exit();
}

$query_delete = "DELETE FROM schedule WHERE user_id = $user_id AND schedule_id = $schedule_id";
$result_delete = mysqli_query($conn, $query_delete);

if (mysqli_affected_rows($conn) > 0) {
  echo 'success';
} else {
  echo 'error';
}
?>
