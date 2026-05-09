<?php
require_once(__DIR__ . '/../../config.php');

// Ensure the user is logged in.
require_login();

// Standard Moodle page setup.
$PAGE->set_url(new moodle_url('/theme/myarena/waiting_room.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Competition Waiting Room');
$PAGE->set_heading('The Arena is Cold');

echo $OUTPUT->header();

// Button link to the My Courses page.
$courseurl = new moodle_url('/my/courses.php');

echo "<div class='container mt-5 text-center'>";
echo "    <div class='card shadow-sm p-5 border-0' style='border-radius: 20px; background-color: #FFFBF5;'>";
echo "        <h1 class='display-4 mb-4' style='color: #2c3e50; font-weight: 800;'>Get Ready!</h1>";
echo "        <p class='lead mb-5'>The competition hasn't started yet. Prepare your mind.</p>";
echo "        <a href='{$courseurl}' class='btn btn-lg px-5 py-3' style='background-color: #FF8800; color: white; border-radius: 12px; font-weight: bold; border: 4px solid #2c3e50;'>";
echo "            <i class='fa fa-trophy mr-2'></i> View My Courses";
echo "        </a>";
echo "    </div>";
echo "</div>";

echo $OUTPUT->footer();
