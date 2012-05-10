<?php
	// this file depends on a config file in a specific place
?>

<?php
$response = array();
if(isset($_POST['sender']) && isset($_POST['friends'])) {
	include_once("../config/config.php");
	db_connect();
	
	$sender = escape($_POST['sender']);
	$friends = $_POST['friends'];
	
	// send emails to each friend
	foreach($friends as $friend){
		if(! empty($friend)){
			$response['emails'][] = send_email($sender,$friend);
		}
	}
	
	$response['status'] = "success";
	$response['message'] = "Emails sent successfully!";
} else {
	$response['status'] = "fail";
	$response['message'] = "Not all required fields were found";
}
echo json_encode($response);

function send_email($from,$to){
	$subject = "Stonyfield Organic Oikos Photo Share Gallery!";
	$body = "<html><head></head><body><p>The questions, topics, and prizes are ever-changing, but there are always some great pics up there from fans of Stonyfield Organic Oikos. Check out the gallery and upload your own!<br /><br /><a href='http://stonyfieldcontests.com/oikos-photo-contest/gallery.php'>http://stonyfieldcontests.com/oikos-photo-contest/gallery.php</a></p></body></html>";
	$headers = "From: $from\r\n";
	$headers .= "Content-type: text/html; charset=UTF-8\r\n";
	return mail($to,$subject,$body,$headers);
}
?>