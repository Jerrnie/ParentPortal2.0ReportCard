function extendSession() {

        $.ajax({
            url: 'includes/sessionExtend.php',
            type: "POST",
            cache: false,
            success: function () {
            },
            error: function (xhr, ajaxOptions, thrownError) {
            }
        });
}

function retrieveSession() {
  extendSession();
  isDisplayed=false;
  Swal.close();
}

function sessionChecker() { 
  $.ajax({
    type:"post",
    url:"includes/sessionChecker.php",
    dataType: 'json',
    success:function(data)
    {
      if (data[0]==2&&!isDisplayed) {
            let timerInterval;
            var timerLeft=data[1];
          Swal.fire({
            title: 'Session will expire!',
            html: 'You will be logged out in <b></b> seconds.',
            footer: '<button class="btn btn-primary " onclick="retrieveSession()">Continue session</button>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="includes/logout.php" class="btn btn-danger">Log out</a>',
            timer: timerLeft,
            allowOutsideClick: false,
            allowEscapeKey: false,
            timerProgressBar: true,

            onBeforeOpen: () => {
              Swal.showLoading()
              timerInterval = setInterval(() => {
                const content = Swal.getContent()
                if (content) {
                  const b = content.querySelector('b')
                  if (b) {
                    b.textContent = parseInt(Swal.getTimerLeft()/1000);
                  }
                }
              }, 1000)
            },
            onClose: () => {
              clearInterval(timerInterval)
            }
          }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
              isDisplayed=false;
            }
          });
          isDisplayed=true;
      }
      else if (data[0]==1&&isPosted==null) {
        Swal.fire({
          title: 'Session expired',
          icon: 'info',
          html: 'Please login again',
          allowOutsideClick:false,
          allowEscapeKey: false
        }).then((result) => {document.location.href = 'includes/logout.php?';});
          isPosted=true;
        }

        else if (data[0]==0){
          
        }
        else{
        }
      }
    });
}