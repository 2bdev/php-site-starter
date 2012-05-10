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
	// assumes that a SITE_URL variable is set
	// keeps the like button in a wrapper for styling purposes
?>
<div class="fb">
	<div class="fb-like" data-href="<?php echo SITE_URL; ?>" data-send="false" data-layout="button_count" data-width="50" data-show-faces="false"></div>
</div>