<?php
require_once(__DIR__ . '/../../config.php');

// Standard Moodle page setup.
$PAGE->set_url(new moodle_url('/theme/myarena/test.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Hello World');
$PAGE->set_heading('Hello World Page');

echo $OUTPUT->header();
echo "<div class='container mt-5 text-center'>";
echo "    <h1 class='display-4'>Hello World!</h1>";
echo "    <p class='lead'>Your custom Moodle theme is now rendering this page.</p>";
echo "</div>";
echo $OUTPUT->footer();
