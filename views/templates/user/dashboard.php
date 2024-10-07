<?= $this->renderLayout('header') ?>

<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Personal Dashboard</h2>

        <!-- Stats Overview -->
        <div class="mb-4 text-center">
            <h3 class="font-weight-bold">Stats Overview</h3>
            <div class="row">
                <div class="col-lg-4 mb-3">
                    <div class="card shadow border-light rounded p-4">
                        <h4 class="text-muted">Total Entries</h4>
                        <h2 class="display-5 text-teal font-weight-bold">50</h2>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="card shadow border-light rounded p-4">
                        <h4 class="text-muted">Days Since Last Entry</h4>
                        <h2 class="display-5 text-teal font-weight-bold">3</h2>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="card shadow border-light rounded p-4">
                        <h4 class="text-muted">Average Entries per Week</h4>
                        <h2 class="display-5 text-teal font-weight-bold">5</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Entries Preview -->
        <div class="mb-4">
            <h3 class="font-weight-bold">Recent Entries Preview</h3>
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    Entry Title 1 <span class="badge bg-teal rounded-pill">Date</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    Entry Title 2 <span class="badge bg-teal rounded-pill">Date</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    Entry Title 3 <span class="badge bg-teal rounded-pill">Date</span>
                </a>
            </div>
        </div>

        <!-- Reminders Management UI -->
        <div class="mb-4">
            <h3 class="font-weight-bold">Manage Reminders</h3>
            <div class="list-group">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Reminder: Write a Journal</h5>
                    <span class="badge bg-teal rounded-pill">Tomorrow</span>
                    <button class="btn btn-outline-danger btn-sm">Delete</button>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <h5>Reminder: Reflect on the Week</h5>
                    <span class="badge bg-teal rounded-pill">In 3 Days</span>
                    <button class="btn btn-outline-danger btn-sm">Delete</button>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <h5>Reminder: Monthly Review</h5>
                    <span class="badge bg-teal rounded-pill">In 7 Days</span>
                    <button class="btn btn-outline-danger btn-sm">Delete</button>
                </div>
                <!-- Add Reminder Button -->
                <button class="btn btn-teal mt-3" data-bs-toggle="modal" data-bs-target="#addReminderModal">Add Reminder</button>
            </div>
        </div>

        <!-- Achievements or Milestones -->
        <div class="text-center">
            <h3 class="font-weight-bold">Achievements</h3>
            <ul class="list-group">
                <li class="list-group-item">🏆 100 Days of Journaling</li>
                <li class="list-group-item">🔥 Streak of 30 Days</li>
            </ul>
        </div>
    </div>
</section>

<!-- Add Reminder Modal -->
<div class="modal fade" id="addReminderModal" tabindex="-1" aria-labelledby="addReminderLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReminderLabel">Add New Reminder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="reminderTitle" class="form-label">Reminder Title</label>
                        <input type="text" class="form-control" id="reminderTitle">
                    </div>
                    <div class="mb-3">
                        <label for="reminderDate" class="form-label">Reminder Date</label>
                        <input type="date" class="form-control" id="reminderDate">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-teal">Save Reminder</button>
            </div>
        </div>
    </div>
</div>