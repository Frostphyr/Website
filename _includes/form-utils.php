function escape($input) {
  return htmlspecialchars(stripslashes(trim($input)));
}

function validateEmail($email) {
  return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function errorFrame($name, $type) {
  global $element;
  if (isset($element) && $element === $name) {
    echo "class=\"error-$type\"";
  }
}

function errorBorder($name) {
  errorFrame($name, "border");
}

function errorOutline($name) {
  errorFrame($name, "outline");
}

function errorMessage($name = null) {
  global $error;
  if (hasError($name)) {
    echo "<p class=\"error-text margin-none\">
            <img class=\"line-image vertical-middle\" src=\"/images/exclamation-circle-solid.svg\" alt=\"Error\"/>
            <span class=\"vertical-middle\">$error</span>
          </p>";
  }
}

function hasError($name) {
  global $error, $element;
  if (isset($element)) {
    return $element === $name;
  }
  return isset($error) && $name === null;
}