<?php
// Check if the form has been submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize and assign form inputs to variables
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Initialize an error variable
    $errors = [];

    // Validate the name
    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    // Validate the email
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate the message
    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    // Check if there are any errors
    if (empty($errors)) {

        // Specify the email recipient (your email address)
        $to = "victoryankhochisambiro@gmail.com"; // Replace with your actual email address

        // Email subject
        $subject = "New Contact Form Submission from $name";

        // Email body
        $body = "You have received a new message from your website contact form.\n\n";
        $body .= "Here are the details:\n";
        $body .= "Name: $name\n";
        $body .= "Email: $email\n\n";
        $body .= "Message:\n$message\n";

        // Email headers
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Try to send the email
        if (mail($to, $subject, $body, $headers)) {
            // Success message if the email is sent successfully
            echo "<p>Thank you, $name! Your message has been sent successfully.</p>";
        } else {
            // Error message if the mail function fails
            echo "<p>Sorry, there was an error sending your message. Please try again later.</p>";
        }

    } else {
        // Display validation errors
        echo "<p>There were errors in your form submission:</p>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
} else {
    // If the request is not POST, show an invalid request message
    echo "<p>Invalid request method. Please submit the form correctly.</p>";
}
