---
layout: download
---

{%- assign info = site.data[page.project].info -%}

<?php

{% include form-utils.php %}

function validateKey($key) {
  {%- include private/database.php -%}
  $mysqli = new mysqli($host, $username, $password, "license_keys");
  if (!is_null($mysqli->connect_error)) {
    error_log($mysqli->connect_error);
  } else {
    if ($stmt = $mysqli->prepare("SELECT license_key FROM {{ info.key_database }} WHERE license_key=?")) {
      if ($stmt->bind_param("s", $key) && $stmt->execute()) {
        if ($result = $stmt->get_result()) {
          $return = $result->num_rows > 0 ? TRUE : "Invalid license key";
          $result->close();
        } else {
          error_log($mysqli->error);
        }
      } else {
        error_log($mysqli->error);
      }
    } else {
      error_log($mysqli->error);
    }
    $mysqli->close();
  }
  return isset($return) ? $return : "Error validating license key, please contact support";
}

function downloadFile($file) {
  if (file_exists($file)) {
    header("Content-Description: File Transfer");
    {%- if info.download_type == "jar" -%}
      header("Content-Type: application/java-archive");
    {%- else -%}
      header("Content-Type: application/octet-stream");
    {%- endif -%}
    header("Content-Length: " . filesize($file));
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    flush();
    while (ob_get_level()) {
      ob_end_clean();
    }
    readfile($file);
    exit();
  }
}

if (isset($_POST["submit"])) {
  $licenseAgreement = filter_input(INPUT_POST, "license-agreement");
  if ($licenseAgreement === "on") {
    $key = filter_input(INPUT_POST, "key");
    if ($key !== FALSE && $key !== NULL) {
      $result = validateKey($key);
      if ($result === TRUE) {
        downloadFile($_SERVER["DOCUMENT_ROOT"] . "/../downloads/{{ info.name }}/{{ info.name }}-{{ page.version }}.{{ info.download_type }}");
      } else {
        $error = $result;
        $element = "key";
      }
    }
  } else {
    $error = "You must review and accept the License Agreement to download this file";
    $element = "license-agreement";
  }
}

?>

{{ content }}
<h2>Download</h2>
<form action="?" method="post">
  <input type="checkbox" id="license-agreement" name="license-agreement" <?php errorOutline("license-agreement"); ?>>
  <label for="license-agreement">I reviewed and accept the <a href="/{{ page.project }}/license">License Agreement</a></label>
  <?php errorMessage("license-agreement"); ?>
  <p>
    <input type="text" name="key" placeholder="License key" size="25" required <?php errorBorder("key"); ?>>
    <?php errorMessage("key"); ?>
    <input class="button" type="submit" name="submit" value="Download">
  </p>
</form>