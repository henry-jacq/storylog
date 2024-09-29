<?= $this->renderLayout('header'); ?>

<!-- Journal Creation Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Create a New Journal Entry</h2>

        <form id="journalForm">
            <!-- Entry Title -->
            <div class="mb-3">
                <label for="entryTitle" class="form-label">Entry Title</label>
                <input type="text" class="form-control" id="entryTitle" placeholder="Enter your journal title" required>
            </div>

            <!-- Entry Content -->
            <div class="mb-3">
                <label for="entryContent" class="form-label">Content</label>
                <textarea class="form-control" id="entryContent" rows="6" placeholder="Write your thoughts here..." required></textarea>
            </div>

            <!-- Mood Tracker -->
            <div class="mb-4">
                <label for="entryMood" class="form-label">Mood</label>
                <select class="form-select form-select-lg" id="entryMood">
                    <option value="" disabled selected>Select your mood</option>
                    <option value="happy">Happy</option>
                    <option value="sad">Sad</option>
                    <option value="neutral">Neutral</option>
                    <option value="excited">Excited</option>
                    <option value="anxious">Anxious</option>
                </select>
            </div>

            <!-- Custom Tags -->
            <div class="mb-4">
                <label for="entryTags" class="form-label">Tags</label>
                <input type="text" class="form-control form-control-lg" id="entryTags" placeholder="Add custom tags (separate by commas)">
                <small class="text-muted">Add tags relevant to your entry (e.g., reflection, personal, milestone)</small>
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label for="entryCategory" class="form-label">Category</label>
                <select class="form-select" id="entryCategory" required>
                    <option value="" disabled selected>Select a category</option>
                    <option value="usual">Usual</option>
                    <option value="special">Special</option>
                    <option value="work">Work</option>
                    <option value="planning">Planning</option>
                    <option value="personal">Personal</option>
                </select>
            </div>

            <!-- Date -->
            <div class="mb-3">
                <label for="entryDate" class="form-label">Date</label>
                <input type="date" class="form-control" id="entryDate" required>
            </div>

            <!-- Location -->
            <div class="mb-3">
                <label for="entryLocation" class="form-label">Location</label>
                <input type="text" class="form-control" id="entryLocation" placeholder="Where are you journaling from?">
            </div>

            <!-- Auto-Save and Draft Options -->
            <div class="mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="saveAsDraft">
                    <label class="form-check-label" for="saveAsDraft">Save as Draft</label>
                </div>
                <div id="autoSaveMessage" class="text-success mt-2" style="display:none;">Draft saved automatically!</div>
            </div>

            <!-- Submit Buttons -->
            <div class="text-center">
                <button type="submit" class="btn btn-teal btn-lg">Save Entry</button>
                <a href="/" class="btn btn-outline-secondary btn-lg ms-3">Cancel</a>
            </div>
        </form>
    </div>
</section>

<script>
    // Auto-Save Feature
    let autoSaveTimeout = null;
    const entryForm = document.getElementById('journalForm');
    const autoSaveMessage = document.getElementById('autoSaveMessage');

    entryForm.addEventListener('input', function() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(autoSaveEntry, 3000); // Auto-save after 3 seconds of inactivity
    });

    function autoSaveEntry() {
        // Logic to auto-save the form
        autoSaveMessage.style.display = 'block';
        setTimeout(() => {
            autoSaveMessage.style.display = 'none';
        }, 2000);
    }
</script>