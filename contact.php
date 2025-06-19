<?php
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $success = true;
}
include 'customer_navbar.php';
?>
<div class="main-wrapper">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="./css/insert.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <style>
        .contact-container { max-width: 600px; margin: 40px auto; background: #fff; padding: 32px 28px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .contact-container h2 { color: #007bff; text-align: center; margin-bottom: 18px; }
        .contact-container p { color: #444; font-size: 1.1em; margin-bottom: 18px; }
        .contact-info { margin-bottom: 24px; }
        .success-msg { color: #28a745; text-align: center; font-weight: bold; margin-bottom: 18px; }
    </style>
</head>
<body>
    <div class="contact-container">
        <h2>Contact Us</h2>
        <?php if ($success): ?>
            <div class="success-msg">Thank you for contacting us! We will get back to you soon.</div>
        <?php endif; ?>
        <div class="contact-info">
            <p>Email: info@boatsafari.com</p>
            <p>Phone: +123 456 7890</p>
            <p>Address: 123 Safari Lane, River City</p>
        </div>
        <form method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </div>
</body>
</html>
</div>
<?php include 'footer.php'; ?> 