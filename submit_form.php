<?php
// Database connection details
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "poetry_blog_website"; // Your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the input values from the form and sanitize them
    $title = $conn->real_escape_string($_POST['title']);
    $type = $conn->real_escape_string($_POST['type']);
    $content = $conn->real_escape_string($_POST['content']);

    // Validate input fields
    if (empty($title) || empty($type) || empty($content)) {
        echo "All fields are required. Please fill out the form completely.";
    } else {
        // Insert the data into the database
        $sql = "INSERT INTO submissions (title, type, content) VALUES ('$title', '$type', '$content')";
        if ($conn->query($sql) === TRUE) {
            // Email notification after successful submission

            // Recipient email address (your email)
            $to = "your-email@example.com"; // Replace with your email address

            // Email subject
            $subject = "New Submission: $type - $title";

            // Email content in plain text and HTML formats
            $message_plain = "You have received a new submission on your website.\n\n";
            $message_plain .= "Title: $title\n";
            $message_plain .= "Type: $type\n";
            $message_plain .= "Content:\n$content\n";

            $message_html = "<html><body>";
            $message_html .= "<h1>New Submission: $type - $title</h1>";
            $message_html .= "<p><strong>Title:</strong> $title</p>";
            $message_html .= "<p><strong>Type:</strong> $type</p>";
            $message_html .= "<p><strong>Content:</strong><br>$content</p>";
            $message_html .= "</body></html>";

            // Email headers
            $headers = "From: no-reply@yourdomain.com\r\n"; // Replace with your domain's email
            $headers .= "Reply-To: no-reply@yourdomain.com\r\n"; // Replace as needed
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: multipart/alternative; boundary=\"boundary\"\r\n";

            // Define the boundary for separating plain text and HTML content
            $boundary = md5(uniqid(time()));

            // Full message body, including both plain text and HTML parts
            $message = "--boundary\r\n";
            $message .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
            $message .= $message_plain . "\r\n";
            $message .= "--boundary\r\n";
            $message .= "Content-Type: text/html; charset=UTF-8\r\n\r\n";
            $message .= $message_html . "\r\n";
            $message .= "--boundary--\r\n";

            // Send the email
            if (mail($to, $subject, $message, $headers)) {
                echo "Submission successful, and email notification sent!";
            } else {
                echo "Submission successful, but email notification could not be sent.";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
