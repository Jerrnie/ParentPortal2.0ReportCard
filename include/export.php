
<?php
  require '../include/config.php';
  require '../u/assets/scripts.php';
  require '../include/getschoolyear.php';
?>


<?php

    //$currentDate = date('Y-m-d H:i:s');
    $date = date_create();
    $currentDateTime = date_format($date,"Y-m-d H:i:s");
    
   // $datestr = $currentDateTime->format('Y-m-d H:i:s');
    $tagsub = 0;
    $tagexpo = 0;
    $all ="";
    $all = $_POST['r1'];
    $filename = $_POST['filename'];
    // $sub = $_POST['r1'];
    // $expo = $_POST['r1'];
    if ($all  == "submitted")
    {
        $tagsub = 1;
    }
    if ($all  == "exported")
    {
        $tagexpo = 1;
    }
    if ($all == "all")
    {
        $quote = '"';
        $tagsub = 1;
        $query = "select s.studentCode as Code, concat(".$quote."'".$quote.",s.LRN) as LRN,
            (case when s.prefix = 'M' then 'Mr.' when s.prefix = 'F' then 'Ms.' End ) as Prefix,
            s.lastName,s.firstName,s.middleName,s.suffix,
            s.birthdate as Birthday,c.fullName as Parentname,
            concat(".$quote."'".$quote.",c.mobile) as Mobileno,
            s.isEldest as Eldest,c.email  from tbl_student s 
            join tbl_parentuser u
            on s.userID = u.userID  
            join tbl_contact c
			on c.studentID = s.studentID
            where s.schoolYearID = " . $schoolYearID . " and s.isSubmitted = $tagsub order by code;";
    }
    elseif ($all == "exported")
    {
        $quote = '"';
        //$query = "select cast(concat(".$quote."'".$quote.",cellphone)  as char) as cellphone  from tbl_student";
        
        $query = "select s.studentCode as Code, concat(".$quote."'".$quote.",s.LRN) as LRN,
            (case when s.prefix = 'M' then 'Mr.' when s.prefix = 'F' then 'Ms.' End ) as Prefix,
            s.lastName,s.firstName,s.middleName,s.suffix,
            s.birthdate as Birthday,c.fullName  as Parentname,
            concat(".$quote."'".$quote.",c.mobile) as Mobileno,
            s.isEldest as Eldest,c.email  from tbl_student s 
            join tbl_parentuser u
            on s.userID = u.userID 
            join tbl_contact c
			on c.studentID = s.studentID
            where isExported = $tagexpo and schoolYearID = $schoolYearID order by code;";
           // and timestamp(dateTimeSubmitted) <= timestamp('".$currentDateTime."') ;";
    }
    else
    {
        $quote = '"';
        //$query = "select cast(concat(".$quote."'".$quote.",cellphone)  as char) as cellphone  from tbl_student";

        $query = "select s.studentCode as Code, concat(".$quote."'".$quote.",s.LRN) as LRN,
            (case when s.prefix = 'M' then 'Mr.' when s.prefix = 'F' then 'Ms.' End ) as Prefix,
            s.lastName,s.firstName,s.middleName,s.suffix,
            s.birthdate as Birthday,c.fullName  as Parentname,
            concat(".$quote."'".$quote.",c.mobile) as Mobileno,
            s.isEldest as Eldest,c.email  from tbl_student s 
            join tbl_parentuser u
            on s.userID = u.userID  
            join tbl_contact c
			on c.studentID = s.studentID
            where s.isSubmitted = $tagsub and  isExported = $tagexpo
            and schoolYearID = $schoolYearID  order by code;";
           //and timestamp(dateTimeSubmitted) < timestamp('".$currentDateTime."') ;";

    
    };
    $resultset = mysqli_query($conn, $query);
 
    if ($resultset->num_rows > 0) {
        while( $rows = $resultset->fetch_assoc())
        {
            $stud[] = $rows;
        }
    }

    if(empty($stud))
    {
      echo '<script type="text/javascript">';
      echo ' alert("No Records to generate Export General Info")';  //not showing an alert box.
      echo '</script>'; 
      echo '<script type="text/javascript">';
      echo 'window.open("../u/exportpage.php","_self")';  
      echo '</script>'; 
     exit;
    }
    else
    {
        $filename = $filename . ".xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        $show_coloumn = false;
        ob_end_clean();
        if(!empty($stud)) 
        {
            foreach($stud as $record) 
            {
                if(!$show_coloumn) 
                {
                // display field/column names in first row
                echo implode("\t", array_keys($record)) . "\n";
                $show_coloumn = true;
                }
                echo implode("\t",  array_values($record)) . "\n";
            }
        } 
        exit();
    }

?>









    