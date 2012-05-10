<?php 
	// include the Twitter SDK as close to the opening body tag as possible, or in the head tag
	// could also manually include as: <script id="twitter-wjs" src="//platform.twitter.com/widgets.js"> (???)
?>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

<?php
	// assumes that a SITE_URL variable is set
	// keeps the tweet button in a wrapper for styling purposes
?>
<div class="tw">
	<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo SITE_URL; ?>" data-count="none" data-text="Check out the @Stonyfield Organic Oikos photo share gallery, where questions and prizes are ever-changing!">Tweet</a>
</div>