<!DOCTYPE html>
<?php
require '../include/config.php';
require '../assets/phpfunctions.php';
require '../include/schoolConfig.php';
require '../include/getschoolyear.php';
require 'assets/generalSandC.php';
require 'assets/fonts.php';
require 'assets/adminlte.php';
$page = "inbox";

session_start();
?>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Parent Portal | Inbox</title>
     <link rel="shortcut icon" href="../assets/imgs/favicon.ico">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../include/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../include/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../include/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link rel="stylesheet" href="../include/plugins/datatables-bs4/css/dataTables.bootstrap4.css">

    <link rel="stylesheet" type="text/css" href="../assets.css.tablestyle.css">


</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php
        require 'includes/navAndSide.php';
        $user_check = $_SESSION['userID'];
        $levelCheck = $_SESSION['usertype'];
        if (!isset($user_check) && !isset($password_check)) {
            session_destroy();
            header("location: ../login.php");
        } else if ($levelCheck == 'P') {
            header("location: index.php");
        } else if ($levelCheck == 'E') {
            header("location: PersonnelHome.php");
        }

        ?>

        <div class="content-wrapper">

            <div class="container-fluid">

                <section class="content">

                    <div class="row">

                        <div class="col-md-12">

                            <div class="card card-outline card-info">

                                <div class="card-header">
                                    <div class="card-title" style="font-size: 30px;">

                                        Inbox
                                        <small></small>

                                    </div>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                            <i class="fas fa-minus"></i></button>
                                    </div>

                                </div>

                                <div class="card-body pad">

                                    <div class="col-sm-4">
                                        <div class="card-tools">
                                            <!-- <div class="input-group input-group-sm">
                                                <input id="searchbox" type="text" class="form-control" placeholder="Search Subject">
                                                <div class="input-group-append">
                                                    <div id="filter" class="btn btn-primary">
                                                    <i class="fas fa-search"></i>
                                                </div>
                                            </div>
                                        </div> -->
                                        </div>
                                    </div>

                                    <div class="card-body p-0">
                                        <!-- <div class="mailbox-controls"> -->
                                        <!-- <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                                            </button> -->
                                        <!-- <div class="btn-group"> -->
                                        <!-- <button type="button" class="btn btn-default btn-sm"><i class="far fa-trash-alt"></i></button>
                                                <button type="button" class="btn btn-default btn-sm"><i class="fas fa-reply"></i></button>
                                                <button type="button" class="btn btn-default btn-sm"><i class="fas fa-share"></i></button> -->
                                        <!-- </div> -->

                                        <!-- <div class="float-right">
                                            1-50/200
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm"><i class="fas fa-chevron-left"></i></button>
                                                <button type="button" class="btn btn-default btn-sm"><i class="fas fa-chevron-right"></i></button>
                                            </div>

                                        </div> -->

                                        <!-- </div> -->

                                        <div class="table-responsive mailbox-messages">
                                            <table id="example1" class="table table-hover" style="table-layout: fixed; width: 100%;">
                                                <thead>
                                                    <tr hidden="true">
                                                        <th>Username</th>
                                                        <th>Subject / Message</th>
                                                        <th>Date Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    date_default_timezone_set('Asia/Manila');
                                                    function facebook_time_ago($timestamp)
                                                    {
                                                        $time_ago = strtotime($timestamp);
                                                        $current_time = time();
                                                        $time_difference = $current_time - $time_ago;
                                                        $seconds = $time_difference;
                                                        $minutes      = round($seconds / 60);           // value 60 is seconds  
                                                        $hours           = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec  
                                                        $days          = round($seconds / 86400);          //86400 = 24 * 60 * 60;  
                                                        $weeks          = round($seconds / 604800);          // 7*24*60*60;  
                                                        $months          = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60  
                                                        $years          = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60  
                                                        if ($seconds <= 60) {
                                                            return "Just Now";
                                                        } else if ($minutes <= 60) {
                                                            if ($minutes == 1) {
                                                                return "one minute ago";
                                                            } else {
                                                                return "$minutes minutes ago";
                                                            }
                                                        } else if ($hours <= 24) {
                                                            if ($hours == 1) {
                                                                return "an hour ago";
                                                            } else {
                                                                return "$hours hrs ago";
                                                            }
                                                        } else if ($days <= 7) {
                                                            if ($days == 1) {
                                                                return "yesterday";
                                                            } else {
                                                                return "$days days ago";
                                                            }
                                                        } else if ($weeks <= 4.3) //4.3 == 52/12  
                                                        {
                                                            if ($weeks == 1) {
                                                                return "a week ago";
                                                            } else {
                                                                return "$weeks weeks ago";
                                                            }
                                                        } else if ($months <= 12) {
                                                            if ($months == 1) {
                                                                return "a month ago";
                                                            } else {
                                                                return "$months months ago";
                                                            }
                                                        } else {
                                                            if ($years == 1) {
                                                                return "one year ago";
                                                            } else {
                                                                return "$years years ago";
                                                            }
                                                        }
                                                    }



                                                    $sql = "SELECT a.Subject_Id ,b.MessageBody, b.PostedDateTime,
                                                    c.fullName, d.fullName, b.SenderUser_Id, b.ReceiverUserId
                                                    FROM tbl_MessageThread a
                                                    Left JOIN tbl_Message b ON b.Message_Id = a.Message_Id
                                                    LEFT JOIN tbl_parentuser c ON c.userID = b.SenderUser_Id
                                                    LEFT JOIN tbl_parentuser d ON d.userID = b.ReceiverUserId
                                                    WHERE b.schoolYearID = '" . $schoolYearID . "' AND b.SenderUser_Id = '" . $_SESSION['userID'] . "' 
                                                    OR b.ReceiverUserId = '" . $_SESSION['userID'] . "' 
                                                    ORDER BY  b.PostedDateTime desc";

                                                    $result = mysqli_query($conn, $sql);
                                                    if ($result) {
                                                        if (mysqli_num_rows($result) > 0) {
                                                            $counter = 0;
                                                            $addUser1 = array();
                                                            $addUser = array();
                                                            $addedInbox = array();
                                                            while ($row = mysqli_fetch_array($result)) {

                                                                if (in_array($row[0],  $addedInbox)) {
                                                                } else {
                                                                    $addedInbox[] = $row[0];
                                                                    $subjID = $row[0];
                                                                    $msg = $row[1];
                                                                    $date = date_format(date_create($row[2]), "Y-m-d H:i:s");
                                                                    $sfname = $row[3];
                                                                    $rfname = $row[4];
                                                                    $sID = $row[5];
                                                                    $rID = $row[6];

                                                                    $addUser[] = $row[5];
                                                                    $addUser1[] = $row[6];
                                                                    $body = html_entity_decode(htmlspecialchars_decode($msg));
                                                                    $out = strlen($body) > 20 ? substr($body, 0, 20) . "..." : $body;

                                                                     $salt = "Ph03n1x927";

                                                                    $var1 = md5($salt.$row[0].$row[5]);
                                                                    $var2 = md5($salt.$row[0].$row[6]);


                                                                    $encodeThis1 = urlencode(base64_encode($row[0]));
                                                                    $encodeThis2 = urlencode(base64_encode($row[5]));
                                                                    $encodeThis3 = urlencode(base64_encode($row[6]));
                                                                    $encodeThis4 = urlencode(base64_encode($var1));
                                                                    $encodeThis5 = urlencode(base64_encode($var2));





                                                                    if ($_SESSION['userID'] == $sID) {
                                                                        if (in_array($rID,  $addUser)) {
                                                                        } else {
                                                                            echo "<tr>";
                                                                            echo '<td align="left"> <h5> <a href="readmail.php?page=' . $encodeThis1 . '&id=' . $encodeThis3 . '&hash='.$encodeThis5.'">';
                                                                            echo  $row[4];
                                                                            echo "</h5></td>";

                                                                            echo "<td align='center'>";
                                                                            // echo "<h4>$out1</h4> ";
                                                                            echo "<h6>$out</h6>";
                                                                            echo "</td>";

                                                                            echo "<td align='right'><h6>";
                                                                            echo facebook_time_ago($date);
                                                                            echo "</h6></td>";
                                                                            echo "</tr>";
                                                                            $addUser++;
                                                                            // $addUser = array($counter => $rID);
                                                                            // $counter++;
                                                                        }
                                                                    } elseif ($_SESSION['userID'] == $rID) {
                                                                        if (in_array($sID, $addUser1)) {
                                                                            // class="clickableRow"
                                                                        } else {
                                                                            echo "<tr>";
                                                                            echo '<td align="left"> <h5> <a href="readmail.php?page=' . $encodeThis1 . '&id=' . $encodeThis2 . '&hash='.$encodeThis4.'">';
                                                                            echo $row[3];
                                                                            echo "</h5></td>";

                                                                            echo "<td align='center'>";
                                                                            // echo "<h4>$out1</h4> ";
                                                                            echo "<h6>$out</h6>";
                                                                            echo "</td>";

                                                                            echo "<td align='right'><h6>";
                                                                            echo facebook_time_ago($date);
                                                                            echo "</h6></td>";
                                                                            echo "</tr>";
                                                                            $addUser1++;
                                                                            // $addUser = array($counter => $sID);
                                                                            // $counter++;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        } else {
                                                            //
                                                        }
                                                    } else {
                                                        echo "<script> swal('error'); </script>";
                                                    }




                                                    ?>
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>
                                    <!-- <div class="card-footer p-0">

                                        <div class="mailbox-controls">

                                            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                                            </button>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm"><i class="far fa-trash-alt"></i></button>
                                                <button type="button" class="btn btn-default btn-sm"><i class="fas fa-reply"></i></button>
                                                <button type="button" class="btn btn-default btn-sm"><i class="fas fa-share"></i></button>
                                            </div>

                                            <button type="but ton" class="btn btn-default btn-sm"><i class="fas fa-sync-alt"></i></button>
                                            <div class="float-right">
                                                1-50/200
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm"><i class="fas fa-chevron-left"></i></button>
                                                    <button type="button" class="btn btn-default btn-sm"><i class="fas fa-chevron-right"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                    </div> -->

                                </div>

                            </div>

                        </div>
                </section>
            </div>
        </div>
        <?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>
    </div>
    <?php

    require 'assets/scripts.php';
    ?>
    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../include/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/demo.js"></script>
    <!-- Page Script -->
    <script src="../include/plugins/datatables/jquery.dataTables.js"></script>

    <script src="../include/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

    <script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script> <!-- for sorting dates -->
    <script>
        $(document).ready(function() {
            $('#example1').DataTable({
                "scrollX": true,
                "order": [
                    [2, "desc"]
                ],
                "columnDefs": [{
                    "targets": 2,
                    "type": "date-eu"
                }]
            });
        });

        // $(document).ready(function() {
        //     load_data();

        //     function load_data(query) {
        //         $.ajax({
        //             url: "filtersubject.php",
        //             method: "POST",
        //             data: {
        //                 query: query
        //             },
        //             success: function(data) {
        //                 $('#example1').html(data);
        //             }
        //         });
        //     }
        //     $('#searchbox').keyup(function() {
        //         var search = $(this).val();
        //         if (search != '') {
        //             load_data(search);
        //         } else {
        //             load_data();
        //         }
        //     });
        // });

        $(function() {
            //Enable check and uncheck all functionality
            $('.checkbox-toggle').click(function() {
                var clicks = $(this).data('clicks')
                if (clicks) {
                    //Uncheck all checkboxes
                    $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
                    $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
                } else {
                    //Check all checkboxes
                    $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
                    $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
                }
                $(this).data('clicks', !clicks)
            })

            //Handle starring for glyphicon and font awesome
            $('.mailbox-star').click(function(e) {
                e.preventDefault()
                //detect type
                var $this = $(this).find('a > i')
                var glyph = $this.hasClass('glyphicon')
                var fa = $this.hasClass('fa')

                //Switch states
                if (glyph) {
                    $this.toggleClass('glyphicon-star')
                    $this.toggleClass('glyphicon-star-empty')
                }

                if (fa) {
                    $this.toggleClass('fa-star')
                    $this.toggleClass('fa-star-o')
                }
            })
        })

        // $(function() {
        //     $(".clickableRow").on("click", function() {
        //         document.location = $(this).data("href");

        //     });

        // });
    </script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <script src="includes/sessionChecker.js"></script>
    <script type="text/javascript">
        extendSession();
        var isPosted;
        var isDisplayed = false;
        setInterval(function() {
            sessionChecker();
        }, 20000); //time in milliseconds 
    </script>
    <?php require '../maintenanceChecker.php';
    ?>
</body>

</html>