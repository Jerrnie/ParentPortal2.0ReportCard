<?php
require_once('bdd.php');


require '../include/config.php';

require '../include/getschoolyear.php';
require 'assets/scripts/phpfunctions.php';
require 'assets/fonts.php';
require '../include/schoolConfig.php';
require 'assets/adminlte.php';
$page = "personnelCalendar";

$sql = "SELECT id, title, description,start, end, color FROM events WHERE schoolYearID = '" . $schoolYearID . "'";
$req = $bdd->prepare($sql);
$req->execute();

$events = $req->fetchAll();

$page = "parentCalendar";
session_start();
  $userID = $_SESSION['userID'];
  $userFname = $_SESSION['first-name'];
  $userMname = $_SESSION['middle-name'];
  $userLname = $_SESSION['last-name'];
  $userLvl = $_SESSION['usertype'];
  $userEmail = $_SESSION['userEmail'];


  $user_check = $_SESSION['userID'] ;
  $levelCheck = $_SESSION['usertype'];
  if(!isset($user_check) && !isset($password_check))
  {
    session_destroy();
    header("location: ../index.php");
  }

  else if ($levelCheck=='A'){
    header("location: index.php"); 
  }
  else if ($levelCheck=='E'){
    header("location: PersonnelHome.php");
  }
  else if ($levelCheck == 'S') {
	  header("location: index.php");
  }


  ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="author" content="">
	<title>Events Calendar | Parent Portal</title>

    <!-- Bootstrap Core CSS  	<link href="assets/calendar/css/bootstrap.min.css" rel="stylesheet">
   -->

	<!-- FullCalendar -->
	<link href='assets/calendar/css/fullcalendar.css' rel='stylesheet' />
	<link rel="stylesheet" type="text/css" href="assets/css/css-navAndSlide.css">
    <!-- Custom CSS -->
    <style>
	#calendar {
		max-width: 800px;
	}
	.col-centered{
		float: none;
		margin: 0 auto;
	}

    </style>

</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper">
<?php
require 'includes/navAndSide2.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Events Calendar</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Events Calendar</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
	
    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-lg-12 text-center">
			<div id="calendar" class="col-centered">
                </div>
            </div>
			
        </div>
        <!-- /.row -->
	</div>
	
		<!-- Modal -->
		<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			<form class="form-horizontal" method="POST" action="editEventTitle.php">
			  <div class="modal-header">
				  <br>
				<h4 class="modal-title" id="myModalLabel">Event Details</h4>
			  </div>
			  <div class="modal-body">

				  <div class="form-group">
					<label for="title" class="col-sm-2 control-label">Title</label>
					<div class="col-sm-10">
					  <input type="text" name="title" class="form-control" id="title" placeholder="Title" readonly>
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="description" class="col-sm-2 control-label">Description</label>
					<div class="col-sm-10">
					<textarea type="text" name="description" class="form-control" id="description" placeholder="Description" readonly rows="4" cols="50" ></textarea>
					</div>
				  </div>
				  <div class="form-group">
					<label for="start" class="col-sm-2" style="font-size:14px">Start Date and Time</label>
					<div class="col-sm-10">
					  <input type="text" name="start" class="form-control" id="start" readonly>
					</div>
				  </div>
				  <div class="form-group">
					<label for="end" class="col-sm-2" style="font-size:14px">End Date and Time</label>
					<div class="col-sm-10">
					  <input type="text" name="end" class="form-control" id="end" readonly>
					</div>
				  </div>
 
				  <input name="id" class="form-control fetched-data" id="id" hidden>
				
				
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
			  </div>
			</form>
			</div>
		  </div>
		</div>

	</div>
	<?php 
    require '../include/getVersion.php';
    include 'footer.php';
    ?>

    <!-- /.container -->
	<?php

require 'assets/scripts.php';

?>
    <!-- jQuery Version 1.11.1 -->
    <script src="assets/calendar/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="assets/calendar/js/bootstrap.min.js"></script>
	
	<script src='assets/calendar/js/moment.js'></script>
	<script src='assets/calendar/js/moment-with-locales.js'></script>

	<!-- FullCalendar -->
	<script src='assets/calendar/js/moment.min.js'></script>
	<script src='assets/calendar/js/fullcalendar.min.js'></script>
	<script>

	$(document).ready(function() {
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			selectable: true,
			selectHelper: true,
			select: function(start, end) {
				
				$('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD ha'));
				$('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD ha'));
				$('#ModalAdd').modal('show');
			},
			eventRender: function(event, element) {
				element.bind('dblclick', function() {
					$('#ModalEdit #id').val(event.id);
					$('#ModalEdit #title').val(event.title);
					$('#ModalEdit #description').val(event.description);
					$('#ModalEdit #color').val(event.color);
					$('#ModalEdit #start').val(moment(event.start).format('LLL'));
					$('#ModalEdit #end').val(moment(event.end).format('LLL'));
					$('#ModalEdit').modal('show');
				});
			},
			eventDrop: function(event, delta, revertFunc) { 

				edit(event);

			},
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) { 

				edit(event);

			},
			events: [
			<?php foreach($events as $event): 
			
				$start = explode(" ", $event['start']);
				$end = explode(" ", $event['end']);
				if($start[1] == '00:00:00'){
					$start = $start[0];
				}else{
					$start = $event['start'];
				}
				if($end[1] == '00:00:00'){
					$end = $end[0];
				}else{
					$end = $event['end'];
				}
			?>
				{
					id: '<?php echo $event['id']; ?>',
					title: '<?php echo $event['title']; ?>',
					description: '<?php echo $event['description']; ?>',
					start: '<?php echo $start; ?>',
					end: '<?php echo $end; ?>',
					color: '<?php echo $event['color']; ?>',
				},
			<?php endforeach; ?>
			],
			eventMouseover: function(calEvent, jsEvent) {
    var tooltip = '<div class="tooltipevent" style="width:200px;;background:#fff;position:absolute;z-index:10001;">Double click to see details. </div>';
    var $tooltip = $(tooltip).appendTo('body');

    $(this).mouseover(function(e) {
        $(this).css('z-index', 10000);
        $tooltip.fadeIn('500');
        $tooltip.fadeTo('10', 1.9);
    }).mousemove(function(e) {
        $tooltip.css('top', e.pageY + 10);
        $tooltip.css('left', e.pageX + 20);
    });
},

eventMouseout: function(calEvent, jsEvent) {
    $(this).css('z-index', 8);
    $('.tooltipevent').remove();
}
		});		
	});

</script>
<?php require '../maintenanceChecker.php';
  ?>
</body>
<script src="includes/sessionChecker.js"></script>
<script type="text/javascript">
    extendSession();
    var isPosted;
    var isDisplayed = false; 
setInterval(function(){sessionChecker();}, 20000);//time in milliseconds 
</script>

</html>
