<?php 
	// include the Facebook SDK as close to the opening body tag as possible
	// make sure to change out the appId
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=288550837903480";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php
	// just a button that will trigger the share dialog, key is id="fb-share"
?>
<a id="fb-share">
	<img src="img/fb.png" alt="" />
	<span>Facebook</span>
</a>

<?php
	// javascript to set up the share object and trigger it on button click
	// provides a callback that checks that the share was successful, this callback makes an AJAX request
?>
<script>
	var share_obj = {
		  method: "feed",
		  name: "Stonyfield's o-MEGA Farm Tour",
		  description: (
		      "o-MEGA Awesome! I just played Stonyfield’s o-MEGA Farm Tour and feel o-MEGA smart. Turns out, we’re closer to the cows than we think!"
		  ),
		  link: "<?php echo SITE_URL; ?>",
		  picture: "<?php echo SITE_URL; ?>img/share-image.jpg"
	};
	
	$("#fb-share").click(function(evt){
		FB.ui(share_obj, shareCallback);
	});
	
	function shareCallback(resp){
		if(resp && resp.post_id) {
			$.ajax({
				url: "handles/handleShare.php",
				dataType: "json",
				type: "POST",
				data: {"entry_id":entry_id},
				success: function(resp){
					if(resp.status == "success"){
						alert("You have been entered for another chance to win!");
					} else if(resp.status == "fail") {
						alert(resp.message);
					} else {
						alert("There was an unknown error");
					}
				}
			});
		}
	}
</script>