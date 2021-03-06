  <?php

  require '../include/config.php';
  require '../include/getschoolyear.php';

  //filter.php  
  if (isset($_POST["from_date"], $_POST["to_date"])) {

    require '../include/config.php';

    $FromTime   = date('Y-m-d', strtotime($_POST['from_date']));

    $ToDate   = date('Y-m-d 23:59:59.999', strtotime($_POST['to_date']));

    $query =
      "SELECT b.lastName,b.firstName,b.middleName,a.TimePunch,a.Mode,b.studentCode
        FROM tbl_Attendance AS a, tbl_student AS b WHERE b.studentCode=a.StudentId 
        AND TimePunch >='" . $FromTime . "' 
        AND TimePunch <= '" . $ToDate . "' AND a.isStudent = '1' 
        AND a.schoolYearID = '" . $schoolYearID . "' ORDER BY a.TimePunch DESC  
      ";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_array($result)) { ?>
        <table>

          <tr>
            <td class="text-center">
              <h4><span style="font-weight:normal;" class="badge">
                  <?php echo $row["studentCode"]; ?>
                </span></h4>
            </td>
            <td  class="text-center">
              <h4><span style="font-weight:normal;" class="badge">
                  <?php echo $row["lastName"];
                  echo ','; ?>
                  <?php echo $row["firstName"];
                  echo ' '; ?>
                  <?php echo $row["middleName"]; ?>
                </span></h4>
            </td>
            <td class="text-center">
              <h4><span style="font-weight:normal;" class="badge"><?php echo date_format(date_create($row["TimePunch"]), "M d, Y h:i A"); ?></span></h4>
            </td>
            <?php if ('1' == $row[4]) {
              echo '<td class="text-center"><h4><span style="font-weight:normal; width:100px; height:30px;" class="badge badge-success">TIME IN</span></h4></td>';
            } elseif ('2' == $row[4]) {
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
        echo 'window.open("../u/viewAllStudentAttendance.php","_self")';
        echo '</script>';
        exit;
        }
      ?>
    <?php }
    ?>
        </table>