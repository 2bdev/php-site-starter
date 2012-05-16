<?php
$response = array();
if(isset($_POST['page']) && is_numeric($_POST['page'])) {
	include_once("../config/config.php");
	db_connect();
	$page = $_POST['page'];
	$offset = ($page - 1) * PER_PAGE;
	
	$response['page'] = $page;
	$response['offset'] = $offset;
	$response['per_page'] = PER_PAGE;

	$sql = "SELECT entry_id, image_type, image_name, story_title, first_name, last_name, state FROM tales_entries WHERE hidden=0 ORDER BY date DESC LIMIT $offset,".PER_PAGE;
	$rs = mysql_query($sql);
	$entries = array();
	if($rs && mysql_num_rows($rs) > 0) {
		while($row = mysql_fetch_assoc($rs)){
			$t['id'] = $row['entry_id'];
			if($row['image_type'] == "upload") {
				$img_src = SITE_URL."uploads/final/".$row['image_name'];
			} else {
				$img_src = SITE_URL."img/".$row['image_name'];
			}
			$t['img_src'] = $img_src;
			$t['title'] = stripslashes($row['story_title']);
			$t['name'] = ucfirst(stripslashes($row['first_name']))." ".ucfirst(stripslashes(substr($row['last_name'],0,1)))." from ". $row['state'];
			$entries[] = $t;
		}
	}

	$response['status'] = "success";
	$response['data'] = $entries;
} else {
	$response['status'] = "fail";
	$response['message'] = "You must provide a valid page number";
}
echo json_encode($response);

?>