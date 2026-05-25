<?php
defined('MOODLE_INTERNAL') || die();

echo $OUTPUT->doctype();
?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $PAGE->title; ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
    <?php echo $OUTPUT->standard_head_html(); ?>
</head>

<body <?php echo $OUTPUT->body_attributes(); ?>>
<?php echo $OUTPUT->standard_top_of_body_html(); ?>

<?php
$username = isloggedin() ? fullname($USER) : '';
$userpicture = isloggedin() ? $OUTPUT->user_picture($USER, array('size' => 35, 'link' => false)) : '';
$logouturl = new moodle_url('/login/logout.php', array('sesskey' => sesskey()));
$homeurl = new moodle_url('/theme/myarena/waiting_room.php');
$dashboardurl = new moodle_url('/my/');
$challengesurl = new moodle_url('/theme/myarena/courses_list.php');

// Module 2 Task: Get strings from lang file
$str_rules = get_string('rules', 'theme_myarena');
$str_challenges = get_string('challenges', 'theme_myarena');
$str_logout = get_string('logout', 'theme_myarena');
$str_login = get_string('login', 'theme_myarena');
?>

<nav class="navbar navbar-expand-lg arena-navbar mb-4">
    <div class="container-fluid">
        <a class="navbar-brand font-weight-black" href="<?php echo $homeurl; ?>">
            <span class="text-orange">CFCC</span>
        </a>
        
        <div class="collapse navbar-collapse" id="arenaNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><?php echo $str_rules; ?></a>
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
