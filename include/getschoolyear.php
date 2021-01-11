<?php 
    $sql = "select a.*,b.* from tbl_schoolyear as a inner join tbl_settings as b on b.currentSchoolYear=a.schoolYearID";

    $result = mysqli_query($conn, $sql);

    $pass_row = mysqli_fetch_assoc($result);

    $schoolYearID = $pass_row['currentSchoolYear'];
	$schoolYear   = $pass_row['schoolYear'];
	$isBodySimple = $pass_row['isBodySimple'];


?>