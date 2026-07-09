<?php
require_once(__DIR__ . '/../../config.php');
require_login();

$id = required_param('id', PARAM_INT);
$course = $DB->get_record('course', array('id' => $id), '*', MUST_EXIST);

$PAGE->set_pagelayout('standard');
$PAGE->set_url(new moodle_url('/theme/cfcc/course_view.php', array('id' => $id)));
$PAGE->set_context(context_course::instance($id));
$PAGE->set_title($course->fullname);
$PAGE->set_heading($course->fullname);

echo $OUTPUT->header();

// Inject premium styles for Neo-Brutalist Course View
echo "
<style>
    .course-header {
        background: #ffffff;
        border: 4px solid #1f2937;
        border-radius: 32px;
        box-shadow: 10px 10px 0px #1f2937;
        padding: 2.5rem;
        margin-bottom: 3.5rem;
        position: relative;
    }
    .header-tag {
        display: inline-block;
        background: #7254b3;
        color: white;
        border: 3px solid #1f2937;
        border-radius: 12px;
        padding: 0.3rem 0.8rem;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.8rem;
        box-shadow: 3px 3px 0px #1f2937;
        margin-bottom: 1.25rem;
    }
    .course-title {
        font-size: 2.8rem;
        font-weight: 900;
        color: #1f2937;
        line-height: 1.1;
        margin-bottom: 1rem;
    }
    .section-card {
        background: white;
        border: 4px solid #1f2937 !important;
        border-radius: 28px !important;
        box-shadow: 8px 8px 0px #1f2937 !important;
        margin-bottom: 2.5rem !important;
        padding: 2rem !important;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .section-card:hover {
        transform: translate(-2px, -2px);
        box-shadow: 10px 10px 0px #1f2937 !important;
    }
    .section-title {
        font-weight: 900;
        font-size: 1.6rem;
        color: #ff6b00;
        margin-bottom: 1.25rem;
        border-bottom: 3px solid #1f2937;
        padding-bottom: 0.75rem;
    }
    .activity-item {
        background: #fafafa;
        border: 3px solid #1f2937 !important;
        border-radius: 18px !important;
        padding: 1rem 1.5rem !important;
        margin-bottom: 1rem !important;
        box-shadow: 4px 4px 0px #1f2937 !important;
        transition: all 0.15s ease !important;
        display: flex;
        align-items: center;
        text-decoration: none !important;
    }
    .activity-item:hover {
        transform: translate(-3px, -3px) !important;
        box-shadow: 7px 7px 0px #1f2937 !important;
        background: #ffffff !important;
    }
    .activity-icon-wrap {
        background: white;
        border: 2px solid #1f2937;
        border-radius: 10px;
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        box-shadow: 2px 2px 0px #1f2937;
        font-size: 1.2rem;
    }
    .activity-details {
        flex-grow: 1;
    }
    .activity-name {
        font-weight: 800;
        font-size: 1.1rem;
        color: #1f2937 !important;
        margin-bottom: 0.1rem;
    }
    .activity-badge {
        font-size: 0.7rem;
        font-weight: 900;
        text-transform: uppercase;
        border: 2px solid #1f2937;
        border-radius: 6px;
        padding: 0.1rem 0.4rem;
        box-shadow: 1px 1px 0px #1f2937;
        display: inline-block;
        margin-left: 0.5rem;
    }
    .badge-task { background: #fee2e2; color: #ef4444; }
    .badge-doc { background: #e0f2fe; color: #0284c7; }
    .badge-default { background: #f3f4f6; color: #4b5563; }
</style>
";

$modinfo = get_fast_modinfo($course);
$sections = $modinfo->get_section_info_all();
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            
            <!-- Course Header Info Card -->
            <div class="course-header text-center text-md-left">
                <div class="d-md-flex justify-content-between align-items-start">
                    <div>
                        <span class="header-tag">Arena Stage</span>
                        <h1 class="course-title"><?php echo $course->fullname; ?></h1>
                        <p class="lead text-muted font-weight-bold mb-0">
                            <?php echo !empty($course->summary) ? strip_tags($course->summary) : 'Select a task, complete the logic constraints, and run test compilation scripts.'; ?>
                        </p>
                    </div>
                    <div class="text-md-right mt-3 mt-md-0">
                        <a href="<?php echo new moodle_url('/theme/cfcc/courses_list.php'); ?>" class="btn-tactile btn-white" style="padding: 0.6rem 1.2rem !important; font-size: 0.95rem !important;">
                            <i class="fa fa-arrow-left mr-2"></i> Stages
                        </a>
                    </div>
                </div>
            </div>

            <?php 
            $visible_sections_count = 0;
            foreach ($sections as $section):
                // Skip section 0 (General section)
                if ($section->section == 0) continue;

                // Only show sections that have contents or a summary and are visible.
                if ($section->uservisible && (!empty($modinfo->sections[$section->section]) || !empty($section->summary))):
                    $visible_sections_count++;
                    ?>
                    <div class="card section-card">
                        <h3 class="section-title">
                            <?php echo $section->name ? $section->name : "Section " . $section->section; ?>
                        </h3>

                        <?php if (!empty($section->summary)): ?>
                            <div class="mb-4 text-muted font-weight-bold">
                                <?php echo format_text($section->summary, $section->summaryformat); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($modinfo->sections[$section->section])): ?>
                            <div class="activity-list">
                                <?php 
                                foreach ($modinfo->sections[$section->section] as $cmid):
                                    $cm = $modinfo->cms[$cmid];
                                    if (!$cm->uservisible) continue;

                                    $url = $cm->url;
                                    
                                    // Determine type labels and icons
                                    $badge_class = 'badge-default';
                                    $badge_label = 'Resource';
                                    $icon_class = 'fa-file-text-o';
                                    $icon_color = '#4b5563';

                                    if ($cm->modname == 'quiz') {
                                        $badge_class = 'badge-task';
                                        $badge_label = 'Coding Task';
                                        $icon_class = 'fa-terminal';
                                        $icon_color = '#ef4444';
                                    } else if ($cm->modname == 'resource') {
                                        $badge_class = 'badge-doc';
                                        $badge_label = 'Docs';
                                        $icon_class = 'fa-book';
                                        $icon_color = '#0284c7';
                                    } else if ($cm->modname == 'assign') {
                                        $badge_class = 'badge-task';
                                        $badge_label = 'Assignment';
                                        $icon_class = 'fa-tasks';
                                        $icon_color = '#ff6b00';
                                    }
                                    ?>
                                    
                                    <a href="<?php echo $url; ?>" class="activity-item">
                                        <div class="activity-icon-wrap" style="color: <?php echo $icon_color; ?>;">
                                            <i class="fa <?php echo $icon_class; ?>"></i>
                                        </div>
                                        <div class="activity-details text-left">
                                            <div class="d-flex align-items-center flex-wrap">
                                                <span class="activity-name"><?php echo $cm->name; ?></span>
                                                <span class="activity-badge <?php echo $badge_class; ?>"><?php echo $badge_label; ?></span>
                                            </div>
                                        </div>
                                        <div>
                                            <i class="fa fa-chevron-right text-muted"></i>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php 
                endif; 
            endforeach; 

            if ($visible_sections_count == 0):
            ?>
                <div class="card section-card text-center p-5">
                    <h3 class="font-weight-black mb-2">No Tasks Released</h3>
                    <p class="text-muted font-weight-bold">Check back soon for stage instructions!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
echo $OUTPUT->footer();
