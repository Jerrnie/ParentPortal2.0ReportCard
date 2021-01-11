    <!-- sweet alert -->
    <script type="text/javascript" src="../include/plugins/sweetalert2/sweetalert2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../include/plugins/sweetalert2/sweetalert2.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<input type="" id="field1" name="" oninput="lenValidation('field1','10')" >

<input type="" id="field2" name="" oninput="lenValidation('field2','5')" >
<script type="text/javascript">

	
function lenValidation(id,limit) {
	if ($("#"+id).val().length>=limit) {
		$("#"+id).val($("#"+id).val().substr(0,limit));
		  const toast = swal.mixin({
		  toast: true,
		  position: 'bottom-end',
		  showConfirmButton: false,
		  timer: 3000 });
			toast.fire({
		  type: 'warning',
		  title: 'The maximum number of characters has been reached!'
		});
	}
}


</script>