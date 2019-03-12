---
layout: project
---

<?php

{% assign project = page.projects[page.project-id] %}

function validateKey($key) {
    {% include database.php %}
    $mysqli = new mysqli($host, $username, $password, "license_keys");
    if ($mysqli->connect_error) {
        $return = "Error connecting to database. Please retry later.";
    } else {
        if ($stmt = $mysqli->prepare("SELECT license_key FROM {{ project.key-database }} WHERE license_key=?")) {
            if ($stmt->bind_param("s", $key)) {
                if ($stmt->execute()) {
                    if ($result = $stmt->get_result()) {
                        $return = $result->num_rows > 0 ? TRUE : "Invalid license key";
                        $result->close();
                    }
                }
            }
        }
        $mysqli->close();
    }
    return isset($return) ? $return : "Error validating license key.";
}

function downloadFile($file) {
    if (file_exists($file)) {
        header("Content-Description: File Transfer");
        {% if project.download-type == "jar" %}
            header("Content-Type: application/java-archive");
        {% else %}
            header("Content-Type: application/octet-stream");
        {% endif %}
        header("Content-Length: " . filesize($file));
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        flush();
        readfile($file);
    }
}

$error = "";
$key = filter_input(INPUT_POST, "key");
if ($key !== FALSE && $key !== NULL) {
    $result = validateKey($key);
    if ($result === TRUE) {
        downloadFile($_SERVER['DOCUMENT_ROOT'] . "/../downloads/{{ project.name }}/{{ project.name }}-{{ page.version }}.{{ project.download-type}}");
    } else {
        $error = $result;
        echo "{% include {{ project.download-content }} %}";
    }
} else {
    echo "{% include {{ project.download-content }} %}";
}

?>