<?php

session_start();
if (isset($_SESSION['userID'])) {
	echo "0";
}
else{
	echo "1";
}

?>