<?php 
  require 'include/schoolConfig.php';
  require 'include/config.php';
  include 'include/fonts.php';
  require 'assets/phpfunctions.php';

  
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
  <title>Site Maintenance | Parent Portal</title>
    <link rel="shortcut icon" href="assets/imgs/favicon.ico">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="UTF-8">
  
  <!-- Font -->
  
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700%7CPoppins:400,500" rel="stylesheet">
  
  <!-- Stylesheets -->
  
  <link href="assets/css/common-css/bootstrap.css" rel="stylesheet">
  
  <link href="assets/css/common-css/ionicons.css" rel="stylesheet">
  
  <link rel="stylesheet" href="assets/css/common-css/jquery.classycountdown.css" />
    
  <link href="assets/css/maintenance-css/maintenance-styles2.css" rel="stylesheet">
  
  <link href="assets/css/maintenance-css/maintenance-responsive2.css" rel="stylesheet">

  
</head>
<body>
  
  <div class="main-area">
    <div class="container full-height position-static">
    
      <section class="left-section full-height">
                  
        <div class="display-table">
          <div class="display-table-cell">
            <div class="main-content">
              <h1 class="title"><b>Under Maintenance</b></h1>
              <p>The Parent Portal is currently undergoing a regular website maintenance. 
This is to ensure that any reporteds issues are fixed and keeping it updated and relevant. 
The website will be available again once the maintenance is complete. We apologize for any inconvenience this has caused you.</p>

<br><br>
            <center>
            <img class="img-school-logo " draggable="false" src="<?php echo SCHOOL_LOGO_PATH ?>" style="border-radius: 50%; float: center; width: 200px; height: 200px;">
            </center>
            </div><!-- main-content -->
          </div><!-- display-table-cell -->
        </div><!-- display-table -->
        
        <!--<ul class="footer-icons">
          <li>Stay in touch : </li>
          <li><a href="#"><i class="ion-social-facebook"></i></a></li>
          <li><a href="#"><i class="ion-social-twitter"></i></a></li>
          <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
          <li><a href="#"><i class="ion-social-instagram-outline"></i></a></li>
          <li><a href="#"><i class="ion-social-pinterest"></i></a></li>
        </ul> -->
    
      </section><!-- left-section -->
  
      <section class="right-section" draggable="false" style="background-image: url(assets/imgs/ChibiMaintenance.png)">
      
        <div class="display-table center-text">
          <div class="display-table-cell">
            
            
            <div id="rounded-countdown">
              <div class="countdown" id="cDown" data-remaining-sec="<?php echo $diff; ?>"></div><!-- countdown -->
            </div>
            
          </div><!-- display-table-cell -->
        </div><!-- display-table -->
        
      </section><!-- right-section -->
    
    </div><!-- container -->
  </div><!-- main-area -->
  
  <!-- SCIPTS -->
  
  <script src="assets/css/common-js/jquery-3.1.1.min.js"></script>
  
  <script src="assets/css/common-js/tether.min.js"></script>
  
  <script src="assets/css/common-js/bootstrap.js"></script>
  
  <script src="assets/css/common-js/jquery.classycountdown.js"></script>
  
  <script src="assets/css/common-js/jquery.knob.js"></script>
  
  <script src="assets/css/common-js/jquery.throttle.js"></script>
  
  <script src="assets/css/common-js/scripts.js"></script>

  <script type="text/javascript">
    
window.setInterval(function(){
  var row = $("#cDown").attr('data-remaining-sec');
    if (row<0) {
      window.location.href = "index.php";
    }
}, 2000);


  </script>
  
</body>
</html>