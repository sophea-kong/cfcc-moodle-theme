<?php
require_once(__DIR__ . '/../../config.php');
require_login();

$PAGE->set_pagelayout('standard');
$PAGE->set_url(new moodle_url('/theme/cfcc/waiting_room.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('CADT Freshman Coding Championship');
$PAGE->set_heading('Championship Home');

echo $OUTPUT->header();

echo "
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap');

    body { 
        background-color: #ffffff !important; 
        font-family: 'Nunito', sans-serif; 
        color: #3c3c3c; 
    }

    #page { 
        background: #ffffff;
        min-height: 100vh; 
    }

    /* Duolingo-style Buttons */
    .btn-duo {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        border-radius: 16px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 1.1rem 2rem;
        font-size: 1.1rem;
        transition: transform 0.1s ease, box-shadow 0.1s ease;
        text-decoration: none !important;
        cursor: pointer;
        width: 100%;
    }

    .btn-orange { 
        background: #ff6b00; 
        color: white !important; 
        box-shadow: 0 4px 0 #cc5500; 
    }
    .btn-orange:active { 
        transform: translateY(4px); 
        box-shadow: 0 0 0 transparent; 
    }
    
    .btn-white { 
        background: white; 
        color: #1f2937 !important; 
        border: 2px solid #e5e7eb;
        box-shadow: 0 4px 0 #e5e7eb; 
    }
    .btn-white:active { 
        transform: translateY(4px); 
        box-shadow: 0 0 0 transparent; 
    }

    /* Layout Elements */
    .hero-section {
        padding: 6rem 0 4rem 0;
        border-bottom: 2px solid #e5e7eb;
    }

    .hero-heading {
        font-weight: 900;
        font-size: 2.2rem;
        line-height: 1.2;
        color: #3c3c3c;
        margin-bottom: 1.5rem;
    }

    .hero-subtitle {
        font-size: 1.1rem;
        font-weight: 700;
        color: #777;
        margin-bottom: 2.5rem;
        line-height: 1.6;
    }

    /* Mascot */
    .mascot-container { 
        display: inline-block;
        max-width: 320px;
        width: 100%;
    }

    /* Features Section */
    .features-section {
        padding: 5rem 0;
        background: #ffffff;
    }

    .feature-card {
        text-align: center;
        padding: 2rem;
    }

    .feature-icon-wrapper {
        width: 100px;
        height: 100px;
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem auto;
        font-size: 2.5rem;
        border: 2px solid #e5e7eb;
        background: white;
        box-shadow: 0 4px 0 #e5e7eb;
    }

    .feature-icon-wrapper.blue { color: #0ea5e9; }
    .feature-icon-wrapper.purple { color: #7254b3; }
    .feature-icon-wrapper.orange { color: #ff6b00; }

    .feature-title {
        font-weight: 900;
        font-size: 1.6rem;
        margin-bottom: 1rem;
        color: #3c3c3c;
    }

    .feature-text {
        color: #777;
        font-weight: 700;
        font-size: 1.15rem;
        line-height: 1.5;
    }
    
    .cfcc-highlight-logo {
        max-width: 450px;
        width: 100%;
        filter: drop-shadow(0 0 20px rgba(255, 107, 0, 0.6));
        animation: logoPulse 3s infinite alternate ease-in-out;
    }
    @keyframes logoPulse {
        0% { transform: scale(1) translateY(0); filter: drop-shadow(0 0 15px rgba(255, 107, 0, 0.4)); }
        100% { transform: scale(1.05) translateY(-5px); filter: drop-shadow(0 0 25px rgba(255, 107, 0, 0.8)); }
    }
    
    @media (max-width: 991px) {
        .hero-heading { font-size: 1.8rem; text-align: center; }
        .hero-subtitle { text-align: center; }
        .hero-buttons { justify-content: center; margin: 0 auto; }
    }
    </style>
";
?>

<!-- HERO SECTION -->
<div class="hero-section">
    <div class="container" style="max-width: 1100px;">
        <div class="row align-items-center justify-content-between">
            
            <div class="col-lg-5 text-center mb-5 mb-lg-0 order-lg-2">
                <img src="<?php echo $CFG->wwwroot; ?>/theme/cfcc/assets/CFCC.png" alt="CFCC Logo" class="cfcc-highlight-logo">
            </div>

            <div class="col-lg-6 order-lg-1">
                <h1 class="hero-heading text-center text-lg-left">
                    Ready to code, <br><span style="color: #7254b3;">compete, and conquer?</span>
                </h1>
                
                <p class="hero-subtitle text-center text-lg-left">
                    Welcome to the <strong>CADT Freshman Coding Championship</strong>! It's time to unleash your inner programmer in an epic full-day quest. Power up your logic, crush those bugs, and take down the final algorithmic boss to claim your glory!
                </p>

                <div class="hero-buttons" style="max-width: 400px; margin-left: 0;">
                    <div class="mb-3">
                        <a href="<?php echo new moodle_url('/theme/cfcc/courses_list.php'); ?>" class="btn-duo btn-orange w-100">Get Started</a>
                    </div>
                    <div>
                        <a href="<?php echo new moodle_url('/theme/cfcc/rules.php'); ?>" class="btn-duo btn-white w-100">Read the Rules</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- FEATURES SECTION -->
<div class="features-section">
    <div class="container" style="max-width: 1100px;">
        <h2 class="text-center" style="font-weight: 900; color: #3c3c3c; margin-bottom: 4rem; font-size: 2.2rem;">Why join the Championship?</h2>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon-wrapper orange">
                        <i class="fa fa-code"></i>
                    </div>
                    <h3 class="feature-title">Enhance Problem-Solving Skills</h3>
                    <p class="feature-text">Write C to solve algorithmic challenges. Our secure Jobe Sandbox instantly grades your logic against hidden test cases.</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon-wrapper purple">
                        <i class="fa fa-level-up"></i>
                    </div>
                    <h3 class="feature-title">Gain Valuable Experience</h3>
                    <p class="feature-text">Progress through escalating difficulty. Start with fast-paced Sprint challenges, survive the Marathon, and face the final Boss Fight.</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon-wrapper blue">
                        <i class="fa fa-trophy"></i>
                    </div>
                    <h3 class="feature-title">Win Exclusive Rewards</h3>
                    <p class="feature-text">Compete against your peers for glory. Exclusive trophies await the <strong>Top 1, Top 2, and Top 3</strong> champions.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SPONSORS SECTION -->
<div class="sponsors-section" style="padding: 5rem 0; background: #ffffff; border-top: 2px solid #e5e7eb;">
    <div class="container" style="max-width: 1100px; text-align: center;">
        
        <!-- Organized By -->
        <div class="sponsor-tier mb-5">
            <h4 class="text-uppercase font-weight-black mb-4" style="color: #a3a3a3; letter-spacing: 2px; font-size: 1rem;">Organized By</h4>
            <div class="d-flex justify-content-center flex-wrap" style="gap: 2rem;">
                <img src="<?php echo $CFG->wwwroot; ?>/theme/cfcc/assets/CADT-IDT-Logos-Navy_CADT-IDT-Lockup-1-Khmer-English.png" alt="Silver Sponsor" style="border-radius: 8px; border: 2px solid #ffffff; padding: 5px; background: #ffffff;" width=150px>
            </div>
        </div>
        
        <!-- Diamond Sponsors -->
        <div class="sponsor-tier mb-5">
            <h4 class="text-uppercase font-weight-black mb-4" style="color: #a3a3a3; letter-spacing: 2px; font-size: 1rem;"><span style="color: #0ea5e9;">✦</span> Diamond Sponsors <span style="color: #0ea5e9;">✦</span></h4>
            <div class="d-flex justify-content-center flex-wrap" style="gap: 2rem;">
                <img src="<?php echo $CFG->wwwroot; ?>/theme/cfcc/assets/All_Sponsor_logo/Logo_Metfone.png" alt="Silver Sponsor" style="border-radius: 8px; border: 2px solid #ffffff; padding: 5px; background: #ffffff;" width=250px>
            </div>
        </div>

        <!-- Gold Sponsors
        <div class="sponsor-tier mb-5">
            <h4 class="text-uppercase font-weight-black mb-4" style="color: #a3a3a3; letter-spacing: 2px; font-size: 1rem;"><span style="color: #eab308;">★</span> Gold Sponsors <span style="color: #eab308;">★</span></h4>
            <div class="d-flex justify-content-center flex-wrap" style="gap: 2rem;">
                <img src="https://via.placeholder.com/180x80?text=Gold+1" alt="Gold Sponsor" style="border-radius: 12px; border: 2px solid #eab308; padding: 10px; background: #fef9c3;">
                <img src="https://via.placeholder.com/180x80?text=Gold+2" alt="Gold Sponsor" style="border-radius: 12px; border: 2px solid #eab308; padding: 10px; background: #fef9c3;">
                <img src="https://via.placeholder.com/180x80?text=Gold+3" alt="Gold Sponsor" style="border-radius: 12px; border: 2px solid #eab308; padding: 10px; background: #fef9c3;">
            </div>
        </div> -->

        <!-- Silver & Bronze -->
        <div class="row">
            <div class="col-md-6 mb-5">
                <h4 class="text-uppercase font-weight-black mb-4" style="color: #a3a3a3; letter-spacing: 2px; font-size: 0.9rem;">Silver Sponsors</h4>
                <div class="d-flex justify-content-center flex-wrap" style="gap: 1.5rem;">
                    <img src="<?php echo $CFG->wwwroot; ?>/theme/cfcc/assets/All_Sponsor_logo/FC-Logo-All-Gray.png" alt="Silver Sponsor" style="border-radius: 8px; border: 2px solid #ffffff; padding: 5px; background: #ffffff;" width=150px>
                    <img src="<?php echo $CFG->wwwroot; ?>/theme/cfcc/assets/All_Sponsor_logo/UDAYA.png" alt="Silver Sponsor" style="border-radius: 8px; border: 2px solid #ffffff; padding: 5px; background: #ffffff;" width=150px>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <h4 class="text-uppercase font-weight-black mb-0" style="color: #a3a3a3; letter-spacing: 2px; font-size: 0.9rem;">Media Partner</h4>
                <div class="d-flex justify-content-center flex-wrap" style="gap: 0rem;">
                    <img src="<?php echo $CFG->wwwroot; ?>/theme/cfcc/assets/All_Sponsor_logo/bizkhmer.png" alt="bizkhmer" style="border-radius: 8px; border: 0px solid #ffffff; background: #ffffff; padding: top -10px; margin-top : 0px;" width=150px>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php
echo $OUTPUT->footer();
?>
