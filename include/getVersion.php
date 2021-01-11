<?php 
    $sql = "select * from version";

    $result = mysqli_query($conn, $sql);

    $pass_row = mysqli_fetch_assoc($result);

    $VersionNo = $pass_row['Version'];
	$BuildNo   = $pass_row['BuildNo'];

?>