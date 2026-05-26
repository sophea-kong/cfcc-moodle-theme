<?php
require_once(__DIR__ . '/../../config.php');
require_login();

$PAGE->set_pagelayout('standard');
$PAGE->set_url(new moodle_url('/theme/myarena/waiting_room.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('The Ultimate 1-Day Showdown');
$PAGE->set_heading('Arena Lobby');

echo $OUTPUT->header();

// Failsafe CSS injection for Moodle 4.1: Echo it directly in the body.
echo "
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@800;900&family=Roboto+Mono:wght@700&display=swap');

    body { 
        background-color: #fafafa !important; 
        font-family: 'Nunito', sans-serif; 
        color: #1f2937; 
    }

    #page { 
        background: radial-gradient(circle at center, rgba(255,107,0,0.08) 0%, rgba(250,250,250,1) 75%);
        min-height: 100vh; 
    }

    /* Neo-Brutalist Tactile Card */
    .tactile-card {
        background: white;
        border: 4px solid #1f2937;
        border-radius: 32px;
        box-shadow: 12px 12px 0px #1f2937;
        position: relative;
    }

    /* Buttons with physical 'Push' feel */
    .btn-tactile {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 4px solid #1f2937 !important;
        border-radius: 24px !important;
        font-weight: 900 !important;
        text-transform: uppercase;
        padding: 1.2rem 2.5rem !important;
        font-size: 1.25rem !important;
        transition: all 0.1s ease;
        text-decoration: none !important;
        cursor: pointer;
        width: 100%;
    }

    .btn-orange { 
        background: #ff6b00 !important; 
        color: white !important; 
        box-shadow: 0 8px 0 #b34a00 !important; 
    }
    .btn-orange:active { 
        transform: translateY(4px); 
        box-shadow: 0 4px 0 #b34a00 !important; 
    }
    
    .btn-white { 
        background: white !important; 
        color: #1f2937 !important; 
        box-shadow: 0 8px 0 #d1d5db !important; 
    }
    .btn-white:active { 
        transform: translateY(4px); 
        box-shadow: 0 4px 0 #d1d5db !important; 
    }

    /* Mascot & Animations */
    .mascot-container { 
        animation: float 4s ease-in-out infinite; 
        display: inline-block;
    }
    @keyframes float { 
        0%, 100% { transform: translateY(0) rotate(0deg); } 
        50% { transform: translateY(-20px) rotate(2deg); } 
    }

    .wiggle-text { 
        display: inline-block; 
        animation: wiggle 2.5s infinite ease-in-out; 
        color: #ff6b00; 
    }
    @keyframes wiggle { 
        0%, 100% { transform: scale(1); } 
        50% { transform: scale(1.05); } 
    }

    /* Countdown Styling */
    .countdown-display { 
        font-family: 'Roboto Mono', monospace; 
        font-size: 5.5rem; 
        color: #ff6b00; 
        font-weight: 700;
        line-height: 1;
    }
    .colon { animation: blink 1s step-start infinite; }
    @keyframes blink { 50% { opacity: 0; } }

    .ribbon {
        position: absolute; top: 30px; right: -40px;
        background: #ef4444; color: white; padding: 8px 50px;
        transform: rotate(45deg); font-weight: 900; font-size: 0.9rem;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        z-index: 10;
    }

    /* Panels */
    .sub-panel {
        border-radius: 24px;
        padding: 1.25rem;
        border: 3px solid #1f2937;
        display: flex;
        align-items: center;
        text-align: left;
    }
    .panel-blue { background: #e0f2fe; }
    .panel-yellow { background: #fef9c3; }

    .avatar-cluster img {
        width: 36px; height: 36px; border-radius: 50%;
        border: 3px solid white; margin-left: -12px;
    }

    /* === GRID BACKGROUND === */
    #arena-bg {
        position: fixed;
        inset: 0;
        z-index: 0;
        overflow: hidden;
        pointer-events: none;
    }

    .grid-lines {
        position: absolute;
        inset: 0;
        background-image:
        linear-gradient(rgba(31,41,55,0.06) 1px, transparent 1px),
        linear-gradient(90deg, rgba(31,41,55,0.06) 1px, transparent 1px);
        background-size: 48px 48px;
    }

    /* === THE ORANGE ORB AND THE PURPLE ORB ON THE BACKGROUND === */
    .orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.18;
    }
    .orb-orange {
        width: 500px; height: 500px;
        background: #ff6b00;
        top: -100px; right: -100px;
        animation: orbFloat1 12s ease-in-out infinite;
    }
    .orb-purple {
        width: 400px; height: 400px;
        background: #7254b3;
        bottom: -80px; left: -80px;
        animation: orbFloat2 15s ease-in-out infinite;
    }

    /* === MASCOT === */
    .mascot-wrap {
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .mascot-svg-container {
        animation: mascotFloat 4s ease-in-out infinite;
        display: inline-block;
        flex-shrink: 0;
    }

    @keyframes mascotFloat {
        0%,100% { transform: translateY(0) rotate(-1deg); }
        50%      { transform: translateY(-14px) rotate(2deg); }
    }

    .mascot-bubble {
        background: white;
        border: 4px solid #1f2937;
        border-radius: 20px;
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 900;
        color: #1f2937;
        box-shadow: 4px 4px 0 #1f2937;
        position: relative;
        line-height: 1.4;
        max-width: 180px;
        animation: bubblePop 3s ease-in-out infinite;
    }

    @keyframes bubblePop {
        0%,100% { transform: scale(1); }
        50%      { transform: scale(1.04); }
    }

    .mascot-bubble::before {
        content: '';
        position: absolute;
        left: -22px; top: 50%;
        transform: translateY(-50%);
        border: 10px solid transparent;
        border-right-color: #1f2937;
    }
    .mascot-bubble::after {
        content: '';
        position: absolute;
        left: -14px; top: 50%;
        transform: translateY(-50%);
        border: 8px solid transparent;
        border-right-color: white;
    }

    </style>
";
?>
<!-- PAGE BG -->
<div id="arena-bg">
  <div class="grid-lines"></div>
  <div class="orb orb-orange"></div>
  <div class="orb orb-purple"></div>
  <div id="particles-container"></div>
</div>

<!-- PAGE CONTENT -->
<div class="container mx-auto" style="max-width: 1200px;">
    <div class="row align-items-center justify-content-center" style="min-height: 70vh;">
        
        <!-- Left Side: The Hype Zone -->
        <div class="col-lg-6 text-center text-lg-left mb-5 mb-lg-0 py-5">

            <!-- MASCOT -->
            <div class="mascot-wrap">
                <div class="mascot-container mb-5">
                    <svg width="110" height="130" viewBox="0 0 110 130" xmlns="http://www.w3.org/2000/svg">
                        <!-- Antenna -->
                        <line x1="55" y1="8" x2="55" y2="22" stroke="#1f2937" stroke-width="4" stroke-linecap="round"/>
                        <circle cx="55" cy="5" r="5" fill="#ff6b00" stroke="#1f2937" stroke-width="3"/>
                        <!-- Head -->
                        <rect x="18" y="22" width="74" height="58" rx="14" fill="#ff6b00" stroke="#1f2937" stroke-width="4"/>
                        <!-- Eyes -->
                        <rect x="28" y="36" width="22" height="18" rx="5" fill="white" stroke="#1f2937" stroke-width="3"/>
                        <rect x="60" y="36" width="22" height="18" rx="5" fill="white" stroke="#1f2937" stroke-width="3"/>
                        <!-- Pupils (animated) -->
                        <rect x="34" y="40" width="10" height="10" rx="2" fill="#1f2937">
                        <animate attributeName="x" values="34;36;34;32;34" dur="3s" repeatCount="indefinite"/>
                        </rect>
                        <rect x="66" y="40" width="10" height="10" rx="2" fill="#1f2937">
                        <animate attributeName="x" values="66;68;66;64;66" dur="3s" repeatCount="indefinite"/>
                        </rect>
                        <!-- Mouth -->
                        <rect x="30" y="62" width="50" height="10" rx="5" fill="white" stroke="#1f2937" stroke-width="3"/>
                        <rect x="34" y="65" width="8" height="4" rx="2" fill="#22c55e"/>
                        <rect x="46" y="65" width="8" height="4" rx="2" fill="#22c55e"/>
                        <rect x="58" y="65" width="8" height="4" rx="2" fill="#22c55e"/>
                        <!-- Neck -->
                        <rect x="44" y="80" width="22" height="10" rx="4" fill="#1f2937"/>
                        <!-- Body -->
                        <rect x="10" y="90" width="90" height="54" rx="16" fill="#fafafa" stroke="#1f2937" stroke-width="4"/>
                        <!-- Screen on body -->
                        <rect x="22" y="100" width="66" height="32" rx="8" fill="#1f2937"/>
                        <!-- Code on screen -->
                        <text x="28" y="113" font-family="monospace" font-size="8" fill="#22c55e" font-weight="700">&gt;_ solving...</text>
                        <text x="55" y="125" font-family="monospace" font-size="8" fill="#ff6b00" font-weight="700" text-anchor="middle">CFCC</text>
                        <!-- Ear bolts -->
                        <circle cx="10" cy="105" r="6" fill="#ff6b00" stroke="#1f2937" stroke-width="3"/>
                        <circle cx="100" cy="105" r="6" fill="#ff6b00" stroke="#1f2937" stroke-width="3"/>
                    </svg>
                </div>

                 <div class="mascot-bubble">
                    Ready to code?<br>
                    <span style="color:#ff6b00;">Let's GO!</span>
                </div>
            </div>

            

            <h1 class="font-weight-black mb-4" style="line-height: 1.1; font-weight: 900; font-size: 3.2rem;">
                Welcome Players To <br>
                <span class="wiggle-text">
                    <!-- <span style="color: #7254b3; display: block;">CADT</span>
                    <span style="display: block;">Freshman <br>Coding <br>Championship</span> -->
                    <span>
                        <p style="color: #7254b3;">CADT</p> Freshman Coding Championship
                    </span>
                </span>
            </h1>
            <p class="mb-5 text-muted" style="font-size: 1.3rem; font-weight: 800;">3 Stages. 1 Champion. <br>Warm up your fingers.</p>

            <div class="row" style="max-width: 500px; margin: 0 auto; margin-left: -10px;">
                <div class="col-6">
                    <a href="#" class="btn-tactile btn-white">
                        <i class="fa fa-book mr-2"></i> Rules
                    </a>
                </div>
                <div class="col-6">
                    <a  id="enter-btn" href="<?php echo new moodle_url('/theme/myarena/course_view.php?id=2'); ?>" class="btn-tactile btn-orange">
                        <i class="fa fa-bolt mr-2"></i> Enter
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Right Side: Info & Countdown Zone -->
        <!-- <div class="col-lg-6 px-4">
            <div class="tactile-card p-5 text-center">
                <div class="ribbon">LIVE SOON</div>
                
                <p class="text-uppercase font-weight-black text-muted mb-2 small" style="letter-spacing: 2px;">Competition Begins In</p>
                <div class="countdown-display d-flex justify-content-center align-items-center mb-5">
                    <span id="hr-digit">00</span>
                    <span class="mx-2">:</span>
                    <span id="min-digit">00</span>
                    <span class="mx-2">:</span>
                    <span id="sec-digit">00</span>
                </div>

                <div class="stats-container mt-4">

                    <div class="sub-panel panel-blue mb-3">
                        <div class="bg-white rounded-circle p-2 mr-3" style="border: 2px solid #1f2937;">
                            <i class="fa fa-users text-primary px-1"></i>
                        </div>
                        <div class="flex-grow-1">
                            <span class="d-block h5 mb-0 font-weight-black">4,281 registered</span>
                            <small class="text-muted font-weight-bold">Participants joined the fight</small>
                        </div>
                        <div class="avatar-cluster d-none d-md-flex">
                            <img src="https://i.pravatar.cc/150?u=a" alt="v">
                            <img src="https://i.pravatar.cc/150?u=b" alt="v">
                            <img src="https://i.pravatar.cc/150?u=c" alt="v">
                        </div>
                    </div>
                    
                    <div class="sub-panel panel-yellow">
                        <div class="bg-white rounded-circle p-2 mr-3" style="border: 2px solid #1f2937;">
                            <i class="fa fa-trophy text-warning px-1"></i>
                        </div>
                        <div>
                            <span class="d-block h5 mb-0 font-weight-black">50,000 Gems + Badge</span>
                            <small class="text-muted font-weight-bold">Victory Reward Pool</small>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

    </div>
</div>

<script>
    (function() {

        const targetDate = new Date("July, 04, 2026").getTime();
        const now = new Date().getTime();

        const timeDifference = targetDate - now;
        // convert the remaining time into total seconds
        const totalSecondsFromTarget = Math.floor(timeDifference / 1000);


        // use total seconds computed from target date
        let totalSeconds = totalSecondsFromTarget;
        const hrEl = document.getElementById('hr-digit');
        const minEl = document.getElementById('min-digit');
        const secEl = document.getElementById('sec-digit');

        const updateTimer = () => {
            if (totalSeconds <= 0) {
                hrEl.innerText = '00';
                minEl.innerText = '00';
                secEl.innerText = '00';
                clearInterval(timerInterval);
                return;
            }
            totalSeconds--;
            const hrs = Math.floor(totalSeconds / 3600);
            const mins = Math.floor((totalSeconds % 3600) / 60);
            const secs = totalSeconds % 60;
            hrEl.innerText = hrs.toString().padStart(2, '0');
            minEl.innerText = mins.toString().padStart(2, '0');
            secEl.innerText = secs.toString().padStart(2, '0');
            // display days left (from outer calculation)
        };

        const timerInterval = setInterval(updateTimer, 1000);

        
        const enterBtn = document.getElementById('enter-btn');
        enterBtn.addEventListener('click', (e) => {
            if (totalSeconds > 0) {
                e.preventDefault();
                // alert('The arena is not open yet! Please wait for the countdown to finish.');
            }
        });

    })();
</script>

<?php
echo $OUTPUT->footer();
