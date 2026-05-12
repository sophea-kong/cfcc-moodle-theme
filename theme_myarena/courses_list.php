<?php
require_once(__DIR__ . '/../../config.php');
require_login();

$PAGE->set_pagelayout('standard');
$PAGE->set_url(new moodle_url('/theme/myarena/courses_list.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Arena Challenges');
$PAGE->set_heading('Available Challenges');

echo $OUTPUT->header();

// Get all visible courses except the site home (ID 1).
$courses = $DB->get_records('course', array('visible' => 1), 'fullname ASC');

echo "<div class='container py-5'>";
echo "    <div class='row'>";

if ($courses) {
    foreach ($courses as $course) {
        if ($course->id == 1) continue;

        $courseurl = new moodle_url('/course/view.php', array('id' => $course->id));
        
        echo "<div class='col-md-4 mb-4'>";
        echo "    <div class='card dashboard-card h-100 p-3'>";
        echo "        <div class='card-body text-center d-flex flex-column'>";
        echo "            <h4 class='font-weight-black mb-2'>{$course->fullname}</h4>";
        echo "            <p class='text-muted small mb-4'>{$course->shortname}</p>";
        echo "            <a href='{$courseurl}' class='btn-tactile btn-orange mt-auto'>Start Challenge</a>";
        echo "        </div>";
        echo "    </div>";
        echo "</div>";
    }
} else {
    echo "<div class='col-12 text-center'><p class='lead'>No challenges available yet.</p></div>";
}

echo "    </div>";
echo "</div>";

echo $OUTPUT->footer();
