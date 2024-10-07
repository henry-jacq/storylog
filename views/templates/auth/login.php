<style>
    body {
        background: url('http://localhost:8000/images/Designer.jpeg') center/cover no-repeat;
        position: relative;
    }

    /* Add a dark overlay on top of the background image */
    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Adjust the opacity for darkness */
        z-index: 0;
    }

    .login-container {
        background-color: rgba(0, 0, 0, 0.75);
        padding: 2rem;
        width: 400px;
        border-radius: 0.75rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.3);
        z-index: 1;
        /* Ensure the login container is on top of the overlay */
        position: relative;
    }
</style>

<div class="d-flex align-items-center justify-content-center min-vh-100 bg-gradient">
    <div class="login-container text-center">
        <h3 class="mb-3 fw-bold text-teal"><i class="fas fa-book-open text-teal me-2"></i>Storylog</h3>
        <p class="text-muted mb-4">Please login to secure your journals</p>

        <!-- Login Form -->
        <form id="loginForm">
            <div class="mb-3">
                <input type="email" class="form-control form-control-lg bg-transparent border-0 shadow-sm text-white" id="email" placeholder="Email address" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control form-control-lg bg-transparent border-0 shadow-sm text-white" id="password" placeholder="Password" required>
            </div>
            <div class="d-flex justify-content-between mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember Me</label>
                </div>
                <a href="#" class="text-muted">Forgot Password?</a>
            </div>
            <button type="submit" class="btn btn-lg w-100 bg-teal text-white shadow-sm">Login</button>

            <!-- Google Login Button -->
            <div class="mt-3">
                <button type="button" class="btn btn-lg btn-google w-100 shadow-sm">
                    <i class="fab fa-google me-2"></i>Login with Google
                </button>
            </div>
        </form>

        <!-- MFA and Security Assurance -->
        <div class="text-center mt-3">
            <small class="d-block mb-2 text-muted">
                <i class="bi bi-shield-shaded me-1"></i>
                Secured by End-to-End Encryption
            </small>
        </div>

        <!-- Footer -->
        <div class="login-footer mt-4">
            <p class="mb-0">Don't have an account? <a class="text-sand" href="/register">Sign Up</a></p>
            <p><a class="text-sand" href="/privacy-policy">Privacy Policy</a> | <a class="text-sand" href="/terms">Terms & Conditions</a></p>
        </div>
    </div>
</div>

<script>
    // Handle login form submission
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Add login logic here (e.g., API call, form validation)
    });
</script>