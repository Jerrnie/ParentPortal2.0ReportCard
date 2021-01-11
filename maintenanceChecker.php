<?php 


$sql = "sELECT * FROM tbl_settings";

$result = mysqli_query($conn, $sql);

  $totalrows = mysqli_num_rows($result);


  if($totalrows > 0){
  $pass_row = mysqli_fetch_assoc($result);
    
  $isMaintenance  = $pass_row['isMaintenance'];
  $mStartDate   = $pass_row['startDate'];
  $mEndDate   = $pass_row['endDate'];
  $hours   = $pass_row['hoursToNotify'];
  $timeWarning = $hours * 3600;

  $newDate = date("F d, Y", strtotime($mStartDate));  
   $newDate1 = date("h:ia", strtotime($mStartDate));  
  $newDate2 = date("h:ia", strtotime($mEndDate));  

$date = new DateTime(date("Y-m-d H:i:s"));
$date2 = new DateTime($mEndDate );
$date3 = new DateTime($mStartDate );



$diff = $date2->getTimestamp() - $date->getTimestamp();
$diff2 = $date3->getTimestamp() - $date->getTimestamp();
$diffToWarn =  $diff2 - $timeWarning;

$mins = floor($diff2/60);
$secs = $diff2 % 60;

  if ($isMaintenance) {

    //check if maintenance is done
    if ($diff<1) {
      $sql = "Update tbl_settings set isMaintenance = 0 where skey = 1;";
      mysqli_query($conn, $sql);
    }

    elseif ($diffToWarn<1&&$diff2>1) {
      # display

      # 
echo '

<style type="text/css">
  .alert-fixed {
    position:fixed; 
    left:20px;
    bottom: 1px; 
    width: 100%;
    z-index:9999; 
    border-radius:0px
}
</style>
<script type="text/javascript">
var timer = setInterval(function () {
    $(".countdown").each(function() {
        var newValue = parseInt($(this).text(), 10) - 1;
        $(this).text(newValue);

        if (newValue < 10 && newValue > 0) {
          $(this).text("0"+$(this).text());
        }
        if(newValue == 0) {
           $(this).text(59);
           var newValue2 = parseInt($(".countdown2").text(), 10) - 1;
           if (newValue2==0) {
            $(".countdown2").text("00");
           }
           else if (newValue2<10 && newValue2>0) {
              $(".countdown2").text("0"+newValue2);
           }
           else if ($(".countdown2").text()<=0) {
              document.location.href = "underMaintenance.php";
           }
           else{
           $(".countdown2").text(parseInt($(".countdown2").text(), 10) - 1);

           }
        }
    });
}, 1000);
</script>

  <div class="row alert-fixed">
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <span class=" fa fa-exclamation-triangle">&nbsp&nbsp</span>Website Advisory<br>
The Parent Portal will undergo a regular website maintenance on <b>'.$newDate.' from '.$newDate1.' - '.$newDate2.'</b> Philippine time. 
<br>You won\'t be able to access the website until the maintenance is complete. We apologize for the inconvenience.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
</div>



';

    }
    elseif ($diff2<1){
    header("Location: underMaintenance.php");
    }

  }



  }


?>

