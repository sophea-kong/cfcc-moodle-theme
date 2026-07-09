<?php
defined('MOODLE_INTERNAL') || die();

// Redirect logged-in users from the dashboard or site home to the custom waiting room page
if (isloggedin() && ($PAGE->pagetype == 'site-index' || $PAGE->pagetype == 'my-index')) {
    redirect(new moodle_url('/theme/cfcc/waiting_room.php'));
}

echo $OUTPUT->doctype();
?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $PAGE->title; ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
    <?php echo $OUTPUT->standard_head_html(); ?>
    <style>

        /* Force side-by-side layout bypassing cache */
        @media (min-width: 992px) {
            .que.coderunner .formulation {
                display: grid !important;
                grid-template-columns: 50% 50% !important;
                gap: 0 1.5rem !important;
            }
            
            /* By default, all direct children (question text paragraphs, etc.) go in the left column */
            .que.coderunner .formulation > * {
                grid-column: 1 / 2 !important;
            }
            
            /* The answer wrapper (code editor) goes in the right column and spans all rows */
            .que.coderunner .formulation > div[id$="_answer_wrapper"] {
                grid-column: 2 / 3 !important;
                grid-row: 1 / 100 !important;
                padding-left: 1.5rem !important;
                border-left: 3px dashed #e5e7eb !important;
                box-sizing: border-box !important;
            }
            
            /* Test results span full width at the bottom */
            .que.coderunner .formulation > .coderunner-test-results {
                grid-column: 1 / -1 !important;
                margin-top: 2rem !important;
            }
            
            .que.coderunner .formulation h4.accesshide {
                display: none !important;
            }

            body{
                background : white;
            }
        }
    </style>
</head>

<body <?php echo $OUTPUT->body_attributes(); ?>>
<?php echo $OUTPUT->standard_top_of_body_html(); ?>

<?php
$username = isloggedin() ? fullname($USER) : '';
$userpicture = isloggedin() ? $OUTPUT->user_picture($USER, array('size' => 35, 'link' => false)) : '';
$logouturl = new moodle_url('/login/logout.php', array('sesskey' => sesskey()));
$homeurl = new moodle_url('/theme/cfcc/waiting_room.php');
$dashboardurl = new moodle_url('/my/');
$challengesurl = new moodle_url('/theme/cfcc/courses_list.php');
$rulesurl = new moodle_url('/theme/cfcc/rules.php');

// Module 2 Task: Get strings from lang file
$str_rules = get_string('rules', 'theme_cfcc');
$str_challenges = get_string('challenges', 'theme_cfcc');
$str_logout = get_string('logout', 'theme_cfcc');
$str_login = get_string('login', 'theme_cfcc');
?>

<nav class="navbar navbar-expand-lg arena-navbar mb-4">
    <div class="container-fluid">
        <a class="navbar-brand font-weight-black d-flex align-items-center" href="<?php echo $homeurl; ?>">
            <img src="<?php echo $CFG->wwwroot; ?>/theme/cfcc/assets/CFCC.png" alt="CFCC Logo" style="max-height: 40px;">
        </a>
        
        <div class="collapse navbar-collapse" id="arenaNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $rulesurl; ?>"><?php echo $str_rules; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $challengesurl; ?>"><?php echo $str_challenges; ?></a>
                </li>
            </ul>
            <div class="navbar-nav ml-auto align-items-center">
                <?php if (isloggedin()): ?>
                    <span class="nav-item mr-3 font-weight-bold d-none d-md-inline"><?php echo $username; ?></span>
                    <div class="nav-item user-avatar mr-3">
                        <?php echo $userpicture; ?>
                    </div>
                    <a href="<?php echo $logouturl; ?>" class="btn-orange-sm"><?php echo $str_logout; ?></a>
                <?php else: ?>
                    <a href="<?php echo get_login_url(); ?>" class="btn-orange-sm"><?php echo $str_login; ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<div id="page-wrapper">
    <div id="page" class="container-fluid">
        <div id="page-content" class="row">
            <?php if ($PAGE->pagetype == 'mod-quiz-view'): ?>
                <div class="col-12">
                    <a href="<?php echo new moodle_url('/theme/cfcc/course_view.php', array('id' => $PAGE->course->id)); ?>" class="btn btn-primary mb-3">
                        <i class="fa fa-arrow-left" style="margin-right: 8px;"></i> BACK
                    </a>
                </div>
            <?php endif; ?>
            <section id="region-main" class="col-12">
                <?php echo $OUTPUT->main_content(); ?>
            </section>
            <!-- Module-specific block regions -->
            <aside id="block-region-side-pre" class="col-12 d-none">
                <?php echo $OUTPUT->blocks('side-pre'); ?>
            </aside>
        </div>
    </div>
</div>

<?php echo $OUTPUT->standard_end_of_body_html(); ?>

</body>
</html>
