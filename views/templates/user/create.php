<?= $this->renderLayout('header'); ?>

<!-- Journal Creation Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4 display-5">Create a New Journal Entry</h2>

        <form id="journalForm" class="p-4 rounded-3">
            <!-- Entry Title -->
            <div class="mb-4">
                <label for="entryTitle" class="form-label fs-5">Entry Title</label>
                <input type="text" class="form-control form-control-lg" id="entryTitle" placeholder="Enter your journal title" required>
            </div>

            <!-- Entry Content -->
            <div class="mb-4">
                <label for="entryContent" class="form-label fs-5">Content</label>
                <textarea class="form-control form-control-lg" id="entryContent" rows="6" placeholder="Write your thoughts here..." required></textarea>
            </div>

            <!-- Mood Tracker with Emoji -->
            <div class="mb-4">
                <label for="entryMood" class="form-label fs-5">Current Mood</label>
                <select class="form-select form-select-lg" id="entryMood">
                    <option value="" disabled selected>Select your mood</option>
                    <option value="happy">😊 Happy</option>
                    <option value="sad">😢 Sad</option>
                    <option value="neutral">😐 Neutral</option>
                    <option value="excited">🤩 Excited</option>
                    <option value="anxious">😰 Anxious</option>
                </select>
            </div>

            <!-- Category with Emoji -->
            <div class="mb-4">
                <label for="entryCategory" class="form-label fs-5">Category</label>
                <select class="form-select form-select-lg" id="entryCategory" required>
                    <option value="" disabled selected>Select a category</option>
                    <option value="usual">📝 Usual</option>
                    <option value="special">🎉 Special</option>
                    <option value="work">💼 Work</option>
                    <option value="planning">🗓️ Planning</option>
                    <option value="personal">❤️ Personal</option>
                </select>
            </div>

            <!-- Date of Journal -->
            <div class="mb-4">
                <label for="entryDate" class="form-label fs-5">Date of Journal</label>
                <input type="date" class="form-control form-control-lg" id="entryDate" required>
            </div>

            <!-- Location Section -->
            <div class="mb-4">
                <label for="entryLocation" class="form-label fs-5">Location</label>

                <!-- Predefined Location Dropdown -->
                <div class="input-group">
                    <select class="form-select form-select-lg" id="predefinedLocation">
                        <option value="" disabled selected>Select the journaling location</option>
                        <option value="home">🏡 Home</option>
                        <option value="office">🏢 Office</option>
                        <option value="park">🌳 Park</option>
                        <option value="custom">➕ Add Custom Location</option> <!-- Custom Location Option -->
                    </select>
                </div>

                <!-- Fetched Location Input (Initially Hidden) -->
                <div id="customLocationFields" class="mt-2" style="display: none;">
                    <input type="text" class="form-control form-control-lg" id="entryLocation" placeholder="Type or fetch your current location">
                    <!-- Status message -->
                    <div id="locationStatus" class="mt-1 text-info" style="display:none;">Fetching location...</div>
                    <div class="d-flex justify-content-between mt-3">
                        <!-- Save Fetched Location Option -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="saveLocation">
                            <label class="form-check-label" for="saveLocation">Save this location for future use</label>
                        </div>
                        <a id="useDefaultLocation" class="text-teal text-decoration-underline" role="button">Fetch current location</a>
                    </div>
                </div>
            </div>

            <!-- Auto-Save and Draft Options -->
            <div class="mb-4">
                <div id="autoSaveMessage" class="text-success my-2" style="display:none;">Draft saved automatically!</div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="saveAsDraft">
                        <label class="form-check-label fs-6" for="saveAsDraft">Save as Draft</label>
                    </div>
                    <a href="/" id="deleteDraftEntry" class="text-danger text-decoration-underline d-none">Delete Draft</a>
                </div>
                <label class="form-text">Enable to automatically save your journal as a draft with each change; only one draft will be kept and overwritten with new edits.</label>
            </div>
    
            <!-- Submit Buttons -->
            <div class="text-center d-flex justify-content-between">
                <a href="/" class="btn btn-outline-secondary btn-lg btn-hover-shadow">Cancel</a>
                <button type="submit" class="btn btn-teal btn-lg btn-hover-shadow">Save Entry</button>
            </div>
        </form>
    </div>
</section>

<?= $this->renderLayout('footer'); ?>