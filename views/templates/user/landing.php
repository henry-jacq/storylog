<style>
    .shadow-lg-custom {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .rounded-circle {
        width: 80px;
        height: 80px;
        object-fit: cover;
    }
</style>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Storylog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active fw-semibold" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="#">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-teal fw-bold px-4" href="#">Get Started</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="bg-teal text-center text-white py-5">
    <div class="container">
        <h1 class="display-4 fw-bold">Capture Your Thoughts with Storylog</h1>
        <p class="lead mb-4">A simple and intuitive personal journal application to track your thoughts, ideas, and memories.</p>
        <a href="#" class="btn btn-light btn-lg px-5">Start Journaling</a>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-white">
    <div class="container">
        <h2 class="text-center mb-5">Why Choose Storylog?</h2>
        <div class="row text-center">
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-lg shadow-lg-custom">
                    <div class="card-body text-teal">
                        <i class="fas fa-book fa-3x mb-3"></i>
                        <h3 class="h5">Easy to Use</h3>
                        <p class="text-muted">Effortlessly jot down your thoughts and revisit them anytime with our user-friendly interface.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-lg shadow-lg-custom">
                    <div class="card-body text-mauve">
                        <i class="fas fa-lock fa-3x mb-3"></i>
                        <h3 class="h5">Privacy First</h3>
                        <p class="text-muted">Your journals are securely stored and only accessible by you.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-lg shadow-lg-custom">
                    <div class="card-body text-amber">
                        <i class="fas fa-calendar-alt fa-3x mb-3"></i>
                        <h3 class="h5">Daily Reminders</h3>
                        <p class="text-muted">Get notifications and reminders to make journaling a habit every day.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-5">What Our Users Say</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow-lg shadow-lg-custom">
                    <div class="card-body">
                        <p class="card-text">"Storylog has transformed my journaling experience! I love how easy it is to use and the daily reminders help me stay consistent!"</p>
                        <h5 class="card-title">- Sarah J.</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow-lg shadow-lg-custom">
                    <div class="card-body">
                        <p class="card-text">"I appreciate the privacy features. It's comforting to know my thoughts are secure. Highly recommend!"</p>
                        <h5 class="card-title">- Mark R.</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow-lg shadow-lg-custom">
                    <div class="card-body">
                        <p class="card-text">"The user interface is so intuitive! I can easily find my past entries and reflect on my journey." </p>
                        <h5 class="card-title">- Emily T.</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section class="py-5 text-center bg-sand text-white">
    <div class="container">
        <h2 class="mb-4">Ready to Start Your Journaling Journey?</h2>
        <p class="mb-4">Join thousands of users and start capturing your thoughts and memories today!</p>
        <a href="#" class="btn btn-light btn-lg">Get Started Now</a>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5 bg-white">
    <div class="container">
        <h2 class="text-center mb-5">Frequently Asked Questions</h2>
        <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne">
                        What platforms does Storylog support?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="faqOne"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Storylog is available on web and mobile platforms, making it accessible wherever you are.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                        aria-expanded="false" aria-controls="collapseTwo">
                        How does the privacy feature work?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="faqTwo"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Your journals are encrypted and stored securely, ensuring that only you can access them.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                        aria-expanded="false" aria-controls="collapseThree">
                        Can I access my entries offline?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="faqThree"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes! You can access your entries offline, and they will sync once you're back online.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-mauve text-white text-center py-4">
    <div class="container">
        <p>&copy; 2024 Storylog. All Rights Reserved.</p>
        <div>
            <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
        </div>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>