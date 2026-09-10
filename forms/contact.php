<?php
header('Content-Type: text/plain');

// Basic server-side validation (never trust client-side alone)
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    http_response_code(400);
    echo "Please fill in all required fields.";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Invalid email address.";
    exit;
}

$to = "info@talentvisionhr.com";
$emailSubject = "New Contact Form Submission: " . $subject;
$emailBody = "Name: $name\nEmail: $email\nSubject: $subject\n\nMessage:\n$message";
$headers = "From: no-reply@talentvisionhr.com\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

if (mail($to, $emailSubject, $emailBody, $headers)) {
    echo "OK";
} else {
    http_response_code(500);
    echo "Message could not be sent. Please try again later.";
}
?>