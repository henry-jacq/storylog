<?= $this->renderLayout('header') ?>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Settings</h2>

        <!-- Personal Information -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h3>Personal Information</h3>
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                    </div>
                    <button type="submit" class="btn btn-teal">Update Details</button>
                </form>
            </div>
        </div>

        <!-- Theme Preferences -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h3>Theme Preferences</h3>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="theme" id="light" value="light" checked>
                    <label class="form-check-label" for="light">Light Theme</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="theme" id="dark" value="dark">
                    <label class="form-check-label" for="dark">Dark Theme</label>
                </div>
                <button class="btn btn-teal mt-3">Save Theme Preferences</button>
            </div>
        </div>

        <!-- Password Management -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h3>Password Management</h3>
                <form>
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" placeholder="Current Password" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" placeholder="New Password" required>
                    </div>
                    <button type="submit" class="btn btn-teal">Change Password</button>
                </form>
            </div>
        </div>

        <!-- Notification Preferences -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h3>Notification Preferences</h3>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="reminderNotifications" checked>
                    <label class="form-check-label" for="reminderNotifications">Enable Reminder Notifications</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="emailNotifications" checked>
                    <label class="form-check-label" for="emailNotifications">Receive Email Notifications</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="dailyQuoteNotifications" checked>
                    <label class="form-check-label" for="dailyQuoteNotifications">Get Daily Inspirational Quotes</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="weeklySummaryNotifications">
                    <label class="form-check-label" for="weeklySummaryNotifications">Receive Weekly Journaling Summaries</label>
                </div>
                <button class="btn btn-teal mt-3">Save Notification Preferences</button>
            </div>
        </div>

        <!-- Data Management -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h3>Data Management</h3>
                <p class="text-muted mb-3">Manage your journal data by exporting, deleting, or backing up your entries. Ensure your privacy and data security with the available options.</p>
                <button class="btn btn-warning">Export Journals</button>
                <button class="btn btn-danger">Delete All Journals</button>
            </div>
        </div>

        <!-- Writing Prompts or Goals -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h3>Writing Prompts / Goals</h3>
                <form>
                    <div class="mb-3">
                        <label for="goal" class="form-label">Set Personal Journaling Goal</label>
                        <input type="text" class="form-control" id="goal" placeholder="Enter your goal" required>
                    </div>
                    <button type="submit" class="btn btn-teal">Save Goal</button>
                </form>
                <div class="mt-3">
                    <h5>Daily Writing Prompt:</h5>
                    <p class="border rounded p-2 bg-white">"What made you smile today?"</p>
                </div>
            </div>
        </div>
    </div>
</section>
