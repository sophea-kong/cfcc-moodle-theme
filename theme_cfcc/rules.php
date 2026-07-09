<?php
require_once(__DIR__ . '/../../config.php');
require_login();

$PAGE->set_pagelayout('standard');
$PAGE->set_url(new moodle_url('/theme/cfcc/rules.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('CFCC Rules & Guidelines');
$PAGE->set_heading('Championship Rules');

echo $OUTPUT->header();

// Inject specific styles for the Neo-Brutalist rules page
echo "
<style>
    body {
        font-family: 'Nunito', sans-serif !important;
    }
    .rules-container {
        max-width: 900px;
        margin: 0 auto;
    }
    .rules-card {
        background: #ffffff;
        border: 4px solid #1f2937;
        border-radius: 32px;
        box-shadow: 12px 12px 0px #1f2937;
        padding: 3rem;
        margin-bottom: 3rem;
    }
    .rules-header {
        border-bottom: 4px solid #1f2937;
        padding-bottom: 2rem;
        margin-bottom: 2.5rem;
    }
    .badge-brutal {
        display: inline-block;
        background: #7254b3;
        color: white;
        border: 3px solid #1f2937;
        border-radius: 12px;
        padding: 0.4rem 1rem;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.9rem;
        box-shadow: 3px 3px 0px #1f2937;
        margin-bottom: 1.5rem;
    }
    .badge-orange {
        background: #ff6b00;
    }
    .rule-section {
        margin-bottom: 2.5rem;
    }
    .rule-section h3 {
        font-weight: 900;
        font-size: 1.6rem;
        color: #1f2937;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
    }
    .rule-icon {
        background: #ff6b00;
        color: white;
        border: 3px solid #1f2937;
        border-radius: 10px;
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.75rem;
        font-size: 1.1rem;
        box-shadow: 2px 2px 0px #1f2937;
    }
    .rule-section:nth-child(even) .rule-icon {
        background: #7254b3;
    }
    .rule-list {
        list-style: none;
        padding-left: 0;
    }
    .rule-list li {
        position: relative;
        padding-left: 2rem;
        margin-bottom: 1rem;
        font-size: 1.1rem;
        line-height: 1.6;
        color: #374151;
        font-weight: 700;
    }
    .rule-list li::before {
        content: '⚡';
        position: absolute;
        left: 0;
        top: 0.1rem;
        font-size: 1.1rem;
    }
    .alert-brutal {
        background: #fffbeb;
        border: 3px solid #1f2937;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 5px 5px 0px #1f2937;
        margin-top: 2rem;
        display: flex;
        align-items: flex-start;
    }
    .alert-brutal-icon {
        font-size: 2rem;
        margin-right: 1rem;
        line-height: 1;
    }
    .alert-brutal-content h5 {
        font-weight: 900;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }
    .alert-brutal-content p {
        margin: 0;
        font-weight: 700;
        color: #4b5563;
        font-size: 1rem;
    }
</style>
";

?>

<div class="container py-5 rules-container">
    <div class="rules-card">
        <div class="text-center py-5">
            <h1 style="font-size: clamp(4rem, 10vw, 8rem); font-weight: 900; color: #ef4444; text-transform: uppercase; line-height: 1; margin-bottom: 2rem; animation: shake 0.5s infinite; text-shadow: 8px 8px 0px #1f2937;">NO CHEATING</h1>
            <p style="font-size: 1.5rem; font-weight: 800; color: #1f2937; margin-bottom: 2rem;">
                Seriously, our anti-cheat mascot is watching you.
            </p>
            <div style="max-width: 250px; margin: 0 auto 3rem auto; pointer-events: none;">
                <div class="tenor-gif-embed" data-postid="15194421034682700946" data-share-method="host" data-aspect-ratio="1" data-width="100%"><a href="https://tenor.com/view/no-emotiguy-emotiguy-no-mad-emotiguy-emotiguy-mad-gif-15194421034682700946">No Emotiguy Sticker</a>from <a href="https://tenor.com/search/no-stickers">No Stickers</a></div> <script type="text/javascript" async src="https://tenor.com/embed.js"></script>
            </div>
            <marquee style="font-weight: 900; color: #ff6b00; font-size: 1.5rem; background: #1f2937; padding: 15px; border-radius: 12px; border: 4px solid #ff6b00;">
                IF YOU CHEAT YOU WILL BE TURNED INTO A PRINT STATEMENT! 🏃‍♂️💨
            </marquee>
            
            <style>
                @keyframes shake {
                    0% { transform: translate(1px, 1px) rotate(0deg); }
                    10% { transform: translate(-1px, -2px) rotate(-2deg); }
                    20% { transform: translate(-3px, 0px) rotate(2deg); }
                    30% { transform: translate(3px, 2px) rotate(0deg); }
                    40% { transform: translate(1px, -1px) rotate(2deg); }
                    50% { transform: translate(-1px, 2px) rotate(-2deg); }
                    60% { transform: translate(-3px, 1px) rotate(0deg); }
                    70% { transform: translate(3px, 1px) rotate(-2deg); }
                    80% { transform: translate(-1px, -1px) rotate(2deg); }
                    90% { transform: translate(1px, 2px) rotate(0deg); }
                    100% { transform: translate(1px, -2px) rotate(-2deg); }
                }
            </style>
            
            <div class="text-center mt-5">
                <a href="<?php echo new moodle_url('/theme/cfcc/waiting_room.php'); ?>" class="badge-brutal badge-orange" style="max-width: 300px; text-decoration: none;"><i class="fa fa-arrow-left mr-2"></i> Fine, I promise...</a>
            </div>
        </div>
    </div>
</div>

<?php
echo $OUTPUT->footer();
