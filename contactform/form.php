<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Get the form fields and remove whitespace
	$name = strip_tags(trim($_POST["name"]));
	$name = str_replace(array("\r","\n"),array(" "," "),$name);
	$email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
	$phone = trim($_POST["phone"]);
	$message = trim($_POST["message"]);
	$city = trim($_POST["city"]);
	$other_city = trim($_POST["other-city"]);

	// Check for empty fields
	if (empty($name) || empty($email) || empty($phone) || empty($message) || empty($city)) {
		http_response_code(400);
		echo "Please fill out all required fields.";
		exit;
	}

	// Check for valid email address
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		http_response_code(400);
		echo "Please provide a valid email address.";
		exit;
	}

	// Set the recipient email address
	$to = "kartikahire@kalasource.in";

	// Set the email subject
	$subject = "New contact form submission from $name";

	// Build the email message
	$email_message = "Name: $name\n\n";
	$email_message .= "Email: $email\n\n";
	$email_message .= "Phone: $phone\n\n";
	$email_message .= "Message: $message\n\n";
	$email_message .= "City: $city\n\n";
	if ($city == "Other") {
		$email_message .= "Other City: $other_city\n\n";
	}

	// Set the email headers
	$headers = "From: $name <$email>\r\n";
	$headers .= "Reply-To: $email\r\n";

	// Send the email
	if (mail($to, $subject, $email_message, $headers)) {
		// Redirect to the thank you page
		header("Location: thankyou.html");
		exit;
	} else {
		http_response_code(500);
		echo "Oops! Something went wrong and we couldn't send your message.";
		exit;
	}
}
?>