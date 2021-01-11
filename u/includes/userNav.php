 <?php
  ob_start();
  function isActive($page, $navtitle)
  {
    if ($page == $navtitle) {
      echo "active";
    } else {
      echo "";
    }
  }
  function treeOpen($page, $navtitle)
  {
    if (strpos($page, $navtitle)) {
      echo "menu-open";
    } else {
      echo "";
    }
  }
  function titlePage()
  {
    echo SCHOOL_NAME;
  }
  require '../include/getschoolyear.php';

  ?>
 <style type="text/css">
   .link-home {}

   .link-registration {}

   .link-accountsetting {
     padding-right: 30px;
   }
 </style>
 <div class="wrapper">

   <!-- Navbar -->
   <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
     <div class="container">
       <a href="../../index3.html" class="navbar-brand">
         <img src="<?PHP echo "../" . SCHOOL_LOGO_PATH ?>" alt="<?PHP echo SCHOOL_ABV ?>" class="brand-image img-circle elevation-3" style="opacity: .8; width: 55px; height: 55px;">
         <span class="brand-text font-weight-light"><?php titlePage(); ?></span>
       </a>

       <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
       </button>
       <div class="collapse navbar-collapse order-3" id="navbarCollapse">


         <!-- Right navbar links -->
         <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
           <li class="nav-item">
             <a href="index3.html" class="nav-link link-home">Home</a>
           </li>
           <li class="nav-item">
             <a href="#" class="nav-link link-registration">Registration</a>
           </li>
           <li class="nav-item dropdown link-accountsetting">
             <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Account Settings</a>
             <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
               <li><a href="#" class="dropdown-item">Change User Information</a></li>
               <li><a href="#" class="dropdown-item">Change Password</a></li>
               <li><a href="#" class="dropdown-item">Change Security Question</a></li>


             </ul>
           </li>

           <!-- Notifications Dropdown Menu -->
           <strong class="nav-link-special ">S.Y. <?php echo $schoolYear ?></strong>
           <li class="nav-item">
             <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">Log Out</a>
           </li>
         </ul>
       </div>

     </div>
   </nav>
   <!-- /.navbar -->