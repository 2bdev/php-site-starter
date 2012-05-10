<?php
	// here is the markup for the button to display
	// it is kept in a wrapper for styling purposes
?>
<div class="email">
	<a id="email-button" class="email-button" href="#">Email</a>
</div>


<?php
	// this is the form for sending emails for sharing
?>
<div class="email-poppers" id="email-popup">
	<form id="email-form" action="handleEmail.php" method="post">
		<h2>Enter your email address:</h2>
		<input type="text" id="sender" name="sender" class="your-email" value="">
		               
		<div id="many-emails">
			<h2>Enter your friends' email addresses:</h2>
			<input type="text" id="friend1" class="friend-email" name="friends[]" />
			<input type="text" id="friend2" class="friend-email" name="friends[]" />
			<input type="text" id="friend3" class="friend-email" name="friends[]" />
			<input type="text" id="friend4" class="friend-email" name="friends[]" />
		</div>
		               
		<div class="message" id="emailMessage" name="emailMessage">The questions, topics, and prizes are ever-changing, but there are always some great pics up there from fans of Stonyfield Organic Oikos. Check out the gallery and upload your own!</div>            
		<p class="disclaimer">*We will not use your friends' information other than to facilitate your sending of this one time email.</p>
		<button type="submit" class="button submit" id="send-emails">Submit</button>
		
		<div class="close">or cancel</div>
	</form>                    
</div>

<?php
	// depends on jquery being loaded
	// here is the javascript to handle the email form
?>
<script>
$("#email-button").click(function(evt){
	evt.preventDefault();
	$("#email-popup").show();
});

$(".close").click(function() { 
	$(this).parentsUntil(".email-poppers").parent().hide();
});

$("#email-form").submit(function(evt){
	evt.preventDefault();
	$("#send-emails").attr("disabled","disabled");
	var sender = $("#sender").val();
	var friend1 = $("#friend1").val();
	
	var validEmailExp = /^[^@]+@[a-z0-9.-]+\.[a-z]{2,}$/i;

	var error = false;
	var errorMsgs = new Array();
	
	if(validEmailExp.test(sender) == false){
		error = true;
		errorMsgs.push("You must provide your valid email address");
	}
	
	if(validEmailExp.test(friend1) == false) {
		error = true;
		errorMsgs.push("You must provide at least one valid friend's email address");
	}
	
	if(! error) {
		$.ajax({
			url: "<?php echo SITE_URL; ?>handles/handleEmail.php",
			type: "POST",
			dataType: "json",
			data: $("#email-form").serialize(),
			success: function(resp){
				if(resp.status == "success"){
					$("#email-popup .close").trigger("click");
					$("#send-emails").removeAttr("disabled");
					alert(resp.message);
				} else if(resp.status == "fail") {
					alert(resp.message);
					$("#send-emails").removeAttr("disabled");
				} else {
					alert("An unknown error occurred");
					$("#send-emails").removeAttr("disabled");
				}
			}
		});
	} else {
		displayErrors(errorMsgs);
		$("#send-emails").removeAttr("disabled");
	}

	$("#send-emails").removeAttr("disabled");		
});

function displayErrors(errMsgs){
	var size = errMsgs.length;
	var message = "";
	for(var i=0;i<size;i++){
		message += errMsgs[i]+"\n";
	}
	alert(message);
}
</script>