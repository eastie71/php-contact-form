<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Contact Us</title>

	    <!-- Required meta tags always come first -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <meta http-equiv="x-ua-compatible" content="ie=edge">

	    <!-- Bootstrap CSS -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

	    <style type="text/css">
	    	body {
	    		background-color: #EEEEEE;
	    	}
	    	h2 {
	    		margin-top: 50px;
	    	}
			.errorMsg {
				color: red;
			}

	    </style>

	</head>

	<body>
		<?php
			$emailError = $subjectError = $commentsError = $nameError = "";
			$email = $name = $subject = $comments = "";
			$body = $successMsg = "";
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				# code...
				if (empty($_POST["email"])) {
					$emailError = "Please enter a valid Email address";
				} else {
					$email = clean_input($_POST["email"]);
					// Perform an email address validation
					if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
						$emailError = "Please enter a valid Email address";
					}
				}
				if (empty($_POST["name"])) {
					$nameError = "Please enter your Name";
				} else {
					$name = clean_input($_POST["name"]);
				}
				if (empty($_POST["subject"])) {
					$subjectError = "Please enter a Subject";
				} else {
					$subject = clean_input($_POST["subject"]);
				}
				if (empty($_POST["comments"])) {
					$commentsError = "Please enter some Comments";
				} else {
					$comments = clean_input($_POST["comments"]);
				}

				// If no errors are found, then can perform the actual email
				if (empty($emailError) && empty($subjectError) && empty($commentsError)) {
					$emailTo = "craigdavideastwood@gmail.com";
					$body = "Web Contact Form\nMessage From: ".$name."\n\n".$comments;
					$headers = "From: ".$email;
					if (mail($emailTo, $subject, $body, $headers)) {
						$successMsg = '<div class="alert alert-success alert-dismissible fade show" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>Thank-you <strong>'.$name.'</strong> for contacting us! Your message has been sent. We\'ll get back to you ASAP!</div>';
					} else {
						$successMsg = '<div class="alert alert-danger alert-dismissible fade show" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>Sorry, your message could not be sent. Please try again later.</div>';
					}
				}

			}

			function clean_input($data)
			{
				$data = trim($data);
  				$data = stripslashes($data);
  				$data = htmlspecialchars($data);
  				return $data;
			}
			
		?>


		<div class="container">

			<h2>Any comments, feedback, questions? Drop us a line.</h2>

			<div id="userMessage">
				<?php echo $successMsg; ?>
			</div>
			
			<!-- The PHP_SELF - returns the submitted form data to the current THIS page instead of jumping to a different page -->
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

				<fieldset class="form-group">
					<label for="contactEmail">Email address</label>
					<input type="email" class="form-control" id="contactEmail" name="email" placeholder="Enter your email address">
					<small class="text-muted">We'll never share your email with anyone else.</small>
					<p><small class="errorMsg"><? echo $emailError; ?></small></p>
				</fieldset>

				<fieldset class="form-group">
					<label for="contactName">Name</label>
					<input type="text" class="form-control" id="contactName" name="name" placeholder="Enter your name">
					<p><small class="errorMsg"><? echo $nameError; ?></small></p>
				</fieldset>

				<fieldset class="form-group">
					<label for="contactSubject">Subject</label>
					<input type="text" class="form-control" id="contactSubject" name="subject">
					<p><small class="errorMsg"><? echo $subjectError; ?></small></p>
				</fieldset>				  

				<fieldset class="form-group">
					<label for="contactComments">Comments/Feedback/Questions</label>
					<textarea class="form-control" id="contactComments" name="comments" rows="3"></textarea>
					<p><small class="errorMsg"><? echo $commentsError; ?></small></p>
				</fieldset>

				<button type="submit" id="submitForm" class="btn btn-primary">Submit</button>

			</form>

		</div>

		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
		
	    <script type="text/javascript">

	    	$("form").submit(function(e) {
	    		return(validateForm(e));
	    	});
	    	
	    	function validateForm(e) {
				// body...
				var errorMessage = "";
				var fieldsMissing = "";

				if ($("#contactEmail").val() == "") {
					fieldsMissing += "<br>Email";
				}

				if ($("#contactName").val() == "") {
					fieldsMissing += "<br>Name";
				}

				if ($("#contactSubject").val() == "") {
					fieldsMissing += "<br>Subject";
				}

				if ($("#contactComments").val() == "") {
					fieldsMissing += "<br>Comments/Feedback";
				}

				if (fieldsMissing != "") {
					errorMessage += "<strong>The following field(s) cannot be empty:</strong>" + fieldsMissing;
				}

				if (errorMessage != "") {					
					$("#userMessage").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>' + errorMessage + '</div>');
					//e.preventDefault();
					return false;
				} else {
					return true;
				}
	/**
				} else {
					$("#userMessage").html('<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>Thanks for contacting us! Your message has been sent. We\'ll get back to you ASAP!</div>');
					return;
				}
	**/	
			

			}

	    </script>

	</body>

</html>