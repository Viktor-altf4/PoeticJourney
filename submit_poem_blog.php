<?php
// Check if the form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize and get the form inputs
    $title = htmlspecialchars(trim($_POST['title']));
    $type = htmlspecialchars(trim($_POST['type']));
    $content = htmlspecialchars(trim($_POST['content']));

    // Validate that all fields are filled
    if (!empty($title) && !empty($type) && !empty($content)) {

        
        $to = "mali victoryankhochisambiro@gmail.com";
        $subject = "New $type Submission: $title";

        // Email body
        $body = "You have received a new $type submission.\n\n";
        $body .= "Title: $title\n";
        $body .= "Content:\n$content\n";

        // Email headers
        $headers = "From: no-reply@yourwebsite.com\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Send the email
        if (mail($to, $subject, $body, $headers)) {
            echo "<p>Thank you! Your $type has been submitted successfully.</p>";
        } else {
            echo "<p>Sorry, there was an issue submitting your $type. Please try again later.</p>";
        }

    } else {
        echo "<p>Please fill in all the fields before submitting.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}
