<?php
require '../include/config.php';
session_start();

$user_check = $_SESSION['userID'];
$levelCheck = $_SESSION['usertype'];
//$_POST["query"]
//  and
if (isset($_POST["contact"])) {

    $query = "SELECT userID, fname, lname FROM tbl_parentuser WHERE 
    usertype = 'P'";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_array($result)) {
        $uID = $row[0];
        $fname = $row[1];
        $lname = $row[2];

        $output .= '<table id="example1" class="table table-borderless table-striped">';

        $output .=
            '
        echo "<tr>";
        echo "<td>" . $uID  . "</td>";
        echo "<td>" . $fname . " " . $lname . "</td>";   
        echo "</tr>";
        ';
    }

    $output .= '</table>';
    echo $output;
}
