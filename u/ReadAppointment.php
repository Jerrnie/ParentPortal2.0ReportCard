<?php
require '../include/config.php';

$query1 = mysqli_query($conn, "UPDATE tbl_appointment SET  ReadTag='4' WHERE Appoint_Id='".$_GET['page']."'");
mysqli_query($conn, $query1);

header('Location: parentAppointmentHistory.php');
?>