  
<?php

require '../include/config.php';
require '../include/getschoolyear.php';
//filter.php  
if (isset($_POST["from_date"], $_POST["to_date"], $_POST["pid"])) {

    require '../include/config.php';

    $FromTime   = date('Y-m-d', strtotime($_POST['from_date']));
    
    $ToDate   = date('Y-m-d 23:59:59.999', strtotime($_POST['to_date']));

    $query =
        "SELECT TimePunch,Mode FROM tbl_Attendance
        where StudentId = '".$_POST['pid']."' AND TimePunch 
        >= '" . $FromTime . "' AND TimePunch 
        <='" . $ToDate . "' AND isStudent = '2'
        AND schoolYearID = '" . $schoolYearID . "'
        ORDER BY TimePunch DESC    
      ";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {?>
  <table>
            
  <tr>
  <td class="text-center"><h4><span style="font-weight:normal;" class="badge"><?php echo date_format(date_create($row["TimePunch"]), "M d, Y h:i A"); ?></span></h4></td>
    <?php if ('1' == $row["Mode"]) {
    echo '<td class="text-center"><h4><span style="font-weight:normal; width:100px; height:30px;" class="badge badge-success">TIME IN</span></h4></td>';
    } elseif ('2' == $row["Mode"]) {
    echo '<td class="text-center"><h4><span style="font-weight:normal; width:100px; height:30px;" class="badge badge-danger">TIME OUT</span></h4></td>';

    } ?>
  </tr>
<?php }
?>
<?php }  
else {

echo '<script type="text/javascript">';
echo ' alert("No Records to generate Attendance Records")';  //not showing an alert box.
echo '</script>';
echo '<script type="text/javascript">';
echo 'window.open("../u/viewAllAttendance.php","_self")';
echo '</script>';
exit;
}
?>
<?php }
?>
</table>
