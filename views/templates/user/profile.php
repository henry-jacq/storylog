<?= $this->renderLayout('header') ?>
<style>
    .profile-header {
        padding: 2rem 0;
    }

    .profile-picture {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
    }

    .achievement-card {
        transition: transform 0.2s;
    }

    .achievement-card:hover {
        transform: scale(1.05);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
    }

    .stat-label {
        color: #888;
    }
</style>
</style>
<!-- Profile Header Section -->
<section class="profile-header text-center">
    <div class="container">
        <img src="https://via.placeholder.com/150" alt="User Profile" class="profile-picture border border-5 border-body mb-3">
        <h2 class="fw-bold text-body">John Doe</h2>
        <p class="text-muted mb-4">"Capturing moments, one entry at a time."</p>

        <!-- Profile Stats -->
        <div class="row justify-content-center">
            <div class="col-4 col-md-3">
                <p class="stat-number">120</p>
                <p class="stat-label">Journal Entries</p>
            </div>
            <div class="col-4 col-md-3">
                <p class="stat-number">30</p>
                <p class="stat-label">Special Entries</p>
            </div>
            <div class="col-4 col-md-3">
                <p class="stat-number">5</p>
                <p class="stat-label">Achievements</p>
            </div>
        </div>
    </div>
</section>

<!-- Main Content Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Personal Details Column -->
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h4 class="card-title fw-bold">Personal Details</h4>
                        <p><strong>Name:</strong> John Doe</p>
                        <p><strong>Email:</strong> johndoe@example.com</p>
                        <p><strong>Location:</strong> New York, USA</p>
                        <p><strong>Member Since:</strong> January 2022</p>
                        <a href="/settings" class="btn btn-outline-primary">Edit Details</a>
                    </div>
                </div>
            </div>

            <!-- Journal Stats and Achievements Column -->
            <div class="col-md-8">
                <!-- Journal Stats -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h4 class="card-title fw-bold">Journal Statistics</h4>
                        <div class="row text-center">
                            <div class="col-6 col-md-4">
                                <p class="stat-number">120</p>
                                <p class="stat-label">Total Entries</p>
                            </div>
                            <div class="col-6 col-md-4">
                                <p class="stat-number">45</p>
                                <p class="stat-label">Work Journals</p>
                            </div>
                            <div class="col-6 col-md-4">
                                <p class="stat-number">75</p>
                                <p class="stat-label">Personal Journals</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Achievements Section -->
                <div class="row">
                    <h4 class="fw-bold mb-3">Achievements</h4>
                    <!-- Achievement 1 -->
                    <div class="col-md-6">
                        <div class="card achievement-card border-0 bg-body-tertiary shadow text-center p-3 mb-4">
                            <i class="fas fa-award fa-3x text-teal mb-3"></i>
                            <h5 class="fw-bold">Prolific Writer</h5>
                            <p class="text-muted">Reached 100 journal entries.</p>
                        </div>
                    </div>
                    <!-- Achievement 2 -->
                    <div class="col-md-6">
                        <div class="card achievement-card border-0 bg-body-tertiary shadow text-center p-3 mb-4">
                            <i class="fas fa-star fa-3x text-teal mb-3"></i>
                            <h5 class="fw-bold">Milestone Achiever</h5>
                            <p class="text-muted">Logged 30 special entries.</p>
                        </div>
                    </div>
                    <!-- Achievement 3 -->
                    <div class="col-md-6">
                        <div class="card achievement-card border-0 bg-body-tertiary shadow text-center p-3 mb-4">
                            <i class="fas fa-calendar-check fa-3x text-teal mb-3"></i>
                            <h5 class="fw-bold">Consistency Master</h5>
                            <p class="text-muted">Wrote for 30 consecutive days.</p>
                        </div>
                    </div>
                    <!-- Achievement 4 -->
                    <div class="col-md-6">
                        <div class="card achievement-card border-0 bg-body-tertiary shadow text-center p-3 mb-4">
                            <i class="fas fa-heart fa-3x text-teal mb-3"></i>
                            <h5 class="fw-bold">Heartfelt Entry</h5>
                            <p class="text-muted">Created a highly personal journal entry.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>