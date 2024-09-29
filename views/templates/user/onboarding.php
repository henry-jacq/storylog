<?= $this->renderLayout('header') ?>

<style>
    .progress-bar {
        background-color: #51a3a3 !important;
    }

    .onboarding-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 40px;
    }

    .onboarding-step {
        display: none;
    }

    .onboarding-step.active {
        display: block;
    }

    .progress-wrapper {
        height: 6px;
        margin-bottom: 20px;
    }

    .interest-tag {
        cursor: pointer;
        margin: 5px;
    }

    .interest-tag.active {
        background-color: #51a3a3;
        color: #fff;
    }
</style>

<div class="onboarding-container">
    <!-- Progress Bar -->
    <div class="progress-wrapper">
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 16.67%" id="progressBar"></div>
        </div>
    </div>

    <!-- Onboarding Steps -->
    <div class="onboarding-step active" id="step1">
        <h2 class="text-center">Welcome, Henry!</h2>
        <p class="text-center">We’re excited to have you! Let’s personalize your experience to get the most out of the app.</p>
        <div class="text-center">
            <button class="btn btn-teal btn-lg" onclick="nextStep()">Let’s Start</button>
        </div>
    </div>

    <div class="onboarding-step" id="step2">
        <h2 class="text-center">Tell Us More About You</h2>
        <form>
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dob">
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Profile Picture</label>
                <input type="file" class="form-control" id="profilePicture">
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-teal" onclick="nextStep()">Next</button>
            </div>
        </form>
    </div>

    <div class="onboarding-step" id="step3">
        <h2 class="text-center">What Interests You?</h2>
        <div class="d-flex flex-wrap justify-content-center">
            <span class="badge interest-tag bg-light" onclick="toggleInterest(this)">Writing</span>
            <span class="badge interest-tag bg-light" onclick="toggleInterest(this)">Reading</span>
            <span class="badge interest-tag bg-light" onclick="toggleInterest(this)">Fitness</span>
            <span class="badge interest-tag bg-light" onclick="toggleInterest(this)">Mindfulness</span>
            <span class="badge interest-tag bg-light" onclick="toggleInterest(this)">Other</span>
        </div>
        <div class="text-center mt-4">
            <button class="btn btn-teal" onclick="nextStep()">Next</button>
        </div>
    </div>

    <div class="onboarding-step" id="step4">
        <h2 class="text-center">Set Your Intentions</h2>
        <div class="mb-3">
            <label for="intentions" class="form-label">What are your journaling goals?</label>
            <input type="text" class="form-control" id="intentions" placeholder="e.g., Daily journaling, Self-reflection">
        </div>
        <div class="text-center">
            <button class="btn btn-teal" onclick="nextStep()">Next</button>
        </div>
    </div>

    <div class="onboarding-step" id="step5">
        <h2 class="text-center">Where are you located?</h2>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" placeholder="Enter your city or country">
        </div>
        <div class="text-center">
            <button class="btn btn-teal" onclick="nextStep()">Next</button>
        </div>
    </div>

    <div class="onboarding-step" id="step6">
        <h2 class="text-center">Manage Your Notifications</h2>
        <div class="mb-3">
            <label class="form-label">Email Notifications</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="emailNotifications">
                <label class="form-check-label" for="emailNotifications">Receive Email Notifications</label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Reminder Time for Journaling</label>
            <input type="time" class="form-control" id="reminderTime">
        </div>
        <div class="text-center">
            <button class="btn btn-teal" onclick="nextStep()">Next</button>
        </div>
    </div>

    <div class="onboarding-step" id="step7">
        <h2 class="text-center">You're All Set!</h2>
        <p class="text-center">Here's a quick summary of the information you’ve provided.</p>
        <ul class="list-group mb-4">
            <li class="list-group-item"><strong>Date of Birth:</strong> <span id="summaryDOB"></span></li>
            <li class="list-group-item"><strong>Gender:</strong> <span id="summaryGender"></span></li>
            <li class="list-group-item"><strong>Location:</strong> <span id="summaryLocation"></span></li>
            <li class="list-group-item"><strong>Journaling Goals:</strong> <span id="summaryIntentions"></span></li>
            <li class="list-group-item"><strong>Reminder Time:</strong> <span id="summaryReminderTime"></span></li>
        </ul>
        <div class="text-center">
            <button class="btn btn-teal btn-lg" onclick="finishOnboarding()">Finish & Explore Dashboard</button>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let currentStep = 1;
    const totalSteps = 7;

    function nextStep() {
        if (currentStep < totalSteps) {
            document.getElementById(`step${currentStep}`).classList.remove('active');
            currentStep++;
            document.getElementById(`step${currentStep}`).classList.add('active');
            updateProgressBar();
        }
    }

    function updateProgressBar() {
        const progressPercent = (currentStep / totalSteps) * 100;
        document.getElementById('progressBar').style.width = `${progressPercent}%`;
    }

    function toggleInterest(element) {
        element.classList.toggle('active');
    }

    function finishOnboarding() {
        // Gather summary details
        document.getElementById('summaryDOB').innerText = document.getElementById('dob').value;
        document.getElementById('summaryGender').innerText = document.getElementById('gender').value;
        document.getElementById('summaryLocation').innerText = document.getElementById('location').value;
        document.getElementById('summaryIntentions').innerText = document.getElementById('intentions').value;
        document.getElementById('summaryReminderTime').innerText = document.getElementById('reminderTime').value;

        nextStep();
    }
</script>