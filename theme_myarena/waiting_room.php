<?php
require_once(__DIR__ . '/../../config.php');
require_login();

$PAGE->set_pagelayout('standard');
$PAGE->set_url(new moodle_url('/theme/myarena/waiting_room.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('CADT Freshman Coding Championship');
$PAGE->set_heading('Arena Lobby');

echo $OUTPUT->header();

// Failsafe CSS injection for Moodle 4.1: Echo it directly in the body.
echo "
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@800;900&family=Roboto+Mono:wght@700&display=swap');

    body { 
        background-color: #ffffff !important; 
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
    </style>
";
?>

<div class="container" style="max-width: 1200px;">
    <div class="row align-items-center" style="min-height: 85vh;">
        
        <!-- Left Side: The Hype Zone -->
        <div class="col-lg-6 text-center text-lg-left mb-5 mb-lg-0 py-5">
            <div class="mascot-container mb-5">
                <p>HOLY CFCC</p>
            </div>

            <h1 class="display-3 font-weight-black mb-4" style="line-height: 1.1; font-weight: 900;">
                CADT Freshman Coding Championship <br><span class="wiggle-text">Are you ready?</span>
            </h1>
            <p class="mb-5 text-muted" style="font-size: 1.6rem; font-weight: 800;">3 Stages. 1 Champion. <br>Warm up your fingers.</p>

            <div class="row" style="max-width: 500px; margin: 0 auto; margin-left: -10px;">
                <div class="col-6">
                    <a href="#" class="btn-tactile btn-white"><i class="fa fa-book mr-2"></i> Rules</a>
                </div>
                <div class="col-6">
                    <a href="<?php echo new moodle_url('/theme/myarena/course_view.php?id=2'); ?>" class="btn-tactile btn-orange"><i class="fa fa-bolt mr-2"></i> Enter</a>
                </div>
            </div>
        </div>

        <!-- Right Side: Info & Countdown Zone -->
        <div class="col-lg-6 px-4">
            <div class="tactile-card p-5 text-center">
                <div class="ribbon">LIVE SOON</div>
                
                <p class="text-uppercase font-weight-black text-muted mb-2 small" style="letter-spacing: 2px;">Stage 1 Begins In</p>
                <div class="countdown-display d-flex justify-content-center align-items-center mb-5">
                    <span id="min-digit">05</span>
                    <span class="colon mx-2">:</span>
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
        </div>
    </div>
</div>

<script>
    (function() {
        let totalSeconds = 342;
        const minEl = document.getElementById('min-digit');
        const secEl = document.getElementById('sec-digit');

        const updateTimer = () => {
            if (totalSeconds <= 0) return;
            totalSeconds--;
            const mins = Math.floor(totalSeconds / 60);
            const secs = totalSeconds % 60;
            minEl.innerText = mins.toString().padStart(2, '0');
            secEl.innerText = secs.toString().padStart(2, '0');
        };

        setInterval(updateTimer, 1000);
    })();
</script>

<?php
echo $OUTPUT->footer();
