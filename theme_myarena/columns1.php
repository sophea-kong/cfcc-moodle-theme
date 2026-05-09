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

<div id="page-wrapper">
    <div id="page" class="container-fluid">
        <div id="page-content" class="row">
            <div>
                <p>test</p>
            </div>
            <section id="region-main" class="col-12">
                <?php echo $OUTPUT->main_content(); ?>
            </section>
            <!-- Satisfy the Moodle block renderer requirements -->
            <aside id="block-region-side-pre" class="col-12 d-none">
                <?php echo $OUTPUT->blocks('side-pre'); ?>
            </aside>
        </div>
    </div>
</div>

<?php echo $OUTPUT->standard_end_of_body_html(); ?>
</body>
</html>
