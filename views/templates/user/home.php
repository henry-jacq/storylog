<nav class="navbar navbar-expand-lg d-lg-block d-none navbar-dark bg-transparent bg-gradient position-absolute w-100 z-2">
    <div class="container fs-5 my-2">
        <a class="navbar-brand text-teal d-flex align-items-center" href="/" style="font-size: 1.5rem;">
            <i class="fas fa-book-open text-teal me-2"></i>Storylog
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/profile">My Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/journals">My Journals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Log out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section position-relative text-center d-flex align-items-center justify-content-center" style="background: url('http://localhost:8000/images/Designer.png') center/cover no-repeat; height: 100vh;">
    <div class="overlay position-absolute w-100 h-100" style="background-color: rgba(0, 0, 0, 0.7);"></div>
    <div class="container position-relative text-light z-1">
        <h1 class="display-3 fw-bold mb-3">Welcome Back, <span class="text-teal"><?= $user->getName() ?>!</span></h1>
        <p class="fs-4 fw-light mb-5">Your journey continues. Let's capture today's thoughts and make them timeless memories.</p>
        <a href="/journal/create" class="btn btn-lg btn-teal me-3 px-4 shadow">Create Journal</a>
        <a href="/dashboard" class="btn btn-lg btn-outline-light px-4 shadow">My Dashboard</a>
    </div>
</section>

<!-- Daily Inspiration Section -->
<section class="py-5 bg-body text-center">
    <div class="container">
        <h2 class="mb-4 fw-bold">Daily Inspiration</h2>
        <blockquote class="blockquote mb-0">
            <p class="font-italic text-muted">"The only way to do great work is to love what you do." - Steve Jobs</p>
        </blockquote>
    </div>
</section>

<!-- Journaling Stats Section -->
<section class="bg-body py-5">
    <div class="container">
        <h2 class="fw-bold text-body">Your Journaling Stats</h2>
        <hr class="border-3">
        <div class="row mt-4">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card p-4 bg-body-tertiary rounded shadow-sm">
                    <h3 class="text-teal display-5 counter" data-target="50">0</h3>
                    <p class="text-muted">Total Entries</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card p-4 bg-body-tertiary rounded shadow-sm">
                    <h3 class="text-teal display-5 counter" data-target="10">0</h3>
                    <p class="text-muted">Favorite Entries</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card p-4 bg-body-tertiary rounded shadow-sm">
                    <h3 class="text-teal display-5 counter" data-target="5">0</h3>
                    <p class="text-muted">Entries This Month</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Year Stats Section -->
<section class="py-5 bg-body">
    <div class="container text-center">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 p-4 rounded bg-body-tertiary">
                    <h3 class="card-title text-teal">Days Remaining in the Year</h3>
                    <h2 class="display-5 text-body">70 days</h2>
                    <p class="text-muted">Make the most of the remaining days to capture your memories.</p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 p-4 rounded bg-body-tertiary">
                    <h3 class="card-title text-teal">Current Day of the Year</h3>
                    <h2 class="display-5 text-body">295</h2>
                    <p class="text-muted">Today is the 295th day of the year. What will you write about?</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Upcoming Reminders Section -->
<section class="py-5 bg-body">
    <div class="container">
        <h2 class="fw-bold text-body">Upcoming Reminders</h2>
        <hr class="border-3">
        <ul class="list-group shadow-sm">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Journal Entry Reminder: Don't forget to write about your day!
                <span class="badge bg-teal rounded-pill">Tomorrow</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Reflect on Your Week: Take some time to review your entries.
                <span class="badge bg-teal rounded-pill">In 3 Days</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Monthly Review: Check your favorite entries from this month.
                <span class="badge bg-teal rounded-pill">In 7 Days</span>
            </li>
        </ul>
    </div>
</section>

<?= $this->renderLayout('footer') ?>

<!-- Counter Animation Script -->
<script>
    const counters = document.querySelectorAll('.counter');
    let hasStartedCounting = false;

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !hasStartedCounting) {
                hasStartedCounting = true; // Start counting only once
                counters.forEach(counter => {
                    const target = +counter.getAttribute('data-target');
                    let count = 0;

                    // Calculate the increment based on the target and desired time (4 seconds)
                    const duration = 4000; // 4 seconds
                    const increment = target / (duration / 20); // Calculate increment based on time and frame rate

                    const updateCounter = () => {
                        count += increment;

                        // Ensure it doesn't exceed target
                        if (count > target) {
                            count = target;
                        }

                        counter.innerText = Math.ceil(count);

                        if (count < target) {
                            setTimeout(updateCounter, 20); // Continue counting
                        } else {
                            counter.innerText = target; // Set to exact target if overshot
                        }
                    };

                    updateCounter();
                });
            }
        });
    });

    // Observe the stats section
    observer.observe(document.querySelector('.bg-body.py-5'));
</script>