<?php
	// this section is for the intial gallery page load
	/* there is a lot of room for improvement, some ideas:
	 * 1 - keep track of what page they were on with sessions
	 * 2 - add a feature to allow additional filters, i.e. week id in baby tales
	 */
	// assumes that there is a PER_PAGE variable set in config
?>
<?php 
	include_once("config/config.php"); 

	// calculate pages
	$sql = "SELECT entry_id FROM tales_entries WHERE hidden=0";
	$rs = mysql_query($sql);
	$total = mysql_num_rows($rs);
	$pages = ceil($total / PER_PAGE);
	
	// go get pages from db and build an array called entries
	$sql = "SELECT entry_id, image_type, image_name, story_title, first_name, last_name, state FROM tales_entries WHERE hidden=0 ORDER BY date DESC LIMIT 0,".PER_PAGE;
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
?>

<?php
	// this is some sample HTML for a gallery, may need to be changed from project to project
	// any changes to markup will have an effect on the build_posts function in Javascript
?>
	<div id="gallery-grid">
		<?php foreach($entries as $entry) : ?>
		<div>
			<a href="<?php echo SITE_URL."tale.php?id=".$entry['id']; ?>">
				<img src="<?php echo $entry['img_src']; ?>" alt="" />
				<h2><?php echo $entry['title']; ?></h2>
			</a>
			<p><a href="<?php echo SITE_URL."tale.php?id=".$entry['id']; ?>"><?php echo $entry['name']; ?></a></p>
		</div>
		<?php endforeach; ?>
	</div>
	
	<?php // conditionally show paging if there is more than one page ?>
	<?php if($pages > 1) : ?>
	<div class="clearfix" id="pager-wrapper">
		<p>Page</p>
		<a id="pager-first">&laquo; First</a>
		<a id="pager-prev">&lsaquo; Previous</a>
		<?php for($i=1; $i<=$pages; $i++) : ?>
			<a href="#posts-top" class="pager<?php echo ($i==1) ? " selected" : ""; ?>" data-page="<?php echo $i; ?>"><?php echo $i; ?></a>
		<?php endfor; ?>
		<a id="pager-next">Next &rsaquo;</a>
		<a id="pager-last">Last &raquo;</a>
	</div>
	<?php endif; ?>

<?php
	// this loads a javascript file 
	// assumes relativity to a js directory
	// assumes jquery is loaded for all JS
?>
<script src="js/pager.js"></script>

<?php
	// this handles the javascript that may be different from project to project
?>
<script>
	$("a.pager").click(function(evt){
		evt.preventDefault();
		var page = $(this).attr("data-page");
		var clicked = $(this);
		$.ajax({
			url: "handles/handlePager.php",
			dataType: "json",
			type: "POST",
			data: {"page":page},
			success: function(resp){
				if(resp.status == "success") {
					update_pager(page);
					build_posts(resp.data);
					<?php // if #posts-top is needed, be sure to change the scroll to selector ?>
					$("html,body").animate({scrollTop: $("#gallery-grid").offset().top}, "slow");
				} else if(resp.status == "fail") {
					alert(resp.message);
				} else {
					alert("There was an unknown error");
				}
			}
		});
	});
	
	function build_posts(data) {
		var size = data.length;
		<?php // sometimes this is needed if gallery grid isn't positioned where we want ?>
		//var html = '<div id="posts-top"></div>';
		var html = '';
		// clear old posts
		$("#gallery-grid").html(html);
		for(var i=0; i<size; i++) {
			html = '<div><a href="tale.php?id='+data[i].id+'"><img src="'+data[i].img_src+'" alt="" /><h2>'+data[i].title+'</h2><p>'+data[i].name+'</a></div>';
			$("#gallery-grid").append(html);			
		}
	}
	
</script>
</body>
</html>
