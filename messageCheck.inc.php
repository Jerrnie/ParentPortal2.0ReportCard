<?php 
require 'sendText2.php';
	$sql = 'SELECT a.*,b.fullName,c.firstName,c.lastName,c.middleName,b.mobile FROM tbl_pr AS a inner join tbl_parentuser as b on a.userID = b.userID inner JOIN tbl_student AS c ON c.studentID = a.studentID WHERE a.remindDate <= CURRENT_DATE() and isSent = 0  && isDeleted = 0';
	if ($result1 = mysqli_query($conn, $sql)) {
		if (mysqli_num_rows($result1) > 0) {
			while($row = mysqli_fetch_array($result1)){
				$prID				=$row[0];
				$userID				=$row[1];
				$studentID			=$row[2];
				$amount				=$row[3];
				$accountNumber		=$row[4];
				$remindDate			=$row[5];
				$isSent				=$row[6];
				$isDeleted			=$row[7];
				$deadline			=$row[8];
				$parentName         =$row[9];
				$firstName			=$row[10];
				$lastName			=$row[11];
				$middleName			=$row[12];
				$mobile				=$row[13];

				$pname = $parentName;
				$sname = ucwords(combineName($row[10],$row[11],$row[12]));
				$studentName         = $firstName . " " . $middleName[0].". " . $lastName;
				$an =$accountNumber;
				$deadline2 = date("F d, Y", strtotime($deadline));  
				require 'u/paymentReminderMessage.inc.php';


				if (empty($accountNumber)) {
					sendMessage($userID,"1",$message);
					sendOTP($message, $mobile);
				}
				else{
					sendMessage($userID,"1",$messageWithACN);
					sendOTP($messageWithACN, $mobile);
				}

				 $insertQuery2 = "update tbl_pr
set
isSent			='1'
where prID = '".$prID."'";

mysqli_query($conn, $insertQuery2);
				

			}
		}
		else{

		}
	}
	else{

	}




?>