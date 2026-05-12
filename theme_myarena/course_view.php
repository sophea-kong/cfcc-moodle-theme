<?php
require_once(__DIR__ . '/../../config.php');
require_login();

$id = required_param('id', PARAM_INT);
$course = $DB->get_record('course', array('id' => $id), '*', MUST_EXIST);

$PAGE->set_pagelayout('standard');
$PAGE->set_url(new moodle_url('/theme/myarena/course_view.php', array('id' => $id)));
$PAGE->set_context(context_course::instance($id));
$PAGE->set_title($course->fullname);
$PAGE->set_heading($course->fullname);

echo $OUTPUT->header();

$modinfo = get_fast_modinfo($course);
$sections = $modinfo->get_section_info_all();

echo "<div class='container py-5'>";
echo "    <div class='row justify-content-center'>";
echo "        <div class='col-lg-8'>";
echo "            <div class='text-center mb-5'>";
echo "                <h1 class='display-4 font-weight-black'>{$course->fullname}</h1>";
echo "                <p class='lead text-muted'>{$course->summary}</p>";
echo "            </div>";

foreach ($sections as $section) {
    // Only show sections that have contents or a summary and are visible.
    if ($section->uservisible && (!empty($modinfo->sections[$section->section]) || !empty($section->summary))) {
        echo "<div class='card dashboard-card mb-4 p-4 shadow-none'>";
        echo "    <h3 class='font-weight-black mb-3 text-orange'>" . ($section->name ? $section->name : "Section {$section->section}") . "</h3>";

        if (!empty($section->summary)) {
            echo "    <div class='mb-3 text-muted'>" . format_text($section->summary, $section->summaryformat) . "</div>";
        }

        if (!empty($modinfo->sections[$section->section])) {
            echo "<ul class='list-group list-group-flush border-0'>";
            foreach ($modinfo->sections[$section->section] as $cmid) {
                $cm = $modinfo->cms[$cmid];
                if (!$cm->uservisible) continue;

                $url = $cm->url;
                $icon = $cm->get_icon_url();

                echo "<li class='list-group-item d-flex align-items-center border-0 px-0 py-3'>";
                echo "    <img src='{$icon}' class='mr-3' style='width: 24px; height: 24px;'>";
                echo "    <a href='{$url}' class='h5 mb-0 font-weight-bold text-dark' style='text-decoration: none;'>{$cm->name}</a>";
                echo "</li>";
            }
            echo "</ul>";
        }
        echo "</div>";
    }
}

echo "        </div>";
echo "    </div>";
echo "</div>";

echo $OUTPUT->footer();
