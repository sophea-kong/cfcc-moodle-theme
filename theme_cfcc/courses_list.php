<?php
require_once(__DIR__ . '/../../config.php');
require_login();

$PAGE->set_pagelayout('standard');
$PAGE->set_url(new moodle_url('/theme/cfcc/courses_list.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Arena Challenges');
$PAGE->set_heading('Available Challenges');

echo $OUTPUT->header();

// CSS Injection for Neo-Brutalist Challenge Lobby
echo "
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@1,900&display=swap');

    .card-challenge {
        background: white;
        border: 4px solid #1f2937;
        border-radius: 28px;
        box-shadow: 8px 8px 0px #1f2937;
        transition: all 0.15s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }
    .card-challenge:hover {
        transform: translate(-3px, -3px);
        box-shadow: 12px 12px 0px #1f2937;
    }
    .tag-container {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 1.25rem;
    }
    .tag-brutal {
        border: 2px solid #1f2937;
        border-radius: 8px;
        padding: 0.2rem 0.6rem;
        font-size: 0.75rem;
        font-weight: 900;
        text-transform: uppercase;
        color: #1f2937;
        box-shadow: 2px 2px 0px #1f2937;
    }
    .tag-purple { background: #f3e8ff; }
    .tag-orange { background: #ffedd5; }
    .tag-green { background: #dcfce7; }
    .tag-blue { background: #e0f2fe; }

    .challenge-meta {
        background: #f9fafb;
        border-top: 3px solid #1f2937;
        padding: 1.25rem;
        border-radius: 0 0 24px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }
    .meta-item {
        font-size: 0.85rem;
        font-weight: 800;
        color: #4b5563;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .meta-item i {
        color: #ff6b00;
    }

    /* Live Feed / Sidebar style */
    .sidebar-card {
        background: white;
        border: 4px solid #1f2937;
        border-radius: 28px;
        box-shadow: 8px 8px 0px #1f2937;
        padding: 1.75rem;
    }
    .announcement-item {
        border-left: 4px solid #7254b3;
        padding-left: 1rem;
        margin-bottom: 1.25rem;
    }
    .announcement-item:last-child {
        margin-bottom: 0;
    }
    .pulse-dot {
        width: 10px;
        height: 10px;
        background: #22c55e;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
        box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
        animation: pulse 1.6s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(34, 197, 94, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }
    
    .cfcc-highlight-logo {
        filter: drop-shadow(0 0 20px rgba(255, 107, 0, 0.6));
        animation: logoPulse 3s infinite alternate ease-in-out;
    }
    @keyframes logoPulse {
        0% { transform: scale(1) translateY(0); filter: drop-shadow(0 0 15px rgba(255, 107, 0, 0.4)); }
        100% { transform: scale(1.05) translateY(-5px); filter: drop-shadow(0 0 25px rgba(255, 107, 0, 0.8)); }
    }
    
    .cfcc-text-logo {
        font-family: 'Montserrat', sans-serif;
        font-weight: 900;
        font-size: clamp(8rem, 15vw, 14rem);
        font-style: italic;
        color: #ff6b00;
        text-transform: uppercase;
        letter-spacing: -6px;
        line-height: 1;
        margin: 0;
        text-shadow: 8px 8px 0px #1f2937;
        text-align: center;
    }
</style>
";

// Get all visible courses except the site home (ID 1).
$courses = $DB->get_records('course', array('visible' => 1), 'fullname ASC');

?>

<div class="container py-5">
    
    <!-- Challenges layout -->
    <div class="row">
        <?php if ($courses): ?>
            <!-- Main Challenge Area -->
            <div class="col-lg-10 mx-auto mb-4 d-flex align-items-stretch">
                <?php 
                // Since user specified only one course is primary (CFCC), we take it and center/highlight it.
                // We'll filter the site course and render the active one
                $featured_course = null;
                foreach ($courses as $c) {
                    if ($c->id != 1) {
                        $featured_course = $c;
                        break;
                    }
                }
                
                if ($featured_course):
                    $courseurl = new moodle_url('/theme/cfcc/course_view.php', array('id' => $featured_course->id));
                    $num_activities = $DB->count_records('course_modules', array('course' => $featured_course->id, 'visible' => 1));
                    
                    $sql = "SELECT COUNT(ue.id) 
                              FROM {user_enrolments} ue 
                              JOIN {enrol} e ON e.id = ue.enrolid 
                             WHERE e.courseid = ?";
                    $num_enrolled = $DB->count_records_sql($sql, array($featured_course->id));
                    ?>
                    
                    <div class="card card-challenge w-100">
                        <div class="card-body p-4 d-flex flex-column">
                            <h3 class="cfcc-text-logo mb-4">
                                CFCC
                            </h3>
                            
                            <p class="text-muted font-weight-bold mb-4" style="font-size: 1.05rem;">
                                <?php echo !empty($featured_course->summary) ? strip_tags($featured_course->summary) : 'Welcome to the CADT Freshman Coding Championship! A full-day, action-packed individual competition designed to build your problem-solving confidence. Compete across multiple rounds—from logic puzzles and debugging to advanced algorithmic boss problems!'; ?>
                            </p>

                            <a href="<?php echo $courseurl; ?>" class="btn-tactile btn-orange mt-auto w-100 py-3" style="font-size: 1.2rem;">
                                <i class="fa fa-bolt mr-2"></i> Start
                            </a>
                        </div>
                        
                        <div class="challenge-meta">
                            <div class="meta-item">
                                <i class="fa fa-file-code-o"></i>
                                <span><?php echo $num_activities; ?> Tasks available</span>
                            </div>
                            <div class="meta-item">
                                <i class="fa fa-users"></i>
                                <span><?php echo $num_enrolled; ?> Enrolled Players</span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>



        <?php else: ?>
            <div class="col-12 text-center py-5">
                <div class="card-challenge p-5 text-center">
                    <h3 class="font-weight-black mb-2">No Stages Opened Yet</h3>
                    <p class="text-muted font-weight-bold">Check back soon for available challenges!</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
echo $OUTPUT->footer();
