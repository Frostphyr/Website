---
layout: base
title: Contact | Frostphyr
---

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "../vendor/autoload.php";

{% include form-utils.php %}

$success = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (array_key_exists("contact-tos", $_POST) && $_POST["contact-tos"] == "tos") {
    $success = true;
  } else {
    if (($project = escape($_POST["project"])) === "Project") {
      $error = "Please select a project";
      $element = "project";
    } else {
      if (!($email = validateEmail($_POST["email"]))) {
        $error = "Please enter a valid email address";
        $element = "email";
      } elseif (!($message = escape($_POST["message"]))) {
        $error = "Please enter a message";
        $element = "message";
      } elseif (strlen($message) > 500) {
        $error = "Maximum message length is 500 characters";
        $element = "message";
      } else {
        $mail = new PHPMailer(false);
        {%- include private/mailer-smtp-settings.php -%}
        $mail->Subject = "$project Contact Form: $email";
        $mail->Body = $message;
        $mail->AltBody = $message;
        if ($mail->send()) {
          $success = true;
        } else {
          $error = "Error sending message";
          error_log($mail->ErrorInfo);
        }
      }
    }
  }
}

if (isset($_GET["project"])) {
  $defaultProject = escape($_GET["project"]);
}

function projectSelected($project) {
  global $defaultProject;
  if (isset($defaultProject) && $defaultProject === $project) {
    echo 'selected="selected"';
  }
}

?>

<h1>Contact</h1>
<div>
  <div class="side-panel container right margin-left-small padding-x-small">
    <p class="text-center"><strong>Email</strong></p>
    <a class="text-center block" href="mailto:contact@frostphyr.com">contact@frostphyr.com</a>
    <p class="text-center"><strong>GitHub</strong></p>
    <p>You may also use the respective project's <a href="https://github.com/Frostphyr">GitHub</a></p>
  </div>
  <div class="scrollable">
    <?php
    if ($success) {
      echo "<p class=\"banner-text\">Your message was successfully sent</p>";
    }
    ?>
    <form action="" method="post">
      <select class="block width-100" name="project">
        <option value="Project">Project</option>
        {%- for project in site.data.projects -%}
          {%- assign name = site.data[project].info.name -%}
          <option value="{{ name }}" <?php projectSelected("{{ project }}") ?>>{{ name }}</option>
        {%- endfor -%}
        <option value="Other" <?php projectSelected("other") ?>>Other</option>
      </select>
      <?php errorMessage("project"); ?>
      <input class="width-100" type="email" name="email" placeholder="Email address" required>
      <?php errorMessage("email"); ?>
      <textarea class="width-100 unresizable" name="message" placeholder="Message" rows="7" maxlength="500" required></textarea>
      <?php errorMessage("message"); ?>
      <input class="gone" type="checkbox" name="contact-tos" value="tos">
      <input class="button" type="submit" value="Submit">
      <?php errorMessage(); ?>
    </form>
  </div>
</div>