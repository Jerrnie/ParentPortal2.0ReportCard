  <?php

  require '../include/config.php';
  require '../include/getschoolyear.php';
  //filter.php  
  if (isset($_POST["subfrom"], $_POST["subto"] , $_POST["sectioncode"])) {


    $FromTime   = date('Y-m-d', strtotime($_POST['subfrom']));

    $ToDate   = date('Y-m-d 23:59:59.999', strtotime($_POST['subto']));

    $query ="SELECT b.lastName,b.firstName,b.middleName,a.TimePunch,a.Mode,b.studentCode,c.sectionName,c.sectionYearLevel
        FROM tbl_Attendance AS a, tbl_student AS b,tbl_sections as c WHERE b.studentCode=a.StudentId AND b.sectionID = c.sectionID
        AND b.sectionID = '".$_POST['sectioncode']."' AND a.TimePunch >='" . $FromTime . "' 
        AND a.TimePunch <= '" . $ToDate . "' AND a.isStudent = '1' 
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
            <td class="text-center">
              <h4><span style="font-weight:normal;" class="badge">
                  <?php echo $row["lastName"];
                  echo ','; ?>
                  <?php echo $row["firstName"];
                  echo ' '; ?>
                  <?php echo $row["middleName"]; ?>
                </span></h4>
            </td>
            
            <td class="text-center">
              <h4><span style="font-weight:normal;" class="badge">
              
              <?php echo $row["sectionYearLevel"];
                  echo ' -'; ?>
                  
                  <?php echo $row["sectionName"];?>
                </span></h4>
            </td>

            <td class="text-center">
              <h4><span style="font-weight:normal;" class="badge"><?php echo date_format(date_create($row["TimePunch"]), "M d, Y h:i A"); ?></span></h4>
            </td>
            <?php if ('1' == $row["Mode"]) {
              echo '<td  class="text-center"><h4><span style="font-weight:normal; width:100px; height:30px;" class="badge badge-success">TIME IN</span></h4></td>';
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
      echo 'window.open("../u/exportAllStudentAttendancePerSection.php","_self")';
      echo '</script>';
      exit;
      }
      ?>
    <?php }
    ?>
        </table>