<?php
//filter.php  
require '../include/config.php';
require '../include/getschoolyear.php';

if (isset($_POST["from_date"], $_POST["to_date"])) {
    $FromTime   = date('Y-m-d', strtotime($_POST['from_date']));
    $ToDate   = date('Y-m-d 23:59:59.999', strtotime($_POST['to_date']));

    $output = '';
    $query =
        "SELECT userID, fname, lname, activity, activityDate FROM tbl_audittrail 
           WHERE activityDate >='" . $FromTime . "'  
           AND activityDate <= '" . $ToDate . "' 
           AND schoolYearID = '" . $schoolYearID . "' order by activityDate asc
      ";
    $result = mysqli_query($conn, $query);
    $output .= '  
            <table class="table table-bordered" style="table-layout: fixed; width: 100%;" > 
                <tr>  
                    <th hidden="true">UserID</th>
                    <th hidden="true">First Name</th>
                    <th hidden="true">Last Name</th>
                    <th hidden="true">Activity</th>
                    <th hidden="true">Activity Date</th>
                </tr>  
      ';

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {

            $output .= '  
                     <tr>  
                          <td>' . $row["userID"] . '</td>  
                          <td>' . $row["fname"] . '</td>  
                          <td>' . $row["lname"] . '</td>  
                          <td>' . $row["activity"] . '</td>  
                          <td>' . $row["activityDate"] . '</td>  
                     </tr>  
                ';
        }
    } else {
        $output .= '  
                <tr>  
                     <td colspan="5">No Record Found</td>  
                </tr>  
           ';
    }
    $output .= '</table>';
    echo $output;
}
