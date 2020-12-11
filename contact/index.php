---
layout: default
title: Contact | Frostphyr
---

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['contact-tos'] == 'tos') {
        $confirmation = 'Your message was successfully sent';
    } else {
        $email = validate($_POST['email']);
        $message = validate($_POST['message']);

        $mail = new PHPMailer(true);
        try {
            {%- include private/mailer-smtp-settings.php -%}
            $mail->Subject = 'Contact Form: ' . $email;
            $mail->Body = $message;
            $mail->AltBody = $message;
            if ($mail->send()) {
                $confirmation = 'Your message was successfully sent';
            } else {
                $confirmation = 'There was an error sending your message';
            }
        } catch (Exception $e) {
            echo $mail->ErrorInfo;
        }
    }
}

function validate($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

?>

<h1>Contact</h1>
<div class="side-panel container">
    <h2 class="side-panel-header">Email</h2>
    <a href="mailto:contact@frostphyr.com">contact@frostphyr.com</a>
    <h2 class="side-panel-header">GitHub</h2>
    <p>For specific projects, you may also use the relevant GitHub repository located at <a href="https://github.com/Frostphyr">https://github.com/Frostphyr</a></p>
</div>
<div class="empty-divider right"></div>
<div id="main-content">
    <?php
    if (isset($confirmation)) {
        echo "<p id=\"contact-confirmation\">$confirmation</p>";
    }
    ?>
    <form action="" method="post">
        <input id="contact-email" type="email" name="email" placeholder="Email address" required>
        <textarea id="contact-message" name="message" placeholder="Message" rows="5" required></textarea>
        <input type="checkbox" id="contact-tos" name="contact-tos" value="tos">
        <input class="button" type="submit" value="Submit">
    </form>
</div>
